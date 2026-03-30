<?php
use App\Http\Controllers\Helper;
use App\Http\Controllers\Controller;
$controller = new Controller();
?>
@extends('layouts-side-bar.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
@endsection
@section('content')
    <style>
        .item-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .item-card:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 2;
        }

        .item-card img {
            transition: transform 0.4s ease;
        }

        .item-card:hover img {
            transform: scale(1.05);
        }

        .item-card:hover .btn-primary {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            transition: background-color 0.3s ease;
        }

        .item-card:hover .shop-title {
            color: #007bff;
            transition: color 0.3s ease;
        }
    </style>
    <br> <br>
    <h3>Enrolled Courses</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">

                @foreach ($enrolledCourses as $course)
                    @php
                        $courseModuleCount = $course->modules->count();
                        $courseLessonsCount = $course->modules->flatMap->lessons->count();
                        $isEnrolled = in_array($course->id, $enrolledCourseIds);
                    @endphp

                    <div class="col-xl-4 col-lg-6 col-sm-6">
                        <div class="card item-card">
                            <div class="card-body pb-0">
                                <div class="text-center">
                                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('assets/images/products/default.jpg') }}"
                                        alt="Course Thumbnail" class="img-fluid w-100">
                                </div>
                                <div class="card-body px-0">
                                    <div class="cardtitle">
                                        <div>
                                            @for ($i = 0; $i < 5; $i++)
                                                <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                            @endfor
                                        </div>
                                        <a class="shop-title">{{ $course->title }} ({{ $courseLessonsCount }})</a>
                                        <h5 style="margin-top: 0.2rem; text-align: left !important;color:green;">
                                            Ugx{{ $course->selling_price }}
                                        </h5>
                                    </div>

                                    <div class="cardprice"
                                        style="display: flex; flex-direction: column; align-items: flex-start; text-align: left !important;">
                                        <span class="type--strikethrough"
                                            style="text-align: left !important; margin-bottom: 4px;color:red;">
                                            Ugx{{ $course->old_price }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center border-top p-4">
                                <a href="{{ route('course.details', $course->id) }}"
                                    class="btn btn-light btn-svgs mt-1 mb-1">
                                    <i class="fa fa-eye me-1"></i> &nbsp; View Course Details
                                </a>

                                @if ($isEnrolled)
                                    <a href="{{ route('lesson.ongoing', $course->id) }}"
                                        class="btn btn-success btn-svgs mt-1 mb-1">
                                        <i class="fa fa-book me-1"></i> &nbsp; Resume Learning
                                    </a>
                                @else
                                    <form action="{{ route('cart.add', $course->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-svgs mt-1 mb-1">
                                            <i class="fa fa-shopping-cart me-1"></i> Add to Cart
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    </div>
    </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $('#courses-container').on('submit', '.add-to-cart-form', function(e) {
            e.preventDefault();

            var form = $(this);
            var courseId = form.data('course-id');
            var submitBtn = $('#add-to-cart-btn-' + courseId);
            var actionUrl = form.attr('action');
            var formData = form.serialize();

            submitBtn.prop('disabled', true);
            submitBtn.html('Adding to cart ... <i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: formData,
                success: function(response) {
                    submitBtn.html('<i class="fas fa-check-circle"></i> Added to Cart');
                    submitBtn.removeClass('btn-primary').addClass('btn-success');
                },
                error: function(xhr) {
                    submitBtn.html('Try again');
                    submitBtn.prop('disabled', false);
                }
            });
        });

        // ✅ Filter Courses
        $('#course-filter').on('change', function() {
            const filter = $(this).val();

            $.ajax({
                url: "{{ route('student.courses.filter') }}",
                method: "GET",
                data: {
                    filter: filter
                },
                success: function(html) {
                    $('#courses-container').html(html);
                },
                error: function(data) {
                    $('body').html(data.responseText);
                }
            });
        });
    });
</script>
</script>
@section('js')
    <!-- ECharts js -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <!-- Peitychart js-->
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!---jvectormap js-->
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.world.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script>
    <!-- Index js-->
    <script src="{{ URL::asset('assets/js/index1.js') }}"></script>
    <!-- Data tables js-->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>
    <!--Counters -->
    <script src="{{ URL::asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
@endsection
