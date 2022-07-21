<?php

/** --------------------------------------------------------------------------------
 * This middleware class validates input requests for the projects controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Requests\Inventories;

use App\Rules\NoTags;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryStoreUpdate extends FormRequest {

    /**
     * we are checking authorised users via the middleware
     * so just retun true here
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * custom error messages for specific valdation checks
     * @optional
     * @return array
     */
    public function messages() {
        return [];
    }

    /**
     * Validate the request
     * @return array
     */
    public function rules() {

        //initialize
        $rules = [];

        /**-------------------------------------------------------
         * [create] only rules
         * ------------------------------------------------------*/
        if ($this->getMethod() == 'POST' && request('selection-type') == 'existing') {

        }

        /**-------------------------------------------------------
         * [create][new item] only rules
         * ------------------------------------------------------*/
        if ($this->getMethod() == 'POST' && request('selection-type') == 'new') {

        }

        /**-------------------------------------------------------
         * common rules for both [create] and [update] requests
         * ------------------------------------------------------*/
        $rules += [
            'name' => [
                'required'
            ],
            'quantity' => [
                'required',
                'numeric'
            ],
            'total' => [
                function ($attribute, $value, $fail) {
                    if ($value != '' && request('quantity') != '' && ($value <= request('quantity'))) {
                        return $fail(__('lang.total_must_smaller_then_quantity'));
                    }
                },
            ],
            'date_start' => [
                'nullable',
                'date',
            ],
            'date_due' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) {
                    if ($value != '' && request('date_start') != '' && (strtotime($value) < strtotime(request('date_start')))) {
                        return $fail(__('lang.due_date_must_be_after_start_date'));
                    }
                },
            ],
            
        ];

        //validate
        return $rules;
    }

    /**
     * Custom error handing - show message to front end
     */
    public function failedValidation(Validator $validator) {

        $errors = $validator->errors();
        $messages = '';
        foreach ($errors->all() as $message) {
            $messages .= "<li>$message</li>";
        }

        abort(409, $messages);
    }
}
