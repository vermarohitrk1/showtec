@extends('pages.settings.wrapper')
@section('settings-page')
<!--page notification-->
<div class="row">
    <div class="col-12">
        <div class="page-notification-imaged">
            <img src="{{ url('/') }}/public/images/settings.png" alt="Application Settings" />
            <div class="message">
                <h3>{{ cleanLang(__('lang.setting_welcome_message')) }}</h2>
            </div>
            <div class="sub-message">
                <h4>{{ cleanLang(__('lang.setting_welcome_message_sub')) }}</h2>
            </div>
            <div class="m-t-20">
                <h4><span class="badge badge-success"> @lang('lang.version') {{ $settings->get_key('settings_version') }}</span>
                    </h2>
            </div>

            {{-- <div class="m-t-20">
                <a href="{{ url('/app/settings/updates') }}"
                    class="btn btn-rounded-x btn-sm btn-danger waves-effect text-left">@lang('lang.check_for_updates')</a>
            </div> --}}
        </div>
    </div>
</div>
@endsection