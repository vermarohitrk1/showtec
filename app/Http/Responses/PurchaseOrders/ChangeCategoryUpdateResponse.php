<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [category] process for the purchase orders
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\PurchaseOrders;
use Illuminate\Contracts\Support\Responsable;

class ChangeCategoryUpdateResponse implements Responsable {

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

        //generate a new for for each record
        foreach ($allrows as $purchase_orders) {
            //invoice id
            $id = $purchase_orders->first()->po_invoiceid;
            //render html
            $html = view('pages/purchaseorders/components/table/ajax', compact('purchase_orders'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => "#purchase_order_$id",
                'action' => 'replace-with',
                'value' => $html);
            //check the box again (only for bulk actions)
            if (request('type') == 'bulk') {
                $jsondata['dom_property'][] = [
                    'selector' => '#listcheckbox-purchase-orders-' . $id,
                    'prop' => 'checked',
                    'value' => true,
                ];
            }
        }

        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#actionsModal', 'action' => 'close-modal');

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);

    }

}
