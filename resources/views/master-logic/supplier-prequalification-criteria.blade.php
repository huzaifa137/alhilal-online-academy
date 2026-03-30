@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <?php
    
    use App\Http\Controllers\AccessRightController;
    use App\Http\Controllers\MasterDataController;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Helper;
    $controller = new Controller();
    $user_id = Helper::user_id();
    
    $links = MasterDataController::links();
    
    ?>

    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Supplier Prequalification Evaluation Criteria</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Supplier Prequalification</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 panelSep">
            <div class="panel panel-primary tabs-style-4">
                <div class="tab-menu-heading">
                    <div class="tabs-menu">
                        <!-- Tabs -->
                        @include('layouts.active-links')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default tabs-style-4">
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        <h3 class="heading text-primary"></h3>

                        <form id="myForm" action="{{ route('store-prequalification-criteria') }}" method="POST">

                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

                            @csrf
                            <div class="formSep">

                                <style>
                                    .border {
                                        border: 1px solid #ddd;
                                        border-radius: 8px;
                                        padding: 20px;
                                        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.25);
                                        background-color: #ffffff;
                                    }
                                </style>

                                <div class="row border">
                                    @include('sweetalert::alert')

                                    <div class="col-sm-3 col-md-3" style="display:none;">
                                        <label for="">Select Category </label>
                                        <?php
                                        
                                        echo Controller::DropMasterData(config('constants.options.PROCUREMENT_CATEGORY'), '', 'category_of_procurement', 2);
                                        
                                        ?>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <label for="">Evaluation Criteria</label>
                                        <input class="form-control" type="text" name="supplier_document"
                                            id="supplier_document" required>
                                    </div>

                                    <div class="col-sm-4 col-md-4">
                                        <label for="">Mandatory / Optional</label>
                                        <select class="form-control" name="mandatory" id="mandatory">
                                            <option value="0">Optional</option>
                                            <option value="1">Mandatory</option>
                                        </select>
                                    </div>

                                    <div class="clearfix"></div>

                                    <!-- Button -->
                                    <div class="col-sm-4 col-md-4 mt-3">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-fw fa-save"></i> Save
                                            Criteria</button>
                                    </div>
                                </div>

                        </form>

                        <table class="table table-bordered table-striped" id="table">
                            <br>
                            <thead>
                                <tr>
                                    <th style="width: 1px;">No.</th>
                                    <th>Document Name</th>
                                    <th>Mandatory</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($documents as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->md_name }}</td>
                                        <td>{{ $item->md_misc2 ? 'Mandatory' : 'Optional' }}</td>
                                        <td>

                                            <a href="{{ url('master-data/edit-supplier-document/' . $item->md_id) }}"
                                                class="btn btn-sm btn-primary edit-record-btn"
                                                data-url="{{ url('master-data/edit-supplier-document/' . $item->md_id) }}">
                                                 <i class="fas fa-edit"></i> Edit
                                             </a>
                                             
                                             <a href="{{ url('delete-supplier-document/' . $item->md_id) }}"
                                                class="btn btn-sm btn-danger delete-record-btn">
                                                 <i class="fas fa-trash-alt"></i> Delete
                                             </a>
                                             

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
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

@section('scripts')
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'please confirm you want to add this document !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-record-btn').forEach(function(btn) {
            btn.addEventListener('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Please confirm before you delete this document!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = this.href;
                    }
                });
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-record-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                let url = this.getAttribute('data-url');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Please confirm you want to update this document!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, edit it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>

@section('js')
@endsection
