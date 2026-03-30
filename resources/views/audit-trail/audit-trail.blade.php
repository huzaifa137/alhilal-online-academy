@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <?php
    
    use App\Http\Controllers\AccessRightController;
    use App\Http\Controllers\AuditTrailController;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Helper;
    $controller = new Controller();
    $user_id = Helper::user_id();
    
    // $links = AuditTrailController::links();
    
    ?>

    <!--Page header-->
    <div class="page-header">
        
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Approvers</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
                        <section id="Approved_suppliers">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h3 class="heading text-primary" style="margin: 0;">Today</h3>

                            </div>
                            <br>

                            @if ($audit->isEmpty())
                                <div class="alert alert-warning" role="alert">
                                    No records found in the system
                                </div>
                            @else
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <th>Description</th>
                                            <th>By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($audit as $count => $list)
                                            <tr>
                                                <td>{{ $count + 1 }}.</td>
                                                <td>{{ Helper::date_fm($list->at_date_added) }}</td>
                                                <td>{{ $list->at_action }}</td>
                                                <td>{!! $list->at_description !!}</td>
                                                <td>{{ $list->at_username }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                    </div>
                    </section>

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

                    <script>
                        document.querySelectorAll('.delete-record-btn').forEach(function(btn) {
                            btn.addEventListener('click', function(event) {
                                event.preventDefault(); // Prevent the default link behavior

                                Swal.fire({
                                    title: 'Are you sure ?',
                                    text: 'Please confirm before you delete this record!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // If confirmed, redirect to the href (deletion URL)
                                        window.location.href = this.href;
                                    }
                                });
                            });
                        });

                        document.querySelectorAll('.edit-record-btn').forEach(function(button) {
                            button.addEventListener('click', function(event) {
                                event.preventDefault();

                                let url = this.getAttribute('data-url');

                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You are about to edit this record!",
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
                    </script>


                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
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
    </script>
@endsection



@section('js')
@endsection
