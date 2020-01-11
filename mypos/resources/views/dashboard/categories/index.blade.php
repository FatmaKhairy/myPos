@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class="active">@lang('site.categories')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.categories')<smail>{{$categories->total()}}</smail></h3>
                    <form action="{{route('dashboard.categories.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search"  placeholder="@lang('site.search')" value="{{request()->search}}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')
                                </button>
                                @if(auth()->user()->hasPermission('create_categories'))
                                    <a href="{{route('dashboard.categories.create')}}" class="btn btn-info">
                                        <i class="fa fa-plus"></i>@lang('site.add category')
                                    </a>
                                @else
                                    <a href="#" class="btn btn-info disabled">
                                        <i class="fa fa-plus"></i>@lang('site.add category')
                                    </a>
                                @endif
                            </div>
                        </div>

                    </form><!-- end of form search -->
                </div><!-- end of box header -->
                <div class="box-body">

                    @if ($categories->count() > 0)

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.product_count')</th>
                                <th>@lang('site.related_product')</th>
                                <th>@lang('site.Action')</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $index=>$category)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->product->count()}}</td>
                                    <td><a href="{{ route('dashboard.products.index',['category_id' =>$category->id])}}" class="btn btn-default">@lang('site.related_product')</a></td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_categories'))
                                            <a href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.Edit')</a>
                                        @else
                                            <a href="#" class="btn btn-primary disabled"><i class="fa fa-edit"></i>@lang('site.Edit')</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_categories'))
                                            <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post" style="display: inline-block">
                                                {{csrf_field()}}
                                                {{method_field('delete')}}
                                                <button type="submit" class="btn btn-danger delete"><i class="fa fa-trash"></i> @lang('site.Delete')</button>
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
        </section>
    </div>
@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            