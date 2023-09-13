

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

.number-text{
    color: blue !important;
}

.phone {
   
  padding: 20px;
  border-radius: 0 8px 8px 0;

  margin: 0px auto;
  margin-bottom: 1rem;
  width: 350px;
  
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
  color: #63b9c8;
  letter-spacing: 0.1rem;
  text-align: center;
  width: 100%;
  border: 0;
  outline: 0;
  background: 0;
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
  padding: 1rem;
  outline: 0;
}
.phone .grid button:nth-last-child(-n+3) {
  padding-bottom: 3.3em;
}


.phone .grid span {
  display: block;
  color: #9A9A9A;
  font-size: 0.7rem;
  letter-spacing: 0.3rem;
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
.phone .ans-call:hover, .phone .ans-call:focus {
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
.phone .end-call:hover, .phone .end-call:focus {
  background: #cd5d6c;
}
.phone .end-call:active {
  box-shadow: 0;
  background: #c64556;
}
.phone .end-call i {
  transform: rotate(135deg);
}

.phone .dialer-icons{
    bottom: 10px;
    position: absolute;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
}

.custome-size{
  font-size: xx-large;;
}

.custom-size-ui{
  font-size: xx-large;;
}

.custom-select{
  
  border: 0px;
  width: 100%;
  max-width: 100%;
}

.soft-phone{
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

.sidebar-top{
    display: flex;
    flex-direction: column;
    align-items: center;
}

.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 20px;
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

input:checked + .slider {
  background-color: #43d743;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
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
        
            <div class="modal-sidebar">
                <div class="sidebar-top">
                <img class="rounded-circle header-profile-user" src="{{ asset('back/assets/images/user.png') }}" alt="Header Avatar">                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="sidebar-end">
                    <span class="material-icons">star_half</span>
                    <span class='material-icons'>settings</span>
                    <span class="material-icons power-off">power_settings_new</span>
                </div>
            </div>

            <div class="row text-center m-auto incoming-control d-none">
              <div class="col-12">
                  <p class="instructions">
                    Incoming Call from <span id="incoming-number"></span>
                  </p>
                  <div class="btn-group-vertical">
                  <button type="button" id="button-accept-incoming" class="btn btn-primary mb-3 px-5">Accept</button>
                  <button type="button" id="button-reject-incoming" class="btn btn-primary bgred mb-3 px-5">Reject</button>
                  <button type="button" id="button-hangup-incoming" class="btn btn-primary bgred px-5">Hangup</button>
                  </div>
                  
              </div>
            </div>  
            <div class="phone">
              <button type="button" class="close close-dialer" data-dismiss="soft-phone-modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
                <div class="call-display">
                    <div class="row">
                      <input type="tel" class="phone-number" pattern="[0-9 ]+" autofocus />
                    </div>
                </div>

                    <select class="custom-select" id="list-of-phonenumbers">
                        <option selected>Choose...</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>

                <div class="grid">
                    <button class="focus-effects" value="1">1</button>
                    <button class="focus-effects" value="2">2 <span class="number-text">ABC</span></button>
                    <button class="focus-effects" value="3">3 <span class="number-text">DEF</span></button>
                    <button class="focus-effects" value="4">4 <span class="number-text">GHI</span></button>
                    <button class="focus-effects" value="5">5 <span class="number-text">JKL</span></button>
                    <button class="focus-effects" value="6">6 <span class="number-text">MNO</span></button>
                    <button class="focus-effects" value="7">7 <span class="number-text">PQRS</span></button>
                    <button class="focus-effects" value="8">8 <span class="number-text">TUV</span></button>
                    <button class="focus-effects" value="9">9 <span class="number-text">WXYZ</span></button>
                    <button class="focus-effects" value="+">+</button>
                    <button class="focus-effects"value="0">0</button>
                    <button class="focus-effects" value="#">#</button>
                </div>

                <div class="d-flex justify-content-center">
                    <button id="answer-call" class="ans-call" >
                        <i class="fa fa-phone" aria-hidden="true"></i>
                    </button>
                    <button id="end-call" class="end-call d-none">
                      <i class="fa fa-phone" aria-hidden="true"></i>
                  </button>
                </div>

                <!-- <div class="d-flex justify-content-center">
                  <button id="end-call" class="end-call">
                      <i class="fa fa-phone" aria-hidden="true"></i>
                  </button>
                </div>   -->

                <div class="row dialer-icons mt-2">
                    <div class="col-4" style="left: 28px;">
                        <span class='material-icons custom-size-ui'>dialpad</span>
                    </div>
                    <div class="col-4" style="left: 28px;">
                        <span class='material-icons custom-size-ui'>support_agent</span>
                    </div>
                    <div class="col-4" style="left: 28px;">
                        <i class="fa fa-phone custome-size"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


