<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class Category extends Authenticatable
{
		use LaratrustUserTrait;
		use Notifiable;

		use \Dimsav\Translatable\Translatable;
		public $translatedAttributes = ['name'];
		protected $guarded = [];

		public  function product()
		{
				return $this->hasMany(product::class);
		}


}