@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.products')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class="active">@lang('site.products')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.products')<smail>{{$products->total()}}</smail></h3>
                    <form action="{{route('dashboard.products.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search"  placeholder="@lang('site.search')" value="{{request()->search}}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <select name="category_id" class="form-control">
                                    <option value="">@lang('site.products')</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{request()->category_id==$category->id ?'selected':''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')
                                </button>
                                @if(auth()->user()->hasPermission('create_products'))
                                    <a href="{{route('dashboard.products.create')}}" class="btn btn-info">
                                        <i class="fa fa-plus"></i>@lang('site.add product')
                                    </a>
                                @else
                                    <a href="#" class="btn btn-info disabled">
                                        <i class="fa fa-plus"></i>@lang('site.add product')
                                    </a>
                                @endif
                            </div>
                        </div>

                    </form><!-- end of form search -->
                </div><!-- end of box header -->
                <div class="box-body">

                    @if ($products->count() > 0)

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.related_category')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.purchase_price')</th>
                                <th>@lang('site.sales_price')</th>
                                <th>@lang('site.on_stock')</th>
                                <th>@lang('site.profit_percent')</th>
                                <th>@lang('site.Action')</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $index=>$product)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->description}}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td><img src="{{$product->image_path}}" style="width: 110px;" class="img-thumbnail"></td>
                                    <td>{{$product->purchase_price}}</td>
                                    <td>{{$product->sales_price}}</td>
                                    <td>{{$product->stock}}</td>
                                    <td>{{$product->profit_percent}} %</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_products'))
                                            <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.Edit')</a>
                                        @else
                                            <a href="#" class="btn btn-primary disabled"><i class="fa fa-edit"></i>@lang('site.Edit')</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_products'))
                                            <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post" style="display: inline-block">
                                                {{csrf_field()}}
                                                {{method_field('delete')}}
                                                <button type="submit" class="btn btn-danger delete"><i class="fa fa-trash"></i>@lang('site.Delete')</button>
                                            </form>
                                        @else
                                            <form action="#" method="post" style="display: inline-block">
                                                {{csrf_field()}}
                                                {{method_field('delete')}}
                                                <button type="submit" class="btn btn-danger disabled">@lang('site.Delete')</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table><!-- end of table -->


                    @else

                        <h2>@lang('site.no-data-found')</h2>

                    @endif

                </div><!-- end of box body -->
            </div>
        </section>

    </div>
@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            