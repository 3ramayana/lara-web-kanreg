<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsnStatistic;

class AsnStatisticPublicController extends Controller
{
    public function index(Request $request)
    {
        $availableYears = AsnStatistic::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        $availableCities = \App\Models\City::orderBy('name', 'asc')->get();
        $monthsList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $latestYear = AsnStatistic::max('year') ?? date('Y');
        
        // Data 1 Parameters
        $selectedYear = $request->input('year', $latestYear);
        // Smart Default for Month 1
        $maxMonth1 = AsnStatistic::where('year', $selectedYear)->max('month') ?? 1;
        $selectedMonth = $request->input('month', $maxMonth1);
        $selectedCity = $request->input('city_id', 'all');

        // Data 2 Parameters (Comparison)
        $isCompare = $request->has('compare');
        $compareYear = $request->input('compare_year', $latestYear);
        // Smart Default for Month 2
        $maxMonth2 = AsnStatistic::where('year', $compareYear)->max('month') ?? 1;
        $compareMonth = $request->input('compare_month', $maxMonth2);
        $compareCity = $request->input('compare_city_id', 'all');

        // Extract Data 1
        $data1Result = $this->extractData($selectedYear, $selectedMonth, $selectedCity);
        $dataset1 = $data1Result['chart'];
        $tableData = $data1Result['raw'];

        $chartData = [
            'isCompare' => $isCompare,
            'label1' => $this->getLegendLabel($selectedYear, $selectedMonth, $selectedCity, $availableCities, $monthsList),
            'employee' => ['labels' => ['PNS', 'PPPK'], 'values1' => $dataset1['employee']],
            'gender' => ['labels' => ['Laki-Laki', 'Perempuan'], 'values1' => $dataset1['gender']],
            'education' => ['labels' => array_keys($dataset1['education']), 'values1' => array_values($dataset1['education'])],
            'position' => ['labels' => array_keys($dataset1['position']), 'values1' => array_values($dataset1['position'])],
            'age' => ['labels' => array_keys($dataset1['age']), 'values1' => array_values($dataset1['age'])],
            'golPns' => ['labels' => array_keys($dataset1['golPns']), 'values1' => array_values($dataset1['golPns'])],
            'golPppk' => ['labels' => array_keys($dataset1['golPppk']), 'values1' => array_values($dataset1['golPppk'])],
            'masaKerja' => ['labels' => array_keys($dataset1['masaKerja']), 'values1' => array_values($dataset1['masaKerja'])],
        ];

        // If Comparison is active, extract Data 2
        if ($isCompare) {
            $data2Result = $this->extractData($compareYear, $compareMonth, $compareCity);
            $dataset2 = $data2Result['chart'];
            $tableData = $tableData->merge($data2Result['raw']);

            $chartData['label2'] = $this->getLegendLabel($compareYear, $compareMonth, $compareCity, $availableCities, $monthsList);
            $chartData['employee']['values2'] = $dataset2['employee'];
            $chartData['gender']['values2'] = $dataset2['gender'];
            $chartData['education']['values2'] = array_values($dataset2['education']);
            $chartData['position']['values2'] = array_values($dataset2['position']);
            $chartData['age']['values2'] = array_values($dataset2['age']);
            $chartData['golPns']['values2'] = array_values($dataset2['golPns']);
            $chartData['golPppk']['values2'] = array_values($dataset2['golPppk']);
            $chartData['masaKerja']['values2'] = array_values($dataset2['masaKerja']);
        }

        $data = $tableData;

        // Prepare Map Data (Using Data 1)
        $mapData = [];
        $citiesForMap = \App\Models\City::whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($citiesForMap as $city) {
            $cityTotal = $data1Result['raw']->where('city_id', $city->id)->sum(function ($item) {
                return $item->gender_male + $item->gender_female;
            });
            if ($cityTotal > 0) {
                $mapData[] = [
                    'id' => $city->id,
                    'name' => $city->name,
                    'lat' => $city->latitude,
                    'lng' => $city->longitude,
                    'total' => $cityTotal
                ];
            }
        }

        // Prepare Trend Data (Using Data 1's Year and City)
        $trendQuery = AsnStatistic::where('year', $selectedYear);
        if ($selectedCity !== 'all') {
            $trendQuery->where('city_id', $selectedCity);
        }
        $trendRawData = $trendQuery->get();

        $trendData = [
            'labels' => array_values($monthsList),
            'pns' => [],
            'pppk' => []
        ];

        for ($i = 1; $i <= 12; $i++) {
            $monthData = $trendRawData->where('month', $i);
            $pnsTotal = $monthData->where('employee_type', 'PNS')->sum(function ($item) {
                return $item->gender_male + $item->gender_female;
            });
            $pppkTotal = $monthData->where('employee_type', 'PPPK')->sum(function ($item) {
                return $item->gender_male + $item->gender_female;
            });
            $trendData['pns'][] = $pnsTotal;
            $trendData['pppk'][] = $pppkTotal;
        }

        return view('website.pages.statistik-asn', compact(
            'chartData', 
            'mapData',
            'trendData',
            'availableYears', 
            'availableCities', 
            'monthsList',
            'selectedYear', 
            'selectedMonth',
            'selectedCity',
            'isCompare',
            'compareYear',
            'compareMonth',
            'compareCity',
            'data'
        ));
    }

