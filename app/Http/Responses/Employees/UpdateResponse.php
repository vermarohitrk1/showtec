<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [update] process for the clients
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Employees;
use Illuminate\Contracts\Support\Responsable;

class UpdateResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for team members
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //replace the row of this record
        $html = view('pages/employees/components/table/ajax', compact('employees'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => "#employee_" . $employees->first()->id,
            'action' => 'replace-with',
            'value' => $html);


        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //editing from main page
        if (request('ref') == 'page') {

            //close modal
            $jsondata['dom_visibility'][] = array('selector' => '.modal', 'action' => 'close-modal');

            //redirect to project page
            $jsondata['redirect_url'] = url("employees/".$employees->first()->id);

            //success
            request()->session()->flash('success-notification', __('lang.request_has_been_completed'));      
        }

        //response
        return response()->json($jsondata);

    }

}
