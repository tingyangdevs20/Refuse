
<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>Bulk SMS Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pet Store Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('back/assets/images/sms.svg')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Bootstrap Css -->
    <link href="<?php echo e(asset('back/assets/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo e(asset('back/assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo e(asset('back/assets/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
<?php echo $__env->yieldContent('styles'); ?>
</head>

<body data-sidebar="dark">

<!-- Begin page -->
<div id="layout-wrapper">


    <!-- ========== Header ========== -->
    <?php echo $__env->make('back.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Header -->
    <!-- ========== Left Sidebar Start ========== -->
    <?php echo $__env->make('back.inc.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
        <style>
            .ct_message_text {
              position: relative;
              top: 80px;
            }
        </style>
    <div class="main-content">
   
     <div class="ct_message_text">
       
     </div>
        

       <?php echo $__env->yieldContent('content'); ?>
        <!-- End Page-content -->


        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © REIFuze.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-right d-none d-sm-block">

                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->



<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<script src="<?php echo e(asset('back/assets/libs/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('back/assets/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('back/assets/libs/metismenu/metisMenu.min.js')); ?>"></script>
<script src="<?php echo e(asset('back/assets/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(asset('back/assets/libs/node-waves/waves.min.js')); ?>"></script>

<!-- apexcharts -->


<!-- Saas dashboard init -->


<script src="<?php echo e(asset('back/assets/js/app.js')); ?>"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/inc/master.blade.php ENDPATH**/ ?>