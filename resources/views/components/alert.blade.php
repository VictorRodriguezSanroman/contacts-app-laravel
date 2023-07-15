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

    @if (!auth()->user()?->subscribed() && auth()->user()?->onTrial())
        @php
            $freeTrialDays = now()->diffInDays(auth()->user()->trial_ends_at);
        @endphp
        <div class="alert alert-info">
            Trial ends in {{ $freeTrialDays }} days 
            <a href="{{route('checkout')}}">Subscribed here</a>
        </div>
    @endif
</div>
