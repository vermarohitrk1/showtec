<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [destroy] process for the purchase orders
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\PurchaseOrders;
use Illuminate\Contracts\Support\Responsable;

class AuthorizeResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * remove the item from the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //refresh actions
        $html = view('pages/po/components/misc/actions', compact('po'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#list-page-actions-container',
            'action' => 'replace',
            'value' => $html,
        ];

        //refresh status
        $status_html = view('pages/po/components/elements/header-web', compact('po'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#list-page-header-web-widget',
            'action' => 'replace',
            'value' => $status_html,
        ];

        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);

    }

}
