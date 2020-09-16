@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Two Factor Verification') }}</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-info" role="alert">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                            <form method="POST" action="{{ route('verify.store') }}">
                                {{ csrf_field() }}
                                <p class="text-muted">
                                    You have received an email which contains two factor login code.
                                    If you haven't received it, press <a href="{{ route('verify.resend') }}">here</a>.
                                </p>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="two_factor_token" type="text"
                                           class="form-control{{ $errors->has('two_factor_token') ? ' is-invalid' : '' }}"
                                           required autofocus placeholder="Two Factor Token">
                                    @if($errors->has('two_factor_token'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('two_factor_token') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary px-4">
                                            Verify
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
