<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call with browser</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <form>
        <input type="text" name="phone_number" id="phone_number">
        <input type="hidden" name="identity" id="identity" value="harpreet">
        <input type="button" name="call" id="call" class="call" value="Call">
        <input type="button" name="hang" id="hang" class="hang" value="Hang">
        <!-- <input type="button" name="reject" id="reject" class="reject" value="reject"> -->
    </form>
</body>
<script src="{{ URL('js/twilio.min.js') }}"></script>
<script>
    /*
     *Global variables
     */
    var token, identity, device, call, callerId;

    //script to setup twilio device
    getTwilioAccessToken();

    /**
     * *functions
     */

    //get the twilio access token
    async function getTwilioAccessToken() {
        url = "{{ URL('phone/access-token') }}?identity=" + $('#identity').val();
        try {
            const data = await fetch(url).then(response => response.json());

            //get the token
            window['token'] = data.token;
            //set the identity
            window['identity'] = data.identity;

            //set the calerid  named twilio call number
            window['callerId'] = data.caller_id;

            //Initialising the device
            initializeDevice();
        } catch (error) {
            console.log(error);
        }
    }

    //function to initialze twilio device
    function initializeDevice() {
        //Init Device
        device = new Twilio.Device(token, {
            logLevel: 1,
            codecPreferences: ['opus', 'pcmu'],
            maxCallSignalTimeoutMs: 30000
        });

        //Register Event Listner
        registerPhoneEventListners();

        //register the device
        window['device'].register();
    }

    //function for phone frontend
    function registerPhoneEventListners() {

        //when call button is clicked
        $('.call').on('click', async function() {
            //Get the phone Number to call
            phoneNumberToCall = $('#phone_number').val();

            //Set the twilio parameter up
            var params = {
                To: phoneNumberToCall,
                agent: identity,
                callerId: callerId,
                Location: 'IN',
            };

            if (device) {
                //call the agent/customer
                try {
                    const call = await device.connect(params);
                    window['call'] = call;
                    // Call successfully connected
                } catch (error) {
                    console.error("Error connecting call:", error);
                }

                //onclick of the .hang class
                $('.hang').on('click', function() {

                    //Disconnect the call ---- Hanging the call without end
                    call.disconnect();
                })
            }

        });

        //Register call event listners
        // call.on("disconnect",updateUiDisconnectedOutgoingCall);


        device.on("Incoming", handleIncommingPhoneCall);

    }

    //functiojn to handle the ui 
    function updateUiDisconnectedOutgoingCall() {
        console.log('disconnected by cs');
    }

    //funciton to get inbound call
    function handleIncommingPhoneCall(call) {
        console.log('Inbound call from ' + call.parameters.From);


        //Listen for the reject call
        $(".reject").on('click', function() {
            rejectIncommingcall(call);
        });

        //listen for the incomming call 
        $(".accept").on('click', function() {
            acceptIncomingCall(call);
        })
    }

    //handle incomming call reject
    function rejectIncommingcall(call) {
        //reject call
        call.reject();

        console.log("Incomming call rejected");
    }

    //function to accept incomming call
    function acceptIncomingCall(call) {
        //accept the call
        call.accept();

        console.log("Accepted the incomming");
    }
</script>

</html>
