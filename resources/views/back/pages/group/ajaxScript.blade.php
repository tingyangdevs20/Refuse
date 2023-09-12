<link rel="stylesheet" href="{{asset('/summernote/dist/summernote.css')}}" />
    <script src="{{asset('/summernote/dist/summernote.min.js')}}"></script>
<div class="col-md-12">
    <textarea class="form-control text12333 email_body_edit summernote-usage" disabled name="scripts" id="body_email" rows="10">{{$scrip->scripts}}</textarea>
</div>
<script>
    $('.summernote-usage').summernote('disable');
        $(".summernote-usage").summernote({
    	    height: 200,
    	});
</script>