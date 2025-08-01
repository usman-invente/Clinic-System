@extends('layouts.app')
@section('content')  

    <div class="col-md-12 main">           
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active">Dashboard</li>
            </ol>
        </div>
        <!--/.row-->
       
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
            <h2 class="page-header" style="margin: 0;">Dashboard</h2>
            <div class="date-range-filter" style="display: flex; align-items: center;">
                <input type="date" class="ant-range-picker-input" placeholder="Start date" style="margin-right: 0.5rem;">
                <span class="ant-range-separator" style="margin: 0 0.5rem;">—</span>
                <input type="date" class="ant-range-picker-input" placeholder="End date" style="margin-right: 0.5rem;">
                <button class="ant-range-picker-btn">Filter</button>
            </div>
        </div>
         @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-orange panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-2 col-lg-3 widget-left">
                        <i class="fas fa-notes-medical fa-3x"></i>
                        </div>
                        <div class="col-sm-10 col-lg-9 widget-right">
                            <div class="large">{{$pending['appointment']}}</div>
                            <div class="text-muted">Pending Appointment</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-blue panel-widget ">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                        <i class="fas fa-users fa-3x"></i>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$patients->count()}}</div>
                            <div class="text-muted">Total Patient</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-teal panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                        <i class="fas fa-vial fa-3x"></i>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$total_test}}</div>
                            <div class="text-muted">Total Test</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-red panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                        <i class="fas fa-user-md fa-3x"></i>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$total_doctor}}</div>
                            <div class="text-muted">Total Doctor</div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.row-->
        <!-- End of summary cards row -->
        <!-- Date Range Filter (Ant Design style) -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">Appointments Over Time</div>
                    <div class="card-body">
                        <canvas id="appointmentsChart" height="180"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">Revenue (Monthly)</div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="180"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">Patient Types</div>
                    <div class="card-body">
                        <canvas id="patientsPieChart" height="180"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">Doctor Activity</div>
                    <div class="card-body">
                        <canvas id="doctorBarChart" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            
            <!-- Appointment for today -->
             <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Today's Appointment</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table1" class="table" cellspacing="0" width="100%">
                                <thead>
                                   <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Description</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;?>
                                    @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$appointment->name}}</td>
                                        <td>{{$appointment->patient->first_name}} {{$appointment->patient->last_name}}</td>
                                        <td>{{$appointment->doctor->employee->first_name}} {{$appointment->doctor->employee->middle_name}} {{$appointment->doctor->employee->last_name}}</td>
                                        <td>{{$appointment->description}}</td>
                                        <td>{{$appointment->time}}</td>
                                        <td>
                                         @if($appointment->status)
                                        <a class="btn-sm btn-success" href="{{ route('appointment.edit',$appointment->id) }}"><span class=" glyphicon glyphicon-ok"></span> Complete</a>    
                                        @else
                                        <a class="btn-sm btn-warning" href="{{ route('appointment.edit',$appointment->id) }}"><span class=" glyphicon glyphicon-refresh"> </span> Pending</a>
                                        @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>                 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Appointmet table ends -->
            <div class="col-lg-12">
            <!-- Today invoice collection -->
                <div class="card">
                    <div class="card-header">Today's Collection</div>
                    <div class="card-body">
                        <table id="table" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                               <tr>
                               <th>#</th>
                                <th>Invoice No</th>
                                <th>Payment</th>
                                <th>Sub Total</th>
                                <th>Discount</th>
                                <th>Tax</th>
                                <th>Total Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1;?>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$invoice->invoice_no}}</td>
                                    <td>{{$invoice->payment_type}}</td>
                                    <td>${{number_format($invoice->sub_total, 2)}}</td>
                                    <td>${{$invoice->discount}}</td>
                                    <td>${{number_format($invoice->tax_amount, 2)}}</td>
                                    <td>${{number_format($invoice->total_amount)}}</td>
                                </tr>@endforeach
                            </tbody>
                                 <tr>
                                    <th></th>
                                    <th>Total:</th>
                                    <th></th>
                                    <th>${{number_format($total['sub_total'], 2)}}</th>
                                    <th>${{$total['discount']}}</th>
                                    <th>${{number_format($total['tax_amount'], 2)}}</th>
                                    <th>${{number_format($total['total_amount'])}}</th>
                                </tr>                    
                        </table>
                    </div>
                </div>
            </div>
            <!-- Today collection ends -->
            <!-- opd table -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Today's OPD</div>
                    <div class="card-body">
                         <table id="example" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                               <tr>
                                <th>#</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Register At</th>
                                <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($opds as $opd)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$opd->invoice->patient->first_name}} {{$opd->invoice->patient->last_name}}</td>
                                    <td>{{$opd->doctor->employee->first_name}} {{$opd->doctor->employee->middle_name}} {{$opd->doctor->employee->last_name}}</td>
                                    <td>{{$opd->created_at}}</td>
                                    @if($opd->status == 1)
                                    <td><span class="btn-sm btn-success glyphicon glyphicon-ok"> Complete</span></td>
                                    @else
                                    <td><a class="btn-sm btn-warining" href="{{ route('doctor.edit',$opd->id) }}"><span class=" glyphicon glyphicon-refresh"> Pending</span></a> </span></td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>                 
                        </table>
                    </div>
                </div>
            </div>

        </div><!--/.row-->
        </div>
        <!-- End of summary cards row -->

        <!-- Move chart containers here, below the cards -->
       
        <!-- <div class="row">
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>New Orders</h4>
                        <div class="easypiechart" id="easypiechart-blue" data-percent="92" ><span class="percent">92%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Comments</h4>
                        <div class="easypiechart" id="easypiechart-orange" data-percent="65" ><span class="percent">65%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>New Users</h4>
                        <div class="easypiechart" id="easypiechart-teal" data-percent="56" ><span class="percent">56%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Visitors</h4>
                        <div class="easypiechart" id="easypiechart-red" data-percent="27" ><span class="percent">27%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!--/.row-->
                                
       <!--  <div class="row">
            <div class="col-md-8">
            
                <div class="panel panel-default chat">
                    <div class="panel-heading" id="accordion"><svg class="glyph stroked two-messages"><use xlink:href="#stroked-two-messages"></use></svg> Chat</div>
                    <div class="panel-body">
                        <ul>
                            <li class="left clearfix">
                                <span class="chat-img pull-left">
                                    <img src="http://placehold.it/80/30a5ff/fff" alt="User Avatar" class="img-circle" />
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font">John Doe</strong> <small class="text-muted">32 mins ago</small>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ante turpis, rutrum ut ullamcorper sed, dapibus ac nunc. Vivamus luctus convallis mauris, eu gravida tortor aliquam ultricies. 
                                    </p>
                                </div>
                            </li>
                            <li class="right clearfix">
                                <span class="chat-img pull-right">
                                    <img src="http://placehold.it/80/dde0e6/5f6468" alt="User Avatar" class="img-circle" />
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="pull-left primary-font">Jane Doe</strong> <small class="text-muted">6 mins ago</small>
                                    </div>
                                    <p>
                                        Mauris dignissim porta enim, sed commodo sem blandit non. Ut scelerisque sapien eu mauris faucibus ultrices. Nulla ac odio nisl. Proin est metus, interdum scelerisque quam eu, eleifend pretium nunc. Suspendisse finibus auctor lectus, eu interdum sapien.
                                    </p>
                                </div>
                            </li>
                            <li class="left clearfix">
                                <span class="chat-img pull-left">
                                    <img src="http://placehold.it/80/30a5ff/fff" alt="User Avatar" class="img-circle" />
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font">John Doe</strong> <small class="text-muted">32 mins ago</small>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ante turpis, rutrum ut ullamcorper sed, dapibus ac nunc. Vivamus luctus convallis mauris, eu gravida tortor aliquam ultricies. 
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="panel-footer">
                        <div class="input-group">
                            <input id="btn-input" type="text" class="form-control input-md" placeholder="Type your message here..." />
                            <span class="input-group-btn">
                                <button class="btn btn-success btn-md" id="btn-chat">Send</button>
                            </span>
                        </div>
                    </div>
                </div>
                 -->
          <!--/.col-->
            
           <!--  <div class="col-md-4">
            
                <div class="panel panel-blue">
                    <div class="panel-heading dark-overlay"><svg class="glyph stroked clipboard-with-paper"><use xlink:href="#stroked-clipboard-with-paper"></use></svg>To-do List</div>
                    <div class="panel-body">
                        <ul class="todo-list">
                        <li class="todo-list-item">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox" />
                                    <label for="checkbox">Make a plan for today</label>
                                </div>
                                <div class="pull-right action-buttons">
                                    <a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg></a>
                                    <a href="#" class="flag"><svg class="glyph stroked flag"><use xlink:href="#stroked-flag"></use></svg></a>
                                    <a href="#" class="trash"><svg class="glyph stroked trash"><use xlink:href="#stroked-trash"></use></svg></a>
                                </div>
                            </li>
                            <li class="todo-list-item">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox" />
                                    <label for="checkbox">Update Basecamp</label>
                                </div>
                                <div class="pull-right action-buttons">
                                    <a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg></a>
                                    <a href="#" class="flag"><svg class="glyph stroked flag"><use xlink:href="#stroked-flag"></use></svg></a>
                                    <a href="#" class="trash"><svg class="glyph stroked trash"><use xlink:href="#stroked-trash"></use></svg></a>
                                </div>
                            </li>
                            <li class="todo-list-item">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox" />
                                    <label for="checkbox">Send email to Jane</label>
                                </div>
                                <div class="pull-right action-buttons">
                                    <a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg></a>
                                    <a href="#" class="flag"><svg class="glyph stroked flag"><use xlink:href="#stroked-flag"></use></svg></a>
                                    <a href="#" class="trash"><svg class="glyph stroked trash"><use xlink:href="#stroked-trash"></use></svg></a>
                                </div>
                            </li>
                            <li class="todo-list-item">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox" />
                                    <label for="checkbox">Drink coffee</label>
                                </div>
                                <div class="pull-right action-buttons">
                                    <a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg></a>
                                    <a href="#" class="flag"><svg class="glyph stroked flag"><use xlink:href="#stroked-flag"></use></svg></a>
                                    <a href="#" class="trash"><svg class="glyph stroked trash"><use xlink:href="#stroked-trash"></use></svg></a>
                                </div>
                            </li>
                            <li class="todo-list-item">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox" />
                                    <label for="checkbox">Do some work</label>
                                </div>
                                <div class="pull-right action-buttons">
                                    <a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg></a>
                                    <a href="#" class="flag"><svg class="glyph stroked flag"><use xlink:href="#stroked-flag"></use></svg></a>
                                    <a href="#" class="trash"><svg class="glyph stroked trash"><use xlink:href="#stroked-trash"></use></svg></a>
                                </div>
                            </li>
                            <li class="todo-list-item">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox" />
                                    <label for="checkbox">Tidy up workspace</label>
                                </div>
                                <div class="pull-right action-buttons">
                                    <a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg></a>
                                    <a href="#" class="flag"><svg class="glyph stroked flag"><use xlink:href="#stroked-flag"></use></svg></a>
                                    <a href="#" class="trash"><svg class="glyph stroked trash"><use xlink:href="#stroked-trash"></use></svg></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-footer">
                        <div class="input-group">
                            <input id="btn-input" type="text" class="form-control input-md" placeholder="Add new task" />
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-md" id="btn-todo">Add</button>
                            </span>
                        </div>
                    </div>
                </div> -->

    <script type="text/javascript">
        $(document).ready(function(){
            $('#table').DataTable();
            $('#table1').DataTable();

        });
    </script>
