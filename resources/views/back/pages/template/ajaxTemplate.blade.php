<label>Select Template</label>
<select class="custom-select" name="template_id" id="template-select-edit" required>
    <option value="0">Select Template</option>
    @foreach($templates as $template)
    <option value="{{ $template->id }}">{{ $template->title }}</option>
        @endforeach
</select>