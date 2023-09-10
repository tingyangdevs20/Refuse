<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Settings</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item">Settings</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog"></i> General Settings
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.settings.update',$settings)); ?>" method="post"
                                  enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="form-group">
                                    <label>Auto-Reply</label>
                                    <select class="custom-select" name="auto_reply" required>
                                        <option value="1" <?php echo e($settings->auto_reply?"selected":""); ?>>Active</option>
                                        <option value="0" <?php echo e($settings->auto_reply?"":"selected"); ?>>Not Active</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Auto Keyword Responder</label>
                                    <select class="custom-select" name="auto_respond" required>
                                        <option value="1" <?php echo e($settings->auto_responder?"selected":""); ?>>Active</option>
                                        <option value="0" <?php echo e($settings->auto_responder?"":"selected"); ?>>Not Active
                                        </option>
                                    </select>
                                </div>

                               
                                
                                 <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog"></i> Email Settings
                          
                        </div>
                          <br/>
                            
                         <div class="form-group">
                                    <label>Send From Email</label>
                                    <div class="input-group mb-2">
                                      
                                        <input type="text" class="form-control" placeholder="Send From Email"
                                               name="sender_email" id="sender_email" value="<?php echo e($settings->sender_email); ?>"  required>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label>Reply To Email</label>
                                    <div class="input-group mb-2">
                                      
                                        <input type="text" class="form-control" placeholder="Reply To Email"
                                               name="reply_email" id="reply_email" value="<?php echo e($settings->reply_email); ?>"  required>
                                    </div>
                                </div>
                                
                                   <div class="card-header bg-soft-dark ">
                            <i class="fas fa-cog"></i> Third Party APIs Settings
                          
                        </div>
                          <br/>
                            
                         <div class="form-group">
                                    <label>Send Grid API Key</label>
                                    <div class="input-group mb-2">
                                      

                                        <input type="text" class="form-control" placeholder="Enter Send Grid API Key" name="sendgrid_key" name="sendgrid_key" value="<?php echo e($settings->sendgrid_key); ?>"  required>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label>Twilio Account SID</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" placeholder="Enter Twilio Account SID" name="twilio_api_key" id="twilio_api_key" value="<?php echo e($settings->twilio_api_key); ?>"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Twilio Auth Token</label>
                                    <div class="input-group mb-2">
                                      
                                        <input type="text" class="form-control" placeholder="Enter Twilio Auth Token"
                                               name="twilio_secret" id="twilio_secret" value="<?php echo e($settings->twilio_acc_secret); ?>"  required>
                                    </div>
                                </div>
                                <div class="card-header bg-soft-dark ">
                                    <i class="fas fa-cog"></i> Slybroadcast Settings
                          
                                </div>
                          <br/>
                            
                         <div class="form-group">
                                    <label>Post Call URL</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" placeholder="Enter new key to update"
                                               name="slybroad_call_url" name="slybroad_call_url" value="<?php echo e($settings->slybroad_call_url); ?>"  required>
                                    </div>
                                </div>
                               
                                <div class="card-header bg-soft-dark ">
                                    <i class="fas fa-cog"></i> Call Forward Settings
                          
                                </div>
                          <br/>
                            
                         <div class="form-group">
                                    <label>Call Forward Number</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" placeholder="Enter new key to update"
                                               name="call_forward_number" id="call_forward_number" value="<?php echo e($settings->call_forward_number); ?>"  required>
                                    </div>
                                </div>
                               
                                <div class="card-header bg-soft-dark ">
                                    <i class="fas fa-cog"></i> Campaign Schedule Settings
                          
                                </div>
                          <br/>
                            
                         <div class="form-group">
                                    <label>Scheduled Hours</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" placeholder="Enter Hours value ex. 11 AM EST - 8 PM EST"
                                               name="schedule_hours" id="schedule_hours" value="<?php echo e($settings->schedule_hours); ?>"  required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Settings</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/settings/index.blade.php ENDPATH**/ ?>