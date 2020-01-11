<?php



Route::group(
		[
				'prefix' => LaravelLocalization::setLocale(),
				'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
		],
		function()
		{
				Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function (){


						Route::get('/','WelcomeController@index')->name('welcome');
						Route::post('/all-year-data','WelcomeController@getAllData')->name('allYearData');

            //categories route
						Route::resource('categories','CategoryController')->except(['show']);
						//productss route
						Route::resource('products','productController')->except(['show']);
						//clients route
						Route::resource('clients','ClientController')->except(['show']);
						//orders route
						Route::resource('clients.orders','client\OrderController')->except(['show']);
						//order outer route
						Route::resource('orders','OrderController')->except(['show']);
						Route::get     ('orders/{order}/products','OrderController@products')->name('orders.products');
						//user route
						Route::resource('users','UserController')->except(['show']);




				});//end of dashboard route
		});