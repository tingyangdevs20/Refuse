@extends('back.inc.master')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                                    <h4 class="mb-0 font-size-18">Lists</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                            <li class="breadcrumb-item">Lead Generation</li>
                                            <li class="breadcrumb-item active">Lists</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-soft-dark ">
                                        All Lists
                                        <button class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal" data-target="#newModal"><i class="fas fa-plus-circle"></i></button>
                                        <a href="{{ asset('uploads/examplenew.csv') }}" download class="btn btn-success btn-sm float-right mr-3" ><i class="fas fa-download"></i> Download Sample</a>
                                        <a href="{{ url('admin/group-contacts-all') }}" class="btn btn-warning btn-sm float-right mr-3" ><i class="fas fa-eye"></i> View All Contacts</a>
                                        <button class="btn btn-outline-primary btn-sm float-right mr-2" title="helpModal" data-toggle="modal"
                        data-target="#helpModal">How to Use</button>  
                        @include('components.modalform')

                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">List Name</th>
                                                    <th scope="col">Numbers</th>
                                                    <th scope="col">Market</th>
                                                    <th scope="col">Tag</th>
                                                    <th scope="col">Campaign</th>
                                                    <th scope="col">Created At</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($groups as $group)
                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ $group->name }}</td>
                                                <td><a href="{{ route('admin.group.show',$group->id) }}" id="trigger-startup-button">View Contacts</a></td>
                                                <td>{{ $group->market_id }}</td>
                                                <td>{{ $group->tag_id }}</td>
                                                <td>{{ $group->campaign_id }}</td>
                                                <td>{{ $group->created_at->format('j F Y') }}</td>
                                                <td><button class="btn btn-outline-danger btn-sm" title="Remove {{ $group->name }}" data-id="{{ $group->id }}" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-times-circle"></i></button></td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
            {{--Modals--}}
            {{--Modal New--}}
            <div class="modal fade" id="newModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.opt.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                <select class="from-control" style="width: 100%;" required id="optiontype" name="optiontype">
                                        <option value="0">Select Option</option>
                                            <option value="new">Create New List</option>
                                            <option value="update">Update Existing List</option>
                                    </select>
                                </div>
                                <div class="form-group" id="new_user">
                                    <label style="margin-right:50px">List Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter List Name" required>
                                </div>

                                <div class="form-group" id="existing_user">
                                <select class="from-control" style="width: 100%;" id="existing_group_id" name="existing_group_id">
                                        <option value="0">Select Existing List</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="file" required>
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <div class="form-group">
                                    <label>Select Campaign</label>
                                    <select class="custom-select" name="campaign_id" id="campaign_id">
                                        <option value="0">Select Campaign</option>
                                        @if(count($campaigns) > 0)
                                            @foreach($campaigns as $campaign)
                                                <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group pt-2">
                                    <label>Market</label><br>
                                    <select class="from-control" style="width: 100%;" id="market" name="market_id" required>
                                        <option value="">Select Market</option>
                                        @foreach($markets as $market)
                                            <option value="{{ $market->id }}">{{ $market->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group pt-2">
                                    <label>Select Tag</label><br>
                                    <select class="from-control" style="width: 100%;" id="tag" name="tag_id" required>
                                        <option value="">Select Tag</option>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{--End Modal New--}}


            {{--Modal Delete--}}
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.group.destroy','test') }}" method="post" id="editForm">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                <div class="modal-body">
                                    <p class="text-center">
                                        Are you sure you want to delete this?
                                    </p>
                                    <input type="hidden" id="id" name="id" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{--End Modals--}}
                @endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script >

        $(document).ready(function() {
            $('#datatable').DataTable();

            const csrfToken = $('meta[name="csrf-token"]').attr('content');

             // Handle when the "Skip Trace" button is clicked
             $('.skip_trace_option').on('change', function () {

                var selectedOption = $(this).val();
                if (selectedOption) {

                    var groupId = $(this).data('group-id');
                    var firstName = $(this).data('group-name');
                    var lastName = $(this).data('group-lastname');
                    var mailingAddress = $(this).data('group-email')

                    // Make an AJAX request to perform skip tracing
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.skip-trace') }}', // Define the skip tracing route
                        data: {
                            _token: '{{ csrf_token() }}',
                            group_id: groupId,
                            first_name: firstName,
                            last_name: lastName,
                            mailing_address: mailingAddress,
                            skip_trace_option: selectedOption,
                        },
                        success: function (response) {

                            console.log('response',response);
                            // Check if the API response indicates success (you may need to adjust this condition)
                            if (response.Status === true && response.header.Status === 0) {
                                // Iterate through the 'Data' array in the response and display each entry using Toastr
                                response.ResponseDetail.Data.forEach(function (dataEntry) {
                                    var fullName = dataEntry.FirstName + ' ' + dataEntry.LastName;
                                    var address = dataEntry.Address + ', ' + dataEntry.City + ', ' + dataEntry.Zip;
                                    var email = dataEntry.Email;

                                    // Customize the Toastr message based on your requirements
                                    toastr.success('Full Name: ' + fullName + '<br>Address: ' + address + '<br>Email: ' + email, 'API Response', {
                                        timeOut: 10000, // Set the duration (5 seconds in this example)
                                    });
                                });

                               

                            } else {
                                // Display an error message using Toastr for failed API responses
                                toastr.error('API Error: ' + response.Message, 'API Response Error', {
                                    timeOut: 9000, // Set the duration (5 seconds in this example)
                                });
                            }
                        },
                        error: function (error) {
                            // Handle AJAX errors here and display using Toastr if needed
                            toastr.error('AJAX Error: ' + error.statusText, 'AJAX Error', {
                                timeOut: 9000, // Set the duration (5 seconds in this example)
                            });
                        }
                    });
                }
            });

            // push to
            $('.push-to-campaign').click(function () {
                var groupId = $(this).data('group-id');
                var groupName = $(this).data('group-name');



                // AJAX request to push data to the campaign table
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.push-to-campaign') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        group_id: groupId,
                        group_name: groupName,
                    },
                    success: function (data) {
                        // Handle success response
                        if (data.success) {
                            toastr.success('Data pushed to campaign successfully.', {
                                    timeOut: 9000, // Set the duration (5 seconds in this example)
                            });
                        } else {
                            toastr.error('Data already exists.', {
                                    timeOut: 9000, // Set the duration (5 seconds in this example)
                            });
                        }
                    },
                    error: function (error) {
                        toastr.error('AJAX Error: Name filed not found', {
                                timeOut: 9000, // Set the duration (5 seconds in this example)
                        });
                    }
                });
            });
        } );
    </script>
    <script >
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });

        $("#optiontype").change(function(){
        var selectedValue = $(this).children("option:selected").val();
            if(selectedValue == 'new'){
                $('#existing_user').hide();
                $('#new_user').show();
            }else{
                $('#new_user').hide();
                $('#existing_user').show();
            }
        });
    </script>
    <script>

    </script>
    @endsection