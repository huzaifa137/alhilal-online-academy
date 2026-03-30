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

    <div class="mb-3 d-flex justify-content-between align-items-end flex-wrap">
        <div>
            <label for="course-filter" class="form-label">Filter Courses:</label>
            <select id="course-filter" class="form-control" style="max-width: 300px;">
                <option value="all" selected>All Courses</option>
                <option value="enrolled">Enrolled Courses</option>
                <option value="not_enrolled">Not Enrolled Courses</option>
            </select>
        </div>

        <div>
            <a href="{{ route('student.cart') }}" class="btn mt-4" style="background-color: #28a745; color: white;">
                <i class="fas fa-shopping-cart"></i> Proceed to Cart
            </a>
        </div>
    </div>


    <div id="courses-container">
        @include('Courses.partials.courses_grid', [
            'allCourses' => $allCourses,
            'enrolledCourseIds' => $enrolledCourseIds,
        ])
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
