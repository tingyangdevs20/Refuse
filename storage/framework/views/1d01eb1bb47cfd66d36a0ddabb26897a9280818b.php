<?php $__env->startSection('content'); ?>
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
                                <li class="breadcrumb-item"><a href="#">Command Central</a></li>
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
                                            <img src="<?php echo e(asset('back/assets/images/user.png')); ?>" alt=""
                                                 class="avatar-md rounded-circle img-thumbnail">
                                        </div>
                                        <div class="media-body align-self-center">
                                            <div class="text-muted">
                                                <p class="mb-2">Welcome</p>
                                                <h5 class="mb-1"><?php echo e(Auth::user()->name); ?></h5>
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
                                                    <h5 class="mb-0"><?php echo e($total_sent_lifetime); ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Received (<small>lifetime</small>)
                                                    </p>
                                                    <h5 class="mb-0"><?php echo e($total_received_lifetime); ?></h5>
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
                                                        $<?php echo e(($total_sent_lifetime+$total_received_lifetime)*$settings->sms_rate); ?></h5>
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
                                        <h4><?php echo e($goalValue); ?></h4>

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
                                        <h4><?php echo e($messages_sent_today_goals); ?></h4>

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
                                        <h4><?php echo e($messages_sent_seven_days_goals); ?></h4>

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
                                        <h4><?php echo e($messages_sent_month_days_goals); ?></h4>

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
                                        <h4><?php echo e($messages_sent_ninety_days_goals); ?></h4>

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
                                        <h4><?php echo e($total_sent_lifetime); ?></h4>

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
                                        <h4><?php echo e($messages_sent_today); ?></h4>

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
                                        <h4><?php echo e($messages_sent_today); ?></h4>
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
                                            $<?php echo e(($messages_sent_today+$messages_received_today)*$settings->sms_rate); ?></h4>
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
            
        </div> <!-- container-fluid -->
    </div>
<?php $__env->stopSection(); ?>
<script>
    function blink_text() {
    $('.blink').fadeOut(500);
    $('.blink').fadeIn(500);
}
setInterval(blink_text, 1000);
</script>
<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/index.blade.php ENDPATH**/ ?>