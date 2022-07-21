@extends('pages.settings.ajaxwrapper')
@section('settings-page')
<div class="row">
    @if($section == 'stripe-not-configured')
    <div class="col-12 text-center  p-b-40">
        <div class="p-b-20">
            <img src="{{ url('/') }}/public/images/stripe-connection.png" alt="404 - Not found" /> 
        </div>
        <h4 class="p-b-20">@lang('lang.stripe_account_error')</h4>
        <a href="{{ url('/app/settings/stripe') }}" class="btn btn-info btn-sm">@lang('lang.edit_settings')</a>
    </div>
    @endif
</div>
@endsection