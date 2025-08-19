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
			];

		public function letterin()
		{
			return $this->hasMany(LetterIn::class);
		}

		public function departement()
		{
			return $this->belongsTo(Departement::class);
		}

}
