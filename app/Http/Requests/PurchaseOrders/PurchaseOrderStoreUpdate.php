<?php

/** --------------------------------------------------------------------------------
 * This middleware class validates input requests for the purchase order controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Requests\PurchaseOrders;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseOrderStoreUpdate extends FormRequest
{
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
        //custom error messages
        return [
            'bill_clientid.exists' => __('lang.item_not_found'),
            'bill_categoryid.exists' => __('lang.item_not_found'),
            'bill_projectid.exists' => __('lang.item_not_found'),
            'bill_recurring_duration.required_if' => __('lang.fill_in_all_required_fields'),
            'company_name.required' => __('lang.company_name') . ' ' . __('lang.is_required'),
            'first_name.required' => __('lang.first_name') . ' ' . __('lang.is_required'),
            'last_name.required' => __('lang.last_name') . ' ' . __('lang.required'),
            'email.required' => __('lang.email') . ' ' . __('lang.required'),
            'email.email' => __('lang.email') . ' ' . __('lang.is_not_a_valid_email_address'),
            'email.unique' => __('lang.email_already_exists'),
        ];
    }

    /**
     * Validate the request
     * @return array
     */
    public function rules() {

        //initialize
        $rules = [];

        /**-------------------------------------------------------
         * [create][existing vendor] only rules
         * ------------------------------------------------------*/
        if ($this->getMethod() == 'POST' && request('vendor-selection-type') == 'existing') {
            $rules += [
                'po_vendorid' => [
                    'required',
                    Rule::exists('vendors', 'vendor_id'),
                ],
            ];
        }

        /**-------------------------------------------------------
         * [create][new vendor] only rules
         * ------------------------------------------------------*/
        if ($this->getMethod() == 'POST' && request('vendor-selection-type') == 'new') {
            $rules += [
                'vendor_company_name' => [
                    'required',
                ],
                'first_name' => [
                    'required',
                ],
                'last_name' => [
                    'required',
                ],
                'mobile_number' => [
                    'required',
                ],
            ];
            if(request()->email != '' ) {
                $rules += [
                    'email' => [
                        'sometimes',
                        'email',
                    ],
                ];
            }
        }

        /**-------------------------------------------------------
         * [update] only rules
         * ------------------------------------------------------*/
        if ($this->getMethod() == 'PUT') {
            $rules += [

            ];
        }

        /**-------------------------------------------------------
         * common rules for both [create] and [update] requests
         * ------------------------------------------------------*/
        $rules += [
            'po_date' => [
                'required',
                'date',
            ],
            'po_categoryid' => [
                'required',
                Rule::exists('categories', 'category_id'),
            ],
            'tags' => [
                'bail',
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $key => $data) {
                        if (hasHTML($data)) {
                            return $fail(__('lang.tags_no_html'));
                        }
                    }
                },
            ],
        ];
        //validate
        return $rules;
    }

    /**
     * Deal with the errors - send messages to the frontend
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
