<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [index] process for the vendors
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\VendorFiles;

use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable
{

    private $payload;

    public function __construct($payload = array())
    {
        $this->payload = $payload;
    }

    /**
     * render the view for team members
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

        //was this call made from an embedded page/ajax or directly on team page
        if (request('source') == 'ext' || request('action') == 'search' || request()->ajax()) {

            //template and dom - for additional ajax loading
            switch (request('action')) {

                case 'load':
                    $template = 'pages/vendorfiles/components/table/ajax';
                    $dom_container = '#vendor-files-td-container';
                    $dom_action = 'append';
                    break;

                    //from the sorting links
                case 'sort':
                    $template = 'pages/vendorfiles/components/table/ajax';
                    $dom_container = '#vendor-files-td-container';
                    $dom_action = 'replace';
                    break;

                case 'search':
                    $template = 'pages/vendorfiles/components/table/table';
                    $dom_container = '#vendor-files-table-wrapper';
                    $dom_action = 'replace-with';
                    break;

                default:
                    //template and dom - for ajax initial loading
                    $template = 'pages/vendorfiles/wrapper';
                    $dom_container = '#embed-content-container';
                    $dom_action = 'replace';
                    break;
            }
            // dd($template);
            //reset stats
            // $stats_html = view('misc/list-pages-stats', compact('stats'))->render();
            // $jsondata['dom_html'][] = array(
            //     'selector' => '#vendors-stats-wrapper',
            //     'action' => 'replace',
            //     'value' => $stats_html
            // );

            //load more button - change the page number and determine buttons visibility
            if ($vendorFiles->currentPage() < $vendorFiles->lastPage()) {
                $url = loadMoreButtonUrl($vendorFiles->currentPage() + 1, request('source'));
                $jsondata['dom_attributes'][] = array(
                    'selector' => '#load-more-button',
                    'attr' => 'data-url',
                    'value' => $url
                );
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
                    'value' => $sort_url
                );
            }

            //render the view and save to json
            $html = view($template, compact('page', 'vendorFiles'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => $dom_container,
                'action' => $dom_action,
                'value' => $html
            );

            //move the actions buttons
            if (request('source') == 'ext' && request('action') == '') {
                $jsondata['dom_move_element'][] = array(
                    'element' => '#list-page-actions',
                    'newparent' => '.parent-page-actions',
                    'method' => 'replace',
                    'visibility' => 'show'
                );
                $jsondata['dom_visibility'][] = [
                    'selector' => '#list-page-actions-container',
                    'action' => 'show',
                ];
            }

            //for embedded - change breadcrumb title
            $jsondata['dom_html'][] = [
                'selector' => '.active-bread-crumb',
                'action' => 'replace',
                'value' => strtoupper(__('lang.vendors')),
            ];
            // dd($jsondata);

            //reload stats widget
            // $html = view('misc/list-pages-stats', compact('stats'))->render();
            // $jsondata['dom_html'][] = array(
            //     'selector' => '#list-pages-stats-widget',
            //     'action' => 'replace-with',
            //     'value' => $html
            // );

            //ajax response
            return response()->json($jsondata);
        } else {
            dd('normal view');
            //standard view
            $page['url'] = loadMoreButtonUrl($vendorFiles->currentPage() + 1, request('source'));
            $page['loading_target'] = 'vendor-files-td-container';
            $page['visibility_show_load_more'] = ($vendorFiles->currentPage() < $vendorFiles->lastPage()) ? true : false;
            return view('pages/vendorfiles/wrapper', compact('page', 'vendorFiles', 'categories', 'tags'))->render();
        }
    }
}
