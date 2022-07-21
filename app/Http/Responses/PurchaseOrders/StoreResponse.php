<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [store] process for the purchase orders
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\PurchaseOrders;
use Illuminate\Contracts\Support\Responsable;

class StoreResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for purchase orders
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }
        
        //redirect to purchase order page
        $jsondata['redirect_url'] = url("/purchase-orders/$id/edit-purchase-order");

        //response
        return response()->json($jsondata);
    }

}
