<div class="row">
    <div class="col-lg-12">

        @if(isset($page['section']) && $page['section'] == 'create')
            <div class="client-selector">
                    <!--existing client-->
                    <div class="client-selector-container" id="client-existing-container">
                        <div class="form-group row">
                            <label class="col-12 text-left control-label col-form-label">{{ $page['form_label_parent_category'] ?? '' }} ({{ cleanLang(__('lang.optional')) }})</label>
                            <div class="col-12">
                                <!--select2 basic search-->
                                <select class="select2-basic form-control form-control-sm" id="migrate"
                                    name="parent_category">
                                    <option>&nbsp;</option>
                                    @foreach($categories as $parent)
                                    <option value="{{ $parent->category_id }}">{{ $parent->category_name }}</option>
                                    @endforeach
                                </select>
                                <!--select2 basic search-->
                            </div>
                        </div>
                    </div>
            </div>
        @elseif(isset($category->parent_category) && $category->parent_category !=0)
        <div class="client-selector">
                    <!--existing client-->
                    <div class="client-selector-container" id="client-existing-container">
                        <div class="form-group row">
                            <label class="col-12 text-left control-label col-form-label">{{ $page['form_label_parent_category'] ?? '' }}</label>
                            <div class="col-12"> <strong> {{ $category->name($category->parent_category) }} </strong></div>
                        </div>
                    </div>
            </div>
        @endif



        <!--title-->
        <div class="form-group row">
            <label class="col-12 text-left control-label col-form-label required">{{ $page['form_label_category_name'] ?? '' }}</label>
            <div class="col-12">
                <input type="text" class="form-control form-control-sm" id="category_name" name="category_name"
                    value="{{ $category->category_name ?? '' }}">
                <input type="hidden" name="category_type" value="{{ request('category_type') }}">
            </div>
        </div>
        
        <!-- category color -->
        @if((isset($category->category_type) && $category->category_type == 'inventory') || request('category_type') == 'inventory')
        <div class="form-group row">
            <label class="col-12 text-left control-label col-form-label">{{ $page['form_label_category_color'] ?? '' }}</label>
            <div class="col-md-6">
                <input type="color" class="form-control form-control-color" id="category_color" name="category_color" value="{{ $category->category_color ?? '' }}" title="Choose your color" colorpick-eyedropper-active="true">
            </div>
        </div>
        @endif


        <!--migrate to another category-->
        @if(isset($page['section']) && $page['section'] == 'edit')
        <div class="form-group row">
            <label class="col-12 text-left control-label col-form-label">{{ $page['form_label_move_items'] ?? '' }} ({{ cleanLang(__('lang.optional')) }})</label>
            <div class="col-12">
                <select class="select2-basic form-control form-control-sm" id="migrate"
                    name="migrate">
                    <option>&nbsp;</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

    </div>
</div>