<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
		protected $fillable = [
			'name',
			'departement_id',
			'position',
			'nip',
			'photo',
			'lhkpn',
			'category'
			];

		public function letterin()
		{
			return $this->hasMany(LetterIn::class);
		}

		public function departement()
		{
			return $this->belongsTo(Departement::class);
		}

		public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

		public function getMaskedNipAttribute()
    {
        $nip = $this->attributes['nip'];

        // ambil 6 digit pertama
        $prefix = substr($nip, 0, 6);

        // ambil 2 digit terakhir
        $suffix = substr($nip, -2);

        // hitung jumlah digit yang harus dimasking
        $maskLength = strlen($nip) - (strlen($prefix) + strlen($suffix));

        // buat masking
        $masked = str_repeat('*', $maskLength);

        return $prefix . $masked . $suffix;
    }



}
