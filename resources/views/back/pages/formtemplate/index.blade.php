@extends('back.inc.master') @section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css"> @endsection
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
              <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard')}}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">Lead Generation</li>
              <li class="breadcrumb-item active">Lists</li>
            </ol>
          </div>
        </div>
        <div class="card">
          <div class="card-header bg-soft-dark "> All Form Template <button
              class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
              data-target="#newModal">
              <i class="fas fa-plus-circle"></i>
            </button>

          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered" id="datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col"> Template Name </th>
                  <th scope="col"> Content </th>
                  <th scope="col"> Status </th>

                  <th scope="col">Created At</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody> @foreach($groups as $group) <tr>
                  <td>{{ $sr++ }}</td>
                  <td>{{ $group->template_name }}</td>

                  <td> @php print_r(substr($group->content,0,40)) @endphp</td>
                  <td> @if($group->status == 0 ) {{'Active'}} @else {{'Deactive'}} @endif </td>
                  <td>{{ $group->created_at }}</td>
                  <td>
                    <button class="btn btn-outline-primary btn-sm edit-template" title="Edit {{ $group->name }}"
                      data-id="{{ $group->id }}" data-toggle="modal" data-target="#editModal{{ $group->id }}">
                      <i class="fas fa-edit"></i>
                    </button>

                    <button class="btn btn-outline-danger btn-sm" title="Remove {{ $group->name }}"
                      data-id="{{ $group->id }}" data-toggle="modal" data-target="#deleteModal{{ $group->id }}">
                      <i class="fas fa-times-circle"></i>
                    </button>
                  </td>

                  <!-- Edit Modal -->

                  {{--Edit Modal New--}}
                  <div class="modal fade" id="editModal{{ $group->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"> Edit Form Template </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{ route('admin.update-form-templates') }}" method="POST"
                          enctype="multipart/form-data">
                          <div class="modal-body"> @csrf @method('POST')

                            <input type="hidden" name="id" value="{{$group->id}}">
                            <div class="form-group">
                              <label style="margin-right:50px">Template Name</label>
                              <input type="text" class="form-control" name="template_name"
                                placeholder="Enter Template Name" required value="{{$group->template_name}}">
                            </div>

                            <div class="form-group pt-2">
                              <label> Template Content </label>
                              <br>
                              <textarea class="form-control ckeditor" style="width: 100%;" id="market" name="content"
                                required> {{$group->content}} </textarea>
                            </div>

                            <div class="form-group pt-2">
                              <label>Status</label>
                              <br>
                              <select class="form-control" name="status" required>
                                <option value="">Select Status</option>
                                <option value="0" @if($group->status==0){{'selected'}} @endif > Active </option>
                                <option value="1" @if($group->status==1){{'selected'}} @endif > Deactive </option>
                              </select>
                            </div>

                            <div class="form-group pt-2">
                              <label>Sortcode For Variables</label>
                              <br>
                              {name}, {street}, {city}, {state}, {zip}
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  {{--End Modal New--}}

                  <!-- End Edit Modal -->

                  {{--Modal Delete--}}
                  <div class="modal fade" id="deleteModal{{ $group->id }}" tabindex="-1" role="dialog"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Delete List</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{ route('admin.delete-form-templates' ) }}" method="post" id="editForm">
                          @method('POST') @csrf <div class="modal-body">
                            <div class="modal-body">
                              <p class="text-center"> Are you sure you want to delete this? </p>
                              <input type="hidden" id="id" name="id" value="{{ $group->id }}">
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
                  {{--End Modal Delete--}}

                </tr> @endforeach </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->
  </div>
  <!-- container-fluid -->
</div>
<!-- End Page-content -->
{{--Modals--}}
{{--Modal New--}}
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> New Template </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.form-templates-store') }}" method="POST" enctype="multipart/form-data">
        <div class="modal-body"> @csrf @method('POST')

          <div class="form-group">
            <label style="margin-right:50px">Template Name</label>
            <input type="text" class="form-control" name="template_name" placeholder="Enter Template Name" required>
          </div>

          <div class="form-group pt-2">
            <label> Template Content </label>
            <br>
            <textarea class="form-control ckeditor" style="width: 100%;" id="market" name="content"
              required> </textarea>
          </div>

          <div class="form-group pt-2">
            <label>Status</label>
            <br>
            <select class="form-control" name="status" required>
              <option value="">Select Status</option>
              <option value="0" checked> Active </option>
              <option value="1"> Deactive </option>
            </select>
          </div>
          <div class="form-group pt-2">
            <label>Sortcode For Variables</label>
            <br>
            {name}, {street}, {city}, {state}, {zip}
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

{{--End Modals--}} @endsection @section('scripts') <script
  src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable();
  });
</script>
<script>
  $('#deleteModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(id);
  });
</script>
<script></script>
<!-- Sachin 08-09-2023 -->

<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>


@endsection