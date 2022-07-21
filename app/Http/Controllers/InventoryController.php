<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Responses\Inventories\StoreResponse;
use App\Http\Responses\Inventories\IndexResponse;
use App\Http\Responses\Inventories\CreateResponse;
use App\Repositories\InventoryCountryRepository;
use App\Repositories\InventoryRepository;
use App\Http\Requests\Inventories\InventoryStoreUpdate;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * The inventory repository instance.
     */
    protected $inventoryrepo;
    
     //contruct
    public function __construct(InventoryRepository $inventoryrepo, InventoryCountryRepository $inventory_countryrepo) {

            //parent
            parent::__construct();

            //vars
            $this->inventoryrepo = $inventoryrepo;
            $this->inventory_countryrepo = $inventory_countryrepo;


            //authenticated
            $this->middleware('auth');

            $this->middleware('inventoryMiddlewareIndex')->only([
                'index'
            ]);

        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            
            $inventories = $this->inventoryrepo->search();
            $inventory_countries = $this->inventory_countryrepo->get_inventory_countries();
            
            $payload = [
                'inventories' => $inventories,
                'inventory_countries' => $inventory_countries,
                'page' => $this->pageSettings('inventories')
            ];

            return new IndexResponse($payload);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
    
            $inventory_countries = $this->inventory_countryrepo->get_inventory_countries();

            //reponse payload
            $payload = [
                'inventory'=> array(),
                'inventory_countries' => $inventory_countries,
                'page' => $this->pageSettings('create'),
                ];
    
            //show the form
            return new CreateResponse($payload);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(InventoryStoreUpdate $request)
        {
            $inventory_countries = $this->inventory_countryrepo->get_inventory_countries();

            // foreach($inventory_countries as $country)
            // {
            //     $quantity_by_country[$country->short_name] = request('qty_country_'.$country->short_name);
            // }
            //$data['quantity_by_country'] = json_encode($quantity_by_country);
            $data['highlighted'] = request('highlighted') == 'on' ? 1 : 0;
            $data['freight_dimensions'] = json_encode(array('fd_length'=>request('fd_length'),'fd_width'=>request('fd_width'),'fd_height'=>request('fd_height'),'fd_weight'=>request('fd_weight')));

            //create the project
            if (!$inventory_id = $this->inventoryrepo->create($data)) {
                abort(409);
            }
            // add quantity by country
            $inv_countryrepo->add($inventory_id);

            //get the lead
            $inventories = $this->inventoryrepo->search($inventory_id);

            //counting rows
            $rows = $this->inventoryrepo->search();

            //reponse payload
            $payload = [
                'inventories' => $inventories,
                'inventory_id' => $inventory_id,
                'count' => $rows->total()
            ];

            //process reponse
            return new StoreResponse($payload);
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Inventory  $inventory
         * @return \Illuminate\Http\Response
         */
        public function show(Inventory $inventory)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  \App\Inventory  $inventory
         * @return \Illuminate\Http\Response
         */
        public function edit(Inventory $inventory)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\Inventory  $inventory
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Inventory $inventory)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Inventory  $inventory
         * @return \Illuminate\Http\Response
         */
        public function destroy(Inventory $inventory)
        {
            //
        }


            /**
         * basic page setting for this section of the app
         * @param string $section page section (optional)
         * @param array $data any other data (optional)
         * @return array
         */
        private function pageSettings($section = '', $data = []) {

            //common settings
            $page = [
                'crumbs' => [
                    __('lang.inventory'),
                ],
                'crumbs_special_class' => 'list-pages-crumbs',
                'page' => 'inventory',
                'no_results_message' => __('lang.no_results_found'),
                'mainmenu_inventory' => 'active',
                'submenu_inventory' => 'active',
                'sidepanel_id' => 'sidepanel-filter-inventory',
                'dynamic_search_url' => url('inventory/search?action=search'),
                'add_button_classes' => 'add-edit-inventory-button',
                'load_more_button_route' => 'inventory',
                'source' => 'list',
            ];

            //default modal settings (modify for sepecif sections)
            $page += [
                'add_modal_title' => __('lang.add_inventory'),
                'add_modal_create_url' => url('inventory/create'),
                'add_modal_action_url' => url('inventory'),
                'add_modal_action_ajax_class' => '',
                'add_modal_action_ajax_loading_target' => 'commonModalBody',
                'add_modal_action_method' => 'POST',
            ];

            //inventorys list page
            if ($section == 'inventories') {
                $page += [
                    'meta_title' => __('lang.inventory'),
                    'heading' => __('lang.inventory'),
                    'sidepanel_id' => 'sidepanel-filter-inventory',
                ];
                if (request('source') == 'ext') {
                    $page += [
                        'list_page_actions_size' => 'col-lg-12',
                    ];
                }
                return $page;
            }

            //project page
            if ($section == 'inventory') {
                //adjust
                $page['page'] = 'project';

                //crumbs
                $page['crumbs'] = [
                    __('lang.project'),
                    '#' . $data->project_id,
                ];

                //add
                $page += [
                    'crumbs_special_class' => 'main-pages-crumbs',
                    'meta_title' => __('lang.projects') . ' - ' . $data->project_title,
                    'heading' => $data->project_title,
                    'project_id' => request()->segment(2),
                    'source_for_filter_panels' => 'ext',
                    'section' => 'overview',
                ];
                //ajax loading and tabs
                return $page;
            }

            //ext page settings
            if ($section == 'ext') {
                $page += [
                    'list_page_actions_size' => 'col-lg-12',

                ];
                return $page;
            }

            //create new resource
            if ($section == 'create') {
                $page += [
                    'section' => 'create',
                ];
                return $page;
            }

            //edit new resource
            if ($section == 'edit') {
                $page += [
                    'section' => 'edit',
                ];
                return $page;
            }

            //return
            return $page;
        }
}