    private function getLegendLabel($year, $month, $cityId, $cities, $monthsList)
    {
        $cityName = 'Seluruh Wilayah Kerja';
        if ($cityId !== 'all') {
            $city = $cities->where('id', $cityId)->first();
            if ($city) $cityName = $city->name;
        }
        $monthName = $monthsList[$month] ?? '';
        return $monthName . ' ' . $year . ' - ' . $cityName;
    }

    private function extractData($year, $month, $cityId)
    {
        $query = AsnStatistic::with('city')->where('year', $year)->where('month', $month);
        if ($cityId !== 'all') {
            $query->where('city_id', $cityId);
        }

        $data = $query->get();

        $totalPns = $data->where('employee_type', 'PNS')->sum(function ($item) {
            return $item->gender_male + $item->gender_female;
        });
        $totalPppk = $data->where('employee_type', 'PPPK')->sum(function ($item) {
            return $item->gender_male + $item->gender_female;
        });

        return [
            'raw' => $data,
            'chart' => [
                'employee' => [$totalPns, $totalPppk],
                'gender' => [$data->sum('gender_male'), $data->sum('gender_female')],
                'education' => [
                    'SD' => $data->sum('edu_sd'),
                    'SMP' => $data->sum('edu_smp'),
                    'SMA' => $data->sum('edu_sma'),
                    'Diploma' => $data->sum('edu_d1') + $data->sum('edu_d2') + $data->sum('edu_d3') + $data->sum('edu_d4'),
                    'Strata 1' => $data->sum('edu_s1'),
                    'Strata 2 & 3' => $data->sum('edu_s2') + $data->sum('edu_s3'),
                    'Profesi' => $data->sum('edu_profesi')
                ],
                'position' => [
                    'JPT' => $data->sum('pos_jpt_madya') + $data->sum('pos_jpt_pratama'),
                    'Administrator' => $data->sum('pos_administrator'),
                    'Pengawas' => $data->sum('pos_pengawas'),
                    'Fungsional' => $data->sum('pos_fungsional'),
                    'Pelaksana' => $data->sum('pos_pelaksana')
                ],
                'age' => [
                    '17-20' => $data->sum('age_17_20'),
                    '21-30' => $data->sum('age_21_30'),
                    '31-40' => $data->sum('age_31_40'),
                    '41-50' => $data->sum('age_41_50'),
                    '51-58' => $data->sum('age_51_58'),
                    '>58' => $data->sum('age_58_plus')
                ],
                'golPns' => [
                    'Gol I' => $data->sum('gol_pns_1'),
                    'Gol II' => $data->sum('gol_pns_2'),
                    'Gol III' => $data->sum('gol_pns_3'),
                    'Gol IV' => $data->sum('gol_pns_4'),
                ],
                'golPppk' => [
                    'Gol I' => $data->sum('gol_pppk_1'), 'Gol II' => $data->sum('gol_pppk_2'), 'Gol III' => $data->sum('gol_pppk_3'),
                    'Gol IV' => $data->sum('gol_pppk_4'), 'Gol V' => $data->sum('gol_pppk_5'), 'Gol VI' => $data->sum('gol_pppk_6'),
                    'Gol VII' => $data->sum('gol_pppk_7'), 'Gol VIII' => $data->sum('gol_pppk_8'), 'Gol IX' => $data->sum('gol_pppk_9'),
                    'Gol X' => $data->sum('gol_pppk_10'), 'Gol XI' => $data->sum('gol_pppk_11'),
                ],
                'masaKerja' => [
                    '0-5 Thn' => $data->sum('mk_0_5'),
                    '6-10 Thn' => $data->sum('mk_6_10'),
                    '11-15 Thn' => $data->sum('mk_11_15'),
                    '16-20 Thn' => $data->sum('mk_16_20'),
                    '21-25 Thn' => $data->sum('mk_21_25'),
                    '26-30 Thn' => $data->sum('mk_26_30'),
                    '>30 Thn' => $data->sum('mk_30_plus'),
                ]
            ]
        ];
    }
}
