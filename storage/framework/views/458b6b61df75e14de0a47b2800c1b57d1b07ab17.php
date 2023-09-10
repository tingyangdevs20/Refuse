<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        #hidden_div {
            display: none;
        }
    </style>
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
                                    <h4 class="mb-0 font-size-18">Campaigns</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                            <li class="breadcrumb-item">Campaigns</li>
                                            <li class="breadcrumb-item active">Campaigns List</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        <i class="fas fa-edit"></i> Campaigns List
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(route('admin.campaignlist.store')); ?>" method="post" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('POST'); ?>
                                            <input type="hidden"  class="form-control" placeholder="Days" value="<?php echo e($id); ?>" name="campaign_id">
                                            <div class="row">
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-7">
                                                    <?php
                                                        $count = 1;      
                                                    ?>
                                                    <?php if(count($campaignsList) > 0): ?>
                                                        <?php $__currentLoopData = $campaignsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="card col-md-12" id="rowCount<?php echo e($count); ?>">
                                                                <input type="hidden"  class="form-control" placeholder="Days" value="<?php echo e($campaign->id); ?>" name="campaign_list_id[]">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group text-right mt-2">
                                                                            <label>Delay</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                                                </div>
                                                                                <input type="number" min="0" class="form-control" placeholder="Days" value="<?php echo e($campaign->send_after_days); ?>" name="send_after_days[]">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                                                </div>
                                                                                <input type="number" min="0" class="form-control" placeholder="Hours" value="<?php echo e($campaign->send_after_hours); ?>" name="send_after_hours[]">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;padding: 10px 5px;" onclick="removeRow('<?php echo e($count); ?>');">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mt-3">
                                                                            <label>Campaign Type</label>
                                                                            <select class="custom-select" name="type[]" onchange="messageType(value,'<?php echo e($count); ?>')" required>
                                                                                <option value="sms" <?php if($campaign->type == 'sms'): ?> selected <?php endif; ?>>SMS</option>
                                                                                <option value="email" <?php if($campaign->type == 'email'): ?> selected <?php endif; ?>>Email</option>
                                                                                <option value="mms" <?php if($campaign->type == 'mms'): ?> selected <?php endif; ?>>MMS</option>
                                                                                <option value="rvm" <?php if($campaign->type == 'rvm'): ?> selected <?php endif; ?>>RVM</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="show_sms_<?php echo e($count); ?>">
                                                                    <?php if($campaign->type == 'sms'): ?>
                                                                        <?php
                                                                            if($campaign->template_id > 0){
                                                                                $template = commonHelper::getBody($campaign->template_id);
                                                                                $body = $template->body;
                                                                            }else{
                                                                                $body = $campaign->body;
                                                                            }
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="form-group" style=" display: none;">
                                                                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                                <input type="file" class="form-control-file" name="media_file<?php echo e($count); ?>">
                                                                            </div>
                                                                            <input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]">
                                                                            <input type="hidden"  class="form-control" placeholder="Subject" value="" name="subject[]">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group ">
                                                                                    <label >Message</label>
                                                                                    <textarea id="template_text" class="form-control"  rows="10" name="body[]"><?php echo e($body); ?></textarea>
                                                                                    <div id='count' class="float-lg-right"></div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php elseif($campaign->type == 'mms'): ?>
                                                                        <?php
                                                                            if($campaign->template_id > 0){
                                                                                $template = commonHelper::getBody($campaign->template_id);
                                                                                $body = $template->body;
                                                                            }else{
                                                                                $body = $campaign->body;
                                                                            }
                                                                        ?>
                                                                        <input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]">
                                                                        <input type="hidden"  class="form-control" placeholder="Subject" value="" name="subject[]">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                                    <input type="file" class="form-control-file" name="media_file<?php echo e($count); ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group ">
                                                                                    <label >Message</label>
                                                                                    <textarea id="template_text" class="form-control"  rows="10" name="body[]"><?php echo e($body); ?></textarea>
                                                                                    <div id='count' class="float-lg-right"></div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php elseif($campaign->type == 'email'): ?>
                                                                        <?php
                                                                            if($campaign->template_id > 0){
                                                                                $template = commonHelper::getBody($campaign->template_id);
                                                                                $subject = $template->subject;
                                                                                $body = $template->body;
                                                                            }else{
                                                                                $subject = $campaign->subject;
                                                                                $body = $campaign->body;
                                                                            }
                                                                        ?>
                                                                        <input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]">
                                                                        <div class="form-group" style=" display: none;">
                                                                            <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                            <input type="file" class="form-control-file" name="media_file<?php echo e($count); ?>">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                    <label >Subject</label>
                                                                                    <input type="text"  class="form-control" placeholder="Subject" value="<?php echo e($subject); ?>" name="subject[]">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group ">
                                                                                    <label >Message</label>
                                                                                    <textarea id="template_text" class="form-control summernote-usage"  rows="10" name="body[]"><?php echo e($body); ?></textarea>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php elseif($campaign->type == 'rvm'): ?>
                                                                        <input type="hidden" class="form-control" placeholder="Hours" value="" name="body[]">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group mt-3">
                                                                                    <label>Rvm Files</label>
                                                                                    <select class="custom-select" name="mediaUrl[]" required>
                                                                                        <option value="">Rvm File</option>
                                                                                        <?php if(count($files) > 0): ?>
                                                                                            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                <option value="<?php echo e($file->mediaUrl); ?>" <?php if($campaign->mediaUrl == $file->mediaUrl): ?> selected <?php endif; ?>><?php echo e($file->name); ?></option>
                                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                        <?php endif; ?>
                                                                                        
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group" style=" display:none;">
                                                                            <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                                            <input type="file" class="form-control-file" name="media_file<?php echo e($count); ?>">
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4 text-center">
                                                                        </div>
                                                                        <div class="col-md-4 text-center">
                                                                            <hr>
                                                                        </div>
                                                                        <div class="col-md-4 text-center">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                $count++;      
                                                            ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                    <div class="addNewRow"></div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3 text-center">
                                                            </div>
                                                            <div class="col-md-6 text-center">
                                                                <button type="button" class="btn btn-primary mt-2" onclick="addNewRows(this.form);">Add new message to the sequence</button>
                                                            </div>
                                                            <div class="col-md-3 text-center">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <button type="submit" class="btn btn-primary mt-2" >Submit</button>
                                            </div>
                                        </form>

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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('/summernote/dist/summernote.css')); ?>" />
    <script src="<?php echo e(asset('/summernote/dist/summernote.min.js')); ?>"></script>
    <script >
        $(".summernote-usage").summernote({
    	    height: 200,
    	});
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );

        var rowCount = <?php echo e(count($campaignsList)); ?>

        function addNewRows(frm) {
            rowCount ++;
            var recRow = '<div id="rowCount'+rowCount+'" class="col-lg-12"><div class="card col-md-12"><div class="row"><div class="col-md-3"><div class="form-group text-right mt-2"><label>Delay</label></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Days" name="send_after_days[]"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Hours" name="send_after_hours[]"></div></div></div><div class="col-md-3"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;padding: 10px 5px;" onclick="removeRow('+rowCount+');"><i class="fas fa-trash"></i></button></div></div><div class="row"><div class="col-md-12"><div class="form-group mt-3"><input type="hidden"  class="form-control" placeholder="Days" value="0" name="campaign_list_id[]"><label>Campaign Type</label><select class="custom-select" name="type[]"  onchange="messageType(value,'+rowCount+');" required><option value="sms">SMS</option><option value="email">Email</option><option value="mms">MMS</option><option value="rvm">RVM</option></select></div></div></div><div class="row show_sms_'+rowCount+'"><div class="col-md-12"><div class="form-group "><div class="form-group" style=" display: none;"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file'+rowCount+'"></div><input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]"><input type="hidden"  class="form-control" placeholder="Subject" value="" name="subject[]"><label >Message</label><textarea id="template_text" class="form-control"  rows="10" name="body[]"></textarea><div id="count" class="float-lg-right"></div></div><div class="form-group"><small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small></div></div></div></div><div class="col-md-12"><div class="row"><div class="col-md-4 text-center"></div><div class="col-md-4 text-center"><hr></div><div class="col-md-4 text-center"></div></div></div></div></div>';
            //var recRow = '<div id="rowCount'+rowCount+'" class="col-lg-12"><div class="card col-md-12"><div class="row"><div class="col-md-12"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #f00;" onclick="removeRow('+rowCount+');"><i class="fas fa-trash"></i></button><div class="form-group mt-3"><label>Campaign Type</label><select class="custom-select" name="type[]" onchange="" required><option value="sms">SMS</option><option value="email">Email</option><option value="mms">MMS</option><option value="rvm">RVM</option></select></div></div></div><div class="row"><div class="col-md-3"><div class="form-group text-right mt-2"><label>Delays</label></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Days" name="send_after_days[]"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="number" min="0" class="form-control" placeholder="Hours" name="send_after_hours[]"></div></div></div><div class="col-md-3"></div></div><div class="row show_sms"><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_email" style="display:none;"><div class="col-md-6"><div class="form-group"><label >Subject</label><input type="text"  class="form-control" placeholder="Subject" name="receiver_number" /></div></div><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_mms" style="display:none;"><div class="col-md-6"><div class="form-group"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file"></div></div><div class="col-md-12"><div class="form-group "><label >Message</label><textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea><div id="count" class="float-lg-right"></div></div></div></div><div class="row show_rvm" style="display:none;"><div class="col-md-6"><div class="form-group"><label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label><input type="file" class="form-control-file" name="media_file[]"></div></div></div><div class="col-md-12"><div class="row"><div class="col-md-4 text-center"></div><div class="col-md-4 text-center"><hr></div><div class="col-md-4 text-center"></div></div></div></div></div>';
            jQuery('.addNewRow').append(recRow);

        }

        function removeRow(removeNum) {
            jQuery('#rowCount'+removeNum).remove();
        }

    </script>
    <script>
        function showDiv(divId, element)
        {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }
        function templateId() {
            template_id = document.getElementById("template-select").value;
           setTextareaValue(template_id)
        }
    </script>
    <script>
        function setTextareaValue(id)
        {
            if(id>0){
                axios.get('/admin/template/'+id)
                    .then(response =>
                        document.getElementById("template_text").value = response.data['body'],
                    )
                    .catch(error => console.log(error));
            }
            else{
                document.getElementById("template_text").value = '';
            }


        }
        const textarea = document.querySelector('textarea')
        const count = document.getElementById('count')
        textarea.onkeyup = (e) => {
            count.innerHTML = "Characters: "+e.target.value.length+"/160";
        };

        function messageType(type,id){
            $('.show_sms_'+id).html('');
            var url = '<?php echo url('/admin/get/message/') ?>/'+type+'/'+id;
            //alert(url);
            $.ajax({
                type: 'GET',
                url: url,
                data: '',
                processData: false,
                contentType: false,
                success: function (d) {
                    $('.show_sms_'+id).html(d);
                }
            });
        }
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('back.inc.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/bbagnall/public_html/bulk/test/bulk_sms/resources/views/back/pages/campaign/indexList.blade.php ENDPATH**/ ?>