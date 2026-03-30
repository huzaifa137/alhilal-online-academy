@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">All Quizzes</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">All Quizzes</li>
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

                @if (count($quizzes) > 0)
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">List of all quizzies</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap table-primary mb-0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-white" style="width: 1px;text-align:center;">No</th>
                                    <th class="text-white">Quiz</th>
                                    <th class="text-white">Course</th>
                                    <th class="text-white" colspan="4" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizzes as $count => $quiz)
                                    <tr>
                                        <th scope="row">{{ $count + 1 }}</th>
                                        <td>{{ $quiz->title }}</td>
                                        <td>{{ Helper::course_information($quiz->course_id) }}</td>
                                        <td>
                                            <a href="{{ url('/quiz/show-questions', $quiz->id) }}"
                                                class="btn btn-sm btn-secondary">
                                                <i class="fas fa-user"></i> Admin View
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('/quiz/on-take', $quiz->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-user-graduate"></i> Student View
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ url('/quiz/questions/create', $quiz->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-file-medical"></i> Add Qns
                                            </a>
                                        </td>

                                        <td>
                                            <a href="#" class="btn btn-sm btn-danger delete-quiz-btn"
                                                data-id="{{ $quiz->id }}">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $quizzes->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-12 col-md-12">
                        {{-- <div class="card-header d-flex justify-content-between align-items-center">
                            <a href="{{ url('quiz/create-quiz') }}" class="btn btn-sm btn-info">
                                <i class="fas fa-plus-circle"></i> Create New Quiz
                            </a>
                        </div> --}}
                        <div class="alert alert-warning mt-3 mb-3" role="alert">
                            No quizzes found in the system
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

        $(document).on('click', '.delete-quiz-btn', function(e) {
            e.preventDefault();

            var quizId = $(this).data('id');

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
                        url: '/quiz/delete-quiz/' + quizId,
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


        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection
