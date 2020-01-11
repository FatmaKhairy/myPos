<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class client extends Model
{
		use LaratrustUserTrait;
		use Notifiable;

    protected $guarded=[];
    protected  $casts=[
    		'phone'=>'array',
		];

		public function orders()
		{
				return $this->hasMany(order::class);
		}//end orders

}
/*
 *   */