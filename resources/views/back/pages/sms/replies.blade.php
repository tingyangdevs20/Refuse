@extends('back.inc.master')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
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
                        <h4 class="mb-0 font-size-18">Replies</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item">Conversations</li>
                                <li class="breadcrumb-item active">Replies To {{ $sms->client_number }}</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-soft-dark ">
                           @if(strlen($number)>0)
                            <span
                                class="float-lg-right" style="display:none">Available Sends: {{$number ? $number->sms_allowed - $number->sms_count :''}}</span>
                                @endif
                               @if(!empty($smsInfo)&&$smsInfo->is_dnc!=1)
                                <form action="{{ route('admin.sms.add-to-dnc') }}" class="mt-2" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="number" value="{{ $smsInfo->number }}">
                                    <label for="">Lead Category:</label>
                                        <select class="from-control" id="lead" name="lead_id"
                                                required>
                                            <option value="">Select Lead Category</option>
                                            @foreach($leadCategories as $lead)
                                                <option value="{{ $lead->id }}" {{ $sms->lead_category_id==$lead->id?'selected':'' }} >{{ $lead->title }}</option>
                                            @endforeach
                                        </select>
                                    <button class="btn btn-success btn-sm" style="background-color:#556ee6;" type="submit">Change</button>
                                </form>
                               
                                   @endif
                                   @if($smsInfo!=null)
                           <div style="margin-left:360px;margin-top: -24px;">
                          <span style="font-size: 14px;font-weight: bold;"> Chat Using Number: </span>
                          @if(strlen($number)>0) <span style="margin-left:5px;">{{$number->number}}</span>@elseif(strlen($number)==0) <span style="margin-left:5px;color:red">Invalid Twilio Number</span>   @endif
                          <span style="font-size: 14px;font-weight: bold;margin-left:5px">With </span> <span style="margin-left:10px"><i class="fa fa-phone" aria-hidden="true"></i>
 <a href="" style="color:#black">{{ $sms->client_number }} </a></span>    <span style="margin-left:50px"><i class="fa fa-envelope" aria-hidden="true"></i>
{{ $smsInfo->email1}}</span>
                       
                       @endif

                      <a style="float:right" href="/admin/contact.detail/224" target="_blank"> View Contact Details</a>
</div>
                        </div>
                        @if(strlen($number)>0)
                        <div class="card-body">
                            <div class="d-lg-flex">
                                <div class="w-100 user-chat">
                                    <div class="card">
                                        <div>
                                            <div class="chat-conversation p-3">
                                                <ul class="list-unstyled" data-simplebar style="max-height: 470px;">

                                                   

                                                    
                                                   <!-- @foreach($sms->replies()->get() as $reply)
                                                    <li class="{{ $reply->system_reply?'right':'' }}">
                                                            <div class="conversation-list">
                                                                <div
                                                                    class="ctext-wrap  {{ $reply->system_reply?'text-primary':'text-success' }}">
                                                                    <p style="font-size: larger">
                                                                        {{ $reply->reply }}
                                                                    </p>
                                                                    <p class="chat-time mb-0"><span style="color:#34c38f;padding-right:5px">{{ $reply->type }}</span><i
                                                                            class="bx bx-time-five align-middle mr-1"></i> {{ $reply->created_at }}
                                                                    </p>
                                                                </div>

                                                            </div>
                                                        </li>
                                                    @endforeach-->
                                                    @foreach($conversations as $conversation)
                                                    <li class="{{ $reply->system_reply?'right':'' }}">
                                                            <div class="conversation-list">
                                                                <div
                                                                    class="ctext-wrap  {{ $reply->system_reply?'text-primary':'text-success' }}">
                                                                   
                                                                   @if($conversation->is_read==0)
                                                                    <p style="font-size: larger;font-weight:bold">
                                                                        {!!nl2br(e($conversation->body_text))!!}
                                                                    </p>
                                                                    @else
                                                                    <p style="font-size: larger;">
                                                                        {!!nl2br(e($conversation->body_text))!!}
                                                                    </p>
                                                                    @endif
                                                                    <p class="chat-time mb-0"><span style="color:#afafaf;padding-right:5px">{{ $conversation->conv_type }}</span><i
                                                                            class="bx bx-time-five align-middle mr-1"></i> {{ $conversation->received_on }}
                                                                    </p>
                                                                   
                                                                </div>
                                                                <p style="float:right;color:#bfbfcf"><i class="fa fa-reply" aria-hidden="true"></i><a href="#" style="text-decoration:none;margin-left:2px;color:#bfbfcf">Reply</a>
                          </p>

                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <form action="{{ route('admin.reply.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="sms_id" value="{{ $sms->id }}">
                                                <input type="hidden" name="to" value="{{ $sms->client_number }}">
                                                <input type="hidden" name="from" value="{{ $sms->client_number }}">
                                                <input type="hidden" name="twilio_number"
                                                       value="{{ $sms->twilio_number }}">
                                                <div class="p-3 chat-input-section">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="position-relative" style="display:none">
                                                                @foreach($quickResponses as $quickResponse)
                                                                    <button class="btn btn-primary btn-sm"
                                                                            onclick="getValue({{ $quickResponse->id }});return false;">{{ $quickResponse->title }}</button>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="p-3 chat-input-section">
                                                    <div class="row" style="display:block">
                                                        <div class="col">
                                                            <div class="position-relative">
                                                                
                                                                </div>
                                                                </div>
                                                                </div>
                                                                <div class="row">
                                                                <div class="col">
                                                                <div class="position-relative">
                                                               
                                                                </div>
                                                                </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div>
                                                                    <select class="form-control" style="margin-bottom:20px;width:150px">
                                                                    <option>Message Type</option>
                                                                   <option>SMS</option>
                                                                    <option>MMS</option>
                                                                     <option>Email</option>
                                                               </select>
</div>
                                                        <div class="col">
                                                       
                                                            <div class="position-relative">
                                                            
                                                                <textarea style="width:100%;border-width:1px;border-color:#efefef" rows="6" class="form-control"
                                                                       id="replyArea" name="reply"
                                                                       placeholder="Enter Message..." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                       
                                                            <button type="submit"
                                                                    class="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light" {{ $number->sms_allowed == $number->sms_count?'disabled':'' }} {{ $smsInfo->is_dnc?'disabled':'' }}>
                                                                <span class="d-none d-sm-inline-block mr-2">Send</span>
                                                                <i class="mdi mdi-send"></i></button>
                                                              
                                                               
                                                              
                                                                 
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if(strlen($smsInfo)>0)
                                                   @elseif($smsInfo->is_dnc==1)
                                                <div class="p-3 chat-input-section">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="position-relative">
                                                                <span style="color:red">You can not conversate as this contact is in block list.</span>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                  @endif
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
        $(document).ready(function () {
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
                    success: function (response) {
                        document.getElementById("replyArea").value = response.body
                    }
                })
            } else {
                document.getElementById("replyArea").value = '';
            }
        }
    </script>

@endsection
