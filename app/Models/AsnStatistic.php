<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsnStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'city_id',
        'employee_type',
        'gender_male',
        'gender_female',
        'edu_sd',
        'edu_smp',
        'edu_sma',
        'edu_d1',
        'edu_d2',
        'edu_d3',
        'edu_d4',
        'edu_s1',
        'edu_s2',
        'edu_s3',
        'edu_profesi',
        'pos_jpt_madya',
        'pos_jpt_pratama',
        'pos_administrator',
        'pos_pengawas',
        'pos_fungsional',
        'pos_pelaksana',
        // Golongan PNS
        'gol_pns_1', 'gol_pns_2', 'gol_pns_3', 'gol_pns_4',
        // Golongan PPPK
        'gol_pppk_1', 'gol_pppk_2', 'gol_pppk_3', 'gol_pppk_4', 'gol_pppk_5', 'gol_pppk_6', 'gol_pppk_7', 'gol_pppk_8', 'gol_pppk_9', 'gol_pppk_10', 'gol_pppk_11',
        // Masa Kerja
        'mk_0_5', 'mk_6_10', 'mk_11_15', 'mk_16_20', 'mk_21_25', 'mk_26_30', 'mk_30_plus',
        // Usia
        'age_17_20', 'age_21_30', 'age_31_40', 'age_41_50', 'age_51_58', 'age_58_plus',
    ];

    /**
     * Relasi ke Kabupaten/Kota/Provinsi
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Hitung total ASN dari rekaman ini (berdasarkan gender)
     */
    public function getTotalAttribute()
    {
        return $this->gender_male + $this->gender_female;
    }
}
