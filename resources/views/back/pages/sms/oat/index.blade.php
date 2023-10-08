@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        #hidden_div {
            display: none;
        }

        .colored-toast.swal2-icon-success {
            background-color: #a5dc86 !important;
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
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">SMS</li>
                                <li class="breadcrumb-item active">Bulk SMS</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            <i class="fas fa-edit"></i> Compose Message

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
                            <form method="post" action="{{ route('admin.one-at-time.details') }}"
                                  enctype="multipart/form-data" id="submitForm">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text"><i
                                                        class="fas fa-mobile text-warning"></i></label>
                                            </div>
                                            <select class="custom-select" id="senderNumber" required
                                                    name="sender_market">
                                                <option value="">Sender's Market</option>
                                                @foreach($markets as $market)
                                                    @if($market->numbers()->count()>0)
                                                    <option
                                                        value="{{ $market->id }}">{{ $market->name }} -Available Sends: {{ $market->totalSends() -  $market->availableSends() }} </option>
                                                    @endif
                                                        @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">Select Contact List</label>
                                            </div>
                                            <select class="custom-select" name="group" id="groupSelectBox">
                                                <option value="0">Select Contact List.....</option>
                                                @foreach($groups as $group)
                                                    <option value="{{ $group->id }}">{{ $group->name }} - Not Sent: {{ $group->getMessageNotSentCount() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <label>Template Category</label>
                                    <select class="custom-select" name="category" id="messageType" required>
                                        <option value="">Select Template Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary" >Send
                                    SMS</button>
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
    <script src="{{ asset('uploads/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>
   {{-- <script>
        function showDiv(divId, element) {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }

        function showDivContact() {
            bulk_id = document.getElementById("bulk_select").value;
            if (bulk_id == 1) {
                document.getElementById('hidden_div_multiple_contacts').style.display = 'block';
                document.getElementById('hidden_div_contacts_group').style.display = 'none';
            } else if (bulk_id == 2) {
                document.getElementById('hidden_div_multiple_contacts').style.display = 'none';
                document.getElementById('hidden_div_contacts_group').style.display = 'block';
            } else {
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
        let contactIdBox = $("#groupSelectBox")
        let dataBox = $('#groupNumbers');

        $(document).ready(function () {
            contactIdBox.on('change', function () {
                getData();
            })
        })

        function getData() {
            if (contactIdBox.value == 0) {
                document.getElementById('hidden_div_contacts_group_numbers').style.display = 'none';
            } else {
                let id = contactIdBox.val()
                $.ajax({
                    url: `/admin/group/${id}`,
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function (response) {
                        let data = response.data
                        if (response.success) {
                            data.forEach(element => {
                                dataBox.append(`<option value="${element.number}">${element.name} - ${element.number}</option>`)

                            })
                        }

                    }
                })

                document.getElementById('hidden_div_contacts_group_numbers').style.display = 'block';
            }
        }
    </script>
    <script>
        function setTextareaValue(id) {
            if (id > 0) {
                axios.get('/admin/template/' + id)
                    .then(response =>
                        document.getElementById("template_text").value = response.data['body'],
                    )
                    .catch(error => console.log(error));
            } else {
                document.getElementById("template_text").value = '';
            }
        }

        const textarea = document.querySelector('textarea')
        const count = document.getElementById('count')
        textarea.onkeyup = (e) => {
            count.innerHTML = "Characters: " + e.target.value.length + "/160";
        };
    </script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        })

        function submitData() {
            let number = $('#groupNumbers').val();
            let senderNumber = $('#senderNumber').val();
            let messageBody = $('#template_text').val();
            let mediaFile = $('#mediaFile').val();

            let data = {
                receiver_number: number,
                sender_number: senderNumber,
                message: messageBody,
                media_file: mediaFile,
            }
            if (number != 0 && senderNumber != "" && messageBody != "") {
                axios.post('/admin/one-at-time/', data)
                    .then(response => {
                            if (response.data.status == 200) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Success'
                                })
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Error!'
                                })
                            }
                        }
                    )
                    .catch(error => console.log(error));
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Fields Cannot be Empty!'
                })
            }

        }


    </script>--}}

@endsection
