<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\client;
use App\order;
use App\product;
use App\product_translations;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class OrderController extends Controller
{

            public function index(Request $request)
            {
            		$orders=order::whereHas('client',function ($q) use ($request){
            				return $q->where('name','like','%'.$request->search.'%');
								})->paginate(5);

                return view('dashboard.orders.index',compact('orders'));

            } //end of index
            public function products(order $order)
            {
            	 	$products= $order->products;
            	 	$client=$order->client;
            	 	 return view('dashboard.orders._product',compact('order','products','client'));
            }//end of store

            public function destroy(order $order)
						{
								//$order->product->pivot->quantityعشان نوصل للكميه
								//مش بس هنحذف كمان لازم نرجع الكميه اللي حذفناها ف المخزن
								foreach ($order->products as $product)
								{
										$product->update([
												'stock'=>$product->stock + $product->pivot->quantity
										]);
								}
								$order->delete();
								session()->flash('success',__('site.deleted-successfully'));
								return redirect()->route('dashboard.orders.index');
						}//end of destroy

}