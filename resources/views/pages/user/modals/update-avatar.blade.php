<div class="splash-image" id="updatePasswordSplash">
    <img src="{{ url('/') }}/images/update-avatar.png" alt="update avatar" />
</div>
<div class="splash-text">
    {{ cleanLang(__('lang.update_your_profile_picture')) }}
</div>


<!--fileupload-->
<div class="form-group row">
    <div class="col-12">
        <div class="dropzone dz-clickable text-center file-upload-box" id="fileupload_avatar">
            <div class="dz-default dz-message">
                <div>
                    <h4>{{ cleanLang(__('lang.drag_drop_file')) }}</h4>
                </div>
                <div class="p-t-10"><small>{{ cleanLang(__('lang.allowed_file_types')) }}: (jpg)</small></div>
                <div class=""><small>{{ cleanLang(__('lang.minimum_size')) }}: (80 x 80) -
                        {{ cleanLang(__('lang.maximum_size')) }}: (500 x 500)</small></div>
            </div>
        </div>
    </div>
</div>