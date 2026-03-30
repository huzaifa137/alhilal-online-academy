@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">All Courses</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">All Courses</li>
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

    <div id="loading-gif">
        <img src="{{ URL::asset('assets/images/brand/loading.gif') }}" alt="Loading...">
    </div>

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">

                @if (count($allCourses) > 0)
                    <div class="card-header">
                        <h3>List of all courses</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap table-primary mb-0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-white" style="width: 1px;text-align:center;">No</th>
                                    <th class="text-white">Course</th>
                                    <th class="text-white">Instructor</th>
                                    <th class="text-white">Category</th>
                                    <th class="text-white">Difficulty</th>
                                    <th class="text-white" colspan="3" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allCourses as $count => $course)
                                    <tr>
                                        <th scope="row">{{ $count + 1 }}</th>
                                        <td>{{ $course->title }}</td>
                                        <td>{{ Helper::item_md_name($course->instructor_id) }}</td>
                                        <td>{{ Helper::item_md_name($course->category_id) }}</td>
                                        <td>{{ $course->difficulty }}</td>
                                        <td>
                                            <a href="{{ url('/courses/course-information', $course->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ url('/courses/edit-course-information', $course->id) }}"
                                                class="btn btn-sm btn-secondary">
                                                <i class="fas fa-eye"></i> <i class="fas fa-edit"></i>
                                                Edit</a>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" data-id="{{ $course->id }}"
                                                class="btn btn-sm btn-danger delete-course-btn">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $allCourses->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-12 col-md-12">
                        <div class="alert alert-warning mt-3" role="alert">
                            No courses found in the system
                        </div>
                    </div>
                @endif


                <!-- table-responsive -->
            </div>
        </div>
    </div>
    <!-- End Row -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <script>
        function showLoading() {
            $('#loading-gif').show();
        }


        function hideLoading() {
            $('#loading-gif').hide();
        }

        $(document).on('click', '.delete-course-btn', function(e) {
            e.preventDefault();

            var courseId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the course and all its related information.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                        url: '/courses/delete-course/' + courseId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                hideLoading();
                                Swal.fire('Deleted!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', 'Could not delete the course.', 'error');
                            }
                        },
                        error: function(data) {
                            $('body').html(data.responseText);
                        }

                    });
                }
            });
        });
    </script>
@endsection
