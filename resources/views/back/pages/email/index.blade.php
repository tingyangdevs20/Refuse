@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        #hidden_div {
            display: none;
        }
    </style>
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
                                    <h4 class="mb-0 font-size-18">Email</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                            <li class="breadcrumb-item">SMS</li>
                                            <li class="breadcrumb-item active">Single SMS</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('admin.single-email.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
														<label>Subject:</label>
                                                        <div class="input-group mb-2">
                                                            <input type="text" class="form-control" placeholder="Subject" name="subject">
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-md-6">
                                                    <div class="form-group">
														<label>Send To:</label>
                                                        <input type="text" class="form-control" placeholder="Sender Email" name="send_to">
														<!--<select class="custom-select" required="" name="send_to">
                                                            <option value="">Sender's Email</option>
                                                            @foreach($contact as $contact)
                                                            <option value="{{ $contact->id}}">{{ $contact->email1 }}</option>
                                                                @endforeach
                                                        </select>-->
                                                    </div>
                                                </div>
                                             
                                            </div>
                                            <div class="form-group ">
                                                <label >Message</label>
                                                <textarea id="template_text" class="form-control summernote-usage"  rows="10" required name="message"></textarea>
                                                <div id='count' class="float-lg-right">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-2" >Send Email</button>
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

                @endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<link rel="stylesheet" href="{{asset('/summernote/dist/summernote4.css')}}" />
    <script src="{{asset('/summernote/dist/summernote4.min.js')}}"></script>
    <script >
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
		$(".summernote-usage").summernote({
    	    height: 200,
    	});
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
    </script>
    @endsection
