@if($type == 'sms')
    <div class="form-group" style=" display: none;">
        <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
        <input type="file" class="form-control-file" name="media_file{{ $count }}">
    </div>
    <input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]">
    <input type="hidden"  class="form-control" placeholder="Subject" value="" name="subject[]">
    <div class="col-md-12">
        <div class="form-group ">
            <label >Message</label>
            <textarea id="template_text" class="form-control"  rows="10" name="body[]"></textarea>
            <div id='count' class="float-lg-right"></div>
        </div>
        <div class="form-group">
            <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
        </div>
    </div>
@elseif($type == 'mms')
    <input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]">
    <input type="hidden"  class="form-control" placeholder="Subject" value="" name="subject[]">
    
    <div class="col-md-12">
        <div class="form-group">
            <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
            <input type="file" class="form-control-file" name="media_file{{ $count }}">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group ">
            <label >Message</label>
            <textarea id="template_text" class="form-control"  rows="10" name="body[]"></textarea>
            <div id='count' class="float-lg-right"></div>
        </div>
        <div class="form-group">
            <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
        </div>
    </div>
@elseif($type == 'email')
    <input type="hidden" class="form-control" placeholder="Hours" value="" name="mediaUrl[]">
    <div class="form-group" style=" display: none;">
        <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
        <input type="file" class="form-control-file" name="media_file{{ $count }}">
    </div>
    
    <div class="col-md-6">
        <div class="form-group ">
            <label >Subject</label>
            <input type="text"  class="form-control" placeholder="Subject" value="" name="subject[]">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group ">
            <label >Message</label>
            <textarea id="template_text" class="form-control summernote-usage"  rows="10" name="body[]"></textarea>
        </div>
        <div class="form-group">
            <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the respective fields</b></small>
        </div>
    </div>
@elseif($type == 'rvm')
    <input type="hidden" class="form-control" placeholder="Hours" value="" name="body[]">
    <div class="col-md-12">
        <div class="form-group mt-3">
            <label>Rvm Files</label>
            <select class="custom-select" name="mediaUrl[]" required>
                <option value="">Rvm File</option>
                @if(count($files) > 0)
                    @foreach($files as $file)
                        <option value="{{ $file->mediaUrl }}">{{ $file->name }}</option>
                    @endforeach
                @endif
                
            </select>
        </div>
    </div>
    <div class="form-group" style=" display:none;">
        <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
        <input type="file" class="form-control-file" name="media_file{{ $count }}">
    </div>
@endif
<script >
    $(".summernote-usage").summernote({
        height: 200,
    });
</script>