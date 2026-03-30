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
    <div class="container my-5">
        <div class="row">
            <!-- Payment Details Left -->
            <div class="col-md-7">
                <h4 class="mb-3">Checkout</h4>

                <!-- Selected Courses -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Selected Courses</h5>
                        @foreach ($cart as $item)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $item['thumbnail'] ? asset('storage/' . $item['thumbnail']) : asset('assets/images/products/default.jpg') }}"
                                    class="rounded mr-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <strong>{{ $item['title'] }}</strong><br>
                                    <small>Quantity: {{ $item['quantity'] }}</small><br>
                                    <small>UGX
                                        {{ number_format((int) str_replace(',', '', $item['price']) * $item['quantity']) }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Payment Method</h5>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" id="visaCard" name="paymentMethod" class="custom-control-input" checked>
                            <label class="custom-control-label" for="visaCard">
                                <img src="https://img.icons8.com/color/48/000000/visa.png" style="height: 24px;"> Visa Debit
                                Card ending with 3456
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="masterCard" name="paymentMethod" class="custom-control-input">
                            <label class="custom-control-label" for="masterCard">
                                <img src="https://img.icons8.com/color/48/000000/mastercard.png" style="height: 24px;">
                                Mastercard ending with 1038
                            </label>
                        </div>
                        <a href="#" class="btn btn-link mt-2">+ Add payment card</a>
                    </div>
                </div>
            </div>

            <!-- Order Recap Right -->
            <div class="col-md-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex flex-column justify-content-between h-100">
                        <div>
                            <h5 class="card-title">Order Recap</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Subtotal</span>
                                    <strong>UGX {{ number_format($subtotal) }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Discount</span>
                                    <strong> UGX {{ number_format($discount ?? 0) }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>VAT (0)</span>
                                    <strong>UGX {{ number_format($vat) }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between font-weight-bold">
                                    <span>Total</span>
                                    <strong>UGX {{ number_format($total) }}</strong>
                                </li>
                            </ul>
                        </div>

                        <link rel="stylesheet"
                            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

                        <div class="mt-4">
                            <a href="#" id="proceed-to-payment-btn" class="btn btn-primary btn-block">
                                {{-- <i class="fas fa-credit-card"></i> Proceed to Payment --}}
                                <i class="fas fa-credit-card"></i> Proceed to Enroll
                            </a>

                            <form id="checkout-process-form" method="POST" action="{{ route('checkout.process') }}"
                                style="display: none;">
                                @csrf
                            </form>

                            <a href="{{ route('student.cart') }}" class="btn btn-info btn-block mt-3">
                                <i class="fas fa-arrow-left"></i> Return to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#proceed-to-payment-btn').on('click', function(e) {
            e.preventDefault();

            let isAllFree = {{ $isAllFree ? 'true' : 'false' }};

            if (isAllFree) {
                $('#checkout-process-form').submit();
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Payment Required',
                    html: 'You can only enroll in free courses for now.<br>For paid courses, please contact the admin on <br><br> Whatsapp : <strong>0702 08 22 09</strong>',
                    confirmButtonText: 'Okay'
                });
            }
        });
    });
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
