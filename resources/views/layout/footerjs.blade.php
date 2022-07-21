<!--ALL THIRD PART JAVASCRIPTS-->
<script src="{{ asset('/vendor/js/vendor.footer.js?v='. config('system.versioning')) }}"></script>

<!--nextloop.core.js-->
<script src="{{ asset('/js/core/ajax.js?v='. config('system.versioning')) }}"></script>

<!--MAIN JS - AT END-->
<script src="{{ asset('/js/core/boot.js?v='. config('system.versioning')) }}"></script>

<!--EVENTS-->
<script src="{{ asset('/js/core/events.js?v='. config('system.versioning')) }}"></script>

<!--CORE-->
<script src="{{ asset('/js/core/app.js?v='. config('system.versioning')) }}"></script>

<!--BILLING-->
<script src="{{ asset('/js/core/billing.js?v='. config('system.versioning')) }}"></script>

<!--PURCHASE-->
<script src="{{ asset('/js/core/purchase.js?v='. config('system.versioning')) }}"></script>

<!--project page charts-->
@if(@config('visibility.projects_d3_vendor'))
<script src="{{ asset('/vendor/js/d3/d3.min.js?v='. config('system.versioning')) }}"></script>
<script src="{{ asset('/vendor/js/c3-master/c3.min.js?v='. config('system.versioning')) }}"></script>
@endif
<!-- font-awesome script -->
<script src="{{ asset('/js/core/fontawesome.js') }}"></script>