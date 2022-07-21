<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [pdf] process for the purchase orders
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\PurchaseOrders;
use App\Http\Responses\PurchaseOrders\PDFResponse;
use Illuminate\Contracts\Support\Responsable;
use PDF;

class PDFResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //[debugging purposes] view invoice in browser (https://domain.com/invoice/1/pdf?view=preview)
        if (request('view') == 'preview') {
            config(['css.po_mode' => 'pdf-mode-preview']);
            return view('pages/po/po-pdf', compact('page', 'po', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields'))->render();
        }

        //download pdf view
        config(['css.po_mode' => 'pdf-mode-download']);
        $pdf = PDF::loadView('pages/po/po-pdf', compact('page', 'po', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields'));
        $filename = strtoupper(__('lang.purchase_order')) . '-' . $po->formatted_po_invoiceid . '.pdf'; //invoice_inv0001.pdf
        return $pdf->download($filename);
    }
}
