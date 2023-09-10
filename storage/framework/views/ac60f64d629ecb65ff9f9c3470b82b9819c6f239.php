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
                                            <li class="breadcrumb-item active"><?php echo e($group->name); ?></li>
                                            <li class="breadcrumb-item active">Numbers</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        All Numbers
                                        <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal" data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                            <tr>
                                                
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Street</th>
                                                <th scope="col">City</th>
                                                <th scope="col">State</th>
                                                <th scope="col">Zip</th>
                                                <th scope="col">Numbers</th>
                                                <th scope="col">Email</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $group->contacts()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                
                                                <td><a href="<?php echo e(route('admin.contact.detail',$contact->id)); ?>"><?php echo e($contact->name); ?></a></td>
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
                                                <!-- <td>
                                                    <a id="button-call" href="javascript:void(0)" phone-number="<?php echo e($contact->number); ?>">
                                                        <i class="fas fa-phone whatsapp-icon"></i>
                                                    </a>
                                                    <button id="button-hangup-outgoing" class='d-none fas fa-phone whatsapp-icon hangupicon'></button>
                                                </td> -->
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
                    
    
   



        <div class="modal fade" id="newModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?php echo e(route('admin.contactlist.store')); ?>" method="POST" enctype="multipart/form-data" />

                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>
                        <input type="hidden"  class="form-control" placeholder="Days" value="<?php echo e($id); ?>" name="group_id">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter First Name" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" required>
                        </div>
                        <div class="form-group">
                            <label>Street</label>
                            <input type="text" class="form-control" name="street" placeholder="Enter Street" required>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" name="city" placeholder="Enter City" required>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" name="state" placeholder="Enter State" required>
                        </div>
                        <div class="form-group">
                            <label>Zip</label>
                            <input type="text" class="form-control" name="zip" placeholder="Enter Zip code" required>
                        </div>
                        <div class="form-group">
                            <label>Phone 1</label>
                            <input type="text" class="form-control" name="number" placeholder="Enter Phone" required>
                        </div>
                        <div class="form-group">
                            <label>Phone 2</label>
                            <input type="text" class="form-control" name="number2" placeholder="Enter Phone" required>
                        </div>
                        <div class="form-group">
                            <label>Email 1</label>
                            <input type="text" class="form-control" name="email1" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label>Email 2</label>
                            <input type="text" class="form-control" name="email2" placeholder="Enter email" required>
                        </div>
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Call Initiated Successfully Modal -->
    <div class="modal fade" id="initiate-call" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content mt-2">
                <div class="modal-body">
                    <p class="calling-response" style="text-align: center;color: green; font-size: 16px;" aria-hidden="true"></p>
                </div>
                
                </div>
            </div>
    </div>
                <?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script src="<?php echo e(asset('uploads/sweetalert2.all.min.js')); ?>"></script>


    <script >
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
    </script>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/group/details.blade.php ENDPATH**/ ?>