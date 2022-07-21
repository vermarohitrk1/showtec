<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [destroy] process for the purchase orders
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Warehouses;

use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable
{

    private $payload;

    public function __construct($payload = array())
    {
        $this->payload = $payload;
    }

    /**
     * remove the item from the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //hide and remove all deleted rows
        foreach ($allrows as $id) {
            $jsondata['dom_visibility'][] = array(
                'selector' => '#warehouse_' . $id,
                'action' => 'slideup-slow-remove',
            );
        }

        //refresh stats
        if (isset($stats)) {
            $html = view('misc/list-pages-stats-content', compact('stats'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#list-pages-stats-widget',
                'action' => 'replace',
                'value' => $html,
            ];
        }

        //deleting from purchase order page
        if (request('source') == 'page') {
            request()->session()->flash('success-notification', __('lang.request_has_been_completed'));
            $jsondata['redirect_url'] = url('purchase-orders');
        }

        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);
    }
}