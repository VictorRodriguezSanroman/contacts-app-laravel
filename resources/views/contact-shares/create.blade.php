@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-alert />
                <div class="card">
                    <div class="card-header">{{ __('Create New Contact') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('contact-shares.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="contact_email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Contact Email') }}</label>

                                <div class="col-md-6">
                                    <input id="contact_email" type="text"
                                        class="form-control @error('contact_email') is-invalid @enderror" name="contact_email"
                                        value="{{ old('contact_email') }}" autocomplete="contact_email">

                                    @error('contact_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="user_email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('User Email') }}</label>

                                <div class="col-md-6">
                                    <input id="user_email" type="text"
                                        class="form-control @error('user_email') is-invalid @enderror" name="user_email"
                                        value="{{ old('user_email') }}" autocomplete="user_email">

                                    @error('user_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
