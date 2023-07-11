<div>
    @if (session('success'))
    <div class="alert alert-success" id='success-message'>
        {{ session('success') }}
    </div>
@endif
@if (session('findIt'))
    <div class="alert alert-danger" id='success-message'>
        {{ session('findIt') }}
    </div>
@endif
@if (session('err'))
    <div class="alert alert-danger" id='success-message'>
        {{ session('err') }}
    </div>
@endif
</div>
