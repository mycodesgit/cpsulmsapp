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
                        <li class="breadcrumb-item active">Semester</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach($progen as $dataprogen)
                <div class="col-lg-3 col-6">
                    <div class="card card-widget widget-user" style="border: 1px solid #bbb;">
                        <div class="widget-user-header" style="background: url('{{ asset('template/img/imgsembook.png') }}')no-repeat; background-position: center; background-size: cover;">
                            <h5 class="widget-user-username text-dark" style="margin-top: 50px;">
                                @if($dataprogen->semester == 1)
                                    1st Semester
                                @elseif($dataprogen->semester == 2)
                                    2nd Semester
                                @elseif($dataprogen->semester == 3)
                                    Summer
                                @else
                                    Unknown Semester
                                @endif
                            </h5>
                            <h6 class="widget-user-desc text-dark">
                                {{-- {{ $dataprogen->progAcronym }} {{ $dataprogen->studYear }}-{{ $dataprogen->studSec }} --}}
                            </h6>
                        </div>
                        <div class="widget-user-image">
                            {{ $dataprogen->schlyear }}
                        </div>
                        <div class="modal-footer justify-content-between">
                            <h6 class="widget-user-desc text-dark">
                                {{ $dataprogen->progAcronym }} {{ $dataprogen->studYear }}-{{ $dataprogen->studSec }}
                            </h6>
                            @auth('web')
                                @if(Auth::guard('web')->user()->role == '100') 
                                    <a href="{{ route('virtual_class', ['semester' => $dataprogen->semester, 'schlyear' => $dataprogen->schlyear]) }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-folder-open"></i> View
                                    </a>
                                @endif
                            @endauth
                            @auth('faculty')
                                @if(Auth::guard('faculty')->user()->role == '943') 
                                    <a href="{{ route('virtualfaculty_class', ['semester' => $dataprogen->semester, 'schlyear' => $dataprogen->schlyear]) }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-folder-open"></i> View
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection