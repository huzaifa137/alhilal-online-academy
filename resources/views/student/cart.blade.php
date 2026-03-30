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
    <br><br>
    <!-- Row-->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 bootstrap snippets">
            <!-- Cart -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Courses Added</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-top">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Quantity</th>
                                    <th>Course Price</th>
                                    <th>Sub Total</th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cart as $item)
                                    <tr data-id="{{ $item['id'] }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div style="width: 64px; height: 64px;">
                                                    <img src="{{ $item['thumbnail'] ? asset('storage/' . $item['thumbnail']) : asset('assets/images/products/default.jpg') }}"
                                                        alt="img" class="w-100 h-100 object-cover rounded" />
                                                </div>
                                                <h6 class="mb-0 ml-3 font-weight-bold">{{ $item['title'] }}</h6>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-sm btn-light quantity-decrease"
                                                    {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                                <span class="mx-2 quantity-value">{{ $item['quantity'] }}</span>
                                                <button class="btn btn-sm btn-light quantity-increase">+</button>
                                            </div>
                                        </td>

                                        <td>UGX <span class="unit-price"
                                                data-price="{{ (int) str_replace(',', '', $item['price']) }}">{{ $item['price'] }}</span>
                                        </td>

                                        <td>

                                            @php
                                                $course = DB::table('courses')->where('id', $item['id'])->first();
                                            @endphp

                                            @if ($course->pricing_category == 0)
                                                Free
                                            @else
                                                UGX <span class="subtotal">
                                                    {{ number_format((int) str_replace(',', '', $item['price']) * $item['quantity']) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('cart.remove', ['id' => $item['id']]) }}" class="remove_cart"
                                                data-toggle="tooltip" data-placement="top" title="">
                                                <span class="delete-icon">
                                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                                        viewBox="0 0 24 24" width="24">
                                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                                        <path d="M8 9h8v10H8z" opacity=".3" />
                                                        <path
                                                            d="M15.5 4l-1-1h-5l-1 1H5v2h14V4zM6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9z" />
                                                    </svg>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No items in cart</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="float-right">
                        <a href="{{ url('/student/courses-and-lessons') }}" class="btn btn-dark"><i
                                class="fe fe-arrow-left"></i> Continue Enrolling</a>

                        <a href="{{ route('student.checkout') }}" class="btn"
                            style="background-color: #007bff; color: white;">
                            <i class="fas fa-credit-card"></i> Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Cart -->
        </div>
    </div>
    </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {


        $('.remove_cart').on('click', function(e) {
            e.preventDefault();
            var $link = $(this);
            var $iconContainer = $link.find('.delete-icon');
            $iconContainer.html('<i class="fas fa-spinner fa-spin"></i>');
            setTimeout(function() {
                window.location.href = $link.attr('href');
            }, 300);
        });


        function updateCartSession(courseId, quantity) {
            $.ajax({
                url: '{{ route('cart.updateQuantity') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: courseId,
                    quantity: quantity
                },
                success: function(response) {
                    console.log('Cart updated successfully.');
                },
                error: function(xhr) {
                    console.error('Failed to update cart.');
                }
            });
        }


        $('.quantity-increase').on('click', function() {
            var $row = $(this).closest('tr');
            var $quantityElement = $row.find('.quantity-value');
            var $decreaseBtn = $row.find('.quantity-decrease');
            var $subtotalElement = $row.find('.subtotal');
            var unitPrice = parseInt($row.find('.unit-price').data('price'));
            var courseId = $row.data('id');

            var quantity = parseInt($quantityElement.text()) + 1;
            $quantityElement.text(quantity);
            $decreaseBtn.prop('disabled', quantity <= 1);

            var newSubtotal = unitPrice * quantity;
            $subtotalElement.text(newSubtotal.toLocaleString());

            updateCartSession(courseId, quantity);
        });


        $('.quantity-decrease').on('click', function() {
            var $row = $(this).closest('tr');
            var $quantityElement = $row.find('.quantity-value');
            var $subtotalElement = $row.find('.subtotal');
            var unitPrice = parseInt($row.find('.unit-price').data('price'));
            var courseId = $row.data('id');

            var quantity = parseInt($quantityElement.text());
            if (quantity > 1) {
                quantity--;
                $quantityElement.text(quantity);

                var newSubtotal = unitPrice * quantity;
                $subtotalElement.text(newSubtotal.toLocaleString());

                $(this).prop('disabled', quantity <= 1);

                updateCartSession(courseId, quantity);
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
