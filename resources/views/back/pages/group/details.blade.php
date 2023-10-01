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
                                        All Numbers 
                                        <span><select onchange="delete_selected(this)">
                                            <option value="0">Action</option>
                                            <option value="1">Delete Selected</option>
                                            
</select></span>
                                        <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal" data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                            <tr>
                                                <th scope="col"><input onclick="allSelected()" type="checkbox"/></th> 
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Street</th>
                                                <th scope="col">City</th>
                                                <th scope="col">State</th>
                                                <th scope="col">Zip</th>
                                                <th scope="col">Numbers</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">No. Of Tags</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                
                                            @foreach($group->contacts()->get() as $contact)
                                            <tr>
                                                 <td><input id="chk{{ $contact->id }}" class="jpCheckbox" type="checkbox"/></td> 
                                                <td><a href="{{ route('admin.contact.detail',$contact->id) }}">{{ $contact->name }}</a></td>
                                                <td><a href="{{ route('admin.contact.detail',$contact->id) }}">{{ $contact->last_name }}</a></td>
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
                                                <td>
                                                    Tags:{{ $group->getContactCountByEmailId($contact->email1,$contact->email2,$contact->number,$contact->number2,$contact->number3 ) }}<br>
                                    
                                                </td>
                                                <td>
                                                    {{ $contact->sts }}<br>
                                                    
                                                </td>
                                                <!-- <td>
                                                    <a id="button-call" href="javascript:void(0)" phone-number="{{ $contact->number }}">
                                                        <i class="fas fa-phone whatsapp-icon"></i>
                                                    </a>
                                                    <button id="button-hangup-outgoing" class='d-none fas fa-phone whatsapp-icon hangupicon'></button>
                                                </td> -->
                                          
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                    </div> <!-- container-fluid -->
                    
    
   



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

    <!-- Call Initiated Successfully Modal -->
    <div class="modal fade" id="initiate-call" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content mt-2">
                <div class="modal-body">
                    <p class="calling-response" style="text-align: center;color: green; font-size: 16px;" aria-hidden="true"></p>
                </div>
                
                </div>
            </div>
    </div>
                @endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script src="{{ asset('uploads/sweetalert2.all.min.js') }}"></script>


    <script >
        $(document).ready(function() {
            $('#datatable').DataTable({

                'columnDefs': [{
         
         'render': function (data, type, full, meta){
             return '<input type="checkbox" name="id[]" value="">';
         }
      }],
            }


            );
        } );

        var isChecked = false;

        function allSelected() 
        {
           
            // this line is for toggle the check
            isChecked = !isChecked;

            //below line refers to 'jpCheckbox' class
            $('input:checkbox.jpCheckbox').attr('checked',isChecked);

            //OR,
            //$('input:checkbox.jpCheckbox').attr('checked','checked');
        }

        function delete_selected(ctrl)
        {
            var array = [];
           // alert(ctrl.value);
           if(ctrl.value!="0")
           {
            
            $("input:checkbox[name=type]:checked").each(function() {
                array.push($(this).val());
            });

           
            
        }
        }
    </script>

    @endsection