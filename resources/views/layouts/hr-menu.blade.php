<!-- Horizontal-menu -->
<div class="horizontal-main hor-menu clearfix">
    <div class="horizontal-mainwrapper container clearfix">

        <!-- Add Font Awesome CDN link in your <head> -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

        <nav class="horizontalMenu clearfix">
            <ul class="horizontalMenu-list">

                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <i class="fas fa-file-alt hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Dashboard <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="#">Phone Tracking </a>
                        </li>
                        <li><a href="#">Active Trackers</a></li>
                    </ul>
                </li>


                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <i class="fas fa-chalkboard-teacher hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Courses & Lessons <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ url('/courses/add-course') }}">Add Course</a></li>
                        <li><a href="{{ url('/courses/all-courses') }}">All Courses</a></li>
                        <li><a href="{{ url('/courses/add-course-module') }}">Course Modules</a></li>
                        <li><a href="{{ url('/quiz/all-quizze-and-assignments') }}">Quiz & Assignments</a></li>
                        <li><a href="{{ url('/code-editor/programming') }}">Interractive Code Editors</a></li>
                        <li><a href="{{ url('/certificates/all-preview') }}">certificates & Badges</a></li>

                    </ul>
                </li>

                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <i class="fas fa-users hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Users <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ url('/users/users-register') }}">Register new User</a></li>
                        <li><a href="{{ url('/users/users-information') }}">View users information</a></li>
                    </ul>
                </li>

                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <i class="fas fa-chart-bar hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Contact Us <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ url('/courses/contact-us') }}">Messages</a></li>
                    </ul>
                </li>

                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <i class="fas fa-sliders-h hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Settings <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ url('master-data/master-code-list') }}">Master Code</a></li>
                        <li><a href="{{ url('master-data/master-code-to-data') }}">Master Data</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!--Nav end -->
    </div>
</div>
<!-- Horizontal-menu end -->
