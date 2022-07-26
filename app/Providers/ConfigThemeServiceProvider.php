<?php
/** ----------------------------------------------------------------------------------------
 *  [GROWCRM][THEME SERVICE PROVIDER]
 *
 *  -Sets and validate the correct theme (as set in the database)
 *
 *  This service provider is skipped when the application's setup has not been completed
 * -----------------------------------------------------------------------------------------*/

/** --------------------------------------------------------------------------------
 * This service provider configures the applications email settings
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Log;

class ConfigThemeServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {

        //do not run this for SETUP path
        // if (env('SETUP_STATUS') != 'COMPLETED') {
        //     //set default theme
        //     config([
        //         'theme.selected_theme_css' => 'themes/default/css/style.css?v=1',
        //     ]);
        //     //skip this provider
        //     return;
        // }

        //get settings
        // $settings = \App\Models\Settings::find(1);

        //get all directories in themes folder
        $directories = Storage::disk('root')->directories('public/themes');

        //clean up directory names
        array_walk($directories, function (&$value, &$key) {
            $value = str_replace('public/themes/', '', $value);
        });

        //check if default theme exists
        // if (!in_array($settings->settings_theme_name, $directories)) {
        //     Log::critical("The selected theme directory could not be found", ['process' => '[validating theme]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'Theme Directory: ' => '/public/themes/' . $settings->settings_theme_name]);
        //     abort(409, __('lang.default_theme_not_found') . ' [' . runtimeThemeName($settings->settings_theme_name) . ']');
        // }

        //check if css file exists
        // if (!is_file(base_path() . '/public/themes/' . $settings->settings_theme_name . '/css/style.css')) {
        //     Log::critical("The selected theme does not seem to have a style.css files", ['process' => '[validating theme]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'Theme Directory: ' => '/public/themes/' . $settings->settings_theme_name]);
        //     abort(409, __('lang.selected_theme_is_invalid'));
        // }

        //validate if the folders in the /public/themes/ directory have a style.css file
        $list = [];
        foreach ($directories as $directory) {
            if (is_file(base_path() . "/public/themes/$directory/css/style.css")) {
                $list[] = $directory;
            }
        }

        //set global data
        // config([
        //     'theme.list' => $list,
        //     'theme.selected_name' => $settings->settings_theme_name,
        //     //main css file
        //     'theme.selected_theme_css' => 'themes/' . $settings->settings_theme_name . '/css/style.css?v='.$settings->settings_system_javascript_versioning,
        //     //invoice/estimate pdf (web preview)
        //     'theme.selected_theme_pdf_css' => 'public/themes/' . $settings->settings_theme_name . '/css/bill-pdf.css?v='.$settings->settings_system_javascript_versioning,
        // ]);

        config([
            'theme.list' => $list,
            'theme.selected_name' => 'default',
            //main css file
            'theme.selected_theme_css' => 'themes/' . 'default' . '/css/style.css?v='.'2021-05-11',
            //invoice/estimate pdf (web preview)
            'theme.selected_theme_pdf_css' => 'public/themes/' . 'default' . '/css/bill-pdf.css?v='.'2021-05-11',
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
