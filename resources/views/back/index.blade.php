@extends('back.inc.master')
@section('content')
    <div class="page-content">
        <div class="container-fluid">

           <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">BulkSMS</h4>

                         <!-- class="mb-0 font-size-18">Command Central</h4>-->
                        <p><span style="color:orange;font-size:16px;margin-right:10px" class="blink">Campaign Status:</span>5 Out of 10 uploaded contacts pending send. Your daily send message limit is 5. <a href="#">Update Limit Now</a> </p>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Command Centralll</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
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
                                                <p class="mb-2">Welcomeeee</p>
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
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
            </div>

            <div class="row">
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
            </div>


            <div class="row">
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
            </div>


            <div class="row">
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
            </div>
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