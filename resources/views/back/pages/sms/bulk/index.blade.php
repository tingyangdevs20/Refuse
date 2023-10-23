@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        #hidden_div {
            display: none;
        }
        #hidden_div_multiple_contacts {
            display: none;
        }
        #hidden_div_contacts_group{
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
                                    <h4 class="mb-0 font-size-18">Bulk SMS</h4>
                                   
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        <i class="fas fa-edit"></i> Compose Message
                                    </div>
                                    <div class="card-body">


                                        <form action="{{ route('admin.bulk-sms.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <label class="input-group-text"><i class="fas fa-mobile text-warning"></i></label>
                                                            </div>
                                                            <select class="custom-select" required name="sender_number">
                                                                <option value="">Sender's Number</option>
                                                                @foreach($numbers as $number)
                                                                    <option value="{{ $number->number.'|'.$number->account->account_id.'|'.$number->account->account_token }}">{{ $number->number }} - {{ $number->account->account_name }} - Available Sends: {{ $number->sms_allowed - $number->sms_count }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                           <label class="input-group-text">Bulk Type</label>
                                                        </div>
                                                           <select class="custom-select" id="bulk_select" name="bulk_type" onchange="showDivContact()" required>
                                                               <option value="0">Choose...</option>
                                                               <option value="1">Multiple Contacts</option>
                                                               <option value="2">Contact List</option>
                                                           </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group w-100 mt-3" id="hidden_div_multiple_contacts">
                                                <label>Contacts (<small class="text-warning">Enter Contacts Spearated by <b>,</b> [XXX,XXX,XXX] </small>)</label>
                                                <textarea class="form-control" name="receiver_number" id="contacts" cols="10" rows="3">{{ old('receiver_number') }}</textarea>
                                            </div>

                                            <div class="form-group mt-3" id="hidden_div_contacts_group">
                                                <label>List</label>
                                                <select class="custom-select" name="group" >
                                                    <option value="0">Select List.....</option>
                                                    @foreach($groups as $group)
                                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>



                                            <div class="form-group mt-2">
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

                                            <div class="form-group">
                                                <label >Message</label>
                                                <textarea id="template_text" class="form-control"  rows="10" required name="message"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary" {{ $number->sms_allowed ==$number->sms_count?'disabled':'' }}>Send SMS</button>
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
        function showDivContact()
        {
            bulk_id = document.getElementById("bulk_select").value;
            if(bulk_id==1)
            {
                document.getElementById('hidden_div_multiple_contacts').style.display = 'block';
                document.getElementById('hidden_div_contacts_group').style.display = 'none';
            }
            else if(bulk_id==2)
            {
                document.getElementById('hidden_div_multiple_contacts').style.display = 'none';
                document.getElementById('hidden_div_contacts_group').style.display = 'block';
            }
            else
                {
                    document.getElementById('hidden_div_multiple_contacts').style.display = 'none';
                    document.getElementById('hidden_div_contacts_group').style.display = 'none';
                }
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

    </script>
    @endsection
