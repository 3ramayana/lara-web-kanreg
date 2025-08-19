<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

		protected $fillable = [
			'question_id', 'jawaban'
		];

		public function questions()
		{
			return $this->belongsTo(Question::class, 'question_id');
		}

		

}
