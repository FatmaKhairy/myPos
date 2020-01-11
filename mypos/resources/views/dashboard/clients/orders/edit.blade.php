@extends('layouts.dashboard.app')@section('content')    <div class="content-wrapper">        <section class="content-header">            <h1>@lang('site.add_order')</h1>            <ol class="breadcrumb">                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>                <li><a href="{{ route('dashboard.clients.index') }}"> @lang('site.clients')</a></li>                <li class="active">@lang('site.Edit')</li>            </ol>        </section>        <section class="content">            <div class="row">                <div class="col-md-6">                    <div class="box box-primary">                        <div class="box-header">                            <h3 class=" box-title">@lang('site.edit_order')</h3>                        </div>                        <div class="box-body">                            @foreach ($categories as $category)                                <div class="panel-group">                                    <div class="panel panel-info">                                        <div class="panel-heading">                                            <h4 class="panel-title">                                                <a data-toggle="collapse" href="#{{ str_replace(' ', '-', $category->name) }}">                                                    {{ $category->name }}</a>                                            </h4>                                        </div>                                        <div id="{{ str_replace(' ', '-', $category->name) }}" class="panel-collapse collapse">                                            <div class="panel-body">                                                @if ($category->product->count() > 0)                                                    <table class="table table-hover">                                                        <tr>                                                            <th>@lang('site.name')</th>                                                            <th>@lang('site.stock')</th>                                                            <th>@lang('site.price')</th>                                                            <th>@lang('site.Add')</th>                                                        </tr>                                                        @foreach ($category->product as $product)                                                            <tr>                                                                <td>{{ $product->name }}</td>                                                                <td>{{ $product->stock }}</td>                                                                <td>{{ number_format($product->sales_price, 2) }}</td>                                                                <td>                                                                    <a href=""                                                                       id="product-{{ $product->id }}"                                                                       data-name="{{ $product->name }}"                                                                       data-id="{{ $product->id }}"                                                                       data-price="{{$product->sales_price}}"                                                                       class="btn {{in_array($product->id, $order->products->pluck('id')->toArray()) ? 'btn-default display':'btn-success add-product-btn'}}">                                                                        <i class="fa fa-plus"></i>                                                                    </a>                                                                </td>                                                            </tr>                                                        @endforeach                                                    </table><!-- end of table -->                                                @else                                                    <h5>@lang('site.no_records')</h5>                                                @endif                                            </div><!-- end of panel body -->                                        </div><!-- end of panel collapse -->                                    </div><!-- end of panel primary -->                                </div><!-- end of panel group -->                            @endforeach                        </div>                        <!-- end of box body -->                    </div>                    {{--**********************************الجزء التاني اللي هنقل ليه الداتا*****************************--}}                </div><!--end of first ol-md-6-->                <div class="col-md-6">                    <div class="box box-primary">                        <div class="box-header">                            <h3 class="box-title">@lang('site.orders')</h3>                        </div><!-- end of box header -->                        <div class="box-body">                            <form action="{{ route('dashboard.clients.orders.update', ['client' => $order->client->id, 'order' => $order->id]) }}" method="post">                                {{ csrf_field() }}                                {{ method_field('put') }}                                @include('partials._errors')                                <table class="table table-hover">                                    <thead>                                    <tr>                                        <th>@lang('site.product')</th>                                        <th>@lang('site.quantity')</th>                                        <th>@lang('site.price')</th>                                    </tr>                                    </thead>                                    <tbody class="order-list">                                    @foreach($order->products as $product)                                        <tr>                                            <td>{{$product->name}}</td>                                            <td><input type="number" name="products[{{$product->id}}][quantity]" data-price="{{number_format($product->sales_price,2)}}"                                                      value="{{$product->pivot->quantity}}" min="1"  value="1" class="form-control input-sm product-quantity"></td>                                            <td class="product-price" >{{ number_format($product->sales_price * $product->pivot->quantity,2)}}</td>                                            <td><button class="btn btn-danger btn-sm order-Delete" data-id="{{$product->id}}"><span class="fa fa-trash"></span></button></td>                                        </tr>                                        @endforeach                                    {{--auto create when add order by jq--}}                                    </tbody>                                </table><!-- end of table -->                                <h4>@lang('site.total') : <span class="total-price">{{$order->total_price}}</span></h4>                                <button class="btn btn-primary btn-block" id="edit-order-form-btn"><i class="fa fa-edit"></i> @lang('site.edit_order')</button>                            </form>                        </div><!-- end of box body -->                    </div><!-- end of box -->                    {{--previous orders  --}}                                        @if ($client->orders->count() > 1)                                            {{-- عشان لو عندي واحد بس وانا بعدل ميعرضهوش--}}                                            <div class="box box-primary">                                                <div class="box-header">                                                    <h3 class="box-title" style="margin-bottom: 10px">@lang('site.previous_orders')                                                        <small>{{ $PreOrders->total() }}</small>                                                    </h3>                                                </div><!-- end of box header -->                                                <div class="box-body">                                                    @foreach ($PreOrders as $PreOrder)                                                      @if($order->id !==$PreOrder->id){{--show previous not that i edit --}}                                                        <div class="panel-group">                                                            <div class="panel panel-success">                                                                <div class="panel-heading">                                                                    <h4 class="panel-title">                                                                        <a data-toggle="collapse" href="#{{ $PreOrder->created_at->format('d-m-Y-s') }}">{{ $PreOrder->created_at->toFormattedDateString() }}</a>                                                                    </h4>                                                                </div>                                                                <div id="{{ $PreOrder->created_at->format('d-m-Y-s') }}" class="panel-collapse collapse">                                                                    <div class="panel-body">                                                                        <ul class="list-group">                                                                            @foreach ($PreOrder->products as $product)                                                                                <li class="list-group-item">{{ $product->name }}</li>                                                                            @endforeach                                                                        </ul>                                                                        @lang('site.total'): <span style="size: 40px; font-weight: bold;">{{$order->total_price}}</span>                                                                    </div><!-- end of panel body -->                                                                </div><!-- end of panel collapse -->                                                            </div><!-- end of panel primary -->                                                        </div><!-- end of panel group -->                                                      @endif                                                    @endforeach                                                    {{ $PreOrders->links() }}                                                </div><!-- end of box body -->                                            </div><!-- end of box -->                                        @endif                </div>                <!--end of secend  col-->            </div><!--end of first of row-->        </section>    </div>@endsection