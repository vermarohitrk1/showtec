@extends('pages.settings.ajaxwrapper')
@section('settings-page')
<!--heading-->
<form>
    <div class="table-responsive p-b-30">
        <table id="custom-fields" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10"">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ cleanLang(__('lang.name')) }}</th>
                    <th class=" w-15">{{ cleanLang(__('lang.show_lead')) }}</th>
            <th class="w-15">{{ cleanLang(__('lang.required')) }}</th>
            <th class="w-10">{{ cleanLang(__('lang.enabled')) }}</th>
            </tr>
            </thead>
            <tbody id="status-td-container">
                @php $count = 1 ; @endphp
                @foreach($fields as $field)
                <tr>
                    <td>
                        @php echo $count++; @endphp
                    </td>
                    <!--title-->
                    <td class="p-r-40">
                        <input type="text" class="form-control form-control-sm" id="add_invoices_date"
                            name="customfields_title[{{ $field->customfields_id }}]"
                            value="{{ $field->customfields_title }}">
                    </td>

                    <!--show on lead summary-->
                    <td class="td-checkbox">
                        <input type="checkbox" id="customfields_show_lead_summary[{{ $field->customfields_id }}]"
                            name="customfields_show_lead_summary[{{ $field->customfields_id }}]"
                            class="filled-in chk-col-light-blue"
                            {{ runtimePrechecked($field->customfields_show_lead_summary) }}>
                        <label for="customfields_show_lead_summary[{{ $field->customfields_id }}]"></label>
                    </td>
                    <!--required-->
                    <td class="td-checkbox">
                        <input type="checkbox" id="customfields_required[{{ $field->customfields_id }}]"
                            name="customfields_required[{{ $field->customfields_id }}]"
                            class="filled-in chk-col-light-blue" {{ runtimePrechecked($field->customfields_required) }}>
                        <label for="customfields_required[{{ $field->customfields_id }}]"></label>
                    </td>
                    <!--status-->
                    <td class="td-checkbox">
                        <input type="checkbox" id="customfields_status[{{ $field->customfields_id }}]"
                            name="customfields_status[{{ $field->customfields_id }}]"
                            class="filled-in chk-col-light-blue" {{ runtimePrechecked($field->customfields_status) }}>
                        <label for="customfields_status[{{ $field->customfields_id }}]"></label>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <!--settings documentation help-->
        {{-- <a href="" target="_blank" class="btn btn-sm btn-info  help-documentation"><i class="ti-info-alt"></i>
            {{ cleanLang(__('lang.help_documentation')) }}</a> --}}

    </div>
    <!--buttons-->
    <div class="text-right">
        <button type="submit" id="commonModalSubmitButton"
            class="btn btn-rounded-x btn-danger waves-effect text-left js-ajax-ux-request"
            data-url="/settings/customfields/leads" data-loading-target="" data-ajax-type="PUT" data-type="form"
            data-on-start-submit-button="disable">{{ cleanLang(__('lang.save_changes')) }}</button>
    </div>
</form>
@endsection