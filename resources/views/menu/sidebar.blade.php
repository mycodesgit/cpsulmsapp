@php
    $current_route=request()->route()->getName();

    $classRoomActive = in_array($current_route, ['studsemester', 'classroomfaculty-index', 'virtual_class', 'virtualfaculty_class', 'virtual_subjectclass', 'virtual_facultysubjectclass']) ? 'active' : ''; 
@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
        <li class="nav-header" style="color: #6c757d;">Main Navigation</li>
        <li class="nav-item">
            <a href="{{ route('dash') }}" class="nav-link text-normal {{ $current_route=='dash'?'active':'' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="
                @if(Auth::guard('faculty')->check() && Auth::guard('faculty')->user()->role == '943')
                    {{ route('classroomfaculty-index') }}
                @elseif(Auth::guard('web')->check() && Auth::guard('web')->user()->role == '100')
                    {{ route('studsemester') }}
                @else
                    # <!-- Fallback URL if neither condition is true -->
                @endif" 
               class="nav-link text-normal {{ $classRoomActive }}">
                <i class="nav-icon fas fa-vr-cardboard"></i>
                <p>Classroom</p>
            </a>
        </li>
    </ul>
</nav>