<!--modal-->
<div class="row" id="js-trigger-inventory-modal-add-edit" data-payload="{{ $page['section'] ?? '' }}">
    <div class="col-lg-12">
        <div class="spacer row justify-content-end">
                <span class="title">{{ cleanLang(__('lang.highlight')) }}</span class="title">
                <div class="switch">
                    <label>
                        <input type="checkbox" class="js-switch-toggle-hidden-content" name="highlighted"
                            data-target="edit_project_setings" {{ $inventory->highlighted ?? '' }}>
                        <span class="lever switch-col-yellow square large dot-none"></span>
                    </label>
                </div>
        </div>
        <!--meta data - creatd by-->
        @if(isset($page['section']) && $page['section'] == 'edit')
        <div class="modal-meta-data">
            <input type="hidden" name="selection-type" id="selection-type" value="existing">
        </div>
        @else
        <div class="modal-meta-data">
            <input type="hidden" name="selection-type" id="selection-type" value="new">
        </div>
        @endif


        <!--TITLE-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.item_name')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="item_name" name="name"
                    placeholder="" value="{{ $inventory->name ?? '' }}">
            </div>
        </div>
        <!--/#TITLE-->
        <!--Qty-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.quantity_short')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="number" class="form-control form-control-sm" id="item_quantity" name="quantity" min="0"
                    placeholder="" value="{{ $inventory->quantity ?? 0 }}">
            </div>
        </div>
        <!--/#Qty-->
        <!--SrNumber-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.serial_number')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="serial_number" name="serial_number"
                    placeholder="" value="{{ $inventory->serial_number ?? '' }}">
            </div>
        </div>
        <!--/#SrNumber-->

        <!-- Quantity by countries -->
        @foreach($inventory_countries as $country)
            <!--Qty-->
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ $country->name }}</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="number" class="form-control form-control-sm" id="qty_country[{{$country->id}}]" name="qty_country[{{$country->id}}]" min="0"
                        placeholder="" value="">
                </div>
            </div>
            <!--/#Qty-->
        @endforeach
        <!-- /#Quantity by countries -->

        <!--Sold-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.sold')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="number" class="form-control form-control-sm" id="sold" name="sold" min="0"
                    placeholder="" value="{{ $inventory->sold ?? 0 }}">
            </div>
        </div>
        <!--/#Sold-->

        <!--Spoiled-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.spoiled')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="number" class="form-control form-control-sm" id="spoiled" name="spoiled" min="0"
                    placeholder="" value="{{ $inventory->spoiled ?? 0 }}">
            </div>
        </div>
        <!--/#Spoiled-->

        <!--Total-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.total')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="number" class="form-control form-control-sm" id="total" name="total" min="0" readonly
                    placeholder="" value="{{ $inventory->total ?? 0 }}">
            </div>
        </div>
        <!--/#Total-->

        <!--Diffrence-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.diffrence')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="number" class="form-control form-control-sm" id="diffrence" name="diffrence" min="0" readonly
                    placeholder="" value="{{ $inventory->diffrence ?? 0 }}">
            </div>
        </div>
        <!--/#Diffrence-->

        <!--Invoice Number-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.invoice_number')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="invoice_number" name="invoice_number"
                    placeholder="" value="{{ $inventory->invoice_number ?? '' }}">
            </div>
        </div>
        <!--/#Invoice Number-->

        <!--Remark-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.remark')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="remark" name="remark"
                    placeholder="" value="{{ $inventory->remark ?? '' }}">
            </div>
        </div>
        <!--/#Remark-->

        <!--Freight Dimensions-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.freight_dimensions')) }}</label>
            <div class="col-sm-12 col-lg-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <label>{{ cleanLang(__('lang.length')) }}(cm)</label>
                            <input type="number" class="form-control form-control-sm" id="fd_length" name="fd_length" min="0"
                                placeholder="" value="">
                        </div>
                        <div class="col-sm-3">
                            <label>{{ cleanLang(__('lang.width')) }}(cm)</label>
                            <input type="number" class="form-control form-control-sm" id="fd_width" name="fd_width" min="0"
                                placeholder="" value="">
                        </div>
                        <div class="col-sm-3">
                            <label>{{ cleanLang(__('lang.height')) }}(cm)</label>
                            <input type="number" class="form-control form-control-sm" id="fd_height" name="fd_height" min="0"
                                placeholder="" value="">
                        </div>
                        <div class="col-sm-3">
                            <label>{{ cleanLang(__('lang.waight')) }}(cm)</label>
                            <input type="number" class="form-control form-control-sm" id="fd_waight" name="fd_waight" min="0"
                                placeholder="" value="">
                        </div>
                    </div>
            </div>
        </div>
        <!--/#Freight Dimensions-->

        <!--SHCHEDULE-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.next_booked_date')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <div class="row">
                    <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm pickadate" name="date_start"
                        autocomplete="off" value="{{ runtimeDatepickerDate($project->date_start ?? '') }}">
                        <input class="mysql-date" type="hidden" name="date_start" id="date_start"
                        value="{{ $inventory->next_booked_date_from ?? '' }}">
                    </div>
                    <div class="col-sm-2">{{ cleanLang(__('lang.to')) }}</div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm pickadate" name="date_due"
                        autocomplete="off" value="{{ runtimeDatepickerDate($project->date_due ?? '') }}">
                        <input class="mysql-date" type="hidden" name="date_due" id="date_due"
                        value="{{ $proinventoryject->next_booked_date_to ?? '' }}">
                    </div>
                </div>
            </div>
        </div>
        <!--/#SHCHEDULE-->

        <!--notes-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small></div>
            </div>
        </div>
    </div>
</div>