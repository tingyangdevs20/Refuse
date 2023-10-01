@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    
@endsection
@section('content')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">

                        <h4 class="mb-0 font-size-18">Source List</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Lead Generation </li>
                                <li class="breadcrumb-item active">Source List</li>
                            </ol>
                        </div>
                    </div>
                    <div class="ct_message_text">
                       
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            How To Source A List
                            
                           
                            
                            <button class="btn btn-outline-primary btn-sm float-right" title="helpModal" data-toggle="modal"
                                    data-target="#helpModal">How to use</button>

                        </div>
                    </div>
                    <link href="https://widget.groovevideo.com/widget/app.css" rel="stylesheet"><groovevideo-widget id="220865" permalink="YTQTSyJxr36QdX94aRh6"></groovevideo-widget><script src="https://widget.groovevideo.com/widget/app.js"></script>
                    <br/>

                    <div style="font-size:18px;margin-top:10px;font-weight:bold;text-align:center">To signup for a PropStream account, please click here to get a 7 day free trial.</div>
                    </div>

                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    {{--Modal Add on 31-08-2023--}}
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">How to Use</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
     
      <div class="modal-body">
            
        <div style="position:relative;height:0;width:100%;padding-bottom:65.5%">
         <iframe src="{{ helpvideolink()->links }}" frameBorder="0" style="position:absolute;width:100%;height:100%;border-radius:6px;left:0;top:0" allowfullscreen="" allow="autoplay">
         </iframe>
        </div>
        <form action="{{ route('admin.helpvideo.updates',helpvideolink()->id) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
            <div class="form-group">
                <label>Video Url</label>
                <input type="url" class="form-control" placeholder="Enter link" name="video_url" value="{{ helpvideolink()->links }}" id="video_url" >
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
    {{--End Modal on 31-08-2023--}}
@endsection
