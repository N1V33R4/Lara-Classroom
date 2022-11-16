@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    'Hours' => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid d-print-none">
    	<a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
		<h2>
	        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
	        <small>{!! $crud->getSubheading() ?? 'Working Hours for <b>'.$entry->name.'</b>' !!}.</small>
	        @if ($crud->hasAccess('list'))
	          <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
	        @endif
	    </h2>
    </section>
@endsection

@section('content')
<div class="row">
	<div class="col-12">

	<!-- Default box -->
	  <div class="">
	    <div class="card no-padding no-border">
          @if ($years->count() > 0)
          <table class="table table-striped mb-0">
               <thead>
                  <tr class="font-weight-bold">
                     <td>Count</td>
                     <td>Class Name</td>
                     <td>Room</td>
                     <td>Start date</td>
                     <td>End date</td>
                     <td>Status</td>
                     <td>Course taught</td>
                     <td>Projected Hours</td>
                  </tr>
               </thead>
               <tbody>
                  @php
                     $count = 0;
                  @endphp
                  @foreach ($years as $year => $classes)
                     <tr class="bg-dark">
                        <td>Year : </td>
                        <td colspan="5" class="font-weight-bold">{{ $year }}</td>
                        <td class="text-right">Total :</td>
                        <td class="font-weight-bold">{{ $classes->reduce(function ($hours, $class) { return $hours += $class->studentGroups->count() * 45; }) }} hrs</td>
                     </tr>
                     @foreach ($classes as $classroom)
                        @php
                           $count++;
                           $assigned_lecturer_order = $classroom->pivot->order;
                           $course_name = $classroom->courseProgram->courses->where('pivot.order', $assigned_lecturer_order)->first()->name;
                           $work_hours = $classroom->studentGroups->count() * 45;
                        @endphp
                        <tr>
                           <td>{{ $count }}.</td>
                           <td><a href="{{ backpack_url('classroom/'.$classroom->id.'/show') }}">{{ $classroom->name }}</a></td>
                           <td>{{ $classroom->room->room_number }}</td>
                           <td>{{ date('d M Y', strtotime($classroom->start_date)) }}</td>
                           <td>{{ date('d M Y', strtotime($classroom->end_date)) }}</td>
                           <td>{{ $classroom->status }}</td>
                           <td>{{ $course_name }}</td>
                           <td>{{ $work_hours }} hrs</td>
                        </tr>
                     @endforeach
                  @endforeach    
               </tbody>
            </table>
            @else
               <div class="card-body">
                  No classes found.
               </div>
            @endif
	    </div><!-- /.box-body -->
	  </div><!-- /.box -->

	</div>
</div>
@endsection
