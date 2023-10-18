
    const speakerDevices = document.getElementById("speaker-devices");
    const ringtoneDevices = document.getElementById("ringtone-devices");
    const outputVolumeBar = document.getElementById("output-volume");
    const inputVolumeBar = document.getElementById("input-volume");
    const volumeIndicators = document.getElementById("volume-indicators");
    const outgoingCallHangupButton = document.getElementById("button-hangup-outgoing");
    const callControlsDiv = document.getElementById("call-controls");
    const audioSelectionDiv = document.getElementById("output-selection");
    const getAudioDevicesButton = document.getElementById("get-devices");
    const logDiv = document.getElementById("log");
    const incomingCallDiv = document.getElementById("incoming-call");
    const incomingCallHangupButton = document.getElementById(
      "button-hangup-incoming"
    );
    const incomingCallAcceptButton = document.getElementById(
      "button-accept-incoming"
    );
    const incomingCallRejectButton = document.getElementById(
      "button-reject-incoming"
    );
    const incomingPhoneNumberEl = document.getElementById("incoming-number");
  
    let device;
    let token;
    let callButton;
    let phoneNumberInput;
    let HangupButton;
  
    // Event Listeners
    
    $(document).on("click", "#button-call", function(e){
      callButton = $(this)
      phoneNumberInput = $(this).attr("phone-number")
      HangupButton = $(this).next()
      makeOutgoingCall(phoneNumberInput);
    })

    $(document).on("click", ".ans-call", function(e){
      $('#end-call').show();

      callButton = $(this)
      phoneNumberInput = $("#soft-phone-modal").find('.phone-number').val();
      HangupButton = $(this).next()
      makeOutgoingCall(phoneNumberInput);
    })
    
    
    getAudioDevicesButton.onclick = getAudioDevices;
    speakerDevices.addEventListener("change", updateOutputDevice);
    ringtoneDevices.addEventListener("change", updateRingtoneDevice);
    
    
    // SETUP STEP 1:
    // Browser client should be started after a user gesture
    // to avoid errors in the browser console re: AudioContext
    

    // SETUP STEP 2: Request an Access Token
    async function startupClient() {
      log("Requesting Access Token...");
  
      try {
          var baseUrl = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
          console.log(baseUrl+ "my data")

          const data = await $.getJSON(baseUrl+"/access-token");
        
        log("Got a token.");
        token = data.token;
        console.log(token +"its my token");
        setClientNameUI('bulk-sms');
        intitializeDevice();
      } catch (err) {
        console.log(err);
        log("An error occurred. See your browser console for more information.");
      }
    }
  
    // SETUP STEP 3:
    // Instantiate a new Twilio.Device
    function intitializeDevice() {
      logDiv.classList.remove("hide");
      console.log(token)
      device = new Twilio.Device(token, {
        logLevel: 1,
        // Set Opus as our preferred codec. Opus generally performs better, requiring less bandwidth and
        // providing better audio quality in restrained network conditions.
        codecPreferences: ["opus", "pcmu"]
      });
      addDeviceListeners(device);
  
      // Device must be registered in order to receive incoming calls
      device.register();
    }
  
    // SETUP STEP 4:
    // Listen for Twilio.Device states
    function addDeviceListeners(device) {
      device.on("registered", function () {
        log("Twilio.Device Ready to make and receive calls!");
        callControlsDiv.classList.remove("hide");
      });
  
      device.on("error", function (error) {
        log("Twilio.Device Error: " + error.message);
      });
      device.on("incoming", handleIncomingCall);
  
      device.audio.on("deviceChange", updateAllAudioDevices.bind(device));
  
      // Show audio selection UI if it is supported by the browser.
      if (device.audio.isOutputSelectionSupported) {
        audioSelectionDiv.classList.remove("hide");
      }
    }
  
    // MAKE AN OUTGOING CALL
  
    async function makeOutgoingCall(phoneNumberInput) {
      try {
          console.log(phoneNumberInput)
          var params = {
            // get the phone number to call from the DOM
            To: phoneNumberInput,
          };
      
          if (device) {
            log(`Attempting to call ${params.To} ...`);
      
            // Twilio.Device.connect() returns a Call object
            const call = await device.connect({ params });
      
            // add listeners to the Call
            // "accepted" means the call has finished connecting and the state is now "open"
            
            call.on("accept", updateUIAcceptedOutgoingCall);
            call.on("disconnect", updateUIDisconnectedOutgoingCall);
            call.on("cancel", updateUIDisconnectedOutgoingCall);
            console.log();
            callButton.next().removeClass('d-none')
            callButton.addClass('d-none');
            $(HangupButton).click(function(){
            
              console.log("Hanging up ...");
              call.disconnect();
              callButton.next().addClass('d-none')
              callButton.removeClass('d-none');
            });
            
          } else {
            log("Unable to make call.");
          }
        } catch(error) {
        console.error("Error in makeOutgoingCall:", error);
      
      }
    }
  
    function updateUIAcceptedOutgoingCall(call) {
      log("Call in progress ...");
      callButton.disabled = true;
      bindVolumeIndicators(call);
    }
  
    function updateUIDisconnectedOutgoingCall() {
      log("Call disconnected.");
      callButton.next().addClass('d-none')
      callButton.removeClass('d-none');
      callButton.disabled = false;
    }
  
    // HANDLE INCOMING CALL
  
    function handleIncomingCall(call) {
      modal.style.display = 'block';
      $("#soft-phone-modal").find(".incoming-control").removeClass('d-none');
      $("#soft-phone-modal").find(".phone").addClass('d-none');

      $(incomingPhoneNumberEl.parentElement.parentNode.parentNode).removeClass('d-none')
      $(incomingPhoneNumberEl.parentElement.parentNode.parentNode).addClass('d-flex')
      log(`Incoming call from ${call.parameters.From}`);
  
      //show incoming call div and incoming phone number
      // incomingCallDiv.classList.remove("hide");
      incomingPhoneNumberEl.innerHTML = call.parameters.From;
  
      //add event listeners for Accept, Reject, and Hangup buttons
      incomingCallAcceptButton.onclick = () => {
        acceptIncomingCall(call);
      };
  
      incomingCallRejectButton.onclick = () => {
        rejectIncomingCall(call);
      };
  
      incomingCallHangupButton.onclick = () => {
        hangupIncomingCall(call);
      };
  
      // add event listener to call object
      call.on("cancel", handleDisconnectedIncomingCall);
      call.on("disconnect", handleDisconnectedIncomingCall);
      call.on("reject", handleDisconnectedIncomingCall);
    }
  
    // ACCEPT INCOMING CALL
  
    function acceptIncomingCall(call) {
      call.accept();
  
      //update UI
      log("Accepted incoming call.");
      incomingCallAcceptButton.classList.add("hide");
      incomingCallRejectButton.classList.add("hide");
      incomingCallHangupButton.classList.remove("hide");
    }
  
    // REJECT INCOMING CALL
  
    function rejectIncomingCall(call) {
      call.reject();
      log("Rejected incoming call");
      resetIncomingCallUI();
    }
  
    // HANG UP INCOMING CALL
  
    function hangupIncomingCall(call) {
      call.disconnect();
      log("Hanging up incoming call");
      resetIncomingCallUI();
    }
  
    // HANDLE CANCELLED INCOMING CALL
  
    function handleDisconnectedIncomingCall() {
      log("Incoming call ended.");
      $("#soft-phone-modal").find(".incoming-control").addClass('d-none');
      $("#soft-phone-modal").find(".phone").removeClass('d-none');

      resetIncomingCallUI();
    }
    // MISC USER INTERFACE
  
    // Activity log
    function log(message) {
      logDiv.innerHTML += `<p class="log-entry">&gt;&nbsp; ${message} </p>`;
      logDiv.scrollTop = logDiv.scrollHeight;
    }
  
    function setClientNameUI(clientName) {
      var div = document.getElementById("client-name");
      div.innerHTML = `Your client name: <strong>${clientName}</strong>`;
    }
  
    function resetIncomingCallUI() {
      incomingPhoneNumberEl.innerHTML = "";
      incomingCallAcceptButton.classList.remove("hide");
      incomingCallRejectButton.classList.remove("hide");
      incomingCallHangupButton.classList.add("hide");
      $(incomingPhoneNumberEl.parentElement.parentNode.parentNode).addClass('d-none')
      $(incomingPhoneNumberEl.parentElement.parentNode.parentNode).removeClass('d-flex')
    }
  
    // AUDIO CONTROLS
    async function getAudioDevices() {
      await navigator.mediaDevices.getUserMedia({ audio: true });
      updateAllAudioDevices.bind(device);
    }
  
    function updateAllAudioDevices() {
      if (device) {
        updateDevices(speakerDevices, device.audio.speakerDevices.get());
        updateDevices(ringtoneDevices, device.audio.ringtoneDevices.get());
      }
    }
  
    function updateOutputDevice() {
      const selectedDevices = Array.from(speakerDevices.children)
        .filter((node) => node.selected)
        .map((node) => node.getAttribute("data-id"));
  
      device.audio.speakerDevices.set(selectedDevices);
    }
  
    function updateRingtoneDevice() {
      const selectedDevices = Array.from(ringtoneDevices.children)
        .filter((node) => node.selected)
        .map((node) => node.getAttribute("data-id"));
  
      device.audio.ringtoneDevices.set(selectedDevices);
    }
  
    function bindVolumeIndicators(call) {
      call.on("volume", function (inputVolume, outputVolume) {
        var inputColor = "red";
        if (inputVolume < 0.5) {
          inputColor = "green";
        } else if (inputVolume < 0.75) {
          inputColor = "yellow";
        }
  
        inputVolumeBar.style.width = Math.floor(inputVolume * 300) + "px";
        inputVolumeBar.style.background = inputColor;
  
        var outputColor = "red";
        if (outputVolume < 0.5) {
          outputColor = "green";
        } else if (outputVolume < 0.75) {
          outputColor = "yellow";
        }
  
        outputVolumeBar.style.width = Math.floor(outputVolume * 300) + "px";
        outputVolumeBar.style.background = outputColor;
      });
    }
  
    // Update the available ringtone and speaker devices
    function updateDevices(selectEl, selectedDevices) {
      selectEl.innerHTML = "";
  
      device.audio.availableOutputDevices.forEach(function (device, id) {
        var isActive = selectedDevices.size === 0 && id === "default";
        selectedDevices.forEach(function (device) {
          if (device.deviceId === id) {
            isActive = true;
          }
        });
  
        var option = document.createElement("option");
        option.label = device.label;
        option.setAttribute("data-id", id);
        if (isActive) {
          option.setAttribute("selected", "selected");
        }
        selectEl.appendChild(option);
      });
    }

    

// Event listener for DOMContentLoaded to trigger startupClient
document.addEventListener("DOMContentLoaded", function () {
  startupClient();
});

  