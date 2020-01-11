<?php

namespace App\Http\Controllers\Dashboard\client;

use App\Category;
use App\client;
use App\order;
use App\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{


    public function create(client $client)

    {
				$categories = Category::with('product')->get();
			  $orders = $client->orders()->with('products')->paginate(5);//previous_orders
				return view('dashboard.clients.orders.create', compact( 'client', 'categories','orders'));
    }//end of create

    public function store(Request $request,client $client)
		{

				//هنا هنخزن ف هنتعامل مع الاوردر موديل
				$request->validate([
						'products' => 'required|array',
						/*
						32	'product_ids' => 'required|array',
							32'quantities' => 'required|array',

							 * لا هنجيبهم من الorder.js  افضل 	'client_id'=>'required',
								'order_id'=>'required',
								'product_id'=>'required',
								'quantity'=>'required',
								'total_price'=>'required',
							*/
				]);//end validation
				/*  use attach_order()
								$order = $client->orders()->create([]);
								//one to manyهنا اتسجل اوردر بس بدون اي شئ لا سعر ولا اي هو --كمان اتسجل ف جدول الوردر بس بدون ..product-order
								$order->products()->attach($request->products);
								//هنا اتسجل ف الجدولين order/product-order
								$total = 0;//نعمل لوب عشان نحسب المجموع
								foreach ($request->products as $productId => $quantity) {
										$product = product::FindOrFail($productId);

												$total += $product->sales_price * $quantity;كدا غلك لا مينفعش اضرب رقم ف array
														dd($request->products);
														array:1 [▼
												2 => array:1 [▼
												"quantity" => "1"
													]
						]
						$total += $product->sales_price * $quantity['quantity'];
						$product->update(['stock' => $product->stock - $quantity['quantity']]);
				}
				$order->update(['total_price' => $total]);*/
				$this->attach_order($request,$client);
				session()->flash('success', __('site.added-successfully'));

				return redirect()->route('dashboard.orders.index');

				/*
				 *  عايزه اقوله شوفلي كل منتج معاه كميه اد اي !
				 * طيب هجيب المنتجاتا منين ؟؟
				 * طبعا من الريكوست اللي جاي فيه الكميه والمنتج
				*/

		   	/*32	foreach ($request->product_ids as $index => $product_id) {

						$product = product::FindOrFail($product_id);
						$total += $product->sales_price * $request->quantities[$index];
						$order->products()->attach($product_id, ['quantity' => $request->quantities[$index]]);
						$product->update(['stock' => $product->stock - $request->quantities[$index]]);
				}*/

				//$order->update(['total_price' => $total]);
				// session()->flash('success', __('site.added-successfully'));
				// return redirect()->route('dashboard.orders.index');

				/*$user->roles()->attach($roleId);
				$user اللي هو الاوبجكت الاصلي اللي هو كلاينت عامل اوردر وقيمته$client->orders()->create([]);
				roless() دي الداله اللي بتربط الابجكت بالموديل وهي علاقه بين حدولين
				attach زي ماعملتها قبل كدا عشان انسب ادمن للسوبر ادمن عملتها هنا عشان انسب الطلبات لعميل معيت
				********************
				 * بدل ال products() كنت كاتبه الobject  منها ودا خلي الكود ميشتغلش لاني اصلا لسا
				 * بعمل لوب عليه وقيمته فاضيه اكتشفت الغلطه وانا بدور ع داله الattach  ف موقع لارافيل */
				//end of store
		}

    public function edit(client $client,order $order)
    {
				 $categories = Category::with('product')->get();
				 $PreOrders = $client->orders()->with('products')->latest()->paginate(5);//previous_orders
          return view('dashboard.clients.orders.edit',compact('client','order','categories','PreOrders'));
    }//end of edit

    public function update(Request $request, client $client,order $order)
    {
      $this->delete_order($order);
			$this->attach_order($request,$client);
      session()->flash('success',__('site.updated-successfully'));
      return redirect()->route('dashboard.orders.index');
    }//end of update


		private function attach_order($request,$client)
		{
				$order = $client->orders()->create([]);
				$order->products()->attach($request->products);
				$total = 0;
				foreach ($request->products as $productId => $quantity) {
						$product = product::FindOrFail($productId);
						$total += $product->sales_price * $quantity['quantity'];
						$product->update(['stock' => $product->stock - $quantity['quantity']]);
				}
				$order->update(['total_price' => $total]);
		}
		private function delete_order($order)
		{
				foreach ($order->products as $product)
				{
						$product->update([
								'stock'=>$product->stock + $product->pivot->quantity
						]);
				}
				$order->delete();
		}
}
