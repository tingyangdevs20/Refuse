<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        #hidden_div {
            display: none;
        }
    </style>
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
                                    <h4 class="mb-0 font-size-18">Single SMS</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                            <li class="breadcrumb-item">SMS</li>
                                            <li class="breadcrumb-item active">Single SMS</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        <i class="fas fa-edit"></i> Compose Message
                                    </div>
                                    <div class="card-body">


                                        <form action="<?php echo e(route('admin.single-sms.store')); ?>" method="post" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('POST'); ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="Reiepient's Number" name="receiver_number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text"><i class="fas fa-mobile text-warning"></i></label>
                                                        </div>
                                                        <select class="custom-select" required="" name="sender_number">
                                                            <option value="">Sender's Number</option>
                                                            <?php $__currentLoopData = $numbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $number): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($number->number.'|'.$number->account->account_id.'|'.$number->account->account_token); ?>"><?php echo e($number->number); ?> - <?php echo e($number->account->account_name); ?> - Available Sends: <?php echo e($number->sms_allowed - $number->sms_count); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                <input type="file" class="form-control-file" name="media_file">
                                            </div>
                                            <div class="form-group">
                                                <label>Message Type</label>
                                                <select class="custom-select" name="message_type" onchange="showDiv('hidden_div', this)" required>
                                                    <option value="0">Custom Message</option>
                                                    <option value="1">Template Message</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="hidden_div">
                                                <label>Select Template</label>
                                                <select class="custom-select" name="template" id="template-select" onchange="templateId()">
                                                    <option value="0">Select Template</option>
                                                    <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($template->id); ?>"><?php echo e($template->title); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="form-group ">
                                                <label >Message</label>
                                                <textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea>
                                                <div id='count' class="float-lg-right">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-2" <?php echo e($number->sms_allowed ==$number->sms_count?'disabled':''); ?>>Send SMS</button>
                                            </div>
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
    <script >
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
    </script>
    <script>
        function showDiv(divId, element)
        {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }
        function templateId() {
            template_id = document.getElementById("template-select").value;
           setTextareaValue(template_id)
        }
    </script>
    <script>
        function setTextareaValue(id)
        {
            if(id>0){
                axios.get('/admin/template/'+id)
                    .then(response =>
                        document.getElementById("template_text").value = response.data['body'],
                    )
                    .catch(error => console.log(error));
            }
            else{
                document.getElementById("template_text").value = '';
            }


        }
        const textarea = document.querySelector('textarea')
        const count = document.getElementById('count')
        textarea.onkeyup = (e) => {
            count.innerHTML = "Characters: "+e.target.value.length+"/160";
        };
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/sms/single/index.blade.php ENDPATH**/ ?>