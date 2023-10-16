<form action="{{ route('admin.user-agreement.store') }}" method="POST" enctype="multipart/form-data"
    id="user-agreement-create">
    <div class="modal-body">
        @csrf
        @method('POST')
        <div id="error-messages" style="color: red; margin-left:30%;"></div>
        <div class="form-group">
            <label for="recipient-name" class="col-form-label">Form Template <span class="required">*</span></label>
            <select class="form-control formTemplate" onchange="fetch(this)" id="template_id" name="template_id" required>
                <option value="">Select Form Template</option>
                @foreach(getFormTemplate() as $templateId => $template)
                <option value="{{ $templateId }}">{{ $template }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Template Content <span class="required">*</span></label>
            <textarea class="form-control text1 userAgreementContent" id="user-agreement-content" name="content"
                rows="10"></textarea>
            <div id='count' class="float-lg-right"></div>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="col-form-label">User Seller <span class="required">*</span></label>
            <div class="checkbox-list">
                @foreach (getUserContact() as $sellerId => $seller)
                    <label><input type="checkbox" class="user-seller" name="seller_id[]" value="{{ $sellerId }}"> {{ $seller }}</label><br>
                @endforeach
        </div>
        </div>
        <div class="form-group">
            <small class="text-danger"><b>Please Keep {SIGNATURE_USER} in contenet for user sign</b></small>
            <br>
            {{ getAuthEmail()->auth_email }}
            {{-- <small class="text-danger"><b> {{ getAuthEmail()->auth_email }}</b></small> --}}
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary saveUserAgreement">Create</button>
    </div>
</form>

<script>
    function fetch(ctrl)
    {
        // //alert(ctrl.value);
        // var tempid=ctrl.value;
        // //alert(tempid);
        // $('#user-agreement-content').html('');
        // var url = '<?php echo url('/admin/get/template/') ?>/'+tempid;
        // $.ajax({
        //     type: 'GET',
        //     url: url,
        //     data: '',
        //     processData: false,
        //     contentType: false,
        //     success: function (d) {
        //        // alert(d);
        //        // $('#user-agreement-content').html(d);
        //     }
        // });
    }
    </script>
