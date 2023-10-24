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
                                    <h4 class="mb-0 font-size-18">Send SMS</h4>
                                   
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        <i class="fas fa-edit"></i> Compose Message
                                    </div>
                                    <div class="card-body">


                                        <form action="{{ route('admin.single-sms.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="Reiepient's Number" name="receiver_number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text"><i class="fas fa-mobile text-warning"></i></label>
                                                        </div>
                                                        <select class="custom-select" required="" name="sender_number">
                                                            <option value="">Sender's Number</option>
                                                            @foreach($numbers as $number)
                                                            <option value="{{ $number->number.'|'.$number->account->account_id.'|'.$number->account->account_token }}">{{ $number->number }} - {{ $number->account->account_name }} - Available Sends: {{ $number->sms_allowed - $number->sms_count }}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Media File (<small class="text-danger">Disregard if not sending MMS</small>)</label>
                                                <input type="file" class="form-control-file" name="media_file">
                                            </div>
                                            <div class="form-group">
                                                <label>Message Type</label>
                                                <select class="custom-select" name="message_type" onchange="showDiv('hidden_div', this)" required>
                                                    <option value="0">Custom Message</option>
                                                    <option value="1">Template Message</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="hidden_div">
                                                <label>Select Template</label>
                                                <select class="custom-select" name="template" id="template-select" onchange="templateId()">
                                                    <option value="0">Select Template</option>
                                                    @foreach($templates as $template)
                                                    <option value="{{ $template->id }}">{{ $template->title }}</option>
                                                        @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group ">
                                                <label >Message</label>
                                                <textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea>
                                                <div id='count' class="float-lg-right">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-2" {{ $number->sms_allowed ==$number->sms_count?'disabled':'' }}>Send SMS</button>
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
    <script >
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
    </script>
    <script>
        function showDiv(divId, element)
        {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }
        function templateId() {
            template_id = document.getElementById("template-select").value;
           setTextareaValue(template_id)
        }
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
