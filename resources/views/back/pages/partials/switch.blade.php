
@if (Session::has('error'))
    <div class="alert alert-danger">
        <div>
            <p>{{ Session::get('error') }}</p>
        </div>
    </div>
@endif
@if(Auth::user()->hasSwitchedRole())
<div class="alert alert-info" id="switchRoleAlert">
    You are currently viewing <span style="color: red; font-weight: bold;" class="highlighted-text">{{ Auth::user()->name }}</span> .
    <a href="{{ route('admin.user.quit') }}" class="btn btn-outline-danger btn-sm ml-2">Quit</a>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Add a click event handler for the close button
        $("#switchRoleAlert button.close").click(function() {
            $("#switchRoleAlert").hide(); // Hide the alert
        });
    });
</script>

