<div class="row">
    <div class="col-12">
        <h2 class="text-white"> <strong>{{ cleanLang(__('lang.welcome')) }}, {{$payload['auth']->full_name}}</strong></h2>
    </div>
        <div class="col-12">
        <h4 class="date text-white">{{$payload['today']}}</h4>
    </div>
</div>
<div class="row">
    <!--PAYMENTS TODAY-->
    @include('pages.home.admin.widgets.first-row.active_leads')

    <!--PAYMENTS THIS MONTH-->
    @include('pages.home.admin.widgets.first-row.active_projects')

    <!--INVOICES DUE-->
    @include('pages.home.admin.widgets.first-row.outstanding_claims')

    <!--INVOICES OVERDUE-->
    @include('pages.home.admin.widgets.first-row.faulty_equipments')
</div>