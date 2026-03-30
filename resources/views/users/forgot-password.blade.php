@extends('layouts.master2')
@section('css')
@endsection
@section('content')
    <div class="d-md-flex">
        <div class="w-40 bg-style h-100vh page-style">
            <div class="page-content">
                <div class="page-single-content">
                    <div class="card-body text-white py-5 px-8 text-center">
                        <a href="{{ url('/users/home-page') }}"><img src="{{ URL::asset('assets/images/png/3.png') }}"
                                alt="img" class="text-center supplier-logo"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-80 page-content">
            <div class="page-single-content">
                <div class="card-body p-6">
                    <div class="row">

                        <div class="col-md-8 mx-auto d-block">
                            <div class="">
                                <h1 class="mb-2">Forgot Password</h1>
                                <p class="text-muted">Please enter your registered email we send a link to reset your
                                    password </p>

                                <form action="{{ url('user-generate-forgot-password-link') }}" method="POST">
                                    @csrf

                                    @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if (Session::get('fail'))
                                        <div class="alert alert-danger">
                                            {{ Session::get('fail') }}
                                        </div>
                                    @endif

                                    <div class="input-group mb-4">
                                        <span class="input-group-addon"><svg class="svg-icon"
                                                xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                                                width="24">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path d="M20 8l-8 5-8-5v10h16zm0-2H4l8 4.99z" opacity=".3" />
                                                <path
                                                    d="M4 20h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM20 6l-8 4.99L4 6h16zM4 8l8 5 8-5v10H4V8z" />
                                            </svg></span>
                                        <input type="emai" name="email" class="form-control"
                                            value="{{ old('email') }}" placeholder="Enter Email">
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-lg btn-primary btn-block px-4"
                                                onclick="confirmSubmission(this)">
                                                <i class="fe fe-check"></i> Send
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="pt-4">
                                <div class="font-weight-normal fs-16">Forget it <a class="btn-link font-weight-normal"
                                        href="{{ url('users/login') }}">Send me back</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                const button = document.querySelector("button[type='button']");
                confirmSubmission(button);
            }
        });

        function confirmSubmission(button) {
            const emailInput = document.querySelector("input[name='email']");


            if (!emailInput.value.trim()) {

                $('#student_username').removeClass('is-invalid').removeClass('is-valid');

                Swal.fire({
                    icon: 'error',
                    title: 'Required Field',
                    text: 'Please enter your email address.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to proceed with the submission?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.disabled = true;
                    button.innerHTML = '<i class="fe fe-loader"></i> Sending...';
                    document.querySelector("form").submit();
                }
            });
        }
    </script>
@endsection
