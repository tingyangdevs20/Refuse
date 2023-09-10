<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    
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
                        <h4 class="mb-0 font-size-18">Templates</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item">Lead Generations</li>
                                <li class="breadcrumb-item active">Templates</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            All Templates
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
                                    <th scope="col">Title</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Body</th>
                                    <!--<th scope="col">Media URL</th>-->
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($sr++); ?></td>
                                        <td><?php echo e($template->title); ?></td>
                                        <td><?php echo e($template->type); ?></td>
                                        <td><?php echo e($template->getCategoryName()); ?></td>
                                        <td>
                                            <?php echo htmlspecialchars_decode(stripslashes($template->body)); ?>
                                            <!--<?php echo e($template->body); ?>-->
                                            <?php if($template->type == 'MMS'): ?>
                                                <br><?php echo e($template->mediaUrl); ?>

                                            <?php endif; ?>
                                        </td>
                                        <!--<td>-->
                                        <!--    <?php if($template->type == 'MMS'): ?>-->
                                        <!--        <?php echo e($template->mediaUrl); ?>-->
                                        <!--    <?php else: ?>-->
                                        <!--        <?php echo e($template->body); ?>-->
                                        <!--    <?php endif; ?>-->
                                            
                                        <!--</td>-->
                                        <td>
                                            <button class="btn btn-outline-primary btn-sm edit-template" title="Edit <?php echo e($template->title); ?>" data-title="<?php echo e($template->title); ?>" data-mediaurl="<?php echo e($template->mediaUrl); ?>" data-category="<?php echo e($template->category_id); ?>" data-type="<?php echo e($template->type); ?>" data-subject="<?php echo e($template->subject); ?>" data-body="<?php echo e(htmlspecialchars_decode(stripslashes($template->body))); ?>" data-id="<?php echo e($template->id); ?>"  data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                                            -
                                            <button class="btn btn-outline-danger btn-sm" title="Remove <?php echo e($template->title); ?>" data-id="<?php echo e($template->id); ?>" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-times-circle"></i></button>
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
    
    
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.template.store')); ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Template Title"
                                   required>
                        </div>
                        <div class="form-group pt-2">
                            <label>Category</label><br>
                            <select class="from-control" style="width: 100%;" id="categories" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group pt-2">
                            <label>Message Type</label><br>
                            <select class="from-control" style="width: 100%;" id="type" name="type" onchange="messageType(value)" required>
                                <option value="">Select Type</option>
                                <option value="SMS">SMS</option>
                                <option value="MMS">MMS</option>
                                <option value="Email">Email</option>
                                <option value="RVM">RVM</option>
                            </select>
                        </div>
                        
                        <div class="show_media_rvm" style="display:none;">
                            <div class="form-group">
                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                <input type="file" class="form-control-file" name="media_file">
                            </div>
                        </div>
                        <div class="show_media_mms" style="display:none;">
                            <div class="form-group">
                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                <input type="file" class="form-control-file" name="media_file_mms">
                            </div>
                            <div class="form-group">
                                <label>Body</label>
                                <textarea class="form-control text111 mms_body" name="mms_body" rows="10"></textarea>
                                <div id='count111' class="float-lg-right"></div>
                            </div>
                            <div class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
                        </div>
                        <div class="show_sms" style="display:none;">
                            <div class="form-group">
                                <label>Body</label>
                                <textarea class="form-control text1 body_sms" name="body" rows="10"></textarea>
                                <div id='count' class="float-lg-right"></div>
                            </div>
                            <div class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
                        </div>
                        <div class="show_email" style="display:none;">
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" class="form-control email_body" name="subject" placeholder="Enter Subject" >
                            </div>
                            <div class="form-group">
                                <label>Body</label>
                                <textarea class="form-control email_body summernote-usage" name="email_body" rows="10"></textarea>
                                <!--<div id='count11' class="float-lg-right"></div>-->
                            </div>
                            <div class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
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
    

    
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.template.update','test')); ?>" method="post" id="editForm" enctype="multipart/form-data">
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="hidden" id="id" name="id" value="">
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        
                        <div class="form-group pt-2">
                            <label>Category</label><br>
                            <select class="from-control" style="width: 100%;" id="categories2" name="category_id"
                                    required>
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group pt-2">
                            <label>Message Type</label><br>
                            <select class="from-control" style="width: 100%;" id="type" name="type" onchange="messageTypeEdit(value)" required>
                                <option value="">Select Type</option>
                                <option value="SMS">SMS</option>
                                <option value="MMS">MMS</option>
                                <option value="Email">Email</option>
                                <option value="RVM">RVM</option>
                            </select>
                        </div>
                        <!--//////-->
                        <div class="show_media_rvm_edit" style="display:none;">
                            <div class="form-group">
                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                <input type="file" class="form-control-file" name="media_file">
                                <label>(<small class="text-danger font-weight-bold file-name"></small>)</label>
                            </div>
                        </div>
                        <div class="show_media_mms_edit" style="display:none;">
                            <div class="form-group">
                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                <input type="file" class="form-control-file" name="media_file_mms">
                                <label>(<small class="text-danger font-weight-bold file-name"></small>)</label>
                            </div>
                            <div class="form-group">
                                <label>Body</label>
                                <textarea class="form-control text112 mms_body" id="mms_body_edit" name="mms_body" rows="10"></textarea>
                                <div id='count112' class="float-lg-right"></div>
                            </div>
                            <div class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
                        </div>
                        <div class="show_sms_edit" style="display:none;">
                            <div class="form-group">
                                <label>Body</label>
                                <textarea class="form-control text2 body_sms_edit" id="body_sms" name="body" rows="10"></textarea>
                                <div id='count2' class="float-lg-right"></div>
                            </div>
                            <div class="form-group">
    
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                                        respective fields</b></small>
                            </div>
                        </div>
                        <div class="show_email_edit" style="display:none;">
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" class="form-control email_body_edit" name="subject" id="subject" placeholder="Enter Subject" >
                            </div>
                            <div class="form-group">
                                <label>Body</label>
                                <textarea class="form-control text12333 email_body_edit summernote-usage" name="email_body" id="body_email" rows="10"></textarea>
                                <!--<div id='count12' class="float-lg-right"></div>-->
                            </div>
                            <div class="form-group">
                                <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
                            </div>
                        </div>
                        <!--//////-->
                        <!--<div class="form-group">-->
                        <!--    <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>-->
                        <!--    <input type="file" class="form-control-file" name="media_file">-->
                        <!--    <label>(<small class="text-danger font-weight-bold">if uploading new file, remove the old link from body</small>)</label>-->
                        <!--</div>-->
                        <!--<div class="form-group">-->
                        <!--    <label>Body</label>-->
                        <!--    <textarea class="form-control message text2" name="body" id="body" rows="10"></textarea>-->
                        <!--    <div id='count2' class="float-lg-right"></div>-->

                        <!--</div>-->
                        <!--<div class="form-group">-->
                        <!--    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the-->
                        <!--            respective fields</b></small>-->
                        <!--</div>-->

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.template.destroy','test')); ?>" method="post" id="editForm">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('/summernote/dist/summernote-bs4.css')); ?>" />
    <script src="<?php echo e(asset('/summernote/dist/summernote-bs4.min.js')); ?>"></script>
    <script>
        $(".summernote-usage").summernote({
    	    height: 200,
    	});
        function messageType(val){
            if(val === 'SMS'){
                $(".email_body").removeAttr("required");
                $(".body_sms").attr("required", "true");
                
                $('.show_media').hide();
                $('.show_email').hide();
                $('.show_media_rvm').hide();
                $('.show_media_mms').hide();
                $('.show_sms').show();
            }else if(val === 'MMS'){
                $(".body_sms").removeAttr("required");
                $(".email_body").removeAttr("required");
                $('.show_email').hide();
                $('.show_sms').hide();
                $('.show_media_rvm').hide();
                $('.show_media_mms').show();
            }else if(val === 'Email'){
                $(".body_sms").removeAttr("required");
                $(".email_body").attr("required", "true");
                $('.show_sms').hide();
                $('.show_media').hide();
                $('.show_media_rvm').hide();
                $('.show_media_mms').hide();
                $('.show_email').show();
            }else if(val === 'RVM'){
                $(".body_sms").removeAttr("required");
                $(".email_body").removeAttr("required");
                $('.show_email').hide();
                $('.show_sms').hide();
                $('.show_media_mms').hide();
                $('.show_media_rvm').show();
            }
        }
        function messageTypeEdit(val){
            if(val === 'SMS'){
                $(".email_body_edit").removeAttr("required");
                $(".body_sms_edit").attr("required", "true");
                $('.show_media_rvm_edit').hide();
                $('.show_media_mms_edit').hide();
                $('.show_email_edit').hide();
                $('.show_sms_edit').show();
            }else if(val === 'MMS'){
                $(".body_sms_edit").removeAttr("required");
                $(".email_body_edit").removeAttr("required");
                $('.show_email_edit').hide();
                $('.show_sms_edit').hide();
                $('.show_media_rvm_edit').hide();
                $('.show_media_mms_edit').show();
                
            }else if(val === 'Email'){
                $(".body_sms_edit").removeAttr("required");
                $(".email_body_edit").attr("required", "true");
                $('.show_sms_edit').hide();
               $('.show_media_rvm_edit').hide();
                $('.show_media_mms_edit').hide();
                $('.show_email_edit').show();
            }else if(val === 'RVM'){
                $(".body_sms_edit").removeAttr("required");
                $(".email_body_edit").removeAttr("required");
                $('.show_email_edit').hide();
                $('.show_sms_edit').hide();
                $('.show_media_mms_edit').hide();
                $('.show_media_rvm_edit').show();
            }
        }
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
        $(document).ready(function () {
            $('#categories').select2();
        });
        $(document).ready(function () {
            $('#type').select2();
        });
        $(document).ready(function () {
            $('#categories2').select2();
        });
        
    </script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);// Button that triggered the modal
            var title = button.data('title');
            var body = button.data('body');
            var id = button.data('id');
            var type = button.data('type');
            var subject = button.data('subject');
            var category = button.data('category');
            var mediaurl = button.data('mediaurl');
            var modal = $(this);
            if(type === 'SMS'){
                $(".email_body").removeAttr("required");
                $(".body_sms").attr("required", "true");
                $('.show_media_rvm_edit').hide();
                $('.show_media_mms_edit').hide();
                $('.show_email_edit').hide();
                $('.show_sms_edit').show();
                modal.find('.modal-body #body_sms').val(body);
            }else if(type === 'MMS'){
                $(".body_sms").removeAttr("required");
                $(".email_body").removeAttr("required");
                $('.show_email_edit').hide();
                $('.show_sms_edit').hide();
                $('.show_media_rvm_edit').hide();
                $('.show_media_mms_edit').show();
                modal.find('.modal-body #mms_body_edit').val(body);
                $('.file-name').html(mediaurl);
            }else if(type === 'Email'){
                $(".body_sms").removeAttr("required");
                $(".email_body").attr("required", "true");
                $('.show_sms_edit').hide();
                $('.show_media_rvm_edit').hide();
                $('.show_media_mms_edit').hide();
                $('.show_email_edit').show();
                modal.find('.modal-body #subject').val(subject);
                $('#body_email').summernote ('code', body);
                //$('#body_email').val(body);
            }else if(type === 'RVM'){
                $(".body_sms").removeAttr("required");
                $(".email_body").removeAttr("required");
                $('.show_email_edit').hide();
                $('.show_sms_edit').hide();
                $('.show_media_mms_edit').hide();
                $('.show_media_rvm_edit').show();
                $('.file-name').html(body);
            }
            modal.find('.modal-body #title').val(title);
            
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #type').val(type);
            $("#categories2").val(category).trigger('change');

        });
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });

        const textarea1 = document.querySelector('.text1')
        const count = document.getElementById('count')
        textarea1.onkeyup = (e) => {
            count.innerHTML = "Characters: "+e.target.value.length+"/160";
        };

        const textarea2 = document.querySelector('.text2')
        const count2 = document.getElementById('count2')
        textarea2.onkeyup = (e) => {
            count2.innerHTML = "Characters: "+e.target.value.length+"/160";
        };
        
        // const textarea11 = document.querySelector('.text11')
        // const count11 = document.getElementById('count11')
        // textarea11.onkeyup = (e) => {
        //     count11.innerHTML = "Characters: "+e.target.value.length+"/160";
        // };
        const textarea111 = document.querySelector('.text111')
        const count111 = document.getElementById('count111')
        textarea111.onkeyup = (e) => {
            count111.innerHTML = "Characters: "+e.target.value.length+"/160";
        };
        const textarea112 = document.querySelector('.text112')
        const count112 = document.getElementById('count112')
        textarea112.onkeyup = (e) => {
            count112.innerHTML = "Characters: "+e.target.value.length+"/160";
        };
        
        
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/template/index.blade.php ENDPATH**/ ?>