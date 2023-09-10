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
                        <h4 class="mb-0 font-size-18">Permissions Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item">Permissions Management</li>
                                <li class="breadcrumb-item active">Permissions</li>
                            </ol>
                        </div>
                    </div>
                    <?php echo $__env->make('back.pages.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Permissions
                            <?php if(auth()->user()->can('administrator') || auth()->user()->can('permissions_create')): ?>
                            <a href="<?php echo e(route('admin.permissions.create')); ?>" class="btn btn-outline-primary btn-sm float-right" title="New" ><i class="fas fa-plus-circle"></i></a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Permissions</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                         <td><?php echo e($loop->index+1); ?></td>
                                         <td><?php echo e($permission->name); ?></td>

                                         <td>
                                            <?php if(auth()->user()->can('administrator') || auth()->user()->can('permissions_edit')): ?>
                                             <a href="<?php echo e(route('admin.permissions.edit', $permission->id)); ?>" class="btn btn-outline-primary btn-sm" title="Edit  Permission" ><i class="fas fa-edit"></i></a> -
                                            <?php endif; ?>

                                             <?php if(auth()->user()->can('administrator') || auth()->user()->can('permissions_delete')): ?>
                                             <a href="<?php echo e(route('admin.permissions.destroy', $permission->id)); ?>" class="btn btn-outline-danger btn-sm"
                                                title="Remove" onclick="event.preventDefault(); confirmDelete(<?php echo e($permission->id); ?>);">
                                                <i class="fas fa-times-circle"></i>
                                                </a>
                                                <form id="delete-form-<?php echo e($permission->id); ?>" action="<?php echo e(route('admin.permissions.destroy', $permission->id)); ?>" method="POST" style="display: none;">
                                                    <?php echo csrf_field(); ?>
                                                </form>
                                                <?php endif; ?>
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

    <?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script >
    $(document).ready(function() {
        $('#datatable').DataTable();
    } );
</script>
<script >
function confirmDelete(roleId) {
    if (confirm('Are you sure you want to delete this record?')) {
        document.getElementById('delete-form-' + roleId).submit();
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/permissions/index.blade.php ENDPATH**/ ?>