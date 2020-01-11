<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productTranslation extends Model
{
		public $timestamps = false;
		protected $fillable = ['name','description'];
}