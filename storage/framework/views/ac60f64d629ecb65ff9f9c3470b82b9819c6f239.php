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
                         <form id="contact_form" action="<?php echo e(route('admin.mailcontactlist')); ?>" method="post"   class="col-lg-12" />  
                         <!-- oldmailurl working -->
                        <!-- <form id="contact_form" action="<?php echo e(url('api/contactmail')); ?>" method="post" class="col-lg-12" > -->
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>
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
                                    <label> All Numbers </label>
                                    <div class="col-md-3">
                                        <select class="form-control" style="float: left;" id="contracttype" name="contracttype">
                                        <option value="">Select Contract</option>
                                        <?php $__currentLoopData = $contractres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value->id); ?>"><?php echo e($value->type_contract); ?></option>
                                        
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <span id="errorcontract" style="color:red"></span>
                                    </div>
                                        <a href="<?php echo e(route('admin.contractview')); ?>"><button type="button" class="btn btn-primary" style="float: right;">Contract View</button> </a>

                                      <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal" data-target="#newModal"><i class="fas fa-plus-circle"></i></button>


                                        <button type="submit" class="btn btn-success" name="bulk_delete_submit" class="btn btn-danger btn-fw" style="float: right;">Send Mail</button>


                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                            <tr>
                                                <th>All<input type="checkbox" id="select_all" value=""/></th> 

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
                                            <?php $__currentLoopData = $group->contacts()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo e($contact->id); ?>"/></td>
                                                 <td><?php echo e($sr++); ?></td>

                                                
                                                
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
                          </form>
                        </div>
                        <!-- end page title -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
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
                <?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script >
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );

        $(document).ready(function(){
            $("#select_all").click(function(){
                    if(this.checked){
                        $('.checkbox').each(function(){
                            $(".checkbox").prop('checked', true);
                        })
                    }else{
                        $('.checkbox').each(function(){
                            $(".checkbox").prop('checked', false);
                        })
                    }
                });
            });


            $(document).ready(function(){
                $('#contact_form').on('submit', function(e){
                    e.preventDefault();
                    var contracttype = $('#contracttype').val();
                    if(contracttype==''){
                        alert("Select Contract first!");
                        $('select[name^="contracttype"]').eq(1).focus();
                        
                        $('#errorcontract').html("Select Contract first*");
                        return false;
                    }
                    if($(".checkbox")[0].checked==false){
                        alert("Select atleast one contact!");
                        $('.checkbox').eq(1).focus();
                        return false;
                    }
                
                    this.submit();
                });
});
    </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/group/details.blade.php ENDPATH**/ ?>