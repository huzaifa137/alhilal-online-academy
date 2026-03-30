@extends('layouts.master')

@section('css')
    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Create new course</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">create new course</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
    <!--Row-->

    <style>
        #course_thumbnail {
            width: 100%;
            padding: 0.375rem 0.75rem;
            display: block;
        }

        #file-message {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .form-control-file {
            display: block;
            width: 100%;
            height: auto;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
            background-color: #fff;
            cursor: pointer;
        }

        #loading-gif {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            /* Ensure it's on top of other content */
        }
    </style>

    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="wizard3">
                        <h3><i class="fas fa-book-open me-2"></i> Course Information</h3>
                        <section>
                            <div class="control-group form-group">
                                <br>
                                <label class="form-label">Course Title</label>
                                <input type="text" id="course_title" class="course_title form-control required"
                                    placeholder="Name">
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label">Instructor</label>
                                <select class="form-control select2" id="instructor_id" name="instructor_id">
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->md_id }}">{{ $instructor->md_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label">Category</label>
                                <select class="form-control select2" id="category_id" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->md_id }}">{{ $category->md_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="control-group form-group mb-0">
                                <label class="form-label">Language</label>
                                <select class="form-control select2" id="language" name="language">
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->md_id }}">{{ $language->md_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </section>

                        <h3><i class="fas fa-file-alt me-2"></i> Course Content</h3>
                        <section>
                            <div class="form-group mt-3">
                                <label for="course_description" class="form-label">Course Description</label>
                                <input type="text" class="form-control" name="course_description" id="course_description"
                                    placeholder="Write course description...">
                            </div>

                            <div class="form-group">
                                <label for="difficulty" class="form-label">Difficulty</label>
                                <select class="form-control select2" name="course_difficulty" id="course_difficulty">
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tags" class="form-label">Tags (comma-separated)</label>
                                <input type="text" class="form-control" name="course_tags" id="course_tags"
                                    placeholder="e.g. PHP, Laravel, Web Development">
                            </div>
                        </section>

                        <h3><i class="fas fa-cog me-2"></i> Settings</h3>
                        <section>

                            <div class="form-group mt-3">
                                <label for="" class="form-label">Attach Course Thumbnail</label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <input type="file" name="course_thumbnail" id="course_thumbnail"
                                            accept=".jpg,.jpeg,.png" class="form-control form-control-file">
                                        <small id="file-message" class="form-text text-muted mt-2" style="display:none;">
                                            Thumbnail has been attached.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pricing_category" class="form-label">Pricing</label>
                                <select class="form-control select2" name="pricing_category" id="pricing_category">
                                    <option value="1">Paid</option>
                                    <option value="0">Free</option>
                                </select>
                            </div>


                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_published" name="is_published">
                                <label class="form-check-label" for="is_published">Publish Course</label>
                            </div>
                        </section>
                    </div>
                </div>

                <div id="loading-gif">
                    <img src="{{ URL::asset('assets/images/brand/loading.gif') }}" alt="Loading...">
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- /Row -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is loaded -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection

@section('js')
    <!-- Jquery.steps js -->
    <script src="{{ URL::asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Form-wizard js-->
    <script src="{{ URL::asset('assets/plugins/formwizard/jquery.smartWizard.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/formwizard/fromwizard.js') }}"></script>
    <!--Accordion-Wizard-Form js-->
    <script src="{{ URL::asset('assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-wizard.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-wizard2.js') }}"></script>
    <!--File-Uploads Js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!-- File uploads js -->
    <script src="{{ URL::asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filupload.js') }}"></script>
    <!-- Multiple select js -->
    <script src="{{ URL::asset('assets/plugins/multipleselect/multiple-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/multipleselect/multi-select.js') }}"></script>
    <!--Sumoselect js-->
@endsection
