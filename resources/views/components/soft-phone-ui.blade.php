<style>
    #soft-phone-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* Style to center the modal content */
    .container.soft-phone {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
    }

    h1 {
        padding: 2rem 0;
        text-align: center;
    }

    .number-text {
        color: #50a5f1 !important;
    }

    .phone {

        padding: 2px;
        border-radius: 8px 8px 8px 0;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0px auto;
        margin-bottom: 1rem;
        width: 350px;
        display: flex;

    }

    .phone .call-display .dropdown-menu {
        background: #32373b;
        border: 2px solid #355760;
        box-shadow: 0px 1px 2px #333;
    }

    .phone .call-display .dropdown-divider {
        border-color: #355760;
    }

    .phone .call-display .call-info {
        margin-top: 1rem;
        padding: 1rem 2.5rem;
        border-radius: 1rem;
        background: #474e54;
        box-shadow: 0 0 0.75rem 0.1rem #262a2d;
    }

    .phone .call-display .call-info .call-img {
        padding: 0 0.5rem;
        border-radius: 100%;
    }

    .phone .call-display .call-info .call-name {
        padding-top: 0;
        padding-left: 0.65rem;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .phone .call-display .call-info .call-number:before {
        content: "+";
    }

    .phone .dial-display {
        position: relative;
    }

    .phone input[type=tel] {
        color: grey;
        letter-spacing: 0.1rem;
        text-align: center;
        width: 100%;
        border: 0;
        outline: 0;
        background: 0;
        font-size: 20px;

    }

    .phone input[type=reset] {
        background: 0;
        border: 0;
        outline: 0;
        font-family: "fontawesome";
        color: #63b9c8;
        text-shadow: none;
        position: absolute;
        right: 1rem;
        top: 1.35rem;
    }

    .phone .grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        margin-bottom: -1.5em;
        margin-top: 9%;
    }

    .phone .grid .focus-effects:focus {
        border: 1px solid #afafaf;
        border-radius: 50px;
    }

    .phone .grid button {
        border: 0;
        background: 0;
        color: black;
        padding: 5px;
        outline: 0;
    }

    .phone .grid button:nth-last-child(-n+3) {
        padding-bottom: 3.3em;
    }


    .phone .grid span {
        display: block;
        color: #9A9A9A;
        font-size: 0.7rem;

    }

    .phone .ans-call {
        color: #998c8c;
        width: 50px;
        margin-top: -0.5rem;
        font-size: 27px;
        border-radius: 50%;
        transform: rotate(90deg);
        height: 50px;
    }

    .phone .ans-call:hover,
    .phone .ans-call:focus {
        background: #5dcd74;
    }

    .phone .ans-call:active {
        box-shadow: 0;
        background: #45c660;
    }

    .phone .end-call {
        color: #998c8c;
        width: 50px;
        margin-top: -0.5rem;
        font-size: 27px;
        border-radius: 50%;
        transform: rotate(90deg);
        height: 50px;
    }

    .phone .end-call:hover,
    .phone .end-call:focus {
        background: #cd5d6c;
    }

    .phone .end-call:active {
        box-shadow: 0;
        background: #c64556;
    }

    .phone .end-call i {
        transform: rotate(135deg);
    }

    .phone .dialer-icons {
        bottom: 10px;
        position: absolute;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }

    .custome-size {
        font-size: xx-large;
        ;
    }

    .custom-size-ui {
        font-size: xx-large;
        ;
    }

    .custom-select {

        border: 1px solid #efefef;
        width: 100%;
        max-width: 100%;

    }

    .soft-phone {
        display: flex;

        background: white;
    }

    .modal-sidebar {
        flex-direction: column;
        display: flex;
        padding: 20px 10px;
        background-color: #f0f0f0;
        border-radius: 8px 0 0 8px;

    }

    .power-off {
        font-size: 32px;
        border: 1px solid;
        border-radius: 50px;
        background: #43d743;
        color: #fff;
        margin-top: 40%;
    }

    .sidebar-end {
        margin: 0;
        bottom: 0px;
        position: absolute;
        margin-left: 2%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .sidebar-top {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 20px;
        margin-top: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 19px;
        left: 5px;
        bottom: 0px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #50a5f1;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #556ee6;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    #call-history {
        list-style-type: none;
        /* Hide list bullets */
        padding: 0;
        width: 100%;
        margin: 2px -15px 0px 0px;
        height: 80%;
        overflow-y: auto;
    }

    #call-history ul li {
        margin: 0px 0px 0px -5px;
        border-left: 0;  /* Hide left border */
    border-right: 0; /* Hide right border */
    border-top: 0;   /* Hide top border */

    }

    #call-history ul li .ans-call {
        color: #8c9990;
        width: 30px;
        margin-top: -0.5rem;
        margin-left: 3rem;
        font-size: 17px;
        border-radius: 50%;
        transform: rotate(90deg);
        height: 29px;
    }

    #call-history ul li .ans-call:hover,
    #call-history ul li .ans-call:focus {
        background: #5dcd74;
    }

    #call-history ul li .ans-call:active {
        box-shadow: 0;
        background: #45c660;
    }

    #call-history ul {
        /* margin-top: 10px; */
        margin-bottom: 1rem;
        margin-left: -35px;
        margin-right: 20px;
    }

    .call-record {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 5px;
    }

    .call-icon {
        margin-right: 10px;
        font-size: 20px;
    }

    .call-number {
        font-weight: bold;
    }
    /* CSS for styling the call count in the center of the call icon */
