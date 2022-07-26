<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [paypal] process for the pay
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Pay;
use Illuminate\Contracts\Support\Responsable;

class MolliePaymentResponse implements Responsable {

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

        //generate paynow button
        $jsondata['redirect_url'] = $redirect_url;

        //response
        return response()->json($jsondata);
    }

}
