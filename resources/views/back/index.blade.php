@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-o9b12nEp6qOBHnpd3b05NUOBtJ9osd/Jfnvs59GpTcf6bd3NUGw+XtfPpCUVHsWqvyd2uuOVxOwXaVRoO2s2KQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

           <!-- start page title -->
            <!-- <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">BulkSMS</h4> -->

                         <!-- class="mb-0 font-size-18">Command Central</h4>-->
                        <!-- <p><span style="color:orange;font-size:16px;margin-right:10px" class="blink">Campaign Status:</span>5 Out of 10 uploaded contacts pending send. Your daily send message limit is 5. <a href="#">Update Limit Now</a> </p>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Command Centralll</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div> -->
            <!-- end page title -->

            <!-- <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="media">
                                        <div class="mr-3">
                                            <img src="{{ asset('back/assets/images/user.png') }}" alt=""
                                                 class="avatar-md rounded-circle img-thumbnail">
                                        </div>
                                        <div class="media-body align-self-center">
                                            <div class="text-muted">
                                                <p class="mb-2">Welcome</p>
                                                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 align-self-center">
                                    <div class="text-lg-center mt-4 mt-lg-0">
                                        <div class="row">
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Sent
                                                        (<small>lifetime</small>)</p>
                                                    <h5 class="mb-0">{{ $total_sent_lifetime }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Received (<small>lifetime</small>)
                                                    </p>
                                                    <h5 class="mb-0">{{ $total_received_lifetime }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 align-self-center">
                                    <div class="text-lg-center mt-4 mt-lg-0">
                                        <div class="row">
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Cost
                                                        (<small>lifetime</small>)</p>
                                                    <h5 class="mb-0">
                                                        ${{ ($total_sent_lifetime+$total_received_lifetime)*$settings->sms_rate }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        <!-- </div>
                    </div>
                </div>
            </div>  -->
        -->
            <!-- end row -->
            <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    @include('back.pages.partials.messages')
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                          Goals Data
                          @if(auth()->user()->can('administrator'))
                          <a href="{{route('admin.create.goals')}}"class="btn btn-outline-primary btn-sm float-right" title="New" ><i class="fas fa-plus-circle"></i></a>
                          @endif
                        </div>
                        <div class="card-body mt-5">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Monthly Goal</th>
                                    <th scope="col">Today</th>
                                    <th scope="col">Past 7 days</th>
                                    <th scope="col">Past 30 days</th>
                                    <th scope="col">Past 90 days</th>
                                    <th scope="col">Past Year</th>
                                    <th scope="col">Life time</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="col">People Reached</th>
                                        <td>{{ $goalValue??'0'}}</td>
                                        <td>{{ $messages_sent_today_goals??'0' }}</td>
                                        <td>{{ $messages_sent_seven_days_goals??'0' }}</td>
                                        <td>{{ $messages_sent_month_days_goals??'0' }}</td>
                                        <td>{{ $messages_sent_ninety_days_goals??'0' }}</td>
                                        <td>{{ $messages_sent_year_goals??'0' }}</td>
                                        <td>{{ $total_sent_lifetime??'0' }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Lead</th>
                                        <td>{{$goal_lead??'0'}}</td>
                                        <td>{{$messages_received_today??'0'}}</td>
                                        <td>{{$messages_received_seven_days_goals??'0'}} </td>
                                        <td>{{$messages_received_month_days_goals??'0'}}</td>
                                        <td>{{$messages_received_ninety_days_goals??'0'}}</td>
                                        <td>{{$messages_received_year_goals??'0'}}</td>
                                        <td>{{$total_received_lifetime??'0'}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Phone Apointment</th>
                                        <td>{{$goal_appointment??'0'}}</td>
                                        <td>{{$appointment_todays??'0'}}</td>
                                        <td>{{$appointment_seven_day??'0'}}</td>
                                        <td>{{$appointment_month??'0'}}</td>
                                        <td>{{$appointment_ninety_day??'0'}}</td>
                                        <td>{{$appointment_year??'0'}}</td>
                                        <td>{{$appointment_lifetime??'0'}}</td>

                                    </tr>
                                    <tr>
                                        <th scope="col">Contracts Out</th>
                                        <td>{{ $contacts_out??'0' }}</td>
                                        <td>{{ $contracts_out_todays??'0' }}</td>
                                        <td>{{ $contracts_out_seven_day??'0' }}</td>
                                        <td>{{ $contracts_out_month??'0' }}</td>
                                        <td>{{ $contracts_out_ninety_day??'0' }}</td>
                                        <td>{{ $contracts_out_year??'0' }}</td>
                                        <td>{{ $contracts_out_lifetime??'0' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Contracts Signed</th>
                                        <td>{{ $contacts_signed??'0' }}</td>
                                        <td>{{ $contracts_signed_todays ??'0'}}</td>
                                        <td>{{ $contracts_signed_seven_day??'0' }}</td>
                                        <td>{{ $contracts_signed_month??'0' }}</td>
                                        <td>{{ $contracts_signed_ninety_day??'0' }}</td>
                                        <td>{{ $contracts_signed_year??'0' }}</td>
                                        <td>{{ $contracts_signed_lifetime??'0' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Deals Closed</th>
                                        <td>{{ $deal_closed??'0' }}</td>
                                        <td>{{ $deals_todays??'0' }}</td>
                                        <td>{{ $deals_seven_day??'0' }}</td>
                                        <td>{{ $deals_month??'0' }}</td>
                                        <td>{{ $deals_ninety_day??'0' }}</td>
                                        <td>{{ $deals_year??'0' }}</td>
                                        <td>{{ $deals_lifetime??'0' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Money Expected</th>
                                        <td>{{ $money_expected??'0' }}</td>
                                        <td>{{ @$expected_money_todays }}</td>
                                        <td>{{ @$expected_money_seven_day }}</td>
                                        <td>{{ @$expected_money_month }}</td>
                                        <td>{{ @$expected_money_ninety_day }}</td>
                                        <td>{{ @$expected_money_year }}</td>
                                        <td>{{ @$expected_money_lifetime }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <th scope="col">Money Collected</th>
                                        <td>{{ number_format($money_collected, 2) }}</td>
                                        <td>{{ number_format($money_collected_todays, 2) }}</td>
                                        <td>{{ number_format($money_collected_seven_day, 2) }}</td>
                                        <td>{{ number_format($money_collected_month, 2) }}</td>
                                        <td>{{ number_format($money_collected_ninety_day, 2) }}</td>
                                        <td>{{ number_format($money_collected_year, 2) }}</td>
                                        <td>{{ number_format($money_collected_lifetime, 2) }}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
            <!-- <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt-dots"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">People to Reach (Goals)</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>{{ $goalValue }}</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt-dots"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">People Reached (Today)</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>{{ $messages_sent_today_goals }}</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt-dots"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">People Reached (In 7 Days)</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>{{ $messages_sent_seven_days_goals }}</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt-dots"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">People Reached (In 30 Days)</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>{{ $messages_sent_month_days_goals }}</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt-dots"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">People Reached (In 90 Days)</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>{{ $messages_sent_ninety_days_goals }}</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt-dots"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">People Reached (Lifetime)</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>{{ $total_sent_lifetime }}</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt-dots"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Received Today</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>{{ $messages_sent_today }}</h4>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Sent Today</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>{{ $messages_sent_today }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bxs-dollar-circle"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Cost Today</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>
                                            ${{ ($messages_sent_today+$messages_received_today)*$settings->sms_rate }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->


            <!-- <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt-dots"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Received Today</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        {{--                                        <h4>{{ $messages_received }}</h4>--}}

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Sent Today</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        {{--                                        <h4>{{ $messages_sent }}</h4>--}}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bxs-dollar-circle"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Cost Today</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>$51.04</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->


            <!-- <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt-dots"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Received Today</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        {{--                                        <h4>{{ $messages_received }}</h4>--}}

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bx-message-alt"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Sent Today</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        {{--                                        <h4>{{ $messages_sent }}</h4>--}}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs mr-3">
                                                        <span
                                                            class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                            <i class="bx bxs-dollar-circle"></i>
                                                        </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Cost Today</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>$51.04</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            {{--
                        <div class="card">
                            <div class="card-header bg-soft-dark">
                                Latest Replies
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="container">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Order ID</th>
                                                    <th scope="col">User Name</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr>
                                                    <th>1</th>
                                                    <th>1</th>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>$1</td>
                                                    <td>
                                                        <a class="btn btn-outline-primary btn-sm text-primary" href="#" title="View1"><i class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
            --}}
        </div> <!-- container-fluid -->
    </div>
@endsection
@section('scripts')

<script>

    function blink_text() {
    $('.blink').fadeOut(500);
    $('.blink').fadeIn(500);
}
setInterval(blink_text, 1000);
</script>
@endsection
