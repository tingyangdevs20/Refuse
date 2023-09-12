<form action="#" method="post" id="user-agreement-edit" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="recipient-name" class="col-form-label">Form Template <span class="required">*</span></label>
                <select class="form-control formTemplate" id="template_id" name="template_id" required>
                    <option value="">Select Form Template</option>
                    @foreach(getFormTemplate() as $templateId => $template)
                    <option value="{{ $templateId }}" @if($userAgreement->template_id == $templateId)
                        selected='selected' @endif >{{ $template }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Template Content <span class="required">*</span></label>
            <textarea class="form-control text1 userAgreementContent" id="user-agreement-content" name="content"
                rows="10">
                {!! $userAgreement->content !!}
            </textarea>
            <div id='count' class="float-lg-right"></div>
        </div>
        <div class="form-group col-sm-6">
            <label for="recipient-name" class="col-form-label">User Seller <span class="required">*</span></label>
            <select class="form-control userSeller" id="seller_id" name="seller_id[]" required multiple="multiple">
                <option value="">Select User Contact</option>
                @foreach(getUserContact() as $sellerId => $seller)
                @if(in_array($sellerId, $userAgreementSellerIds))
                <option value="{{ $sellerId }}" selected='selected'>{{ $seller }}</option>
                @else
                <option value="{{ $sellerId }}">{{ $seller }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <small class="text-danger"><b>Use {name} {street} {city} {state} {zip} to substitute the
                    respective fields</b></small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" data-id="{{ $userAgreement->id }}"
            class="btn btn-primary updateUserAgreement">Update</button>
    </div>
</form>