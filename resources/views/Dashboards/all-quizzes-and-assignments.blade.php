@extends('layouts.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Quizzes and Assignments</h4>
        </div>
    </div>
    <!--End Page header-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection
@section('content')
    <!-- Row -->

    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="row">
                
                <!-- Quizzes Card -->

                <div class="col-xl-6 col-lg-6 col-md-6">
                    <a href="{{ url('/quiz/create-quiz') }}" class="text-decoration-none">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-tasks card-custom-icon text-success icon-dropshadow-success fa-4x"></i>

                                <p class="mb-1" style="visibility: hidden;">Student Quizzes</p>
                                <h2 class="mb-1 font-weight-bold">Create Quiz</h2>
                                <div class="progress progress-sm mt-3 bg-success-transparent">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <a href="{{ url('/quiz/all-quizzes') }}" class="text-decoration-none">
                        <div class="card">
                            <div class="card-body">
                                <i
                                    class="fas fa-clipboard-question card-custom-icon text-primary icon-dropshadow-primary fa-4x"></i>
                                <h4 class="mb-1">All Quizzes</h4>
                                <h2 class="mb-1 font-weight-bold">{{ $quizCount }}</h2>
                                <div class="progress progress-sm mt-3 bg-primary-transparent">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                        style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
            </div>

            <!-- Centered Third Card -->
            {{-- <div class="row justify-content-center mt-4">
                <!-- Assignments Card -->
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <a href="javascript:void(0);" class="text-decoration-none">
                        <div class="card">
                            <div class="card-body">
                                <i class="fas fa-file-alt card-custom-icon text-info icon-dropshadow-info fa-4x"></i>
                                <h4 class="mb-1">Assignments</h4>
                                <h2 class="mb-1 font-weight-bold">0</h2>
                                <div class="progress progress-sm mt-3 bg-info-transparent">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                        style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div> --}}

        </div>
    </div>


    </div>
    </div><!-- end app-content-->
    </div>
@endsection
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
    <!-- P-scroll js-->
    <script src="{{ URL::asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script>
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
