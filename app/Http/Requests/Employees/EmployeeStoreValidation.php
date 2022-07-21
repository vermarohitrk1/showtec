<?php

/** --------------------------------------------------------------------------------
 * This middleware class validates input requests for the template controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Requests\Employees;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreValidation extends FormRequest {

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
        return [
            'project_categoryid.exists' => __('lang.item_not_found'),
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
         * [create] only rules
         * ------------------------------------------------------*/
        if ($this->getMethod() == 'POST') {
            $rules += [
                'first_name' => [
                    'required',
                ],
                'last_name' => [
                    'required',
                ],
                'email' => [
                    'required',
                    'email',
                    'unique:users,email',
                ],
            ];
        }

        /**-------------------------------------------------------
         * [update] only rules
         * ------------------------------------------------------*/
        if ($this->getMethod() == 'PUT') {

        }

        /**-------------------------------------------------------
         * common rules for both [create] and [update] requests
         * ------------------------------------------------------*/
        $rules += [
            'employee_company' => [
                'required',
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
