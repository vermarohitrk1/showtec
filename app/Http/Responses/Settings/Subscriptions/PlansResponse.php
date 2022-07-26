<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [index] process for the temp settings
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Settings\Subscriptions;
use Illuminate\Contracts\Support\Responsable;

class PlansResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for bars
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //error - stripe not setup yet
        if ($section == 'stripe-not-configured') {
            $html = view('pages/settings/sections/subscriptions/error', compact('page', 'section'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => "#settings-wrapper",
                'action' => 'replace',
                'value' => $html);
        }


        //ajax response
        return response()->json($jsondata);
    }
}
