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
                        <li class="breadcrumb-item"><a href="javascript:history.back()" class="breadcrumbactive">
                            {{ $sub->sub_name }}
                        </a></li>
                        <li class="breadcrumb-item active">Virtual Classroom</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                                        <li class="nav-item ml-1">
                                            <a class="nav-link active text-dark text-bold" id="custom-tabs-one-tab" data-toggle="pill" href="#custom-tabs-one" role="tab" aria-controls="custom-tabs-one" aria-selected="true">Stream</a>
                                        </li>
                                        <li class="nav-item ml-1">
                                            <a class="nav-link text-dark text-bold" id="custom-tabs-two-tab" data-toggle="pill" href="#custom-tabs-two" role="tab" aria-controls="custom-tabs-two" aria-selected="false">Classwork</a>
                                        </li>
                                        <li class="nav-item ml-1">
                                            <a class="nav-link text-dark text-bold" id="custom-tabs-three-tab" data-toggle="pill" href="#custom-tabs-three" role="tab" aria-controls="custom-tabs-three" aria-selected="false">Topic</a>
                                        </li>
                                        <li class="nav-item ml-1">
                                            <a class="nav-link text-dark text-bold" id="custom-tabs-four-tab" data-toggle="pill" href="#custom-tabs-four" role="tab" aria-controls="custom-tabs-four" aria-selected="false">People</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-one" role="tabpanel" aria-labelledby="custom-tabs-one-tab">
                                            <div class="alert alert-default alert-dismissible" style="background: url('{{ asset('template/img/img_bookclub.jpg') }}')no-repeat; background-position: center; background-size: cover; border-radius: 5px;">
                                                <h2 style="color: #fff"><i class="icon fas fa-file-lines"></i> <strong>{{ $sub->sub_name }} - {{ $sub->sub_title }}</strong></h2>
                                                <span style="color: #fff; font-size: 12pt; margin-left: 45px">{{ $sub->subSec }}</span>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <center>
                                                            <button class="btn btn-default btn-sm">Join Meeting</button>
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div id="accordion">

                                                        <div class="card card-default">
                                                            <div class="card-header" id="classwork">
                                                                <h4 class="card-title w-100">
                                                                    <a class="d-block w-100 collapsed text-dark" data-toggle="collapse" href="#collapseAnounce" aria-expanded="false">
                                                                        <div class="user-block">
                                                                            <img class="img-circle img-bordered-sm" src="{{ asset('template/img/user.png') }}" alt="user image">
                                                                            <span class="username mt-2">
                                                                                <span style="color: #000">Announce Something</span>
                                                                            </span>
                                                                        </div>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseAnounce" class="collapse" data-parent="#accordion" style="">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <textarea id="summernote" class="form-control" style="height: 500px !important">
                                                                            
                                                                        </textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="btn btn-default btn-file">
                                                                            <i class="fas fa-paperclip"></i> Upload File Attachment
                                                                            <input type="file" name="attachment">
                                                                        </div>
                                                                        <p class="help-block">Max. 25MB</p>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <a href="" class="btn btn-default btn-sm">
                                                                        View Instructions
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="card card-default mt-5">
                                                            <div class="card-header" id="classwork">
                                                                <h4 class="card-title w-100">
                                                                <a class="d-block w-100 collapsed text-dark" data-toggle="collapse" href="#collapseOne" aria-expanded="false">
                                                                    <i class="fas fa-file-lines"></i>&nbsp;&nbsp; <strong>Activity # 1</strong>
                                                                    <span class="float-right text-normal text-gray" style="font-size: 10pt">No due date</span>
                                                                </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                                                <div class="card-body">
                                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                                                                    3
                                                                    wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                                                    laborum
                                                                    eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                                                    nulla
                                                                    assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                                                    nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                                                    beer
                                                                    farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                                                    labore sustainable VHS.
                                                                </div>
                                                                <div class="card-footer">
                                                                    <a href="" class="btn btn-default btn-sm">
                                                                        View Instructions
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card card-default">
                                                            <div class="card-header" id="classwork">
                                                                <h4 class="card-title w-100">
                                                                <a class="d-block w-100 collapsed text-dark" data-toggle="collapse" href="#collapseTwo" aria-expanded="false">
                                                                    <i class="fas fa-file-lines"></i>&nbsp;&nbsp; <strong>Activity # 2</strong>
                                                                    <span class="float-right text-normal text-gray" style="font-size: 10pt">No due date</span>
                                                                </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                                                                <div class="card-body">
                                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                                                                    3
                                                                    wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                                                    laborum
                                                                    eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                                                    nulla
                                                                    assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                                                    nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                                                    beer
                                                                    farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                                                    labore sustainable VHS.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="custom-tabs-two" role="tabpanel" aria-labelledby="custom-tabs-two-tab">
                                            <div class="alert alert-default alert-dismissible" style="background: url('{{ asset('template/img/img_bookclub.jpg') }}')no-repeat; background-position: center; background-size: cover; border-radius: 5px;">
                                                <h2 style="color: #fff"><i class="icon fas fa-file-lines"></i> <strong>{{ $sub->sub_name }} - {{ $sub->sub_title }}</strong></h2>
                                                <span style="color: #fff; font-size: 12pt; margin-left: 45px">{{ $sub->subSec }}</span>
                                            </div>
                                            @auth('faculty')
                                                @if(Auth::guard('faculty')->user()->role == '943') 
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning dropdown-toggle btn-md" data-toggle="dropdown" aria-expanded="false">
                                                            <strong>Create</strong>
                                                        </button>
                                                        <ul class="dropdown-menu" style="">
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fas fa-file-lines"></i> Assignment
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fas fa-file-invoice"></i> Material
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            @endauth
                                            <div id="accordion" class="mt-5">
                                                <div class="card card-default">
                                                    <div class="card-header" id="classwork">
                                                        <h4 class="card-title w-100">
                                                        <a class="d-block w-100 collapsed text-dark" data-toggle="collapse" href="#collapseOne" aria-expanded="false">
                                                            <i class="fas fa-file-lines"></i>&nbsp;&nbsp; <strong>Activity # 1</strong>
                                                            <span class="float-right text-normal text-gray" style="font-size: 10pt">No due date</span>
                                                        </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                                        <div class="card-body">
                                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                                                            3
                                                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                                            laborum
                                                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                                            nulla
                                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                                            beer
                                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                                            labore sustainable VHS.
                                                        </div>
                                                        <div class="card-footer">
                                                            <a href="" class="btn btn-default btn-sm">
                                                                View Instructions
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card card-default">
                                                    <div class="card-header" id="classwork">
                                                        <h4 class="card-title w-100">
                                                        <a class="d-block w-100 collapsed text-dark" data-toggle="collapse" href="#collapseTwo" aria-expanded="false">
                                                            <i class="fas fa-file-lines"></i>&nbsp;&nbsp; <strong>Activity # 2</strong>
                                                            <span class="float-right text-normal text-gray" style="font-size: 10pt">No due date</span>
                                                        </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                                                        <div class="card-body">
                                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                                                            3
                                                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                                            laborum
                                                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                                            nulla
                                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                                            beer
                                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                                            labore sustainable VHS.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="custom-tabs-three" role="tabpanel" aria-labelledby="custom-tabs-three-tab">
                                            <div class="alert alert-default alert-dismissible" style="background: url('{{ asset('template/img/img_bookclub.jpg') }}')no-repeat; background-position: center; background-size: cover; border-radius: 5px;">
                                                <h2 style="color: #fff"><i class="icon fas fa-file-lines"></i> <strong>{{ $sub->sub_name }} - {{ $sub->sub_title }}</strong></h2>
                                                <span style="color: #fff; font-size: 12pt; margin-left: 45px">{{ $sub->subSec }}</span>
                                            </div>
                                            @auth('faculty')
                                                @if(Auth::guard('faculty')->user()->role == '943') 
                                                    <button type="button" class="btn btn-warning btn-md" data-toggle="modal" data-target="#modal-addtopic">
                                                        <i class="fas fa-plus"></i> <strong>Create or Upload Topic</strong>
                                                    </button>
                                                @endif
                                            @endauth
                                            <div id="accordion" class="mt-5">
                                                {{-- <div class="card card-default">
                                                    <div class="card-header" id="classwork">
                                                        <h4 class="card-title w-100">
                                                        <a class="d-block w-100 collapsed text-dark" data-toggle="collapse" href="#collapseOne" aria-expanded="false">
                                                            <i class="fas fa-file-lines"></i>&nbsp;&nbsp; <strong>Topic # 1</strong>
                                                            <span class="float-right text-normal text-gray" style="font-size: 10pt">No due date</span>
                                                        </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                                        <div class="card-body">
                                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                                                            3
                                                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                                            laborum
                                                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                                            nulla
                                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                                            beer
                                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                                            labore sustainable VHS.
                                                        </div>
                                                        <div class="card-footer bg-white">
                                                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                                                <li class="fileattached">
                                                                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                                                                    <div class="mailbox-attachment-info">
                                                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> Sep2014-report.pdf</a>
                                                                        <span class="mailbox-attachment-size clearfix mt-1">
                                                                            <span>1,245 KB</span>
                                                                            <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                                <li class="fileattached">
                                                                    <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>
                                                                    <div class="mailbox-attachment-info">
                                                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> App Description.docx</a>
                                                                        <span class="mailbox-attachment-size clearfix mt-1">
                                                                            <span>1,245 KB</span>
                                                                            <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                                <li class="fileattached">
                                                                    <span class="mailbox-attachment-icon"><i class="far fa-file-powerpoint"></i></span>
                                                                    <div class="mailbox-attachment-info">
                                                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> Computer Computing.ppt</a>
                                                                        <span class="mailbox-attachment-size clearfix mt-1">
                                                                            <span>800 KB</span>
                                                                            <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                                <li class="fileattached">
                                                                    <span class="mailbox-attachment-icon"><i class="far fa-file-image"></i></span>
                                                                    <div class="mailbox-attachment-info">
                                                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> Schedule.png</a>
                                                                        <span class="mailbox-attachment-size clearfix mt-1">
                                                                            <span>145 KB</span>
                                                                            <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div id="topicContainer"></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="custom-tabs-four" role="tabpanel" aria-labelledby="custom-tabs-four-tab">
                                            <div class="alert alert-default alert-dismissible" style="background: url('{{ asset('template/img/img_bookclub.jpg') }}')no-repeat; background-position: center; background-size: cover; border-radius: 5px;">
                                                <h2 style="color: #fff"><i class="icon fas fa-file-lines"></i> <strong>{{ $sub->sub_name }} - {{ $sub->sub_title }}</strong></h2>
                                                <span style="color: #fff; font-size: 12pt; margin-left: 45px">{{ $sub->subSec }}</span>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div style="border-bottom: 1px solid #000;">
                                                        <h2>Teacher</h2>
                                                    </div>
                                                    <div class="user-block mt-3">
                                                        <img class="img-circle img-bordered-sm" src="{{ asset('template/img/user.png') }}" alt="user image">
                                                        <span class="username mt-2">
                                                            <span>
                                                                @if(isset($sub->fname) && isset($sub->lname))
                                                                    {{ $sub->fname }} {{ substr($sub->mname, 0, 1) }}. {{ $sub->lname }}
                                                                @else
                                                                    No Instructor
                                                                @endif
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-5">
                                                    <div style="border-bottom: 1px solid #000;">
                                                        <h2>
                                                            @auth('web')
                                                                @if(Auth::guard('web')->user()->role == '100')
                                                                    Classmates
                                                                @endif
                                                            @endauth 

                                                            @auth('faculty')
                                                                @if(Auth::guard('faculty')->user()->role == '943')
                                                                    Students
                                                                @endif
                                                            @endauth 
                                                            <span class="float-right mt-3" style="font-size: 10pt;">{{ $substudcount }} Students</span>
                                                        </h2> 
                                                    </div>

                                                    <ul class="list-group list-group-unbordered mb-3">
                                                    @foreach($substud as $datastudent)
                                                        <li class="list-group-item">
                                                            <div class="user-block">
                                                                <img class="img-circle img-bordered-sm" src="{{ asset('template/img/student.png') }}" alt="user image">
                                                                <span class="username mt-2">
                                                                    <span>{{ $datastudent->lname }}, {{ $datastudent->fname }} {{ substr($datastudent->mname, 0, 1) }}.</span>
                                                                </span>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@include('modal.addtopicModal')


<script>
    var topicCreateRoute = "{{ route('storeTopics') }}";
    var topicShowRoute = "{{ route('showTopics', ['id' => ':id']) }}";

    var baseViewFileRoute = "{{ route('viewFile', ['filename' => 'filename']) }}";
    var baseUrl = "{{ url('/') }}";

</script>

@endsection