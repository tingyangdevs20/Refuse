<?php $__env->startSection('content'); ?>

<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div style="background:#666666">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4" >
                                    <h5  style="color:#38B6FF">Welcome Back !</h5>
                                    <p style="color:#ffffff">Sign in to continue to REIFuze.</p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                                <img src="<?php echo e(asset('back/assets/images/profile-img.png')); ?>" alt="" style="margin-left: -75%;margin-top: 21px;" class="img-fluid">
                            </div>
                    <div class="card-body pt-0">
                        
                        <div class="p-2" id="dvLogin">
                            <form class="form-horizontal" method="POST" action="<?php echo e(route('login')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>

                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password">

                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" style="background:#38B6FF;border-color:#38B6FF" type="submit">Log In</button>
                                </div>
                            </form>
                            <div class="mt-4 text-center" style="display: block">
                                <a href="#" onclick="forgot_password('login')" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</a>
                            </div>
                        </div>

                        <div class="p-2" id="dvforgot" style="display:none">
                            <form class="form-horizontal" method="POST" action="<?php echo e(route('login')); ?>" >
                                <?php echo csrf_field(); ?>
                                <p style="font-weight:bold">Forgot Password</p>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" placeholder="Enter Registered Email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>

                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                               

                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" style="background:#38B6FF;border-color:#38B6FF" type="submit">Submit</button>
                                </div>
                            </form>
                            <div class="mt-4 text-center" style="display: block">
                                <a href="#" onclick="forgot_password('forgot')" class="text-muted"><i class="mdi mdi-lock mr-1"></i>Back To Login </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">

                    <div>

                        <p>© 2023 REIFuze.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<script>
    function forgot_password(ctrl)
    {
        //dvLogin
        if(ctrl=="login")
        {

        $("#dvforgot").show();
        $("#dvLogin").hide();
        }else{
            $("#dvforgot").hide();
        $("#dvLogin").show();
        }
    }
    </script>

<?php echo $__env->make('auth.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/auth/login.blade.php ENDPATH**/ ?>