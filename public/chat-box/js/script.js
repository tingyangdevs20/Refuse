document.onreadystatechange = function (e) {
    if (document.readyState === 'complete') {
        // console.log("hi, inside document.onreadystatechange function");
        if (!window.jQuery) {
            // console.log('jQuery is not loaded');

            //------------SHOW CHAT BOX---------------
          //  loadScript("https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js", loadChatWindow);
            // console.log('JQuery is added now');
        } else {
            //------------SHOW CHAT BOX---------------
           // loadChatWindow()
        }
    }
}
window.onload = function (e) {
    // console.log("hi, inside window.onload function");
}

var siteUrl = "https://brian-bagnall.com/bulk/bulk_sms_new/public"
var baseUrl = `${siteUrl}/api/v1/`
function loadStyle(url) {
    var link = document.createElement("link")
    link.type = 'text/css'
    link.rel = "stylesheet";

    if (link.readyState) {
        link.onreadystatechange = function () {
            if (link.readyState == "loaded" ||
                link.readyState == "complete") {
                link.onreadystatechange = null;
            }
        };
    } else {
        link.onload = function () {

        };
    }
    link.href = url;
    document.getElementsByTagName("head")[0].appendChild(link);
}

function loadScript(url, callback) {

    var script = document.createElement("script")
    script.type = "text/javascript";

    if (script.readyState) { //IE
        script.onreadystatechange = function () {
            if (script.readyState == "loaded" ||
                script.readyState == "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {
        script.onload = function () {
            callback();
        };
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

var loadChatWindow = function () {

    if (typeof ($.fn.popover) != 'undefined') {
        //  console.log("bootstrap is already loaded");
    } else {
        //console.log("bootstrap is not loaded");
        loadStyle("style.css");
        //console.log("bootstrap is added dynamially");
    }
    // --------- Start Chat Window HTML -------------//
    var chatWindowHTML = `
        <div class="main-parent-box" style="display:none">
              <div class="gl-open-chat-box">
               <div class="chat-box-header">
                <h3>Support Chat<br /></h3>
               </div>
              <i class="fa fa-times close-icon" id="close-icon" aria-hidden="true"></i>
              <h3>Hi There</h3>
              <p>We are here to help. </p>
              <p style="color: red;display: none" id="error-message"></p>

              <input class="chat-user-info visitor-name" type="text" name="name" placeholder="Please enter your name" />
              <input class="chat-user-info visitor-email" type="tel" name="number" placeholder="Please enter your phone number" />

              <button type="button" class="btn btn-danger gl-start-chat-btn">Start Chatting</button>
            </div>
<!--              <div class="open-box-footer">-->
<!--&lt;!&ndash;                <img src="https://images.unsplash.com/photo-1534135954997-e58fbd6dbbfc?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=02d536c38d9cfeb4f35f17fdfaa36619" width="30" height="30" />&ndash;&gt;-->
<!--&lt;!&ndash;                <img src="https://images.unsplash.com/photo-1534135954997-e58fbd6dbbfc?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=02d536c38d9cfeb4f35f17fdfaa36619" width="30" height="30" />&ndash;&gt;-->
<!--              </div>-->
        </div>

    <div class="gl-chat-box" style="display:none" >
      <div class="chat-box-header">
        <h3>Support Chat<br /></h3>
      </div>
       <i class="fa fa-times close-icon" id="close-icon" aria-hidden="true"></i>
      <div id="chat_box_body" class="chat-box-body">
        <div id="chat_messages">
            <div class="gl-chat-suggestions">
                <ul>

                </ul>
            </div>
        </div>
      </div>
      <div id="typing">
        <div><span></span> <span></span> <span></span> <span class="n">Someone</span> is typing...</div>
      </div>
      <div class="chat-box-footer">
        <textarea id="chat_input" placeholder="Enter your message here..."></textarea>
        <input class="telephone-input-design" type="tel" id="phone" name="phone" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
        <button id="gl-send">
          <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="#006ae3" d="M2,21L23,12L2,3V10L17,12L2,14V21Z" />
          </svg>
        </button>
      </div>
    </div>
    <div class="message-icon-design" id="min-chat-icon">
       <img src="${siteUrl}/chat-box/img/chat.svg">
   </div>
    `;

    // ---------End Chat Window HTML -------------//
    setTimeout(function () {
        $("body").append(chatWindowHTML);
        const session = function () {
            // Retrieve the object from storage
            if (sessionStorage.getItem('session')) {
                return  sessionStorage.getItem('session');
            }
            return null;
        }

        // // Call Session init
        var currentSession = session();

        if(currentSession) {
            setInterval(function () {
                getMessagesFromServer();
            }, 5000);
        }

        $(document).on("click", "#min-chat-icon", function (evt) {
            if(currentSession){
                getMessagesFromServer()
                // $('.main-parent-box').fadeOut();
                $('.gl-chat-box').fadeIn();
            }else{
                // $('.gl-chat-box').fadeOut();
                $('.main-parent-box').fadeIn();
            }
            console.log('this',this)
            this.style.display='none'
            evt.preventDefault();
        });

        $(document).on("click", "#close-icon", function (evt) {
            $('.gl-chat-box').fadeOut();
            $('.main-parent-box').fadeOut();
            $('#min-chat-icon').fadeIn();
            evt.preventDefault();
        })



        var chatInput = $('#chat_input');
        var typing = $('#typing');
        var send = $('#gl-send');

        var chatMessages = $('#chat_messages');
        var chatBoxBody = $('#chat_box_body');
        var chatThread = [];


        chatInput.on('input', function () {
            $(this).css('height', '0');
            $(this).css('height', this.scrollHeight + 1 + 'px');
        });

        $(document).on("keydown", "#chat_input", function (evt) {
            if (evt.keyCode == 13 && !evt.shiftKey) {
                sendMessage('my', this);
                evt.preventDefault();
            }
        });

        $(document).on("click", "#gl-send", function (evt) {
            sendMessage('my', $('#chat_input').val());
            evt.preventDefault();
        });


        function renderProfile(p) {
            return '<div class="profile ' + p + '-profile hide"></div>';
        }

        function renderMessage(p, m) {
            return '<div class="message ' + p + '-message hide">' + m + '</div>';
        }
        function resetMessageBody(){
            $('#chat_messages').empty();
        }

        function appendMessage(r) {
            $('#chat_messages').append(r);

            var elms = $('.profile.hide, .message.hide');

            elms.each(function () {
                // if ($(this).hasClass('profile')) {
                //     $(this).css('height', $(this).prop('scrollHeight') + 'px');
                // } else {
                //     $(this).css('height', $(this).prop('scrollHeight') - 20 + 'px');
                // }

                $(this).removeClass('hide');
            });

            $('#chat_box_body').scrollTop($('#chat_box_body').prop('scrollHeight'));
        }

        function getMessagesFromServer() {
            $.ajax({
                type: "GET",
                url: baseUrl + `chatroom/${currentSession}/messages`,
                contentType: "application/json",
                dataType: "json",
                success: function(data) {
                    const userType = data.userable_type
                    const userId = data.userable_id
                    const messages = data.messages ?? [];
                    resetMessageBody()
                    for (const message of messages) {
                        const type = userType === message.userable_type && userId === message.userable_id ? 'my':'other';
                        messageHistory(type,message.message_text)
                    }
                },
                error: function(e) {
                    console.log(e,e.status)
                }
            });
            // if(currentSession) {
            //     setInterval(function () {
            //         getMessagesFromServer();
            //     }, 3000);
            // }
        }

        function sendUserText(text) {
            console.log("sending api for " + text + " - " + session())
            $.ajax({
                type: "POST",
                url: baseUrl + `chatroom/${session()}/message/send`,
                contentType: "application/json",
                dataType: "json",
                data:JSON.stringify({text}),
                success: function(data) {

                },
                error: function(e) {
                    console.log(e,e.status)
                }
            });
        }

        function sendMessage(p, chatText) {

            if (chatText == '') {
                return;
            }
            var r = '';

            // if (chatThread[chatThread.length - 1].profile !== p) {
            //     r += renderProfile(p);
            // }
            if (typeof chatText === 'string') {
                r += renderMessage(p, chatText);

                chatThread.push({
                    'profile': p,
                    'message': chatText
                });
            } else {
                r += renderMessage(p, chatText.value);

                chatThread.push({
                    'profile': p,
                    'message': chatText.value
                });
            }

            sendUserText($('#chat_input').val());
            $('#chat_input').val('');
            appendMessage(r);

            if (chatThread.length == 2) {
                var r = '';
                p = 'other';
                chatText = "One of our support person will get back to you shortly.";
                r += renderMessage(p, chatText);
                chatThread.push({
                    'profile': p,
                    'message': chatText
                });
                appendMessage(r);
            }

        }

        function messageHistory(p, chatText) {

            if (chatText == '') {
                return;
            }
            var r = '';

            // if (chatThread[chatThread.length - 1].profile !== p) {
            //     r += renderProfile(p);
            // }
            if (typeof chatText === 'string') {
                r += renderMessage(p, chatText);

                chatThread.push({
                    'profile': p,
                    'message': chatText
                });
            } else {
                r += renderMessage(p, chatText.value);

                chatThread.push({
                    'profile': p,
                    'message': chatText.value
                });
            }
            appendMessage(r);
        }

        $(document).on("click", ".gl-chat-suggestions li", function () {
            $('.gl-chat-suggestions').hide();
            sendMessage('my', $(this).text());
        });
        $(document).on("click", ".gl-open-chat-box button", function () {
            createRoom()
            // $(this).closest('.main-parent-box').fadeOut();
            // $('.gl-chat-box').fadeIn();
            // sendMessage("other", "Hi " + name);
        });

        const createRoom =async ()=>{
            const name = $('.chat-user-info.visitor-name').val();
            const number = $('.chat-user-info.visitor-email').val();
            const errorElm = document.getElementById('error-message')
            errorElm.style.display = 'none';
            if(!name || !number) {
                errorElm.style.display = 'block';
                errorElm.textContent="Oops! Please fill all fields.";
            }

            // let body = new FormData();
            // body.append('name',name)
            // body.append('number',number)
            // let response = await fetch(baseUrl + "chatroom/create", {
            //     method: 'POST',
            //     headers: {
            //         Accept: 'application.json',
            //         'Content-Type': 'application/json'
            //     },
            //     body: body
            // }).then(res => res.json())

            $.ajax({
                type: "POST",
                url: baseUrl + "chatroom/create",
                contentType: "application/json",
                dataType: "json",
                data:JSON.stringify({name,number}),
                success: function(data) {
                    if(data.status){
                        currentSession = data.data.session_id
                        sessionStorage.setItem('session', data.data.session_id);
                        $('.main-parent-box').fadeOut();
                        $('.gl-chat-box').fadeIn();
                    }else{
                        errorElm.style.display = 'block';
                        errorElm.textContent="Oops! Something went wrong.";
                    }
                },
                error: function(e) {
                    if (e.status ===422){
                        errorElm.style.display = 'block';
                        errorElm.textContent="Oops! Please fill all fields.";
                    }else if (e.status === 500) {
                        errorElm.style.display = 'block';
                        errorElm.textContent="Oops! Internal Server Error.";
                    }else if (e.status === 404) {
                        errorElm.style.display = 'block';
                        errorElm.textContent="Oops! Server API not valid.";
                    }
                    console.log(e,e.status)
                }
            });
            // console.log('response',response)


        }
    }, 1000);
}
