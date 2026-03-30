@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">All Messages</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">All Messages</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')

    <style>
        .swal2-container {
            z-index: 99999 !important;
            /* Ensure SweetAlert is above the modal */
        }
    </style>

    <br> <br>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="tab-pane" id="tab6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-dark">All Messages</h5>

                        @if ($messages->count() > 0)
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap table-primary mb-0">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-white">#</th>
                                            <th class="text-white">Email</th>
                                            <th class="text-white">Subject</th>
                                            <th class="text-white">Date Sent</th>
                                            <th class="text-white">Status</th>
                                            <th class="text-white">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($messages as $index => $message)
                                            <tr>
                                                <td style="width: 1px;">
                                                    {{ $index + 1 }}
                                                </td>
                                                <td>{{ $message->student_email }}</td>
                                                <td>{{ $message->student_subject }}</td>
                                                <td>{{ \Carbon\Carbon::parse($message->date_added)->format('Y-m-d H:i') }}
                                                </td>
                                                <td>
                                                    @if ($message->admin_response_status == 1)
                                                        <span class="badge badge-success">Responded</span>
                                                    @else
                                                        <span class="badge badge-warning">Pending Response</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-info" data-toggle="modal"
                                                        data-target="#messageModal{{ $message->id }}">
                                                        <i class="fas fa-envelope-open-text mr-1"></i> View Message
                                                    </button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="messageModalLabel{{ $message->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title"
                                                                id="messageModalLabel{{ $message->id }}">
                                                                Student Message Details
                                                            </h5>
                                                            <button type="button" class="close text-white"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Email:</strong> {{ $message->student_email }}</p>
                                                            <p><strong>Subject:</strong> {{ $message->student_subject }}
                                                            </p>
                                                            <p><strong>Message:</strong></p>
                                                            <div
                                                                style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; text-align: justify;">
                                                                {{ $message->student_message }}
                                                            </div>
                                                            <hr>
                                                            <p><strong>Date Sent:</strong>
                                                                {{ \Carbon\Carbon::parse($message->date_added)->format('Y-m-d H:i') }}
                                                            </p>

                                                            @if ($message->admin_response_status == 0)
                                                                <form
                                                                    action="{{ route('admin.updateMessageResponse', $message->id) }}"
                                                                    method="POST" id="responseForm">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label for="response">Admin Response:</label>
                                                                        <textarea name="response" id="response" class="form-control" rows="4" required></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            <i class="fas fa-paper-plane"></i> Submit
                                                                            Response
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <p><strong>Admin Response:</strong></p>
                                                                <div
                                                                    style="background-color: #f1f1f1; padding: 15px; border-radius: 5px; text-align: justify;">
                                                                    {{ $message->admin_response_message }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No messages submitted yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6'
                    });
                </script>
            @endif


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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#responseForm').on('submit', function(event) {
            event.preventDefault();

            var submitBtn = $(this).find('button[type="submit"]');
            var originalText = submitBtn.html();

            submitBtn.prop('disabled', true).html('Sending... <i class="fas fa-spinner fa-spin"></i>');

            Swal.fire({
                title: 'Are you sure?',
                text: 'Once submitted, you cannot undo this action.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading indicator
                    Swal.fire({
                        title: 'Submitting...',
                        html: '<div><i class="fas fa-spinner fa-spin"></i> Please wait</div>',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Actually submit the form
                    this.submit();
                } else {
                    submitBtn.prop('disabled', false).html(originalText);
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
