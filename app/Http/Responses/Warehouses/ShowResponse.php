<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [show] process for the warehouses
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Warehouses;

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

        return view('pages/warehouse/wrapper', compact('page', 'warehouse', 'fields', 'tags'))->render();
    }
}
