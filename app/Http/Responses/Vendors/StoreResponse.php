<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [store] process for the vendors
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Vendors;
use Illuminate\Contracts\Support\Responsable;

class StoreResponse implements Responsable {

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

        //prepend content on top of list or show full table
        if ($count == 1) {
            $html = view('pages/vendors/components/table/table', compact('vendors'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#vendors-table-wrapper',
                'action' => 'replace',
                'value' => $html);
        } else {
            //prepend use on top of list
            $html = view('pages/vendors/components/table/ajax', compact('vendors'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#vendors-td-container',
                'action' => 'prepend',
                'value' => $html);
        }
        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        
        //response
        return response()->json($jsondata);

    }

}
