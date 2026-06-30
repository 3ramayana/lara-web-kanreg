<?php

namespace App\Services;

class CBRService
{
    /**
     * Daftar stopwords bahasa Indonesia dasar untuk menghilangkan kata hubung.
     */
    private $stopwords = [
        'yang', 'untuk', 'pada', 'ke', 'di', 'dari', 'dan', 'atau', 'dengan', 
        'ini', 'itu', 'juga', 'sudah', 'saya', 'dia', 'mereka', 'kita', 'kami', 
        'akan', 'bisa', 'dapat', 'adalah', 'sebagai', 'tidak', 'belum', 'dalam',
        'hal', 'tentang', 'bagaimana', 'apa', 'mengapa', 'kapan', 'siapa'
    ];

    /**
     * Memproses kasus (Calculate Similarity).
     */
    public function retrieveSimilarCases($query, $cases)
    {
        // 1. Preprocess Query
        $queryTokens = $this->preprocess($query);
        if (empty($queryTokens)) {
            return collect([]); // Kembalikan kosong jika query hanya berisi stopword
        }

        // 2. Preprocess All Cases (Membuat Document Vectors)
        $documentVectors = [];
        $allTokens = $queryTokens;

        foreach ($cases as $index => $case) {
            // Gabungkan teks dari judul, masalah, dan tag
            $rawText = $case->title . ' ' . strip_tags($case->problem);
            if (is_array($case->tags)) {
                $rawText .= ' ' . implode(' ', $case->tags);
            }

            $tokens = $this->preprocess($rawText);
            $documentVectors[$index] = $tokens;
            $allTokens = array_merge($allTokens, $tokens);
        }

        // Kumpulkan semua kata unik di seluruh corpus (vocabulary)
        $vocabulary = array_unique($allTokens);

        // 3. Menghitung TF (Term Frequency)
        $tfQuery = $this->calculateTF($queryTokens, $vocabulary);
        
        $tfDocuments = [];
        foreach ($documentVectors as $index => $tokens) {
            $tfDocuments[$index] = $this->calculateTF($tokens, $vocabulary);
        }

        // 4. Hitung IDF (Inverse Document Frequency)
        $idf = $this->calculateIDF($documentVectors, $vocabulary);

        // 5. Hitung TF-IDF Vector untuk Query
        $tfidfQuery = [];
        foreach ($vocabulary as $term) {
            $tfidfQuery[$term] = $tfQuery[$term] * $idf[$term];
        }

        // 6. Hitung Cosine Similarity untuk setiap Dokumen
        $scoredCases = collect();

        foreach ($cases as $index => $case) {
            $tfidfDoc = [];
            foreach ($vocabulary as $term) {
                $tfidfDoc[$term] = $tfDocuments[$index][$term] * $idf[$term];
            }

            $similarity = $this->cosineSimilarity($tfidfQuery, $tfidfDoc);
            
            // Set similarity score ke objek model
            $case->similarity_score = $similarity;

            // Simpan jika kemiripan lebih besar dari 0 (ada kecocokan)
            if ($similarity > 0) {
                $scoredCases->push($case);
            }
        }

        // Urutkan berdasarkan skor tertinggi ke terendah
        return $scoredCases->sortByDesc('similarity_score')->values();
    }

    /**
     * Membersihkan teks, huruf kecil, hapus tanda baca, dan buang stopwords.
     */
    private function preprocess($text)
    {
        // Lowercase
        $text = strtolower($text);
        
        // Hapus karakter non-alphanumeric (tanda baca dll)
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
        
        // Tokenisasi (pecah jadi array per spasi)
        $tokens = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        
        // Hapus stopwords
        $filteredTokens = array_filter($tokens, function($token) {
            return !in_array($token, $this->stopwords) && strlen($token) > 1;
        });

        return array_values($filteredTokens);
    }

    /**
     * Term Frequency (Frekuensi Kemunculan Kata).
     */
    private function calculateTF($tokens, $vocabulary)
    {
        $tf = array_fill_keys($vocabulary, 0);
        $totalTokens = count($tokens);

        if ($totalTokens == 0) return $tf;

        $counts = array_count_values($tokens);
        foreach ($counts as $term => $count) {
            if (isset($tf[$term])) {
                $tf[$term] = $count / $totalTokens; // Normalisasi TF
            }
        }

        return $tf;
    }

    /**
     * Inverse Document Frequency.
     */
    private function calculateIDF($documents, $vocabulary)
    {
        $idf = [];
        $totalDocs = count($documents);

        foreach ($vocabulary as $term) {
            $docContainingTerm = 0;
            foreach ($documents as $docTokens) {
                if (in_array($term, $docTokens)) {
                    $docContainingTerm++;
                }
            }
            // Mencegah pembagian dengan nol (seharusnya tidak mungkin terjadi krn term berasal dari doc itu sendiri)
            $idf[$term] = log($totalDocs / ($docContainingTerm + 1)) + 1; // Smoothing
        }

        return $idf;
    }

    /**
     * Perhitungan Cosine Similarity antara 2 vektor.
     */
    private function cosineSimilarity($vecA, $vecB)
    {
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;

        foreach ($vecA as $term => $valA) {
            $valB = $vecB[$term];
            $dotProduct += ($valA * $valB);
            $normA += pow($valA, 2);
            $normB += pow($valB, 2);
        }

        $normA = sqrt($normA);
        $normB = sqrt($normB);

        if ($normA == 0 || $normB == 0) {
            return 0;
        }

        return $dotProduct / ($normA * $normB);
    }
}
