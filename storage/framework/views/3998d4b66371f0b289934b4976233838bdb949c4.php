<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-o9b12nEp6qOBHnpd3b05NUOBtJ9osd/Jfnvs59GpTcf6bd3NUGw+XtfPpCUVHsWqvyd2uuOVxOwXaVRoO2s2KQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                        <h4 class="mb-0 font-size-18">Data Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item">Data Management</li>
                                <li class="breadcrumb-item active">Data</li>
                            </ol>
                        </div>
                    </div>
                    <?php echo $__env->make('back.pages.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Data
                            <?php if(auth()->user()->can('administrator') || auth()->user()->can('scraping_create')): ?>
                            <a href="<?php echo e(route('admin.scraping.create')); ?>" class="btn btn-outline-primary btn-sm float-right" title="New" ><i class="fas fa-plus-circle"></i></a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Count/State</th>
                                    <th scope="col">Price Range</th>
                                    <th scope="col">Property Type</th>
                                    <th scope="col">Bedrooms</th>
                                    <th scope="col">Bathrooms</th>
                                    <th scope="col">Job Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $scrapingdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($data->country); ?> <?php echo e($data->state); ?> <?php echo e($data->city); ?> <?php echo e($data->zip_code); ?></td>
                                    <td><?php echo e($data->price_range); ?></td>
                                    <td>
                                        <?php
                                        $propertyTypes = explode(',', $data->property_type);
                                        ?>

                                        <?php $__currentLoopData = $propertyTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-info"><?php echo e(trim($property)); ?></span>
                                            <?php if (! ($loop->last)): ?>
                                                ,
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>

                                    <td><?php echo e($data->no_of_bedrooms); ?></td>
                                    <td><?php echo e($data->no_of_bathrooms); ?></td>
                                    <td><?php echo e($data->job_name); ?></td>
                                    <td>
                                        <?php if($data->status == 0): ?>
                                            <span >
                                                <i class="fas fa-spinner fa-spin text-warning"></i>  In-Process
                                            </span>
                                        <?php else: ?>
                                            <span style="border-radius: 6px; padding: 5px; background-color: transparent;">
                                                <i class="fa fa-check-circle"></i> Data Ready
                                            </span>
                                        <?php endif; ?>
                                    </td>


                                    <td>
                                        <?php if($data->file): ?>
                                            <a href="<?php echo e(asset('upload/'.$data->file)); ?>" download>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path d="M7.293 1.293a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L8 4.414V11a1 1 0 11-2 0V4.414L2.293 6.707a1 1 0 01-1.414-1.414l4-4z"/>
                                                    <path fill-rule="evenodd" d="M7 0a1 1 0 011 1v10a1 1 0 11-2 0V1a1 1 0 011-1z"/>
                                                </svg>
                                                Download
                                            </a>
                                        <?php else: ?>
                                            No File
                                        <?php endif; ?>
                                    </td>




                                    <td>
                                        <?php if(auth()->user()->can('administrator') || auth()->user()->can('scraping_edit')): ?>
                                        <a href="<?php echo e(route('admin.scraping.edit', $data->id)); ?>" class="btn btn-outline-primary btn-sm" title="Edit  User" ><i class="fas fa-edit"></i></a> -
                                        <?php endif; ?>
                                        <?php if(auth()->user()->can('administrator') || auth()->user()->can('scraping_delete')): ?>
                                        <a href="<?php echo e(route('admin.scraping.destroy', $data->id)); ?>" class="btn btn-outline-danger btn-sm"
                                        title="Remove" onclick="event.preventDefault(); confirmDelete(<?php echo e($data->id); ?>);">
                                        <i class="fas fa-times-circle"></i>
                                        </a>
                                        <form id="delete-form-<?php echo e($data->id); ?>" action="<?php echo e(route('admin.scraping.destroy', $data->id)); ?>" method="POST" style="display: none;">
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

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/secrapinglist/index.blade.php ENDPATH**/ ?>