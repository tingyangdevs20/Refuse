<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <div>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>

<?php if(Session::has('success')): ?>
    <div class="alert alert-success">
        <div>
            <p><?php echo e(Session::get('success')); ?></p>
        </div>
    </div>
<?php endif; ?>

<?php if(Session::has('error')): ?>
    <div class="alert alert-danger">
        <div>
            <p><?php echo e(Session::get('error')); ?></p>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/partials/messages.blade.php ENDPATH**/ ?>