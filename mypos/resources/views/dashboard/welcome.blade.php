@extends('layouts.dashboard.app')
    @section('content')

        <div class="content-wrapper">

            <section class="content-header">

                <h1>@lang('site.dashboard')</h1>

                <ol class="breadcrumb">
                    <li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
                </ol>
            </section>

            <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box 1 -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{$categories_count}}</h3>
                                    <p>@lang('site.categories')</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{route('dashboard.categories.index')}}" class="small-box-footer">
                                    @lang('site.More_info')<i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box 2-->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>{{$products_count}}</h3>

                                    <p>@lang('site.products')</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{route('dashboard.products.index')}}" class="small-box-footer">
                                    @lang('site.More_info')<i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>{{$users_count}}</h3>

                                    <p>@lang('site.users')</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{route('dashboard.users.index')}}" class="small-box-footer">
                                    @lang('site.More_info')<i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{$clients_count}}</h3>
                                    <p>@lang('site.clients')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <a href="{{route('dashboard.clients.index')}}" class="small-box-footer">
                                    @lang('site.More_info')<i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-maroon-active">
                                <div class="inner">
                                    <h3>{{$orders_count}}</h3>

                                    <p>@lang('site.orders')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-shopping-basket"></i>
                                </div>
                                <a href="{{route('dashboard.orders.index')}}" class="small-box-footer">
                                    @lang('site.More_info')<i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    {{-- fa fa-shopping-cart--}}




                        <!-- ./col -->



                    </div>
                    <!-- /.row -->
                <select class="select_year">
                    <option selected>select year </option>
                    @foreach($allYears as $year)
                       <option value="{{$year}}" >
                           {{$year}}
                       </option>
{{--                        <option value="{{$year->created_at->year}}" >--}}
{{--                            {{$year->created_at->year}}--}}
{{--                        </option>--}}
                    @endforeach

                </select>

          <div class="box box-solid">
                        <div class="box-header">
                            <div class="box-header with-border">
                                <h3 class="box-title">@lang('site.sales-graph')</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="box-body border-radius-none">
                            <div class="chart" id="line-chart"  style="height: 250px;"></div>
                        </div>

                    </div>
                    <!-- /.box-body -->

    <!-- end of line chart -->

            </section><!-- end of content -->

        </div>


        @endsection



@push('scripts')

    <script>




        $(document).ready(function () {

            let year,month;
          // let m=['a','c','s','a'];
            $('.select_year').change(function () {
                    year = $(this).val();

                    $.ajax({
                        url: "{{route('dashboard.allYearData')}}",
                        type: 'post',
                        dataType: 'JSON',
                        data: {
                            '_token': "{{csrf_token()}}",
                            'year':year,//$(this).val(),

                        },
                        success: function (data) {
                            new Morris.Bar({
                                element: 'line-chart',
                                resize: true,
                                //هنا هعرف الداتا
                                           // data:  data,//end of data
                                          //{year: 2018, month: 1, sum: 3000}from console
                                            //{ month: '00', a: 100, b: 90}
                                          //[{y:data[2],m:data[0], sum:data[1]}],
                                data: data,
                                xkey: ['month'],//['month'],//
                                ykeys: ['sum'],
                                labels: ["@lang('site.total')"],
                                barColors: ['#3c8dbc'],
                                hideHover: 'auto'
                            })//end of morris line
                        }
                    })
            })

            // new Morris.Line({
            //     element: 'line-chart',
            //     resize: true,
            //     //هنا هعرف الداتا
            //     data:  [
            //         {'sum': 103, 'month': 1},
            //         {'sum': 873, 'month': 2},
            //         {'sum': 653, 'month': 3},
            //         {'sum': 133, 'month': 4},
            //
            //     ],//end of data
            //     xkey: 'sum',//
            //     ykeys: ['month'],
            //     labels: ["month"],
            //     linColors: ['#3c8dbc'],
            //     hideHover: 'auto'
            // })//end of morris line  -chart
        })



    </script>


{{-- باقي اني اوصل قيمه السلكت للداله دي ---}}
{{--<script>
         $('select').on('change', function(e) {
             e.preventDefault();
             var type = this.value;
             alert(type)

         })

            new Morris.Line({
                element: 'line-chart',
                resize: true,
                //هنا هعرف الداتا
                data:  [

                    @foreach($order->getYear($year) as $data)
                            {
                                ym: '{{$data->year}}-{{$data->month}}', sum: '{{$data->sum}}'
                            },// مهمم ' , '
                         @endforeach


                ],//end of data
                xkey: 'ym',//
                ykeys: ['sum'],
                labels: ['@lang('site.total')'],
                lineColors: ['#3c8dbc'],
                hideHover: 'auto'
            })//end of morris line

    </script> --}}

<script>





    {{--var graph = Morris.Line({--}}
    {{--    element: 'line-chart',--}}
    {{--    resize: true,--}}
    {{--    //هنا هعرف الداتا--}}
    {{--    data:  [--}}

    {{--            @foreach($order->getYear(year) as $data)--}}
    {{--                    {--}}
    {{--                        ym: '{{$data->year}}-{{$data->month}}', sum: '{{$data->sum}}'--}}
    {{--                    },// مهمم ' , '--}}
    {{--        @endforeach--}}


    {{--    ],//end of data--}}
    {{--    xkey: 'ym',//--}}
    {{--    ykeys: ['sum'],--}}
    {{--    labels: ['@lang('site.total')'],--}}
    {{--    lineColors: ['#3c8dbc'],--}}
    {{--    hideHover: 'auto'--}}
    {{--});--}}




</script>

  @endpush