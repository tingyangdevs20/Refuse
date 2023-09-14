

@if(Auth::user()->hasSwitchedRole())
<div class="alert alert-info">
    You are currently viewing <span style=" color: red; font-weight: bold;" class="highlighted-text">{{ Auth::user()->name }}</span> as an account administrator.
    <a href="{{ route('admin.user.quit') }}" class="btn btn-outline-danger btn-sm ml-2">Quit</a>
</div>

@endif
