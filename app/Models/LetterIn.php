<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterIn extends Model
{
    use HasFactory;
		protected $fillable = [
			'name',
			'category_letter_id',
			'departement_id',
			'reference_number',
			'date_letter',
			'date_in',
			'origin_letter',
			'properties_letter',
			'file',
			'employee_id'
		];

		public function category_letter()
		{
			return $this->belongsTo(CategoryLetter::class, 'category_letter_id');
		}

		public function departement()
		{
			return $this->belongsTo(Departement::class);
		}

		public function employee()
		{
			return $this->belongsTo(Employee::class,'employee_id');
		}

// 		protected static function boot()
// {
//     parent::boot();

//     static::addGlobalScope('departement', function (\Illuminate\Database\Eloquent\Builder $builder) {
//         if (auth()->check()) {
//             $builder->where('departement_id', auth()->user()->departement_id);
//         }
//     });
// }
}
