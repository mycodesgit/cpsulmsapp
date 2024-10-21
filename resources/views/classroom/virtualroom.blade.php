@extends('layouts.master')

@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Classroom</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dash') }}" class="breadcrumbactive">Dashboard</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('studsemester') }}" class="breadcrumbactive">
                            @php
                                $semester = request('semester');
                                $formattedSemester = '';

                                if ($semester == 1) {
                                    $formattedSemester = '1st Semester';
                                } elseif ($semester == 2) {
                                    $formattedSemester = '2nd Semester';
                                } elseif ($semester == 3) {
                                    $formattedSemester = 'Summer';
                                } else {
                                    $formattedSemester = $semester . 'th';
                                }
                            @endphp
                            {{ $formattedSemester }} - {{ request('schlyear') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Subjects</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @auth('web')
                    @if(Auth::guard('web')->user()->role == '100') 
                        @foreach($subprogen as $datasubprogen)
                            <div class="col-lg-3 col-6">
                                <div class="card card-widget widget-user">
                                    <div class="widget-user-header" style="background: url('{{ asset('template/img/img_bookclub.jpg') }}')no-repeat; background-position: center; background-size: cover;">
                                        <h5 class="widget-user-username text-light">{{ $datasubprogen->sub_name }}</h5>
                                        <h6 class="widget-user-desc text-light">{{ $datasubprogen->subSec }}</h6>
                                    </div>
                                    <div class="widget-user-image">
                                        <img class="img-circle elevation-2" src="{{ asset('template/img/user.png') }}" alt="User Avatar">
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <h6 class="widget-user-desc text-dark">
                                            @if(isset($datasubprogen->fname) && isset($datasubprogen->lname))
                                                {{ substr($datasubprogen->fname, 0, 1) }}. {{ $datasubprogen->lname }}
                                            @else
                                                No Instructor
                                            @endif
                                        </h6>
                                        <a href="{{ route('virtual_subjectclass', ['id' => $datasubprogen->subjID, 'schlyear'  => request('schlyear'), 'semester'  => request('semester')]) }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-folder-open"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endauth

                @auth('faculty')
                    @if(Auth::guard('faculty')->user()->role == '943') 
                        @foreach($facsubprogen as $datafacsubprogen)
                        <div class="col-lg-3 col-6">
                            <div class="card card-widget widget-user">
                                <div class="widget-user-header" style="background: url('{{ asset('template/img/img_bookclub.jpg') }}')no-repeat; background-position: center; background-size: cover;">
                                    <h5 class="widget-user-username text-light">{{ $datafacsubprogen->sub_name }}</h5>
                                    <h6 class="widget-user-desc text-light">{{ $datafacsubprogen->subSec }}</h6>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="{{ asset('template/img/user.png') }}" alt="User Avatar">
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <h6 class="widget-user-desc text-dark">
                                        @if(isset($datafacsubprogen->fname) && isset($datafacsubprogen->lname))
                                            {{ substr($datafacsubprogen->fname, 0, 1) }}. {{ $datafacsubprogen->lname }}
                                        @else
                                            No Instructor
                                        @endif
                                    </h6>
                                    @auth('web')
                                        @if(Auth::guard('web')->user()->role == '100') 
                                            <a href="{{ route('virtual_subjectclass', ['id' => $datafacsubprogen->subjID, 'schlyear'  => request('schlyear'), 'semester'  => request('semester')]) }}" class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-folder-open"></i>
                                            </a>
                                        @endif
                                    @endauth

                                    @auth('faculty')
                                        @if(Auth::guard('faculty')->user()->role == '943') 
                                            <a href="{{ route('virtual_facultysubjectclass', ['id' => $datafacsubprogen->subjID, 'schlyear'  => request('schlyear'), 'semester'  => request('semester')]) }}" class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-folder-open"></i>
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                @endauth
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection