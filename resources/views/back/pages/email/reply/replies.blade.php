@extends('back.inc.master')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
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
                        <h4 class="mb-0 font-size-18">Email Management</h4>
                        
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                            Chatting With {{ $email->to }}
                        </div>
                        <div class="card-body">
                            <div class="d-lg-flex">
                                <div class="w-100 user-chat">
                                    <div class="card">
                                        <div>
                                            <div class="chat-conversation p-3">
                                                <ul class="list-unstyled" data-simplebar style="max-height: 470px;">
                                                    {{-- Person --}}
                                                    @foreach ($email->replies as $message)
                                                        <li
                                                            class="{{ $message->to == LaravelGmail::user() ? 'left' : 'right' }}">
                                                            <div class="conversation-list">
                                                                <div
                                                                    class="ctext-wrap  {{ $message->to == LaravelGmail::user() ? 'text-success' : 'text-primary' }}">
                                                                    <p style="font-size: larger">
                                                                        {!! gmail_remove_reply_part($message->to, $message->from, $message->reply) !!}
                                                                    </p>
                                                                    <p class="chat-time mb-0"><i
                                                                            class="bx bx-time-five align-middle mr-1"></i>
                                                                        {{ $message->created_at }}
                                                                    </p>
                                                                </div>

                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <form action="{{ route('admin.email-conversations.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="emails_id" value="{{ $email->id }}">
                                                <div class="p-3 chat-input-section">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="position-relative">
                                                                @foreach ($quickResponses as $quickResponse)
                                                                    <button class="btn btn-primary btn-sm"
                                                                        onclick="getValue({{ $quickResponse->id }});return false;">{{ $quickResponse->title }}</button>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="p-3 chat-input-section">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="position-relative">
                                                                <label>Conversation Type</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="position-relative">
                                                                <select class="form-control" style="margin-bottom:20px">
                                                                    <option>SMS</option>
                                                                    <option>MMS</option>
                                                                    <option>Email</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control chat-input"
                                                                    id="replyArea" name="reply"
                                                                    placeholder="Enter Message..." required>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">

                                                            <button type="submit"
                                                                class="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light">
                                                                <span class="d-none d-sm-inline-block mr-2">Send</span>
                                                                <i class="mdi mdi-send"></i></button>


                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>


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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#lead').select2();
        });

        function getValue(id) {
            document.getElementById("replyArea").value = '';
            if (id > 0) {
                $.ajax({
                    url: `/admin/quick-response/${id}`,
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        document.getElementById("replyArea").value = response.body
                    }
                })
            } else {
                document.getElementById("replyArea").value = '';
            }
        }
    </script>
@endsection
