@extends('layouts.master')

@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-default alert-dismissible" style="background: url('{{ asset('template/img/img_code.jpg') }}')no-repeat; background-position: center; background-size: cover; border-radius: 5px;">
                        <h2 style="color: #fff" class="mt-2">
                            <strong>👋 Welcome,</strong> 
                            @auth('web')
                            @if(Auth::guard('web')->user()->role == '100')
                                {{ Auth::guard('web')->user()->name }}
                            @endif
                            @endauth

                            @auth('faculty')
                            @if(Auth::guard('faculty')->user()->role == '943')
                                {{ Auth::guard('faculty')->user()->fname }} {{ Auth::guard('faculty')->user()->lname }}
                            @endif
                            @endauth
                        </h2>
                        <span style="color: #fff; font-size: 12pt; margin-left: 45px"></span>
                    </div>
                </div>
                {{-- <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Title</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            Start creating your amazing application!
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            Footer
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div> --}}
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection