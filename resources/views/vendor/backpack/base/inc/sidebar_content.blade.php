<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="nav-icon la la-home"></i>{{ trans('backpack::base.dashboard') }}</a></li>
@if (backpack_user()->can(config('permission.admin')) || backpack_user()->can(config('permission.demo')))

@endif
@if (backpack_user()->can(config('permission.profile')) || backpack_user()->can(config('permission.admin')) || backpack_user()->can(config('permission.demo')))

@endif
<!-- Super Admin -->
@if (backpack_user()->id === 1 || backpack_user()->can(config('permission.demo')))
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i>Authentication</a>
        <ul class="nav-dropdown-items">
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
        </ul>
</li>
@if (backpack_user()->id === 1)
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}\"><i class="nav-icon la la-files-o"></i>
                <span>{{ trans('backpack::crud.file_manager') }}</span></a>
</li>
@endif
@endif

@if (backpack_user()->can('admin') || backpack_user()->can('room') || backpack_user()->can('shift') || backpack_user()->can('course') || backpack_user()->can('student') || backpack_user()->can('lecturer') || backpack_user()->can('department'))
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-adjust"></i>Basic</a>
    <ul class="nav-dropdown-items">
        @if (backpack_user()->can('admin') || backpack_user()->can('room'))
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('room') }}'><i class='nav-icon las la-door-open'></i> Rooms</a></li>
        @endif
        @if (backpack_user()->can('admin') || backpack_user()->can('shift'))
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('shift') }}'><i class='nav-icon las la-cloud-sun'></i> Shifts</a></li>
        @endif
        @if (backpack_user()->can('admin') || backpack_user()->can('course'))
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('course') }}'><i class='nav-icon las la-book'></i> Courses</a></li>
        @endif
        @if (backpack_user()->can('admin') || backpack_user()->can('student'))
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('student') }}'><i class='nav-icon las la-portrait'></i> Students</a></li>
        @endif
        @if (backpack_user()->can('admin') || backpack_user()->can('lecturer'))
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('lecturer') }}'><i class='nav-icon las la-graduation-cap'></i> Lecturers</a></li>
        @endif
        @if (backpack_user()->can('admin') || backpack_user()->can('department'))
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('department') }}'><i class='nav-icon las la-university'></i> Departments</a></li>
        @endif
    </ul>
</li>
@endif

@if (backpack_user()->can('admin') || backpack_user()->can('course-program') || backpack_user()->can('student-group') || backpack_user()->can('classroom'))
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-chart-pie"></i>Advance</a>
    <ul class="nav-dropdown-items">
        @if (backpack_user()->can('admin') || backpack_user()->can('course-program'))
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('course-program') }}'><i class='nav-icon las la-folder-open'></i> Course programs</a></li>
        @endif
        @if (backpack_user()->can('admin') || backpack_user()->can('student-group'))
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('student-group') }}'><i class='nav-icon las la-user-friends'></i> Student groups</a></li>
        @endif
        @if (backpack_user()->can('admin') || backpack_user()->can('classroom'))
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('classroom') }}'><i class='nav-icon las la-credit-card'></i> Classrooms</a></li>
        @endif
    </ul>
</li>
@endif