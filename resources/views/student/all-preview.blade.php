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
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Course Certifications</h4>
        </div>
    </div>

    <style>
        .body-information {
            font-family: 'Georgia', serif;
            text-align: center;
            padding: 60px 20px;
            background: #f2f2f2;
            color: #2c3e50;
        }

        .certificate-container {
            background: #fff url('{{ asset('images/watermark.png') }}') no-repeat center;
            background-size: 60%;
            border: 16px solid #2c3e50;
            padding: 60px 40px;
            position: relative;
            max-width: 1000px;
            width: 100%;
            margin: auto;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.15);
        }

        .certificate-title {
            font-size: 42px;
            font-weight: bold;
            color: #34495e;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 20px;
            color: #7f8c8d;
            margin: 15px 0;
        }

        .recipient-name {
            font-size: 32px;
            margin: 20px 0;
            font-style: italic;
            font-weight: 500;
            color: #2c3e50;
        }

        .course-title {
            font-size: 24px;
            font-weight: 600;
            color: #16a085;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .date {
            font-size: 16px;
            color: #7f8c8d;
            margin-top: 40px;
        }

        .signature {
            margin-top: 60px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            padding: 0 40px;
        }

        .signature .sig-block {
            width: 200px;
            border-top: 1px solid #2c3e50;
            text-align: center;
            font-size: 14px;
            padding-top: 5px;
            color: #34495e;
        }

        .logo {
            width: 80px;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .seal {
            width: 70px;
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        .certificate-container::before {
            content: '';
            background: url('{{ asset('assets/images/uplogo.png') }}') no-repeat center center;
            background-size: 60%;
            opacity: 0.10;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .action-buttons {
            text-align: right;
            margin-top: 20px;
            max-width: 1000px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 768px) {
            .certificate-container {
                padding: 40px 20px;
            }

            .certificate-title {
                font-size: 28px;
            }

            .recipient-name {
                font-size: 24px;
            }

            .course-title {
                font-size: 20px;
            }

            .signature {
                flex-direction: column;
                gap: 20px;
            }

            .logo,
            .seal {
                width: 60px;
            }

            .action-buttons {
                text-align: center;
            }
        }
    </style>


    <!--End Page header-->
@endsection
@section('content')
    <br> <br>
    @foreach ($certificates as $cert)
        @php
            $course = $cert['course'];
            $isCompleted = $cert['isCompleted'];
        @endphp

        <div class="body-information">
            <div class="certificate-container">
                <img src="{{ asset('assets/images/uplogo.png') }}" alt="Logo" class="logo">
                <h1 class="certificate-title">Certificate of Completion</h1>
                <p class="subtitle">This is to certify that</p>
                <div class="recipient-name">
                    @if ($user->firstname && $user->lastname)
                        {{ $user->firstname }} {{ $user->lastname }}
                    @else
                        {{ $user->username }}
                    @endif
                </div>
                <p class="subtitle">has successfully completed the course</p>
                <div class="course-title">"{{ $course->title ?? 'Course Title' }}"</div>
                <p class="date">Awarded on {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>

                <div class="signature">
                    <div class="sig-block">Instructor Name<br><em>Course Instructor</em></div>
                    <div class="sig-block">Platform Admin<br><em>Administrator</em></div>
                </div>

                <img src="{{ asset('assets/images/uplogo.png') }}" alt="Official Seal" class="seal">
            </div>

            <div class="action-buttons text-right mt-3">
                @if ($isCompleted)
                    <a href="{{ route('certificate.download', $course->id) }}" class="btn btn-success">
                        <i class="fa fa-download me-1"></i> Download Certificate
                    </a>
                @else
                    <button class="btn btn-secondary" disabled>
                        <i class="fa fa-lock me-1"></i> Complete all lessons under this course to download
                    </button>
                @endif
            </div>
        </div>

    @endforeach
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
