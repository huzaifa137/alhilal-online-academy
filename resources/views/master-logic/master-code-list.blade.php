@extends('layouts.master')
@section('css')
    <!-- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Master Data</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Master Code</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <?php
    use App\Http\Controllers\Helper;
    ?>

    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <!-- Row -->
    <div class="row mb-5">
        <div class="col-lg-3">
            <div class="panel panel-primary">
                <div class="list-group">
                    @foreach ($selected as $item)
                        @if ($item->mc_id == $mc_id)
                            <a href="#" class="active pt-1 pb-1 list-group-item"><i class="fa fa-circle"
                                    aria-hidden="true"></i> &nbsp; {{ $item->mc_name }} <span
                                    class="badge badge-white pull-right">{{ @$code_totals[$item->id]->total }}</span></a>
                        @else
                            <a href="{{ url('master-data/master-code-list/' . $item->mc_id) }}"
                                class="pt-1 pb-1 list-group-item">{{ $item->mc_name }} <span
                                    class="badge badge-white pull-right">{{ @$code_totals[$item->id]->total }}</span></a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="col-md-12 p-4">
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


                    <section id="Approved_suppliers">
                        <button id="addCodeBtn" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add
                            Record</button>
                        <div id="addCodeForm">
                            <h3 class="heading text-primary">Add Record</h3>

                            <form id="myForm" action="{{ route('add-new-record') }}" method="POST">

                                @csrf
                                <div class="formSep">

                                    <div class="row">

                                        <div class="col-sm-3 col-md-3">
                                            <label for="">Master Code</label>
                                            <select name="master_code_id" id="master_code_id" class="form-control">
                                                @foreach ($selected as $item)
                                                    @if ($item->mc_id == $mc_id)
                                                        <option selected value="{{ $item->id }}">{{ $item->mc_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->mc_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-sm-3 col-md-3">
                                            <label for="">Master Data Code</label>
                                            <input class="form-control" type="text" name="md_code" id="md_code"
                                                required>
                                        </div>


                                        <div class="col-sm-6 col-md-6">
                                            <label for="mask_product">Master Data Name</label>
                                            <input class="form-control" type="text" name="md_name" id="md_name"
                                                required>
                                        </div>

                                        <div class="col-sm-12 col-md-12 ">
                                            <label for="" class="mt-5">Master Data Description</label>
                                            <textarea class="form-control" name="md_description" id="md_description"></textarea>
                                        </div>


                                        <div class="col-sm-3 col-md-3 margTp" style="display: none">
                                            <label for="">md_date_added</label>
                                            <input class="form-control" type="text" name="md_date_added"
                                                id="md_date_added">
                                        </div>


                                        <div class="col-sm-3 col-md-3 margTp" style="display: none">
                                            <label for="mask_product">md_added_by</label>
                                            <input class="form-control" type="text" name="md_added_by" id="md_added_by">
                                        </div>


                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="mt-5 col-sm-3 col-md-3">
                                            <button class="btn btn-primary" id="add_new_data"><i
                                                    class="fa fa-fw fa-save"></i> Save</button>
                                        </div>

                            </form>
                        </div>
                    </section>

                </div>
            </div>
            <h3 class="mt-4 mb-0 pb-0 text-primary text-uppercase">{{ $mc_name }} List</h3>
            <div class="card mt-5 store">
                <div class="table-responsive p-5">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <tr>
                                <!-- <th style="width:30px;">No.</th> -->
                                <th>Data Code</th>
                                <th>Data Name</th>
                                <th class="text-center">Data Description</th>
                                <!-- <th>Date Added</th> -->
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>

                    <input type="hidden" value="{{ $mc_id }}" id="mc_id" />

                </div>

            </div>
        </div>
    </div>
    <!-- End Row -->

    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>


    <script type="text/javascript">
       

        $(document).ready(function() {
            var mcId = $('#mc_id').val();
            if (!mcId) {
                console.error('mc_id is empty or undefined');
                return;
            }

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('master-code-list', ['id' => '__mc_id__']) }}'.replace("__mc_id__", $(
                        '#mc_id').val()),
                    error: function(xhr, error, thrown) {
                        // Log the error response to display it
                        console.error('AJAX Error:', xhr.status, error, thrown);
                        $('body').html(xhr.responseText); // Show the raw response from the server
                    }
                },
                columns: [{
                        data: 'md_code',
                        name: 'md_code'
                    },
                    {
                        data: 'md_name',
                        name: 'md_name'
                    },
                    {
                        data: 'md_description',
                        name: 'md_description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: 20,
                lengthMenu: [10, 25, 50, 100],
                order: [
                    [0, 'asc']
                ],
                searching: true,
                ordering: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        });


        $(document).ready(function() {
            $('#addCodeForm').hide();
            $('#addCodeBtn').click(function() {
                $('#addCodeForm').toggle();
                const buttonText = $('#addCodeForm').is(':visible') ? 'Hide Form' : 'Add Code';
                $(this).text(buttonText);
            });
        });
    </script>
    <!--Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
@endsection
