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
                        <h4 class="mb-0 font-size-18">User Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item">User Management</li>
                                <li class="breadcrumb-item active">Users</li>
                            </ol>
                        </div>
                    </div>
                    <?php echo $__env->make('back.pages.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Users
                            <?php if(auth()->user()->can('administrator') || auth()->user()->can('user_create')): ?>
                            <a href="<?php echo e(route('admin.user.create')); ?>" class="btn btn-outline-primary btn-sm float-right" title="New" ><i class="fas fa-plus-circle"></i></a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><?php echo e($user->email); ?></td>
                                    <td>
                                        <?php $__currentLoopData = $user->roles()->pluck('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-info"><?php echo e($role); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td>
                                        <?php if(auth()->user()->can('administrator') || auth()->user()->can('user_edit')): ?>
                                        <a href="<?php echo e(route('admin.user.edit', $user->id)); ?>" class="btn btn-outline-primary btn-sm" title="Edit  User" ><i class="fas fa-edit"></i></a> -
                                        <?php endif; ?>
                                        <?php if(auth()->user()->can('administrator') || auth()->user()->can('user_delete')): ?>
                                        <a href="<?php echo e(route('admin.user.destroy', $user->id)); ?>" class="btn btn-outline-danger btn-sm"
                                        title="Remove" onclick="event.preventDefault(); confirmDelete(<?php echo e($user->id); ?>);">
                                        <i class="fas fa-times-circle"></i>
                                        </a>
                                        <form id="delete-form-<?php echo e($user->id); ?>" action="<?php echo e(route('admin.user.destroy', $user->id)); ?>" method="POST" style="display: none;">
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
        function confirmDelete(roleId) {
        if (confirm('Are you sure you want to delete this record?')) {
            document.getElementById('delete-form-' + roleId).submit();
        }
    }
</script>
<script >

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/userlist/index.blade.php ENDPATH**/ ?>