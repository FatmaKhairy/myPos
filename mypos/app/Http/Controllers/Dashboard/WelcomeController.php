<?php


namespace App\Http\Controllers\Dashboard;


use App\Category;
use App\client;
use App\Http\Controllers\Controller;
use App\order;
use App\product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class WelcomeController extends  Controller
{


   public function index()
		 {
		 		 $categories_count=Category::count();
				 $users_count=User::whereRoleIs('admin')->count();
				 $products_count=product::count();
				 $clients_count=client::count();
				 $orders_count=order::count();


			/* $years=order::select(
			 		DB::raw('Year(created_at) as year')
			   )->get();

      // dd($years);
//هنا وصلنا اننا نجيب السنوات لوحدها ونطلع اول سنه
$newYears=0;
			$myYears= data_get($years, '*.year');
		  //dd( array_values($myYears)[0]);// call first element in array
			/////نفكر بقي ازاي نستخدمهم هناك*/

		//	$year=$this->getYear('2018');

//$order=new order();

$order=new order();



			/*	select only for all years
			$salesMonthly=order::select(
				 		 DB::raw('YEAR(created_at) as year'),
						 DB::raw('MONTH(created_at) as month'),
						 DB::raw('SUM(total_price) as sum')
				 )->groupby('month')->get();*/



			// $year = $order->getYear('2019');



			// SELECT YEAR(created_at) as year, MONTH(created_at) as month,Sum(total_price) as sum FROM `orders`***select
			 // WHERE YEAR(created_at) =2019 GROUP BY month***where
/*$year=DB::table('orders')
		 ->select(
		         DB::raw('YEAR(created_at) as year'),
						 DB::raw('MONTH(created_at) as month'),
						 DB::raw('SUM(total_price) as sum')
	         )
		 ->whereYear('created_at', '2018')
		 ->groupby('month')
		 ->get();*/
  $order=new  order();
//SELECT YEAR( created_at) as year FROM `orders`GROUP BY year to send years in DB auto
			 $yearsdata=order::select(
			 		DB::raw('YEAR( created_at) as year')
			 )->groupby('year')->get();
      $years=data_get($yearsdata, '*.year');
      $allYears=data_get($yearsdata, '*.year');





		return view('dashboard.welcome',compact(['categories_count','users_count','clients_count','products_count','orders_count','order','years', 'allYears']));
//		return view('dashboard.welcome',compact('categories_count','users_count','clients_count','products_count','orders_count','order','years'));
		 }//end of index fun


		public function getAllData(Request $request){

   		if ($request->ajax()){
					$year=DB::table('orders')
							->select(
									DB::raw('YEAR(created_at) as year'),
									DB::raw('MONTH(created_at) as month'),
									DB::raw('SUM(total_price) as sum')
							)
							->whereYear('created_at', $request->year)
							->groupby('month')
							->get();

					return response()->json($year);

			}


		}

}//end of class
/*جربي تطلعي الشهر
                             data.forEach(function(data,index) {
                                //console.log(data['year'])
                                y=data['year']
                                m=data['month']
                                sum=data['sum']
                                ym=y+'-'+m
                                // console.log(ym)

                            });
*/