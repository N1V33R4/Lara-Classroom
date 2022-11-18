@extends(backpack_view('blank'))

@php
    // $widgets['before_content'][] = [
    //     'type' => 'jumbotron',
    //     'heading' => trans('backpack::base.welcome'),
    //     'content' => trans('backpack::base.use_sidebar'),
    //     'button_link' => backpack_url('logout'),
    //     'button_text' => trans('backpack::base.logout'),
    // ];
    
    $widgets['before_content'][] = [
        'type'    => 'div',
        'class'   => 'row mb-4 font-weight-bold',
        'content' => [ // widgets 
            [ 
                'type' => 'card',
                'wrapper' => ['class' => 'col-sm-6 col-md-4 col-lg-3'],
                'class'   => 'bg-warning text-white',
                'content' => ['header' => 'Students', 'body' => App\Models\Student::count() . ' people']
            ],
            [ 
                'type' => 'card',
                'wrapper' => ['class' => 'col-sm-6 col-md-4 col-lg-3'],
                'class'   => 'bg-success text-white',
                'content' => ['header' => 'Lectuers', 'body' => App\Models\Lecturer::count() . ' people']
            ],
            [ 
                'type' => 'card',
                'wrapper' => ['class' => 'col-sm-6 col-md-4 col-lg-3'],
                'class'   => 'bg-primary text-white',
                'content' => ['header' => 'Departments', 'body' => App\Models\Department::count() . ' departments']
            ],
            [ 
                'type' => 'card',
                'wrapper' => ['class' => 'col-sm-6 col-md-4 col-lg-3'],
                'class'   => 'bg-danger text-white',
                'content' => ['header' => 'Rooms', 'body' => App\Models\Room::count() . ' rooms']
            ]
        ]
    ];


    $widgets['before_content'][] = [
        'type' => 'div', 
        'class' => 'row ',
        'content' => [
            [
                'type' => 'chart',
                'controller' => \App\Http\Controllers\Admin\Charts\BatchChartController::class,
                'class'   => 'card mb-2',
                'wrapper' => ['class'=> 'col-md-6'],
                'content' => [
                    'header' => 'Department Batches',
                    'body'   => 'The number of batches each department has.<br><br>',
                ]
            ],
            [
                'type' => 'chart',
                'controller' => \App\Http\Controllers\Admin\Charts\ClassroomChartController::class,
                'class'   => 'card mb-2',
                'wrapper' => ['class'=> 'col-md-6'],
                'content' => [
                    'header' => 'Department Classrooms',
                    'body'   => 'The number of classrooms each department has (Current | Finished).<br><br>',
                ]
            ],
        ]
    ];
    $widgets['before_content'][] = [
        'type' => 'div', 
        'class' => 'row ',
        'content' => [
            [
                'type' => 'chart',
                'controller' => \App\Http\Controllers\Admin\Charts\WorkingHoursChartController::class,
                'class'   => 'card mb-2',
                'wrapper' => ['class'=> 'col-md-12'],
                'content' => [
                    'header' => 'Projected Work Hours',
                    'body'   => 'Showing lecturers with the highest number of working hours.<br><br>',
                ]
            ]
        ]
    ];
    
@endphp

@section('content')
    {{-- <p>Your custom HTML can live here</p> --}}
@endsection
