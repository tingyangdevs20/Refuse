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
                                    <h4 class="mb-0 font-size-18">Group Management</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                            <li class="breadcrumb-item">Group Management</li>
                                            <li class="breadcrumb-item active">Numbers</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        All Numbers
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Street</th>
                                                <th scope="col">City</th>
                                                <th scope="col">State</th>
                                                <th scope="col">Zip</th>
                                                <th scope="col">Numbers</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Lead Category</th>
                                                <th scope="col">Mail Sent</th>
                                                <th scope="col">Contract Verified</th>
                                                <th scope="col">Message Sent</th>
                                                <th scope="col">DNC</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($sr++); ?></td>
                                                <td><?php echo e($contact->name); ?></td>
                                                <td><?php echo e($contact->last_name); ?></td>
                                                <td><?php echo e($contact->street); ?></td>
                                                <td><?php echo e($contact->city); ?></td>
                                                <td><?php echo e($contact->state); ?></td>
                                                <td><?php echo e($contact->zip); ?></td>
                                                <td>
                                                    Number1:<?php echo e($contact->number); ?><br>
                                                    Number2:<?php echo e($contact->number2); ?><br>
                                                    Number3:<?php echo e($contact->number3); ?>

                                                </td>
                                                <td>
                                                    Email1:<?php echo e($contact->email1); ?><br>
                                                    Email2:<?php echo e($contact->email2); ?>

                                                </td>
                                                <td><?php echo e($contact->getLeadCategory()); ?></td>
                                                <td><?php echo e($contact->mail_sent?"YES":"NO"); ?></td>
                                                <td><?php echo e($contact->contract_verified?"YES":"NO"); ?></td>
                                                <td><?php echo e($contact->msg_sent?"YES":"NO"); ?></td>
                                                <td><?php echo e($contact->is_dnc?"YES":"NO"); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
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
    <script >
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
    </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/group/view_all.blade.php ENDPATH**/ ?>