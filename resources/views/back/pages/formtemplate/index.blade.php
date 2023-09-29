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
              <li class="breadcrumb-item">Settings</li>
              <li class="breadcrumb-item active">Lists</li>
            </ol>
          </div>
        </div>
        <div class="card">
          <div class="card-header bg-soft-dark "> All Digital Signing Template <button
              class="btn btn-outline-primary btn-sm float-right" title="New" data-toggle="modal"
              data-target="#newModal">
              <i class="fas fa-plus-circle"></i>
            </button>

          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered" id="datatable">
              <thead>
                <tr>

                  <th scope="col"> Template Name </th>
                  <th scope="col"> Status </th>

                  <th scope="col">Created At</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody> @foreach($groups as $group) <tr>

                  <td>{{ $group->template_name }}</td>


                  <td> @if($group->status == 0 ) {{'Active'}} @else {{'Deactive'}} @endif </td>
                  <td>{{ $group->created_at }}</td>
                  <td>
                    <button class="btn btn-outline-primary btn-sm edit-template" data-html="{{ $group->content }}" onclick="autofill($(this), '{{ json_encode(['id' => $group->id, 'template_name' => $group->template_name, 'status' => $group->status])}}')"  title="Edit {{ $group->name }}"
                      data-id="{{ $group->id }}" data-toggle="modal" data-target="#editModal">
                      <i class="fas fa-edit"></i>
                    </button>

                    <button class="btn btn-outline-danger btn-sm" title="Remove {{ $group->name }}"
                      data-id="{{ $group->id }}" data-toggle="modal" data-target="#deleteModal{{ $group->id }}">
                      <i class="fas fa-times-circle"></i>
                    </button>
                  </td>

                  <!-- Edit Modal -->

                  {{--Edit Modal New--}}

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

          {{-- <div class="form-group pt-2">
            <label> Template Content </label>
            <br>
            <textarea class="form-control ckeditor" style="width: 100%;" id="market" name="content"
              required> </textarea>
          </div> --}}
        <div class="row">
            <div class="col-8">
                <div class="form-group pt-2">
                    <label> Template Content </label>
                    <br>
                    <textarea class="form-control ckeditor" style="width: 100%;" id="addcontent" name="content"
                        required> </textarea>
                </div>
            </div>
        <div class="col-4">
            <div class="form-group pt-2">
                <label>Insert Short Codes</label>
                <br>
                <select class="form-control insert_code" name="short_code" id="insert_code" data-type = "add">
                    <option value="">Select Code</option>
                    @foreach($short_code as $code)
                        <option value="{{$code}}"> {{$code}} </option>
                    @endforeach
                </select>
            </div>
        </div>
        </div>

          <div class="form-group pt-2">
            <label>Status</label>
            <br>
            <select class="form-control" name="status" required>
              <option value="">Select Status</option>
              <option value="0" selected> Active </option>
              <option value="1"> Deactive </option>
            </select>
          </div>
          <div class="form-group pt-2">
            <label>Sortcode For Variables</label>
            <br>
            {{ '{' . implode('} ,{', $short_code) . '}' }}
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

{{-- Edit Model--}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
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
            <input type="hidden" name="id" id="editrecid">
            <div class="form-group">
              <label style="margin-right:50px">Template Name</label>
              <input type="text" class="form-control" name="template_name" id="edittemplate_name"
                placeholder="Enter Template Name" required>
            </div>

            {{-- <div class="form-group pt-2">
              <label> Template Content </label>
              <br>
              <textarea class="form-control ckeditor" style="width: 100%;" id="editcontent" name="content"
                required> </textarea>
            </div> --}}
            <div class="row">
                <div class="col-8">
                    <div class="form-group pt-2">
                        <label> Template Content </label>
                        <br>
                        <textarea class="form-control ckeditor" style="width: 100%;" id="editcontent" name="content"
                          required> </textarea>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group pt-2">
                        <label>Insert Short Codes</label>
                        <br>
                        <select class="form-control insert_code" name="short_code" id="insert_code" data-type = "update">
                            <option value="">Select Code</option>
                            @foreach($short_code as $code)
                                <option value="{{$code}}"> {{$code}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group pt-2">
              <label>Status</label>
              <br>
              <select class="form-control" name="status" id="editstatus" required>
                <option value="">Select Status</option>
                <option value="0"> Active </option>
                <option value="1"> Deactive </option>
              </select>
            </div>
            <div class="form-group pt-2">
              <label>Sortcode For Variables</label>
              <br>
                {{ '{' . implode('} ,{', $short_code) . '}' }}
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
  {{-- Edit Model end--}}

{{--End Modals--}} @endsection @section('scripts') <script
  src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable();
  });
</script>
<script>
    function autofill(elem, obj){
        var params = JSON.parse(obj);
        $('#editrecid').val(params.id);
        $('#edittemplate_name').val(params.template_name);
        $('#editcontent').html(elem.data('html'));
        CKEDITOR.instances.editcontent.setData(elem.data('html'));
        $('#editstatus').val(params.status);

    }

    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
    });
    $('.insert_code').on('change',function(){
        if($(this).val() != ''){

            if($(this).attr('data-type') == 'add'){
                var text_area_value = CKEDITOR.instances.addcontent.getData();
                text_area_value += ' {'+$(this).val()+'}';
                $(this).closest("form").find("#addcontent").html(text_area_value);
                CKEDITOR.instances.addcontent.setData(text_area_value);
            }else{
                var text_area_value = CKEDITOR.instances.editcontent.getData();
                text_area_value += ' {'+$(this).val()+'}';
                $(this).closest("form").find("#editcontent").html(text_area_value);
                CKEDITOR.instances.editcontent.setData(text_area_value);
            }



            $(this).val('');
        }
    });
</script>
<script></script>
<!-- Sachin 08-09-2023 -->

<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>


@endsection
