<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Document extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Document has been {$eventName}");
    }

		protected $fillable = [
			'title',
			'category_id',
			'desc',
			'is_public',
			'year',
			'file',
			];

		public function categories()
		{
			return $this->belongsto(Category::class, 'category_id');
		}
}
