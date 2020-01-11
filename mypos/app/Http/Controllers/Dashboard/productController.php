<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\product;
use App\product_translations;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class productController extends Controller
{
    public function index(Request $request)
    {
				$categories=Category::all();

    		$products= product::when($request->search,function ($quire) use ($request){

    				return $quire->whereTranslationLike('name','%'.$request->search.'%');

				})->when($request->category_id,	function ($q) use ($request) {

						return $q->where('category_id', $request->category_id);
				}

				)->latest()->paginate(5);


       return view('dashboard.products.index',compact('categories','products'));


    } //end of index


    public function create()
    {
    		$categories=Category::all();
    	return view('dashboard.products.create',compact('categories'));

    }//end of create



    public function store(Request $request)
    {

        $rules=[
        		'category_id'=>'required',
				];
        foreach (config('translatable.locales') as $locale){
        		$rules +=[$locale.'.name'=>'required|unique:product_translations,name'];
        		$rules +=[$locale .'.description'=>'required'];
				}
				$rules +=[
						'purchase_price'=>'required',
						'sales_price'=>'required',
						'stock'=>'required',
				];
        $request->validate($rules);
				$request_data=$request->all();
				if($request->image)
				{
						Image::make($request->image)
								->resize(300, null, function ($constraint)
								{
										$constraint->aspectRatio();
								})->save(public_path('uploads/product_images/'. $request->image->hashName()));

						$request_data['image']=$request->image->hashName();

				}//end if

				product::create($request_data);

				session()->flash('success', __('site.added-successfully'));
				return redirect()->route('dashboard.products.index');

    }//end of store



    public function edit(product $product)
    {
    		$categories=Category::all();
				return view('dashboard.products.edit',compact('categories','product'));
    }

    public function update(Request $request, product $product)
    {
        $rules=[
        		'category_id'=>'required',
				];
			foreach (config('translatable.locales') as $locale){
					$rules +=[$locale.'.name'=>['required',Rule::unique('product_translations','name')->ignore($product->id,'product_id')]];
					$rules +=[$locale.'.description'=>'required',];
		}//end foreach
				$rules +=[
						'purchase_price'=>'required',
						'sales_price'=>'required',
						'stock'=>'required',
				];
				$request->validate($rules);
				$request_data=$request->all();

			if($request->image)
			{
					if ($product->image != 'default.jpg'){
							Storage::disk('public_uploads')->delete('/product_images/'.$product->image);
					}
					Image::make($request->image)->resize(300,null,function ($constraint){

							$constraint->aspectRatio();
					})->save(public_path('uploads/product_images/'. $request->image->hashName()));

					$request_data['image']=$request->image->hashName();
			}//end if
				$product->update($request_data);
				session()->flash('success', __('site.updated-successfully'));
				return redirect()->route('dashboard.products.index');
    }


    public function destroy(product $product)
    {
				if ($product->image != 'default.jpg'){
						Storage::disk('public_uploads')->delete('/product_images/'.$product->image);
				}
        $product->delete();
				session()->flash('success', __('site.deleted-successfully'));
				return redirect()->route('dashboard.products.index');
    }
}
