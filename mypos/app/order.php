<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class order extends Model
{
		protected $guarded = [];

	public function client(){
			return $this->belongsTo(client::class);
	}//end client
		public function products(){
				return $this->belongsToMany(product::class,'product_order')->withPivot('quantity');
				/*withPivot('quantity')
				عشان اقدر اعرض الكميه لازم اكتب كدا
				 لان الكميه مش تبع الproduct model  وكذلك اي شئ عاوزه اوصله موجود ف جدول ليه علاقه بجدولي مش جدولي نفسه
				*/
		}

		//get year
		public function getYear($value)
		{
				$year=DB::table('orders')
						->select(
								DB::raw('YEAR(created_at) as year'),
								DB::raw('MONTH(created_at) as month'),
								DB::raw('SUM(total_price) as sum')
						)
						->whereYear('created_at', $value)
						->groupby('month')
						->get();
				return $year;
		}


}
