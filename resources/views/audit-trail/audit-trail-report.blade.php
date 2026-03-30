<?php 
use App\Http\Controllers\Helper;
?>

@include('includes.header');
    <div id="contentwrapper">
        <div class="main_content">

            @include('sweetalert::alert')
            

            <div class="row">
                <div class="col-sm-12">
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h3 class="heading">
                           
                        </h3>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">

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

                                @include('includes.user_info')

                                <div class="w-box" id="w_sort05">    
                                    <div id="filter-header" class="w-box-header">
                                        Filter Audit Trail
                                        <div class="pull-right">
                                            <i class="fa fa-filter"></i>
                                        </div>
                                    </div>
                                    <div id="filter-body" class="w-box-content cnt_a mb-10">
                                        <div class="col-sm-3 col-md-4">
                                            <label for="w_name">Date</label>
                                            <div class="input-group date">
                                                <input  id="dateRange" class="form-control" type="text">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <span class="help-block">Date range ( Start date - End date)</span>
                                        </div>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                var options = {};
                                                                                                    
                                                $('#dateRange').daterangepicker({
                                                    "timePicker": true,
                                                    options,
                                                }, function(start, end, label) {
                                                console.log("New date range selected: ' + start.format('YYYY-MM-DD H:I:S') + ' to ' + end.format('YYYY-MM-DD H:I:S') + ' (predefined range: ' + label + ')");
                                                });

                                            });
                                        </script>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="w_name">Action</label>
                                                <select id="action" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($actions_list as $action)
                                                        <option value="{{$action}}">{{$action}}</option>                                                        
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="w_name">Action Performed By</label>
                                                <select id="performedBy" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $action)
                                                        @if ($action)
                                                        <option value="{{$action}}">{{$action}}</option>
                                                        @endif                                                        
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        
                                        <div class="clearfix">
                                            <button id="showAuditRecords" class="btn btn-primary pull-right btn-default" type="button"><i class="fa fa-fw fa-filter"></i> Show Records</button>
                                        </div>
                                        <script type="text/javascript">
                                            $('#filter-header').click(function(){
                                                $('#filter-body').toggle();
                                            });
                                            $('#showAuditRecords').click(function(){
                                                $(this).attr('disabled', true);

                                                errors = new Array();
                                                var action = $('#action').val();
                                                var performedBy = $('#performedBy').val();
                                                var dateRange = $('#dateRange').val();

                                                if(!performedBy && !action){
                                                    errors.push("Select Action or Action performed By");
                                                }

                                                if(errors.length){
                                                    alert(errors.join('\n'));
                                                    $(this).attr('disabled',false);
                                                }else{
                                                    var form_data = new FormData();
                                                    form_data.append('action', action);
                                                    form_data.append('performedBy', performedBy);
                                                    form_data.append('dateRange', dateRange);

                                                    $.ajax({
                                                        type: "post",
                                                        processData: false,
                                                        contentType: false,
                                                        cache: false,
                                                        data: form_data,
                                                        url: '/audit-trail/filter-audit-report',
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        },
                                                        success: function(data) {
                                                            $('#filteredRecords').html(data);//location.reload();
                                                            $('#showAuditRecords').attr('disabled',false);
                                                        },
                                                        error: function(data) {
                                                            $('body').html(data.responseText);
                                                        }
                                                    });
                                                }
                                            });
                                        </script>
                                    </div>
                                </div><br/>


                                <?php 
                                Helper::startPrint('AUDIT TRAIL REPORT');
                                ?>
                                
                                @if (count($audit))

                                <div id="filteredRecords">
                                   
                                <table id="table" border="1" cellspacing="0" style="font-size:10px;">
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
                                        
                                        @foreach ($audit as $count=>$list)
                                        <tr>
                                            <td>{{$count+1}}.</td>
                                            <td>{{Helper::date_fm($list->at_date_added)}}</td>
                                            <td>{{$list->at_action}}</td>
                                            <td>{!!$list->at_description!!}</td>
                                            <td>{{$list->at_username}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                                 
                                @else

                                <?php Helper::warning('No data to Display'); ?> 

                                @endif

                                <?php Helper::endPrint(); ?>

                                @if (count($audit))
                                {{$audit->links()}}
                                @endif
                                
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


    @include('includes.side-bar')

    @include('includes.footer')


</body>

</html>
