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
                        <h4 class="mb-0 font-size-18">Market Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item">Market Management</li>
                                <li class="breadcrumb-item active">Markets</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Markets
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
                                    data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                            <button class="btn btn-outline-primary btn-sm float-right" title="helpModal" data-toggle="modal"
                                data-target="#helpModal">How to use</button> 
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Associated Numbers</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $markets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $market): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($sr++); ?></td>
                                        <td><?php echo e($market->name); ?></td>
                                        <?php if( $market->numbers()->get()->isEmpty()): ?>
                                            <td>None</td>
                                        <?php else: ?>
                                            <td>
                                                <?php $__currentLoopData = $market->numbers()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $number): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($market->numbers()->get()->count()==1?$number->number:$number->number.", "); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                        <?php endif; ?>
                                        <td>
                                            <button class="btn btn-outline-primary btn-sm"
                                                    title="Edit <?php echo e($market->name); ?>" data-name="<?php echo e($market->name); ?>"
                                                    data-id=<?php echo e($market->id); ?> data-toggle="modal"
                                                    data-target="#editModal"><i class="fas fa-edit"></i></button>
                                            -
                                            <button class="btn btn-outline-danger btn-sm"
                                                    title="Remove <?php echo e($market->name); ?>" data-id="<?php echo e($market->id); ?>"
                                                    data-toggle="modal" data-target="#deleteModal"><i
                                                    class="fas fa-times-circle"></i></button>
                                        </td>
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

    
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">How to Use</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
     
      <div class="modal-body">
            
        <div style="position:relative;height:0;width:100%;padding-bottom:65.5%">
         <iframe src="<?php echo e(helpvideolink()->links); ?>" frameBorder="0" style="position:absolute;width:100%;height:100%;border-radius:6px;left:0;top:0" allowfullscreen="" allow="autoplay">
         </iframe>
        </div>
        <form action="<?php echo e(route('admin.helpvideo.updates',helpvideolink()->id)); ?>" method="post"
                                  enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
            <div class="form-group">
                <label>Video Url</label>
                <input type="url" class="form-control" placeholder="Enter link" name="video_url" value="<?php echo e(helpvideolink()->links); ?>" id="video_url" >
            </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
    


    
    
    
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Market</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.market.store')); ?>" method="POST">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Market Name"
                                   required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Market</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.market.update','test')); ?>" method="post" id="editForm">
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="hidden" id="id" name="id" value="">
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Market</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.market.destroy','test')); ?>" method="post" id="editForm">
                    <?php echo method_field('DELETE'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="modal-body">
                            <p class="text-center">
                                Are you sure you want to delete this?
                            </p>
                            <input type="hidden" id="id" name="id" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
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
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);// Button that triggered the modal
            var name = button.data('name');
            var id = button.data('id');

            var modal = $(this);

            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #id').val(id);

        });
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/market/index.blade.php ENDPATH**/ ?>