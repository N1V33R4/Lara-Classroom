@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.preview') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid d-print-none">
    	<a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
		<h2>
	        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
	        <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
	        @if ($crud->hasAccess('list'))
	          <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
	        @endif
	    </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="{{ $crud->getShowContentClass() }}">

            <!-- Default box -->
            <div class="">

                <div class="card no-padding no-border">
                    <table class="table table-striped mb-0">
                        <tbody>
                        <tr>
                            <td>
                                <strong>Name</strong>
                            </td>
                            <td>
                                {{$entry->name}};
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Birthdate</strong>
                            </td>
                            <td>
                                {{$entry->birthdate}};
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>POB</strong>
                            </td>
                            <td>
                                {{$entry->place_of_birth}};
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Address</strong>
                            </td>
                            <td>
                                {{$entry->address}};
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Email</strong>
                            </td>
                            <td>
                                {{$entry->email}};
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Phone</strong>
                            </td>
                            <td>
                                {{$entry->phone}};
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Photo</strong>
                            </td>
                            <td>
                                <img  src="{{asset('/').$entry->image}}" style="width:400px" >
                            </td>
                        </tr>

                        @if ($crud->buttons()->where('stack', 'line')->count())
                            <tr>
                                <td><strong>{{ trans('backpack::crud.actions') }}</strong></td>
                                <td>
                                    @include('crud::inc.button_stack', ['stack' => 'line'])
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>
    </div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css').'?v='.config('backpack.base.cachebusting_string') }}">
	<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/show.css').'?v='.config('backpack.base.cachebusting_string') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('packages/backpack/crud/js/crud.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
	<script src="{{ asset('packages/backpack/crud/js/show.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
@endsection
