@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">
    <li><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
    <li><a href="{{route('dashboard.users.index')}}"><i class="fa fa-dashboard"></i> @lang('site.users')</a></li>
    <li><a>@lang('site.Edit')</a></li>
            </ol>
        </section>
        <section class="content">
            <h4> @lang('site.users')</h4>
            <div class="box box-primary">

                <div class="box-header">
                    <h3 class=" box-title">@lang('site.Add')</h3>
                </div> <!---end of box header-->
                <div class="box-body">
                    @include('partials._errors')
                    <form action="{{route('dashboard.users.update',$user->id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{method_field('put')}}

                        <div class="form-group">
                            <label>@lang('site.First-name')</label>
                            <input type="text" name="first_name" class="form-control"  value="{{$user->first_name}}" >
                        </div>
                        <div class="form-group">
                            <label>@lang('site.Last-name')</label>
                            <input type="text" name="last_name" class="form-control"  value="{{$user->last_name}}" >
                        </div>

                        <div class="form-group">
                            <label>@lang('site.Email')</label>
                            <input type="email" name="email" class="form-control"  value="{{$user->email}}" >
                        </div>
                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" class="form-control" name="image"
                                   onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="form-group">
                            <img id="blah" src="{{$user->image_path}}" style="width:100px;" class="img-thumbnail">
                        </div>
                        <!----custom/permision table -->
                        @php
                            $models=[
                                    'users',
                                    'categories',
                                    'products',
                                     'clients',
                                     'orders',
                            ];
                            $maps=[
                                    'create',
                                    'read',
                                    'update',
                                    'Delete'
                            ];
                        @endphp

                    <!--custom tap-->
                        <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs ">
                                    @foreach($models as $index=>$model)
                                        <li class="{{$index==0 ?'active':''}}"><a href="#{{$model}}" data-toggle="tab">@lang('site.'.$model)</a></li>
                                    @endforeach()
                                </ul>
                                <!--checkbox href in li ==id in  div-->
                                <div class="tab-content">
                                    @foreach($models as $index=>$model)
                                        <div class="tab-pane {{$index==0 ?'active':''}} " id="{{$model}}">
                                            @foreach($maps as $map)

                                                <label style="padding: 5px"> <input type="checkbox"     name="permissions[]" {{$user->hasPermission($map.'_'.$model)?'checked':''}} value="{{$map.'_'.$model}}">@lang('site.'.$map)</label>
                                            @endforeach()
                                        </div>
                                    @endforeach()
                                </div><!--end of content-->
                            </div><!--end of taps-->
                        </div>
                        <!--end custom tap-->
                        @if(auth()->user()->hasPermission('update_users'))
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" style="background-color:green"><i class="fa fa-edit">@lang('site.Edit')</i></button>
                            </div>
                        @else
                            <button type="submit" class="btn btn-primary disabled" ><i class="fa fa-edit">@lang('site.Edit')</i></button>
                        @endif
                    </form>
        </div> <!---end of box body-->
    </div><!---end of box -->
        </section> </div>

@endsection