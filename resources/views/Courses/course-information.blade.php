@extends('layouts.master')
@section('css')
    <!-- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Instructor Profile</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void();" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Course Details</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <?php
    use App\Http\Controllers\Helper;
    ?>
    <!-- Row -->
    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card box-widget widget-user">
                <div class="widget-user-image mx-auto mt-5"><img alt="User Avatar" class="rounded-circle"
                        src="{{ URL::asset('assets/images/users/16.jpg') }}"></div>
                <div class="card-body text-center">
                    <div class="pro-user">
                        <h3 class="pro-user-username text-dark mb-1">
                            {{ Helper::item_md_name($course->instructor_id) ?? 'N/A' }}</h3>
                        <h6 class="pro-user-desc text-muted">{{ Helper::item_md_name($course->category_id) ?? 'N/A' }}</h6>
                        <a href="{{ url('/users/users-profile') }}" class="btn btn-primary mt-3">View Profile</a>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <div class="row">
                        <div class="col-sm-12 border-right text-center">
                            <div class="description-block p-4">
                                <h5 class="description-header mb-1 font-weight-bold">689k</h5>
                                <span class="text-muted">Followers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Custom Styling (include once) -->
        <style>
            .form-control[readonly],
            .form-control[disabled],
            textarea[readonly] {
                background-color: #f9f9f9;
                color: #555;
                cursor: not-allowed;
                border-color: #e3e6f0;
            }

            .form-label {
                font-weight: 600;
                color: #444;
            }

            .card-title {
                font-size: 1.25rem;
                font-weight: 600;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .card {
                border-radius: 10px;
                box-shadow: 0 0 12px rgba(0, 0, 0, 0.04);
            }
        </style>

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="card-title text-dark">Course Details</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Instructor Name</label>
                                <input type="text" class="form-control"
                                    value="{{ Helper::item_md_name($course->instructor_id) ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" value="{{ $course->title }}" readonly>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Language</label>
                                <input type="text" class="form-control"
                                    value="{{ Helper::item_md_name($course->language) ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Difficulty</label>
                                <input type="text" class="form-control text-capitalize" value="{{ $course->difficulty }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control"
                                    value="{{ Helper::item_md_name($course->category_id) ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Tags</label>
                            @foreach ($course->tags ?? [] as $tag)
                                <a class="btn btn-sm btn-white mt-1 me-1 text-capitalize"
                                    href="javascript:void();">{{ $tag }}</a>
                            @endforeach
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea rows="5" class="form-control" readonly>{!! $course->description !!}</textarea>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
    <!-- End Row-->

    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <!--Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
@endsection
