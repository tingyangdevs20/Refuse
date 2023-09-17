document.onreadystatechange = function(e) {
    if (document.readyState === 'complete') {
        // console.log("hi, inside document.onreadystatechange function");
        if (!window.jQuery) {
            // console.log('jQuery is not loaded');
            loadScript("https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js", loadChatWindow);
            // console.log('JQuery is added now');
        } else {
            // console.log('JQuery is already loaded');
        }
    }
}
window.onload = function(e) {
    // console.log("hi, inside window.onload function");
}

function loadStyle(url) {
    var link = document.createElement("link")
    link.type = 'text/css'
    link.rel = "stylesheet";

    if (link.readyState) {
        link.onreadystatechange = function() {
            if (link.readyState == "loaded" ||
                link.readyState == "complete") {
                link.onreadystatechange = null;
            }
        };
    } else {
        link.onload = function() {

        };
    }
    link.href = url;
    document.getElementsByTagName("head")[0].appendChild(link);
}

function loadScript(url, callback) {

    var script = document.createElement("script")
    script.type = "text/javascript";

    if (script.readyState) { //IE
        script.onreadystatechange = function() {
            if (script.readyState == "loaded" ||
                script.readyState == "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {
        script.onload = function() {
            callback();
        };
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}
var loadChatWindow = function() {
    
    if (typeof($.fn.popover) != 'undefined') {
      //  console.log("bootstrap is already loaded");
    } else {
        //console.log("bootstrap is not loaded");
        loadStyle("style.css");
        //console.log("bootstrap is added dynamially");
    }
    // --------- Start Chat Window HTML -------------//
    var chatWindowHTML = `<div class="main-parent-box">
      <div class="gl-open-chat-box">
        <i class="fa fa-times close-icon" aria-hidden="true"></i>
      <h3>Hi There</h3>
      <p>We are here to help. </p>
      
      <input class="chat-user-info visitor-name" type="text" name="name" placeholder="Please enter your name" />
      <input class="chat-user-info visitor-email" type="text" name="email" placeholder="Please enter your Email" />
      
      <button type="button" class="btn btn-danger">Satrt Chating</button>
    </div>
    <div class="open-box-footer">
        <img src="https://images.unsplash.com/photo-1534135954997-e58fbd6dbbfc?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=02d536c38d9cfeb4f35f17fdfaa36619" width="30" height="30" />
        <img src="https://images.unsplash.com/photo-1534135954997-e58fbd6dbbfc?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=02d536c38d9cfeb4f35f17fdfaa36619" width="30" height="30" />
      </div>
    </div>

    <div class="gl-chat-box" style="display:none" >
      <div class="chat-box-header">
        <h3>Support Chat<br /><small>Last active: 10 min ago</small></h3>
      </div>
      <div id="chat_box_body" class="chat-box-body">
        <div id="chat_messages">
            <div class="gl-chat-suggestions">
                <ul>
                    <li>Need help with new account setup.</li>
                    <li>Unable to login.</li>
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
    `;

    var session = function() {
        // Retrieve the object from storage
        if(sessionStorage.getItem('session')) {
            var retrievedSession = sessionStorage.getItem('session');
        } else {
            // Random Number Generator
            var randomNo = Math.floor((Math.random() * 1000) + 1);
            // get Timestamp
            var timestamp = Date.now();
            // get Day
            var date = new Date();
            var weekday = new Array(7);
            weekday[0] = "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";
            var day = weekday[date.getDay()];
            // Join random number+day+timestamp
            var session_id = randomNo+day+timestamp;
            // Put the object into storage
            sessionStorage.setItem('session', session_id);
            var retrievedSession = sessionStorage.getItem('session');
        }
        return retrievedSession;
        // console.log('session: ', retrievedSession);
    }

    // Call Session init
    var mysession = session();
    console.log(mysession);
    setInterval(function () {
        getMessagesFromServer(mysession);
    }, 10000);


    
    // ---------End Chat Window HTML -------------//
    setTimeout(function() {
        $("body").append(chatWindowHTML);
    }, 1000);

    var chatInput = $('#chat_input');
    var typing = $('#typing');
    var send = $('#gl-send');

    var chatMessages = $('#chat_messages');
    var chatBoxBody = $('#chat_box_body');
    var chatThread = [];


    chatInput.on('input', function() {
        $(this).css('height', '0');
        $(this).css('height', this.scrollHeight + 1 + 'px');
    });

    $(document).on("keydown", "#chat_input", function(evt) {
        if (evt.keyCode == 13 && !evt.shiftKey) {
            sendMessage('my', this);
            evt.preventDefault();
        }
    });

    $(document).on("click", "#gl-send", function(evt) {
        sendMessage('my', $('#chat_input').val());   
        evt.preventDefault();   
    });

    function renderProfile(p) {
        return '<div class="profile ' + p + '-profile hide"></div>';
    }
    function renderMessage(p, m) {
        return '<div class="message ' + p + '-message hide">' + m + '</div>';
    }
    function appendMessage(r) {
        $('#chat_messages').append(r);

        var elms = $('.profile.hide, .message.hide');

        elms.each(function() {
            if ($(this).hasClass('profile')) {
                $(this).css('height', $(this).prop('scrollHeight') + 'px');
            } else {
                $(this).css('height', $(this).prop('scrollHeight') - 20 + 'px');
            }

            $(this).removeClass('hide');
        });

        $('#chat_box_body').scrollTop($('#chat_box_body').prop('scrollHeight'));
    }
    function getMessagesFromServer(mysession){
        console.log("Calling api to get new messages every 10 seconds");
        console.log(mysession);
    }
    function sendUserText(text) {
        console.log("sending api for "+text +" - "+ mysession)
        // $.ajax({
        //     type: "POST",
        //     url: "API URL",
        //     contentType: "application/json",
        //     dataType: "json",
        //     success: function(data) {
        //         console.log (data);
        //     },
        //     error: function(e) {
        //         console.log (e);
        //     }
        // });
    }
    function sendMessage(p, chatText) {

        if( chatText == ''){
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

        sendUserText( $('#chat_input').val() ); 
        $('#chat_input').val('');
        appendMessage(r);

        if( chatThread.length == 2 ){
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

    $(document).on("click", ".gl-chat-suggestions li", function() {
        $('.gl-chat-suggestions').hide();
        sendMessage('my', $(this).text());
    });
    $(document).on("click", ".gl-open-chat-box button", function() {
        $(this).closest('.main-parent-box').fadeOut();
        $('.gl-chat-box').fadeIn();
        var name = $('.chat-user-info.visitor-name').val();
        var email = $('.chat-user-info.visitor-email').val();
        sendMessage("other","Hi "+ name );
    });


}