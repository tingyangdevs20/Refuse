<!-- resources/views/back/pages/campaign/create.blade.php -->

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="modal fade" id="addCampaignModal" tabindex="-1" role="dialog" aria-labelledby="addCampaignModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCampaignModalLabel">Add Goals</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add the form for adding the campaign here -->
                    <form action="<?php echo e(route('admin.savegoals')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="name">People to contact Per Day</label>
                            <input type="text" name="contact_people" id="contact_people" class="form-control numeric" value="<?php echo e($goalValue); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Goal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add any required scripts for the popup here -->
    <?php $__env->startSection('scripts'); ?>
    <script>
        $(window).on('load', function() {
        $('#addCampaignModal').modal('show');
    });
            // $("#addCampaignModal").show();
        $(document).on("input", ".numeric", function (e) {
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
    });

    </script>
    <?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/goal-settings/index.blade.php ENDPATH**/ ?>