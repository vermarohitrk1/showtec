<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [pdf] process for the invoices
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Invoices;

use Illuminate\Contracts\Support\Responsable;
use PDF;

class PDFResponse implements Responsable
{

    private $payload;

    public function __construct($payload = array())
    {
        $this->payload = $payload;
    }

    /**
     * render the view
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

        // dd($this->payload);

        //[debugging purposes] view invoice in browser (https://domain.com/invoice/1/pdf?view=preview)
        if (request('view') == 'preview') {
            config(['css.bill_mode' => 'pdf-mode-preview']);
            return view('pages/bill/bill-pdf-new', compact('page', 'bill', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields'))->render();
        }

        //download pdf view
        config(['css.bill_mode' => 'pdf-mode-download']);
        if (request('type') === 'quotation') {
            $pdf = PDF::loadView('pages/pdf/quotation', compact('page', 'bill', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields'));
        } else if (request('type') === 'deliverynote') {
            $pdf = PDF::loadView('pages/pdf/delivernote', compact('page', 'bill', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields'));
        } else if (request('type') === 'taxinvoice') {
            $pdf = PDF::loadView('pages/pdf/taxinv', compact('page', 'bill', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields'));
        } else if (request('type') === 'cinvoice') {
            $pdf = PDF::loadView('pages/pdf/cinv', compact('page', 'bill', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields'));
        } else if (request('type') === 'pi_sgd') {
            $pdf = PDF::loadView('pages/pdf/pi_sgd', compact('page', 'bill', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields'));
        } else if (request('type') === 'pi_usd') {
            $pdf = PDF::loadView('pages/pdf/pi_usd', compact('page', 'bill', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields'));
        } else {
            $pdf = PDF::loadView('pages/pdf/taxinv', compact('page', 'bill', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields'));
        }
        $filename = strtoupper(__('lang.invoice')) . '-' . $bill->formatted_bill_invoiceid . '.pdf'; //invoice_inv0001.pdf
        $pdf->setPaper('a4');
        return $pdf->download($filename);
    }
}