@endsection
@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Appointments Over Time (Line Chart)
    if (document.getElementById('appointmentsChart')) {
        new Chart(document.getElementById('appointmentsChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Appointments',
                    data: [120, 150, 170, 140, 180, 200, 220],
                    borderColor: '#1890ff',
                    backgroundColor: 'rgba(24,144,255,0.08)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
    // Revenue (Bar Chart)
    if (document.getElementById('revenueChart')) {
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Revenue',
                    data: [5000, 7000, 8000, 6000, 9000, 11000, 12000],
                    backgroundColor: '#52c41a',
                    borderRadius: 6
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
    // Patient Types (Pie Chart)
    if (document.getElementById('patientsPieChart')) {
        new Chart(document.getElementById('patientsPieChart'), {
            type: 'pie',
            data: {
                labels: ['New', 'Returning', 'Referral'],
                datasets: [{
                    data: [60, 30, 10],
                    backgroundColor: ['#1890ff', '#faad14', '#f5222d']
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
    // Doctor Activity (Bar Chart)
    if (document.getElementById('doctorBarChart')) {
        new Chart(document.getElementById('doctorBarChart'), {
            type: 'bar',
            data: {
                labels: ['Dr. Smith', 'Dr. Lee', 'Dr. Patel', 'Dr. Kim'],
                datasets: [{
                    label: 'Patients Seen',
                    data: [40, 55, 30, 45],
                    backgroundColor: '#722ed1',
                    borderRadius: 6
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
});
</script>
@endsection