.call-icon {
    position: relative;
    display: inline-block;
}

.call-icon::after {
    content: attr(data-count); /* Get the count from the 'data-count' attribute */
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    border-radius: 50%; /* Make it a circle */
    padding: 4px 8px; /* Adjust padding as needed */
    font-size: 12px; /* Font size for the call count */
    z-index: 1; /* Ensure the count is on top of the icon */
}
    .col-4:hover {
        cursor: pointer;
    }
    .close-dialer {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    color: #555;
    cursor: pointer;
}


    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 20px;
        margin-top: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 19px;
        left: 5px;
        bottom: 0px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #50a5f1;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #556ee6;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>


<div id="soft-phone-modal" class="modal">
    <div class="container soft-phone" style="width: 350px !important;padding-left: 0px;height: 500px;">
        <button type="button" class="close close-dialer" data-dismiss="soft-phone-modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="modal-sidebar">
            <div class="sidebar-top">
                <img class="rounded-circle header-profile-user" src="{{ asset('back/assets/images/user.png') }}"
                    alt="Header Avatar"> <label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="sidebar-end">
                <span class="material-icons" style="color:#708090;margin-bottom: 10px;">star_half</span>
                <span class='material-icons' style="color:#708090;margin-bottom: 10px;">settings</span>
                <span class="material-icons power-off"
                style="margin-bottom: 15px;color:#708090">power_settings_new</span>
            </div>
        </div>

        <div class="row text-center m-auto incoming-control d-none">
            <div class="col-12">
                <p class="instructions">
                    Incoming Call from <span id="incoming-number"></span>
                </p>
                <div class="btn-group-vertical">
                    <button type="button" id="button-accept-incoming" class="btn btn-primary mb-3 px-5">Accept</button>
                    <button type="button" id="button-reject-incoming"
                        class="btn btn-primary bgred mb-3 px-5">Reject</button>
                    <button type="button" id="button-hangup-incoming"
                        class="btn btn-primary bgred px-5">Hangup</button>
                </div>

            </div>
        </div>
        <div class="phone">
            <div id="dial_pad">
                <div class="call-display">
                    <div class="row">
                        <input type="tel" class="phone-number" id="phone-number" placeholder="Dial Number"
                            pattern="[0-9 ]+" autofocus />
                    </div>
                </div>

                <span style="color:#C0C0C0;">Call Using</span>
                <select class="custom-select" style="color:#C0C0C0;margin-top:5px" id="call_from">

                    @php
                        $caller_id = 0;
                        use App\Model\Number;
                        $twilio_number = Number::first();
                        if ($twilio_number) {
                            $twilio_number = $twilio_number->toArray();
                            $caller_id = $twilio_number['number'];
                        }

                    @endphp
                    <option value="{{ $caller_id ?? 0 }}" selected>{{ $caller_id }}</option>

                </select>

                <div class="grid">
                    <button class="focus-effects" style="margin-bottom: 15px;font-size: 16px;" value="1">1</button>
                    <button class="focus-effects" style="font-size: 16px;" value="2">2 <span
                            class="number-text">ABC</span></button>
                    <button class="focus-effects" style="font-size: 16px;" value="3">3 <span
                            class="number-text">DEF</span></button>
                    <button class="focus-effects" style="font-size: 16px;" value="4">4 <span
                            class="number-text">GHI</span></button>
                    <button class="focus-effects" style="font-size: 16px;" value="5">5 <span
                            class="number-text">JKL</span></button>
                    <button class="focus-effects" style="font-size: 16px;" value="6">6 <span
                            class="number-text">MNO</span></button>
                    <button class="focus-effects" style="font-size: 16px;" value="7">7 <span
                            class="number-text">PQRS</span></button>
                    <button class="focus-effects" style="font-size: 16px;" value="8">8 <span
                            class="number-text">TUV</span></button>
                    <button class="focus-effects" style="font-size: 16px;" value="9">9 <span
                            class="number-text">WXYZ</span></button>
                    <button class="focus-effects" style="font-size: 16px;" value="+">+</button>
                    <button class="focus-effects" style="font-size: 16px;" value="0">0</button>
                    <button class="focus-effects" style="font-size: 16px;" value="#">#</button>
                </div>

                <div class="d-flex justify-content-center" style="margin-bottom:10px">
                    <button style="margin-top: 10px;" id="answer-call" class="ans-call">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                    </button>
                    <button id="end-call" class="end-call d-none">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div id="call-history" class="history-panel" style="display: none;">
              <h4 style="margin-top:4px">Call History</h4>
                <!-- Call records list -->
                <ul>

                </ul>
                <div class="d-flex align-items-center">
                    <strong>Loading call logs...</strong>
                    <div class="spinner-border spinner-border-sm ml-1"
                        role="status" aria-hidden="true"></div>
                </div>
            </div>

            <div class="row dialer-icons mt-2" style="margin-bottom: 5px;">
                <div class="col-4" style="margin-left: 2px;" id="show-dial-pad">
                    <span class='material-icons custom-size-ui'id="show-dialpad"
                        style="margin-left: 14px;color: #220ada;">dialpad</span>
                </div>
                <div class="col-4" style="margin-left: 15px;">
                    <span class='material-icons custom-size-ui' style="color: #D3D3D3;">support_agent</span>
                </div>
                <div class="col-4" style="left: 28px;">
                    <i class="fa fa-phone custom-size-ui" id="show-history" style="color: #d3d3d3;font-size:x-large"
                        title="History"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
