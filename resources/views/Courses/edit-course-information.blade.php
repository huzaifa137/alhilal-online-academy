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

    <style>
        #loading-gif {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>

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

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="card-title text-dark">Course Details</div>
                </div>

                <form id="updateCourseForm">
                    <input type="hidden" id="course_id" value="{{ $course->id }}">

                    <div class="card-body">
                        <div class="row">

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Instructor Name</label>
                                    <td><?php
                                    echo Helper::DropMasterData(config('constants.options.COURSE_INSTRUCTORS'), $course->instructor_id, 'instructor_id', 1);
                                    ?></td>
                                </div>
                            </div>


                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="pricing_category" class="form-label">Pricing</label>
                                    <select class="form-control select2" name="pricing_category" id="pricing_category">
                                        <option value="{{ $course->pricing_category }}">
                                            {{ $course->pricing_category == 1 ? 'Paid' : 'Free' }}
                                        </option>
                                        <option value="1">Paid</option>
                                        <option value="0">Free</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" value="{{ $course->title }}">
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Language</label>
                                    <td><?php
                                    echo Helper::DropMasterData(config('constants.options.COURSE_LANGUAGES'), $course->language, 'language', 2);
                                    ?></td>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Difficulty</label>
                                    <select class="form-control select2" name="difficulty" id="difficulty">
                                        <option value={{ $course->difficulty }}>{{ $course->difficulty }}</option>
                                        <option value="beginner">Beginner</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="advanced">Advanced</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <td><?php
                                    echo Helper::DropMasterData(config('constants.options.COURSE_CATEGORIES'), $course->category_id, 'category', 2);
                                    ?></td>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Tags</label>
                                <input type="text" class="form-control" name="tags" id="tags"
                                    value="{{ implode(', ', $course->tags ?? []) }}" />
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea rows="5" class="form-control" id="description">{!! $course->description !!}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Old Price</label>
                                    <input type="text" class="form-control" id="old_price"
                                        placeholder="Course Old Price" value="{{ $course->old_price }}">
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Selling Price</label>
                                    <input type="text" class="form-control" id="selling_price"
                                        placeholder="Course Selling Price" value="{{ $course->selling_price }}">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="javascript:void(0);" class="btn btn-lg btn-primary" id="updateBtn">
                                <i class="fas fa-check-circle"></i> Update
                            </a>
                        </div>
                </form>

            </div>
        </div>
    </div>

    </div>
    <!-- End Row-->

    </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.1/dist/sweetalert2.min.js"></script>

    <script>
        $('#updateBtn').click(function() {

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this course?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {

                    var button = $('#updateBtn')[0];
                    button.disabled = true;
                    button.innerHTML = 'Updating course... <i class="fas fa-spinner fa-spin"></i>';

                    var courseData = {
                        course_id: $('#course_id').val(),
                        title: $('#title').val(),
                        language: $('#language').val(),
                        difficulty: $('#difficulty').val(),
                        category: $('#category').val(),
                        description: $('#description').val(),
                        selling_price: $('#selling_price').val(),
                        old_price: $('#old_price').val(),
                        instructor_id: $('#instructor_id').val(),
                        pricing_category: $('#pricing_category').val(),

                        tags: $('#tags').val(),
                        _token: "{{ csrf_token() }}"
                    };

                    $.ajax({
                        url: "{{ route('update.course.information') }}",
                        type: 'POST',
                        data: courseData,
                        success: function(response) {
                            if (response.status) {
                                Swal.fire('Updated!', response.message, 'success').then(() => {
                                    button.disabled = false;
                                    button.innerHTML = 'Update';

                                    location.reload();
                                });
                            } else if (response.error) {
                                Swal.fire('Error!', response.error, 'error').then(() => {
                                    button.disabled = false;
                                    button.innerHTML = 'Update';
                                });
                            }
                        },
                        error: function(data) {
                            $('body').html(data.responseText);

                            button.disabled = false;
                            button.innerHTML = 'Update';
                        }
                    });
                }
            });
        });
    </script>
@endsection
