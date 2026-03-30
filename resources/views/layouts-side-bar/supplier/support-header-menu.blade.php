<div class="col-md-12 col-lg-4 col-xl-3">
    <div class="card">
        <div class="list-group list-group-transparent mb-0 mail-inbox pb-3">
            <div class="mt-4 mb-4 ml-4 mr-4 text-center">

                <button type="button" class="btn btn-primary btn-lg btn-block" data-bs-toggle="modal"
                    data-bs-target="#composeModal">
                    New request
                </button>
            </div>
            <a href="{{ url('support-team/support-dashboard') }}"
                class="list-group-item list-group-item-action d-flex align-items-center active">
                <svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                    width="24">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path d="M20 8l-8 5-8-5v10h16zm0-2H4l8 4.99z" opacity=".3" />
                    <path
                        d="M4 20h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM20 6l-8 4.99L4 6h16zM4 8l8 5 8-5v10H4V8z" />
                </svg> Requests Dashboard <span class="ml-auto badge badge-success">{{ $allIssues }}</span>
            </a>
        </div>
    </div>
</div>