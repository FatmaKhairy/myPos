<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class product extends Model
{
		use LaratrustUserTrait;
		use Notifiable;

		use \Dimsav\Translatable\Translatable;
		public $translatedAttributes = ['name','description'];
		protected $guarded = [];
	//image
		protected  $appends=['image_path','profit_percent'];
		public function getImagepathAttribute(){
				return asset('uploads/product_images/'.$this->image);
		}
		public function getprofitPercentAttribute(){
			$percent=$this->sales_price - $this->purchase_price;
			$profit_percent=$percent*100/$this->purchase_price;
			return number_format($profit_percent);
		}
		public  function category()
		{
				return $this->belongsTo(Category::class);
		}
		public function orders(){
				return $this->belongsToMany(order::class,'product_order');
		}

}