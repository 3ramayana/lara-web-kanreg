<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RetirementCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = [
            [
                'title' => 'Berkas Penetapan Pensiun BUP Belum Turun',
                'problem' => '<p>Seorang PNS sudah mendekati Batas Usia Pensiun (BUP) bulan depan, tetapi SK Penetapan Pensiun belum diterbitkan dari BKN Pusat/Kanreg. Status di aplikasi SIASN masih berbunyi "Menunggu Proses".</p>',
                'resolution' => '<p>Penyelesaian:</p><ul><li>Pastikan instansi asal sudah <strong>mengunggah seluruh dokumen persyaratan</strong> di SIASN secara lengkap.</li><li>Cek apakah ada notifikasi <em>Berkas Tidak Lengkap (BTL)</em> dari evaluator BKN. Jika ada, segera lengkapi dokumen yang diminta.</li><li>Hubungi layanan Helpdesk / SAPA BKN dengan menyertakan Nomor Usulan dan NIP untuk dilakukan pengecekan status secara manual.</li></ul>',
                'tags' => ['BUP', 'SIASN', 'SK Pensiun'],
                'is_published' => true,
            ],
            [
                'title' => 'Perbedaan Data Nama antara SK CPNS dan KTP Saat Pengajuan Pensiun',
                'problem' => '<p>Saat instansi mengusulkan pensiun atas nama pegawai, usulan ditolak (BTL) karena terdapat perbedaan ejaan nama atau tanggal lahir antara SK CPNS, SK Kenaikan Pangkat Terakhir, dan e-KTP.</p>',
                'resolution' => '<p>Penyelesaian:</p><ol><li>Lampirkan surat keterangan perbaikan nama dari Dinas Dukcapil setempat yang mengonfirmasi bahwa nama di KTP dan SK CPNS adalah orang yang sama.</li><li>Jika kesalahan ada di SK, lampirkan <strong>Surat Pernyataan Tanggung Jawab Mutlak (SPTJM)</strong> dari PPK instansi yang bersangkutan.</li><li>Lakukan proses Perbaikan Data (PDM) di SIASN sebelum mengajukan ulang usulan pensiun.</li></ol>',
                'tags' => ['Perbedaan Data', 'BTL', 'Syarat Pensiun'],
                'is_published' => true,
            ],
            [
                'title' => 'Pengajuan Pensiun Janda/Duda karena PNS Meninggal Dunia',
                'problem' => '<p>Seorang PNS aktif meninggal dunia, dan pasangannya (suami/istri) ingin mengurus Pensiun Janda/Duda, tetapi bingung persyaratan apa saja yang harus disiapkan ke BKN.</p>',
                'resolution' => '<p>Syarat yang wajib dilengkapi oleh keluarga/ahli waris melalui instansi tempat PNS tersebut bekerja:</p><ul><li>Surat Kematian asli / dilegalisir dari Kelurahan/Rumah Sakit.</li><li>Akta Nikah asli / dilegalisir.</li><li>SK CPNS dan SK Pangkat Terakhir.</li><li>Surat Keterangan Janda/Duda dari Kelurahan setempat.</li><li>Daftar Susunan Keluarga.</li><li>Pas foto janda/duda berwarna.</li></ul><p>Instansi kemudian akan mengusulkannya melalui menu Pemberhentian PNS di SIASN.</p>',
                'tags' => ['Meninggal Dunia', 'Janda/Duda', 'Ahli Waris'],
                'is_published' => true,
            ],
            [
                'title' => 'Pensiun Atas Permintaan Sendiri (APS) Belum 50 Tahun',
                'problem' => '<p>Pegawai mengajukan Pensiun Atas Permintaan Sendiri (APS) dengan masa kerja 22 tahun, namun usianya baru 48 tahun. Usulan ini ditolak dan tidak mendapat hak pensiun.</p>',
                'resolution' => '<p>Berdasarkan peraturan perundang-undangan (UU ASN dan PP 11/2017), hak pensiun APS hanya diberikan jika memenuhi **dua syarat kumulatif**: usia minimal <strong>50 tahun</strong> DAN masa kerja minimal <strong>20 tahun</strong>.</p><p>Karena PNS bersangkutan baru berusia 48 tahun, maka pemberhentiannya disetujui (diberhentikan dengan hormat sebagai PNS), namun <strong>tidak mendapat hak pembayaran uang pensiun bulanan</strong>. PNS hanya akan mendapat pengembalian tabungan Taspen.</p>',
                'tags' => ['APS', 'Aturan Usia', 'Hak Pensiun'],
                'is_published' => true,
            ],
            [
                'title' => 'Pemberhentian Karena Tidak Cakap Jasmani / Rohani (Sakit Permanen)',
                'problem' => '<p>PNS mengalami sakit parah / lumpuh permanen sehingga tidak dapat lagi menjalankan tugas kedinasan, bagaimana prosedur pengajuan pensiunnya sebelum mencapai BUP?</p>',
                'resolution' => '<p>Bagi PNS yang tidak cakap jasmani/rohani, dapat diberhentikan dengan hormat dengan hak pensiun (berapapun usianya) asal memenuhi syarat berikut:</p><ul><li>Surat keterangan asli dari <strong>Tim Penguji Kesehatan (Majelis Penguji Kesehatan)</strong> yang ditunjuk oleh Menteri Kesehatan yang menyatakan pegawai tersebut tidak dapat bekerja lagi dalam semua jabatan instansi pemerintah.</li><li>SKP tahun terakhir.</li><li>Surat usulan dari PPK (Pejabat Pembina Kepegawaian).</li></ul><p>Instansi agar segera mengunggah dokumen tersebut ke SIASN agar Surat Keputusan Pensiun dapat diterbitkan.</p>',
                'tags' => ['Sakit', 'Tidak Cakap Jasmani', 'Uzur', 'Majelis Kesehatan'],
                'is_published' => true,
            ],
            [
                'title' => 'Diberhentikan Tidak Dengan Hormat (PTDH) Karena Pidana Tipikor',
                'problem' => '<p>Ada PNS yang terkena kasus Tindak Pidana Korupsi (Tipikor) dan sudah memiliki putusan pengadilan yang berkekuatan hukum tetap (Inkracht). Apakah yang bersangkutan masih mendapat hak pensiun?</p>',
                'resolution' => '<p>Berdasarkan UU ASN No. 20 Tahun 2023, PNS yang dipidana penjara berdasarkan putusan pengadilan yang telah memiliki kekuatan hukum tetap karena melakukan kejahatan jabatan atau kejahatan yang ada hubungannya dengan jabatan (termasuk Tindak Pidana Korupsi) akan dijatuhi hukuman <strong>Pemberhentian Tidak Dengan Hormat (PTDH)</strong>.</p><p>Konsekuensi dari PTDH adalah PNS bersangkutan <strong>TIDAK akan mendapatkan Hak Pensiun</strong> bulanan, terlepas dari berapapun masa kerja dan usianya saat ini.</p>',
                'tags' => ['PTDH', 'Korupsi', 'Tipikor', 'Pidana', 'Pemecatan'],
                'is_published' => true,
            ],
            [
                'title' => 'Pengajuan Kenaikan Pangkat Pengabdian Menjelang Pensiun BUP',
                'problem' => '<p>PNS yang akan pensiun bulan depan memiliki SK KP (Kenaikan Pangkat) terakhir 4 tahun yang lalu. Apakah bisa mengajukan Kenaikan Pangkat Pengabdian (KP Pengabdian)?</p>',
                'resolution' => '<p>Bisa, namun ada syarat yang sangat mengikat:</p><ol><li>Memiliki masa kerja paling rendah 30 tahun terus-menerus dan telah 1 bulan dalam pangkat terakhir, atau masa kerja 20 tahun terus-menerus dan 1 tahun dalam pangkat terakhir, atau 10 tahun terus-menerus dan 2 tahun dalam pangkat terakhir.</li><li>Penilaian Kinerja (SKP) bernilai "Sangat Baik" dalam 1 tahun terakhir, atau "Baik" dalam 2 tahun terakhir.</li><li>Tidak pernah dijatuhi hukuman disiplin tingkat sedang atau berat.</li></ol><p>Usulan KP Pengabdian harus diajukan satu paket bersamaan dengan usul penetapan BUP di SIASN.</p>',
                'tags' => ['KP Pengabdian', 'Kenaikan Pangkat', 'BUP', 'Syarat'],
                'is_published' => true,
            ],
            [
                'title' => 'Pemberhentian PNS Karena Menjadi Calon Kepala Daerah / Anggota Legislatif',
                'problem' => '<p>PNS berniat mendaftarkan diri sebagai Calon Bupati / Calon Anggota Legislatif (DPR/DPRD/DPD) dalam Pilkada atau Pemilu. Kapan harus mengundurkan diri dan apakah dapat pensiun?</p>',
                'resolution' => '<p>Sesuai aturan netralitas ASN, PNS <strong>wajib mengundurkan diri secara tertulis</strong> sebagai PNS terhitung sejak mendaftar sebagai calon (bukan sejak ditetapkan). Surat pengunduran diri tidak dapat ditarik kembali.</p><p>Mengenai Hak Pensiun, berlaku syarat APS (Atas Permintaan Sendiri): Jika saat mengundurkan diri usia pegawai minimal 50 tahun DAN masa kerjanya minimal 20 tahun, maka ia berhak atas pensiun. Jika salah satu atau kedua syarat tersebut tidak terpenuhi, maka diberhentikan tanpa hak pensiun (hanya mendapat Taspen).</p>',
                'tags' => ['Pilkada', 'Pemilu', 'Politik', 'Mengundurkan Diri', 'Netralitas'],
                'is_published' => true,
            ],
            [
                'title' => 'Pensiun Anumerta (Gugur Saat Menjalankan Tugas)',
                'problem' => '<p>Seorang PNS meninggal dunia secara mendadak saat sedang dalam perjalanan dinas resmi. Bagaimana pengurusan Pensiun Anumertanya?</p>',
                'resolution' => '<p>PNS yang tewas (meninggal dalam keadaan menjalankan tugas kedinasan) akan diberikan Kenaikan Pangkat Anumerta (dinaikkan pangkatnya setingkat lebih tinggi) dan keluarga/ahli waris berhak atas Pensiun Anumerta.</p><p><strong>Persyaratan Khusus:</strong></p><ul><li>Surat Perintah Tugas (SPT) atau SPPD dari atasan.</li><li>Surat Keterangan Kematian dari instansi medis/kepolisian (jika kecelakaan lalu lintas).</li><li>Laporan Kronologis Kejadian yang ditandatangani Pejabat Pembina Kepegawaian (PPK) atau pejabat berwenang.</li></ul><p>Usulan penetapan tewas wajib dilakukan secepat mungkin ke BKN Pusat agar santunan asuransi kematian dan SK Janda/Duda Anumerta dapat segera dicairkan.</p>',
                'tags' => ['Anumerta', 'Gugur', 'Tewas', 'Dinas', 'Kematian'],
                'is_published' => true,
            ],
            [
                'title' => 'Cara Klaim THT dan Gaji Pensiun Pertama di TASPEN (e-Klim)',
                'problem' => '<p>SK Pensiun dari BKN sudah terbit dan saya sudah memasuki masa pensiun. Bagaimana prosedur untuk mencairkan Tabungan Hari Tua (THT) dan Gaji Pensiun Pertama melalui PT TASPEN?</p>',
                'resolution' => '<p>Pencairan kini dapat dilakukan secara digital melalui layanan <strong>TASPEN Online (e-Klim)</strong> atau TOOS (Taspen One Hour Online Service). Persyaratan utama yang harus disiapkan:</p><ol><li>Fotokopi SK Pensiun yang dilegalisir.</li><li>Asli <strong>Surat Keterangan Penghentian Pembayaran (SKPP)</strong> yang dibuat oleh instansi dan disahkan oleh KPPN/BKAD.</li><li>KTP Elektronik pemohon.</li><li>Buku Rekening Bank untuk penerimaan gaji pensiun.</li><li>Pas foto suami istri berwarna.</li></ol><p><em>Catatan: Kunci utama pencairan adalah SKPP. Jika SKPP belum disahkan oleh KPPN, maka TASPEN belum bisa memproses pencairan.</em></p>',
                'tags' => ['TASPEN', 'THT', 'Gaji Pertama', 'Klaim', 'SKPP'],
                'is_published' => true,
            ],
            [
                'title' => 'Gagal Melakukan Otentikasi TASPEN karena Sakit / Uzur',
                'problem' => '<p>Pensiunan selalu gagal melakukan otentikasi bulanan (wajah/sidik jari) melalui aplikasi TASPEN di HP karena kondisi sakit parah atau sedang dirawat di Rumah Sakit, sehingga gaji pensiunnya ditangguhkan.</p>',
                'resolution' => '<p>Bagi pensiunan yang sedang sakit uzur atau dirawat sehingga tidak bisa melakukan otentikasi digital, keluarga berhak mengurusnya secara manual:</p><ul><li>Keluarga (ahli waris) harus meminta <strong>Surat Keterangan Dokter/Rumah Sakit</strong> atau Surat Keterangan Sakit dari Kelurahan.</li><li>Bawa surat tersebut beserta fotokopi KTP Pensiunan dan KTP perwakilan ke Kantor Cabang TASPEN atau Mitra Bayar (Bank/Pos) terdekat.</li><li>Isi formulir <em>Surat Pernyataan Tanggung Jawab Mutlak (SPTJM)</em> Otentikasi Manual.</li></ul><p>Mitra bayar akan membukakan blokir gaji pada bulan tersebut secara manual berdasarkan bukti fisik tersebut.</p>',
                'tags' => ['TASPEN', 'Otentikasi', 'Sakit', 'Gagal Otentikasi', 'Blokir'],
                'is_published' => true,
            ],
            [
                'title' => 'Mutasi Kantor Bayar Pensiun (Pindah Domisili)',
                'problem' => '<p>Saya seorang Pensiunan PNS yang awalnya berdomisili dan menerima pensiun di Manokwari (Bank Papua). Bulan depan saya pindah menetap ke Makassar dan ingin memindahkan rekening penerimaan ke Bank BRI Makassar. Apa yang harus dilakukan?</p>',
                'resolution' => '<p>Anda harus melakukan proses <strong>Mutasi Kantor Bayar</strong> melalui PT TASPEN, dengan langkah-langkah:</p><ol><li>Datang ke Bank/Kantor Pos tempat penerimaan gaji lama (di Manokwari) untuk meminta <strong>Surat Keterangan Pindah Kantor Bayar (SKPKB)</strong>.</li><li>Pastikan tidak ada tunggakan potongan pinjaman bank di kantor bayar lama.</li><li>Bawa SKPKB tersebut beserta KTP, SK Pensiun, dan Buku Rekening Bank baru ke Kantor TASPEN tujuan (Makassar) atau ajukan secara online via aplikasi TASPEN.</li></ol><p><em>Proses mutasi sebaiknya diajukan selambat-lambatnya tanggal 15 agar gaji bulan berikutnya sudah masuk ke rekening yang baru.</em></p>',
                'tags' => ['TASPEN', 'Mutasi Bank', 'Pindah Domisili', 'Kantor Bayar'],
                'is_published' => true,
            ]
        ];

        foreach ($cases as $case) {
            \App\Models\RetirementCase::create($case);
        }
    }
}
