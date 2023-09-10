<form action="{{ route('admin.user-agreement.store') }}" method="POST" enctype="multipart/form-data"
    id="user-agreement-create">
    <div class="modal-body">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="recipient-name" class="col-form-label">Form Template <span class="required">*</span></label>
            <select class="form-control formTemplate" id="template_id" name="template_id" required>
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
            <select class="form-control userSeller" id="seller_id" name="seller_id[]" required multiple="multiple">
                <option value="">Select User Contact</option>
                @foreach(getUserContact() as $sellerId => $seller)
                <option value="{{ $sellerId }}">{{ $seller }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <small class="text-danger"><b>Please Keep {SIGNATURE_USER} in contenet for user sign</b></small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary saveUserAgreement">Create</button>
    </div>
</form>