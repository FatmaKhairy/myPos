<?php

namespace App\Http\Controllers\Dashboard;

use App\client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index(Request $request)
    {

    		$clients=client::when($request->search,function ($query) use ($request){

    				return $query->where('name','like','%'.$request->search.'%')
								         ->orWhere('phone','like','%'.$request->search.'%')
								         ->orWhere('address','like','%'.$request->search.'%');
				})->latest()->paginate(5);

       return view('dashboard.clients.index',compact('clients'));
    }//end of index

    public function create()
    {
				return view('dashboard.clients.create');
    }//end of create


    public function store(Request $request)
    {
           $request->validate([
           		 'name'=>'required',
							 'phone'=>'required|array|min:1',
							 'phone.0'=>'required',
							 'address'=>'required',

					 ]);
          // $request_data=$request->all();
           //$request_data['phone']=array_filter($request->phone);
          // dd($request_data);
           client::create($request->all());
				session()->flash('success', __('site.added-successfully'));
           return redirect()->route('dashboard.clients.index');
    }//end of store


    public function edit(client $client)
    {
				return view('dashboard.clients.edit',compact('client'));
    }//end of edit

    public function update(Request $request, client $client)
		{
				$request->validate([
						'name'=>'required',
						'phone'=>'required|array|min:1',
						'phone.0'=>'required',
						'address'=>'required',

				]);
				$client->update($request->all());
				session()->flash('success', __('site.updated-successfully'));
				return redirect()->route('dashboard.clients.index');

    }//end of update

    public function destroy(client $client)
    {
      $client->delete();
				session()->flash('success', __('site.deleted-successfully'));
				return redirect()->route('dashboard.clients.index');
    }//end of destroy

}//end of class
