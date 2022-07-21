<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [index] process for the warehouses
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Warehouses;
use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for team members
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //was this call made from an embedded page/ajax or directly on team page
        if (request('source') == 'ext' || request('action') == 'search' || request()->ajax()) {

            //template and dom - for additional ajax loading
            switch (request('action')) {

            case 'load':
                $template = 'pages/warehouses/components/table/ajax';
                $dom_container = '#warehouses-td-container';
                $dom_action = 'append';
                break;

            //from the sorting links
            case 'sort':
                $template = 'pages/warehouses/components/table/ajax';
                $dom_container = '#warehouses-td-container';
                $dom_action = 'replace';
                break;

            case 'search':
                $template = 'pages/warehouses/components/table/table';
                $dom_container = '#warehouses-table-wrapper';
                $dom_action = 'replace-with';
                break;

            default:
                //template and dom - for ajax initial loading
                $template = 'pages/warehouses/tabswrapper';
                $dom_container = '#embed-content-container';
                $dom_action = 'replace';
                break;
            }

            //reset stats
            $stats_html = view('misc/list-pages-stats', compact('stats'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#warehouses-stats-wrapper',
                'action' => 'replace',
                'value' => $stats_html);

            //load more button - change the page number and determine buttons visibility
            if ($warehouses->currentPage() < $warehouses->lastPage()) {
                $url = loadMoreButtonUrl($warehouses->currentPage() + 1, request('source'));
                $jsondata['dom_attributes'][] = array(
                    'selector' => '#load-more-button',
                    'attr' => 'data-url',
                    'value' => $url);
                //load more - visible
                $jsondata['dom_visibility'][] = array('selector' => '.loadmore-button-container', 'action' => 'show');
                //load more: (intial load - sanity)
                $page['visibility_show_load_more'] = true;
                $page['url'] = $url;
            } else {
                $jsondata['dom_visibility'][] = array('selector' => '.loadmore-button-container', 'action' => 'hide');
            }

            //flip sorting url for this particular link - only is we clicked sort menu links
            if (request('action') == 'sort') {
                $sort_url = flipSortingUrl(request()->fullUrl(), request('sortorder'));
                $element_id = '#sort_' . request('orderby');
                $jsondata['dom_attributes'][] = array(
                    'selector' => $element_id,
                    'attr' => 'data-url',
                    'value' => $sort_url);
            }

            //render the view and save to json
            $html = view($template, compact('page', 'stats', 'warehouses'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => $dom_container,
                'action' => $dom_action,
                'value' => $html);

            //move the actions buttons
            if (request('source') == 'ext' && request('action') == '') {
                $jsondata['dom_move_element'][] = array(
                    'element' => '#list-page-actions',
                    'newparent' => '.parent-page-actions',
                    'method' => 'replace',
                    'visibility' => 'show');
                $jsondata['dom_visibility'][] = [
                    'selector' => '#list-page-actions-container',
                    'action' => 'show',
                ];
            }

            //for embedded - change breadcrumb title
            $jsondata['dom_html'][] = [
                'selector' => '.active-bread-crumb',
                'action' => 'replace',
                'value' => strtoupper(__('lang.warehouses')),
            ];

            //reload stats widget
            $html = view('misc/list-pages-stats', compact('stats'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#list-pages-stats-widget',
                'action' => 'replace-with',
                'value' => $html);

            //ajax response
            return response()->json($jsondata);

        } else {
            //standard view
            $page['url'] = loadMoreButtonUrl($warehouses->currentPage() + 1, request('source'));
            $page['loading_target'] = 'warehouses-td-container';
            $page['visibility_show_load_more'] = ($warehouses->currentPage() < $warehouses->lastPage()) ? true : false;
            return view('pages/warehouses/wrapper', compact('page', 'stats', 'warehouses', 'categories', 'tags'))->render();
        }

    }
}