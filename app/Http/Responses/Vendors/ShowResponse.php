<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [show] process for the vendors
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Vendors;

use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable
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

        return view('pages/vendor/wrapper', compact('page', 'vendor', 'fields', 'tags', 'payments'))->render();
    }
}
