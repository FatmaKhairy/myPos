@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.orders')
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.orders')</li>
            </ol>
        </section>
        <section class="content">
             <div class="row">
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class=" box-title" style="margin-bottom: 15px">@lang('site.orders')
                                <small>{{$orders->total()}} </small></h3>
                            <form action="{{route('dashboard.orders.index')}}" method="get">
                                <div class="row">
                                  <div class="col-md-8">
                                      <input type="text" name="search"  placeholder="@lang('site.search')" class="form-control"
                                             value="{{ request()->search }}">
                                  </div>
                                  <div class="col-md-4">
                                      <button type="submit" class="btn btn-primary sm"><i class="fa fa-search"></i>@lang('site.search')</button>
                                  </div>
                                </div>{{--end of inner row --}}
                            </form>
                        </div><!--end of box-header-->
                        @if($orders->count()>0)
                        <div class="box-body table-responsive">
                                    <table class="table table-hover">
                                           <tr>
                                               <th>@lang('site.cline-name')</th>
                                               <th>@lang('site.price')</th>
                                              {{--  <th>@lang('site.status')</th>--}}
                                               <th>@lang('site.created-at')</th>
                                               <th>@lang('site.action')</th>
                                           </tr>
                                             @foreach ($orders as $order)
                                                 <tr>
                                                     <td>{{ $order->client->name }}</td>
                                                     <td>{{ number_format($order->total_price,2) }}</td>
                                                    {{--  <td>
                                                         <button
                                                                   data-status="@lang('site.' . $order->status)"
                                                                      data-url="{{ route('dashboard.orders.update_status', $order->id) }}"
                                                             data-method="put"
                                                             data-available-status='["@lang('site.processing')", "@lang('site.finished') "]'
                                                           class="order-status-btn btn {{ $order->status == 'processing' ? 'btn-warning' : 'btn-success disabled' }} btn-sm"
                                                             >
                                                             @lang('site.' . $order->status)
                                                             </button>
                                                     </td>--}}
                                                     <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                                     <td>
                                                        <button class="btn btn-primary btn-sm order-products"
                                                                data-id="{{ $order->id }}"
                                                                {{--.orders.== orderid--}}
                                                                data-url="{{ route('dashboard.orders.products', $order->id) }}"
                                                                 data-method="get"

                                                         >
                                                           <i class="fa fa-list"></i>
                                                         @lang('site.show')
                                                         </button>

                                                         @if (auth()->user()->hasPermission('update_orders'))
                                                             <a href="{{ route('dashboard.clients.orders.edit', ['client' => $order->client->id, 'order' => $order->id]) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> @lang('site.Edit')</a>
                                                         @else
                                                             <a href="#" disabled class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('site.Edit')</a>
                                                         @endif

                                                         @if (auth()->user()->hasPermission('delete_orders'))
                                                             <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="post" style="display: inline-block;">
                                                                 {{ csrf_field() }}
                                                                 {{ method_field('delete') }}
                                                                 <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> @lang('site.Delete')</button>
                                                             </form>

                                                         @else
                                                             <a href="#" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash"></i> @lang('site.Delete')</a>
                                                         @endif

                                                     </td>
                                                 </tr>
                                                        @endforeach

                                                    </table><!-- end of table -->
                            {{ $orders->appends(request()->query())->links() }}
                                    </div><!--end of box-body-->
                        @else
                            <div class="box-body">
                            <h2>@lang('site.no-data-found')</h2>
                            </div>
                        @endif
                                </div><!--end of box-primary-->
                    </div><!-- end of col-md-8-->


                    {{--**********************************الجزء التاني اللي هنقل ليه الداتا*****************************--}}

                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">@lang('site.show-orders')</h3>
                        </div><!-- end of box header -->
                           <div class="box-body">
                               <div class="loading" style="display: none; flex-direction: column; align-items: center;" id="loading">
                                   <div class="loader"></div>
                                   <p style="margin-top: 10px;text-align: center">@lang('site.loading')</p>
                                   </div>

                               <div id="order-product-list">

                               </div><!-- end of order product list -->
                               <button class="btn btn-primary btn-block" id="print-order-form-btn"><i class="fa fa-print"></i> @lang('site.print')</button>
                            <!-- end of box body -->

                    </div><!-- end of box -->
                    </div>{{--end of box-primary --}}
                </div><!--end of  col-->
             </div>{{-- end of row--}}
          </section>
    </div>{{-- end of content-wrapper--}}
@endsection
