<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [publish] process for the purchase orders
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\PurchaseOrders;
use Illuminate\Contracts\Support\Responsable;

class ReleaseResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for invoices
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //hide release button
        $jsondata['dom_visibility'][] = [
            'selector' => '#purchase-order-action-release-purchase-order',
            'action' => 'hide',
        ];

        //update status
        $jsondata['dom_visibility'][] = [
            'selector' => '#purchase-order-status-new',
            'action' => 'hide',
        ];
        
        $jsondata['dom_visibility'][] = [
            'selector' => '#purchase-order-status-released',
            'action' => 'show',
        ];
        

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);
    }
}
