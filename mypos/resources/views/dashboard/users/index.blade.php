@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.users')</li>
            </ol>
        </section>
            <section class="content">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.users')<smail>{{$users->total()}}</smail></h3>
                           <form action="{{route('dashboard.users.index')}}" method="get">
                                <div class="row">
                                     <div class="col-md-4">
                                          <input type="text" name="search"  placeholder="@lang('site.search')" value="{{request()->search}}" class="form-control">
                                     </div>
                                     <div class="col-md-4">
                                         <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')
                                         </button>
                                        @if(auth()->user()->hasPermission('create_users'))
                                            <a href="{{route('dashboard.users.create')}}" class="btn btn-info">
                                                <i class="fa fa-plus"></i>@lang('site.add user')
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-info disabled">
                                                <i class="fa fa-plus"></i>@lang('site.add user')
                                            </a>
                                        @endif
                                </div>
                            </div>

                        </form><!-- end of form search -->
                    </div><!-- end of box header -->
                    <div class="box-body">

                        @if ($users->count() > 0)

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('site.First-name')</th>
                                    <th>@lang('site.Last-name')</th>
                                    <th>@lang('site.Email')</th>
                                    <th>@lang('site.image')</th>
                                    <th>@lang('site.Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $index=>$user)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td>{{$user->first_name}}</td>
                                        <td>{{$user->last_name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td><img src="{{$user->image_path}}" style="width: 110px;" class="img-thumbnail"></td>
                                        <td>
                                            @if(auth()->user()->hasPermission('update_users'))
                                                <a href="{{route('dashboard.users.edit',$user->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.Edit')</a>
                                            @else
                                                <a href="#" class="btn btn-primary disabled"><i class="fa fa-edit"></i>@lang('site.Edit')</a>
                                            @endif
                                            @if(auth()->user()->hasPermission('delete_users'))
                                                <form action="{{route('dashboard.users.destroy',$user->id)}}" method="post" style="display: inline-block">
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
                            {{$users->appends(request()->query())->links()}}

                        @else

                            <h2>@lang('site.no-data-found')</h2>

                        @endif

                    </div><!-- end of box body -->
                </div>
            </section>
        </section>
    </div>

@endsection