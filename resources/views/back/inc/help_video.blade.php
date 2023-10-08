@php
@dd($helpLink);
$helpLink = helpVideolink($type);
@endphp
<button class="btn btn-outline-primary btn-sm float-right" title="helpModal" data-toggle="modal"
    data-target="#helpModal">How to use</button>

{{--Modal Add on 31-08-2023--}}
<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">How to Use</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(isset($helpLink->links))
                <div style="position:relative;height:0;width:100%;padding-bottom:65.5%">
                    <iframe src="{{ $helpLink->links }}" frameBorder="0"
                        style="position:absolute;width:100%;height:100%;border-radius:6px;left:0;top:0"
                        allowfullscreen="" allow="autoplay">
                    </iframe>
                </div>
                <form action="{{ route('admin.helpvideo.update',$helpLink->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Video Url</label>
                        <input type="url" class="form-control" placeholder="Enter link" name="video_url"
                            value="{{ $helpLink->links }}" id="video_url" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                @else
                <form action="{{ route('admin.helpvideo.save') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="name" value="{{ $type }}">
                    <div class="form-group">
                        <label>Video Url</label>
                        <input type="url" class="form-control" placeholder="Enter link" name="video_url" value=""
                            id="video_url" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
{{--End Modal on 31-08-2023--}}