<!-- resources/views/back/pages/campaign/index.blade.php -->


<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Lead Campaigns</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item">Lead Campaigns </li>
                                <li class="breadcrumb-item active">Campaigns</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark">
                            All Lead Campaigns
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus-circle"></i></button>
                        </div>
                        <div class="card-body">
                            <?php if($campaigns->isEmpty()): ?>
                                <p>No campaigns available.</p>
                            <?php else: ?>
                                <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <!--<th scope="col">Type</th>-->
                                    <!--<th scope="col">Send after days</th>-->
                                    <!--<th scope="col">Send after hours</th>-->
                                    <th scope="col">Contact list</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><a href="<?php echo e(route('admin.compaignlead.list',$campaign->id)); ?>"><?php echo e($campaign->name); ?></a></td>
                                        <!--<td><?php echo e($campaign->type); ?></td>-->
                                        <!--<td><?php echo e($campaign->send_after_days); ?></td>-->
                                        <!--<td><?php echo e($campaign->send_after_hours); ?></td>-->
                                        <td><?php echo e(optional($campaign->group)->name ?? "N/A"); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.compaignlead.copy', $campaign->id)); ?>"><button data-toggle="modal" class="btn btn-outline-warning" >Copy</button></a>
                                            <button data-toggle="modal" class="btn btn-outline-primary" id="editModal" data-target="#editCampaignModal" data-name="<?php echo e($campaign->name); ?>" data-type="<?php echo e($campaign->type); ?>" data-template="<?php echo e($campaign->template_id); ?>" data-sendafterdays="<?php echo e($campaign->send_after_days); ?>" data-sendafterhours="<?php echo e($campaign->send_after_hours); ?>"data-group="<?php echo e($campaign->group_id); ?>"  data-id="<?php echo e($campaign->id); ?>">Edit</button>
                                            <form action="<?php echo e(route('admin.leadcampaign.destroy', $campaign->id)); ?>" method="POST" style="display: inline-block;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
        </div> <!-- container-fluid -->
    </div>
    <!-- Add Campaign Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Campaign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- For example, you can use Laravel Collective's Form or standard HTML form -->
                    <!-- Add the form for adding the campaign here -->
                    <form action="<?php echo e(route('admin.leadcampaign.store')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="name">Campaign Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label for="type">Campaign Type</label>-->
                        <!--    <select name="type" id="type" class="form-control" onchange="getTemplate(value)" required>-->
                        <!--        <option value="sms">SMS</option>-->
                        <!--        <option value="email">Email</option>-->
                        <!--        <option value="mms">MMS</option>-->
                        <!--        <option value="rvm">RVM</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                        <!--<div class="form-group" id="update-templates">-->
                        <!--    <label>Select Template</label>-->
                        <!--    <select class="custom-select" name="template_id" id="template-select">-->
                        <!--        <option value="0">Select Template</option>-->
                        <!--        <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->
                        <!--            <option value="<?php echo e($template->id); ?>"><?php echo e($template->title); ?></option>-->
                        <!--        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->
                        <!--    </select>-->
                        <!--</div>-->
                         <!-- Add schedule field -->
                        <!--<div class="form-group">-->
                        <!--    <label for="send_after_days">Send After Days</label>-->
                        <!--    <input type="number" name="send_after_days" id="send_after_days" class="form-control" required>-->
                        <!--</div>-->
                        
                        <!--<div class="form-group">-->
                        <!--    <label for="send_after_hours">Send After Hours</label>-->
                        <!--    <input type="number" name="send_after_hours" id="send_after_hours" class="form-control" required>-->
                        <!--</div>-->
                        <div class="form-group">
                            <label for="group_id">Select Group/Contact List</label>
                            <select name="group_id" id="group_id" class="form-control">
                                <option value="">Select Group/Contact List</option>
                                <?php if(isset($groups)): ?>
                                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($group->id); ?>"><?php echo e($group->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="active">Active Status</label>
                            <select name="active" id="active" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Campaign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Campaign Modal -->
    <div class="modal fade" id="editCampaignModal" tabindex="-1" role="dialog" aria-labelledby="editCampaignModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCampaignModalLabel">Edit Campaign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if(isset($campaign)): ?>
                    <!-- Add the form for editing the campaign here -->
                        <form action="<?php echo e(route('admin.leadcampaign.update', $campaign->id)); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="form-group">
                            <label for="name">Campaign Name</label>
                            <input type="hidden" name="id" id="id_edit" class="form-control" value="0" required>
                            <input type="text" name="name" id="name_edit" class="form-control" value="" required>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label for="type">Campaign Type</label>-->
                        <!--    <select name="type" id="type_edit" class="form-control" onchange="getTemplateEdit(value)" required>-->
                        <!--        <option value="sms" >SMS</option>-->
                        <!--        <option value="email">Email</option>-->
                        <!--        <option value="mms">MMS</option>-->
                        <!--        <option value="rvm">RVM</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                        <!--<div class="form-group" id="update-templates-edit">-->
                        <!--    <label>Select Template</label>-->
                        <!--    <select class="custom-select" name="template_id" id="template-select-edit">-->
                        <!--        <option value="0">Select Template</option>-->
                        <!--        <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->
                        <!--            <option value="<?php echo e($template->id); ?>"><?php echo e($template->title); ?></option>-->
                        <!--        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->
                        <!--    </select>-->
                        <!--</div>-->
                        <!-- Edit schedule field -->
                        <!--<div class="form-group">-->
                        <!--    <label for="send_after_days">Send After Days</label>-->
                        <!--    <input type="number" name="send_after_days" id="send_after_days_edit" class="form-control" value="" required>-->
                        <!--</div>-->
                        
                        <!--<div class="form-group">-->
                        <!--    <label for="send_after_hours">Send After Hours</label>-->
                        <!--    <input type="number" name="send_after_hours" id="send_after_hours_edit" class="form-control" value="" required>-->
                        <!--</div>-->
                        <div class="form-group">
                            <label for="group_id">Select Group/Contact List</label>
                            <select name="group_id" id="group_id_edit" class="form-control">
                                <option value="">Select Group/Contact List</option>
                                <?php if(isset($groups)): ?>
                                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($group->id); ?>"><?php echo e($group->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Add other fields for campaign details -->
                        <!-- For example, schedule, message content, etc. -->
                        <div class="form-group">
                            <label for="active">Active Status</label>
                            <select name="active" id="active" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Campaign</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    function getTemplate(type){
        var url = '<?php echo url('/admin/get/template/') ?>/'+type;
        $.ajax({
            type: 'GET',
            url: url,
            data: '',
            processData: false,
            contentType: false,
            success: function (d) {
                $('#update-templates').html(d);
            }
        });
    }
    
    
    $('#editCampaignModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);// Button that triggered the modal
        var name = button.data('name');
        var type = button.data('type');
        var template_id = button.data('template');
        getTemplateEdit(type,template_id);
        var id = button.data('id');
        var sendafterdays = button.data('sendafterdays');
        var sendafterhours = button.data('sendafterhours');
        var group_id = button.data('group');
        var modal = $(this);
        
        $('#name_edit').val(name);
        $('#id_edit').val(id);
        $('#type_edit').val(type);
        $('#send_after_days_edit').val(sendafterdays);
        $('#send_after_hours_edit').val(sendafterhours);
        $('#group_id_edit').val(group_id);
    });
    
    function getTemplateEdit(type,template_id){
        var url = '<?php echo url('/admin/get/template/') ?>/'+type;
        $.ajax({
            type: 'GET',
            url: url,
            data: '',
            processData: false,
            contentType: false,
            success: function (d) {
                $('#update-templates-edit').html(d);
                setTimeout(function() {
                    $('#template-select-edit').val(template_id);
                }, 500);
                
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/campaignleads/index.blade.php ENDPATH**/ ?>