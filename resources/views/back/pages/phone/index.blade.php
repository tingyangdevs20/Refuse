@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    
    
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
                        <h4 class="mb-0 font-size-18">Phone Numbers</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Lead Generation </li>
                                <li class="breadcrumb-item active">Phone Numbers</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Active Twilio Phone Numbers
                            <button class="btn btn-outline-primary btn-sm float-right" title="New" style="display:none" data-toggle="modal"
                                    data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                                    <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                        data-target="#helpModal">How to use</button>  
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

                        </div>
                        <div class="card-body">
                            @if ($all_phone_nums->isEmpty())
                                <p>No Active Twilio Phone Numbers.</p>
                            @else
                                <table class="table table-striped table-bordered" id="datatable">
                                <thead>
                                <tr>
                                    
                                  
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Capabilities</th>
                                    <th scope="col">Status</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                $count = 1;      
                                @endphp
                                @foreach ($all_phone_nums as $p_num)

                                    <tr>
                                        
                                       
                                        <td>{{ $p_num->number }}</td>
                                        <td>{{ $p_num->capabilities }}</td>
                                       
                                        <td>
                                          
                                            <input data-id="{{$p_num->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $p_num->is_active ? 'checked' : '' }}>
                    
                                            
                                        </td>
                                    </tr>
                                    @php
                                $count++;      
                                @endphp
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container-fluid -->
    </div>
    <script src="{{ asset('back/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
         $('.toggle-class').change(function() { 
            var status = $(this).prop('checked') == true ? 1 : 0;  
           var phn_id = $(this).data('id');  
        let data = {
                phn_id: phn_id,
                sts: status,
               
            }
            
                axios.post('phone/changeStatus', data)
                    .then(response => {
                            if (response.data.status == 200) {
                               //alert("updated");
                            }
                                })
                            
                        }
                    )
                    .catch(error => console.log(error));
            
  
   
</script>
    <!-- End Page-content -->
@endsection
