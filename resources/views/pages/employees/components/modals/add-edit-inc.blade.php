<!--modal-->
<div class="row" id="js-trigger-clients-modal-add-edit" data-payload="{{ $page['section'] ?? '' }}">
    <div class="col-lg-12">

        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.company_name')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm" id="employee_company"
                    name="employee_company">
                    @foreach($companies as $company)
                    <option value="{{ $company->id }}"
                        {{ runtimePreselected($company->id ?? '', $company->id) }}>{{
                                            runtimeLang($company->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.department')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm" id="employee_department"
                    name="employee_department">
                    @foreach($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ runtimePreselected($department->id ?? '', $department->id) }}>{{
                                            runtimeLang($department->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        @if(isset($page['section']) && $page['section'] == 'edit')

        <div class="form-group row">
            <label for="example-month-input"
                class="col-sm-12 col-lg-3 col-form-label text-left">{{ cleanLang(__('lang.status')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm" id="status" name="status">
                    <option></option>
                    <option value="active" {{ runtimePreselected($employee->status ?? '', 'active') }}>
                        {{ cleanLang(__('lang.active')) }}</option>
                    <option value="suspended" {{ runtimePreselected($employee->status ?? '', 'inactive') }}>
                        {{ cleanLang(__('lang.suspended')) }}
                    </option>
                </select>
            </div>
        </div>

       
        @endif

        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.first_name')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="first_name" name="first_name" value="{{ $employee->first_name ?? '' }}"
                    placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.last_name')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="last_name" name="last_name" value="{{ $employee->last_name ?? '' }}" placeholder="">
            </div>
        </div>
        
        <!--contact section-->
        @if(isset($page['section']) && $page['section'] == 'create')

            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.email_address')) }}*</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.role')) }}*</label>
                <div class="col-sm-12 col-lg-9">
                    <select class="select2-basic form-control form-control-sm" id="role"
                        name="role">
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.designation')) }}*</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="text" class="form-control form-control-sm" id="designation" name="designation" value="{{ $employee->designation ?? '' }}" placeholder="">
                </div>
            </div>

        <div class="line"></div>
        <!--contact section-->

        <!--billing address section-->
        <div class="spacer row">
            <div class="col-sm-12 col-lg-8">
                <span class="title">{{ cleanLang(__('lang.address')) }}</span class="title">
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="switch  text-right">
                    <label>
                        <input type="checkbox" name="address" id="add_address"
                            class="js-switch-toggle-hidden-content" data-target="add_address_section">
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>
        <!--billing address section-->


        <!--billing address section-->
        <div id="add_address_section" class="hidden">
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.street')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="text" class="form-control form-control-sm" id="street"
                        name="street" value="{{ $employee->address ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.city')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="text" class="form-control form-control-sm" id="city"
                        name="city" value="{{ $employee->city ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.state')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="text" class="form-control form-control-sm" id="state"
                        name="state" value="{{ $employee->state ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.zipcode')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="text" class="form-control form-control-sm" id="zip"
                        name="zip" value="{{ $employee->zip ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-month-input"
                    class="col-sm-12 col-lg-3 col-form-label text-left">{{ cleanLang(__('lang.country')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    @php $selected_country = $employee->country ?? ''; @endphp
                    <select class="select2-basic form-control form-control-sm" id="country"
                        name="country">
                        <option></option>
                        @include('misc.country-list')
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.telephone')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="text" class="form-control form-control-sm" id="phone" name="phone"
                        value="{{ $employee->phone ?? '' }}">
                </div>
            </div>

            <div class="line"></div>
        </div>
        <!--billing address section-->

        <!--notes-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small></div>
            </div>
        </div>
    </div>
</div>