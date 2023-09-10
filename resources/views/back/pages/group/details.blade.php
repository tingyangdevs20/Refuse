@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    @endsection
        @section('content')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                         <form id="contact_form" action="{{ route('admin.mailcontactlist') }}" method="post"   class="col-lg-12" />  
                         <!-- oldmailurl working -->
                        <!-- <form id="contact_form" action="{{ url('api/contactmail') }}" method="post" class="col-lg-12" > -->
                        @csrf
                        @method('POST')
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Group Management</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                            <li class="breadcrumb-item">Group Management</li>
                                            <li class="breadcrumb-item active">{{ $group->name }}</li>
                                            <li class="breadcrumb-item active">Numbers</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                    <label> All Numbers </label>
                                    <div class="col-md-3">
                                        <select class="form-control" style="float: left;" id="contracttype" name="contracttype">
                                        <option value="">Select Contract</option>
                                        @foreach($contractres as $value)
                                        <option value="{{ $value->id }}">{{ $value->type_contract }}</option>
                                        
                                        @endforeach
                                        </select>
                                        <span id="errorcontract" style="color:red"></span>
                                    </div>
                                        <a href="{{ route('admin.contractview') }}"><button type="button" class="btn btn-primary" style="float: right;">Contract View</button> </a>

                                      <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal" data-target="#newModal"><i class="fas fa-plus-circle"></i></button>


                                        <button type="submit" class="btn btn-success" name="bulk_delete_submit" class="btn btn-danger btn-fw" style="float: right;">Send Mail</button>


                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                            <tr>
                                                <th>All<input type="checkbox" id="select_all" value=""/></th> 

                                                <th scope="col">#</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Street</th>
                                                <th scope="col">City</th>
                                                <th scope="col">State</th>
                                                <th scope="col">Zip</th>
                                                <th scope="col">Numbers</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Lead Category</th>

                                                <th scope="col">Mail Sent</th>
                                                <th scope="col">Contract Verified</th>

                                                <th scope="col">Message Sent</th>
                                                <th scope="col">DNC</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($group->contacts()->get() as $contact)
                                            <tr>
                                                <td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="{{ $contact->id }}"/></td>
                                                 <td>{{ $sr++ }}</td>

                                                {{-- <td>{{ $sr++ }}</td> --}}
                                                
                                                <td><a href="{{ route('admin.contact.detail',$contact->id) }}">{{ $contact->name }}</a></td>
                                               <td>{{ $contact->last_name }}</td>
                                                <td>{{ $contact->street }}</td>
                                                <td>{{ $contact->city }}</td>
                                                <td>{{ $contact->state }}</td>
                                                <td>{{ $contact->zip }}</td>
                                                <td>
                                                    Number1:{{ $contact->number }}<br>
                                                    Number2:{{ $contact->number2 }}<br>
                                                    Number3:{{ $contact->number3 }}
                                                </td>
                                                <td>
                                                    Email1:{{ $contact->email1 }}<br>
                                                    Email2:{{ $contact->email2 }}
                                                </td>
                                                <td>{{ $contact->getLeadCategory()}}</td>

                                                <td>{{ $contact->mail_sent?"YES":"NO" }}</td>
                                                <td>{{ $contact->contract_verified?"YES":"NO" }}</td>

                                                <td>{{ $contact->msg_sent?"YES":"NO" }}</td>
                                                <td>{{ $contact->is_dnc?"YES":"NO" }}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                          </form>
                        </div>
                        <!-- end page title -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <div class="modal fade" id="newModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.contactlist.store') }}" method="POST" enctype="multipart/form-data" />

                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <input type="hidden"  class="form-control" placeholder="Days" value="{{ $id }}" name="group_id">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter First Name" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" required>
                        </div>
                        <div class="form-group">
                            <label>Street</label>
                            <input type="text" class="form-control" name="street" placeholder="Enter Street" required>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" name="city" placeholder="Enter City" required>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" name="state" placeholder="Enter State" required>
                        </div>
                        <div class="form-group">
                            <label>Zip</label>
                            <input type="text" class="form-control" name="zip" placeholder="Enter Zip code" required>
                        </div>
                        <div class="form-group">
                            <label>Phone 1</label>
                            <input type="text" class="form-control" name="number" placeholder="Enter Phone" required>
                        </div>
                        <div class="form-group">
                            <label>Phone 2</label>
                            <input type="text" class="form-control" name="number2" placeholder="Enter Phone" required>
                        </div>
                        <div class="form-group">
                            <label>Email 1</label>
                            <input type="text" class="form-control" name="email1" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label>Email 2</label>
                            <input type="text" class="form-control" name="email2" placeholder="Enter email" required>
                        </div>
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
                @endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script >
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );

        $(document).ready(function(){
            $("#select_all").click(function(){
                    if(this.checked){
                        $('.checkbox').each(function(){
                            $(".checkbox").prop('checked', true);
                        })
                    }else{
                        $('.checkbox').each(function(){
                            $(".checkbox").prop('checked', false);
                        })
                    }
                });
            });


            $(document).ready(function(){
                $('#contact_form').on('submit', function(e){
                    e.preventDefault();
                    var contracttype = $('#contracttype').val();
                    if(contracttype==''){
                        alert("Select Contract first!");
                        $('select[name^="contracttype"]').eq(1).focus();
                        
                        $('#errorcontract').html("Select Contract first*");
                        return false;
                    }
                    if($(".checkbox")[0].checked==false){
                        alert("Select atleast one contact!");
                        $('.checkbox').eq(1).focus();
                        return false;
                    }
                
                    this.submit();
                });
});
    </script>

    @endsection
