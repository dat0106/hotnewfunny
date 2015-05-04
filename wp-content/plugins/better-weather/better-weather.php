<?php
/*
Plugin Name: BetterWeather
Plugin URI: http://codecanyon.net/item/better-weather-wordpress-version/7724257?ref=Better-Studio
Description:
Version: 1.5.0.1
Author: BetterWeather
Author URI: http://betterstudio.com
License: GPL2
*/

//  Last version ( V < 1.5 ) compatibility
$last_options = get_option( 'bwoptions_settings' );
if( $last_options != false ){

    if( $last_options['bwoptions_api_forecast_apiKei'] != '' )
        add_filter( 'better-framework/panel/options', 'bw_add_api_key_to_new_panel', 150 );
}
function bw_add_api_key_to_new_panel( $options ){

    $last_options = get_option( 'bwoptions_settings' );
    $options['better_weather_options']['fields']['api_key']['std'] =  $last_options['bwoptions_api_forecast_apiKei'];
    delete_option( 'bwoptions_settings' );

    return $options;

}


new Better_Weather();

class Better_Weather{

    /**
     * Contains BW version number that used for assets for preventing cache mechanism
     *
     * @var string
     */
    private static $version = '1.5.0.1';


    function __construct(){

        define( 'BETTER_WEATHER_DIR_URL' , plugin_dir_url( __FILE__ ) );
        define( 'BETTER_WEATHER_DIR_PATH' , plugin_dir_path( __FILE__ ) );

        // Clear BF transients on plugin activation
        register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

        // Register included BF to loader
        add_filter( 'better-framework/loader', array( $this, 'better_framework_loader' ) );

        // Enable needed sections
        add_filter( 'better-framework/sections', array( $this, 'better_framework_sections' ) );

        // Admin panel options
        add_filter( 'better-framework/panel/options' , array( $this , 'setup_option_panel' ) );

        // Active and new shortcodes
        add_filter( 'better-framework/shortcodes', array( $this, 'setup_shortcodes' ) );

        // Initialize BetterWeather
        add_action( 'better-framework/after_setup', array( $this, 'init' ) );

        add_action( 'plugins_loaded', array( $this, 'register_vc_support' ) );

        // Includes BF loader if not included before
        require_once 'includes/libs/better-framework/init.php';

    }


    /**
     * Returns BW current Version
     *
     * @return string
     */
    static function get_version(){
        return self::$version ;
    }


    /**
     * Clears BF transients for avoiding of happening any problem
     */
    function plugin_activation(){

        delete_transient( '__better_framework__widgets_css' );
        delete_transient( '__better_framework__panel_css' );
        delete_transient( '__better_framework__menu_css' );
        delete_transient( '__better_framework__terms_css' );
        delete_transient( '__better_framework__final_fe_css' );
        delete_transient( '__better_framework__final_fe_css_version' );
        delete_transient( '__better_framework__backend_css' );

    }


    /**
     * Adds included BetterFramework to loader
     *
     * @param $frameworks
     * @return array
     */
    function better_framework_loader( $frameworks ){

        $frameworks[] = array(
            'version'   =>  '1.3.2',
            'path'      =>  BETTER_WEATHER_DIR_PATH . 'includes/libs/better-framework/',
            'uri'       =>  BETTER_WEATHER_DIR_URL . 'includes/libs/better-framework/',
        );

        return $frameworks;

    }


    /**
     * activate BF needed sections
     *
     * @param $sections
     * @return mixed
     */
    function better_framework_sections( $sections ){

        $sections['vc-extender'] = true;

        return $sections;

    }


    /**
     *  Init the plugin
     */
    function init(){

        load_plugin_textdomain( 'better-studio', false, 'better-weather/languages' );

        require_once 'includes/generator/class-bw-generator-factory.php';
        BW_Generator_Factory::generator();

        add_action( 'wp_ajax_nopriv_bw_ajax', array( $this, 'ajax_callback' ) );
        add_action( 'wp_ajax_bw_ajax', array( $this, 'ajax_callback' ) );

    }


    /**
     * Setup setting panel for BetterMag
     *
     * 5. => Admin Panel
     *
     * @param $options
     * @return array
     */
    function setup_option_panel( $options ){

        /**
         * 5.1. => General Options
         */
        $field[] = array(
            'name' => __( 'API Key', 'better-studio' ),
            'id' => 'bw_settings',
            'type' => 'tab',
            'icon' => 'fa-key'
        );


            $field['api_key'] = array(
                'name'          =>  __( 'API Key', 'better-studio' ),
                'id'            =>  'api_key',
                'desc'          => __( 'Enter your own API Key for Forecast.io' , 'better-weather' ) ,
                'std'           =>  '',
                'type'          =>  'text',
            );

        $field[] = array(
            'name'          =>  __( 'How to get your own API key!?', 'better-studio' ),
            'id'            =>  'twitter-help',
            'type'          =>  'info',
            'std'           =>  '<p>' . __('Better Weather uses weather API of <a target="_blank" href="http://forecast.io/">Forecast.io</a>. For showing forecast you should get a free API key with a simple sign up to the site.', 'better-studio' ) .

                '</p><ol><li>' .  __( 'Go to <a href="http://goo.gl/d1d6Ji" target="_blank">https://developer.forecast.io/register</a> and Sing up', 'better-studio' ) . '<br><br><img class="aligncenter" src="' . BETTER_WEATHER_DIR_URL .'img/help-singup-page.png"><br></li>
    <li>After you can see your API Key in bottom of page.<br><br><img class="aligncenter" src="' . BETTER_WEATHER_DIR_URL .'img/help-singup-page-api.png"><br></li>
    <li>Copy "API Key" and paste that in upper input box.</li>
  </ol>

',


            'state'         =>  'open',
            'info-type'     =>  'help',
            'section_class' =>  'widefat',
        );

        $field[] = array(
            'name' => __( 'Translations', 'better-studio'),
            'id' => 'translation',
            'std' => 'danes',
            'type' => 'tab',
            'icon' => 'fa-flag-checkered'
        );
            $field[] = array(
                'name'  =>  __( 'Weather Forecast Translations', 'better-studio' ),
                'id'    =>  'tr_forecast',
                'type'  =>  'heading',
            );
                $field['tr_forecast_clear'] = array(
                    'name'          =>  __( 'Clear', 'better-studio' ),
                    'id'            =>  'tr_forecast_clear',
                    'std'           =>  'Clear',
                    'type'          =>  'text',
                );
                $field['tr_forecast_rain'] = array(
                    'name'          =>  __( 'Rain', 'better-studio' ),
                    'id'            =>  'tr_forecast_rain',
                    'std'           =>  'Rain',
                    'type'          =>  'text',
                );
                $field['tr_forecast_snow'] = array(
                    'name'          =>  __( 'Snow', 'better-studio' ),
                    'id'            =>  'tr_forecast_snow',
                    'std'           =>  'Snow',
                    'type'          =>  'text',
                );
                $field['tr_forecast_sleet'] = array(
                    'name'          =>  __( 'Sleet', 'better-studio' ),
                    'id'            =>  'tr_forecast_sleet',
                    'std'           =>  'Sleet',
                    'type'          =>  'text',
                );
                $field['tr_forecast_wind'] = array(
                    'name'          =>  __( 'Wind', 'better-studio' ),
                    'id'            =>  'tr_forecast_wind',
                    'std'           =>  'Wind',
                    'type'          =>  'text',
                );
                $field['tr_forecast_fog'] = array(
                    'name'          =>  __( 'Fog', 'better-studio' ),
                    'id'            =>  'tr_forecast_fog',
                    'std'           =>  'Fog',
                    'type'          =>  'text',
                );
                $field['tr_forecast_cloudy'] = array(
                    'name'          =>  __( 'Cloudy', 'better-studio' ),
                    'id'            =>  'tr_forecast_cloudy',
                    'std'           =>  'Cloudy',
                    'type'          =>  'text',
                );
                $field['tr_forecast_mostly_cloudy'] = array(
                    'name'          =>  __( 'Mostly Cloudy', 'better-studio' ),
                    'id'            =>  'tr_forecast_mostly_cloudy',
                    'std'           =>  'Mostly Cloudy',
                    'type'          =>  'text',
                );
                $field['tr_forecast_partly_cloudy'] = array(
                    'name'          =>  __( 'Partly Cloudy', 'better-studio' ),
                    'id'            =>  'tr_forecast_partly_cloudy',
                    'std'           =>  'Partly Cloudy',
                    'type'          =>  'text',
                );
                $field['tr_forecast_thunderstorm'] = array(
                    'name'          =>  __( 'Thunderstorm', 'better-studio' ),
                    'id'            =>  'tr_forecast_thunderstorm',
                    'std'           =>  'Thunderstorm',
                    'type'          =>  'text',
                );
                $field['tr_forecast_drizzle'] = array(
                    'name'          =>  __( 'Drizzle', 'better-studio' ),
                    'id'            =>  'tr_forecast_drizzle',
                    'std'           =>  'Drizzle',
                    'type'          =>  'text',
                );
                $field['tr_forecast_light_rain'] = array(
                    'name'          =>  __( 'Light Rain', 'better-studio' ),
                    'id'            =>  'tr_forecast_light_rain',
                    'std'           =>  'Light Rain',
                    'type'          =>  'text',
                );
                $field['tr_forecast_overcast'] = array(
                    'name'          =>  __( 'Overcast', 'better-studio' ),
                    'id'            =>  'tr_forecast_overcast',
                    'std'           =>  'Overcast',
                    'type'          =>  'text',
                );
                $field['tr_forecast_breezy_and_partly_cloudy'] = array(
                    'name'          =>  __( 'Breezy and Partly Cloudy', 'better-studio' ),
                    'id'            =>  'tr_forecast_breezy_and_partly_cloudy',
                    'std'           =>  'Breezy and Partly Cloudy',
                    'type'          =>  'text',
                );
                $field['tr_forecast_humid_and_mostly_cloudy'] = array(
                    'name'          =>  __( 'Humid and Mostly Cloudy', 'better-studio' ),
                    'id'            =>  'tr_forecast_humid_and_mostly_cloudy',
                    'std'           =>  'Humid and Mostly Cloudy',
                    'type'          =>  'text',
                );
        // todo add this LIGHT RAIN AND WINDY
        // WINDY AND MOSTLY CLOUDY

            $field[] = array(
                'name'  =>  __( 'Months Name Translations', 'better-studio' ),
                'id'    =>  'tr_month',
                'type'  =>  'heading',
            );

                $field['tr_month_january'] = array(
                    'name'          =>  __( 'January', 'better-studio' ),
                    'id'            =>  'tr_month_january',
                    'std'           =>  'January',
                    'type'          =>  'text',
                );
                $field['tr_month_february'] = array(
                    'name'          =>  __( 'February', 'better-studio' ),
                    'id'            =>  'tr_month_february',
                    'std'           =>  'February',
                    'type'          =>  'text',
                );
                $field['tr_month_march'] = array(
                    'name'          =>  __( 'March', 'better-studio' ),
                    'id'            =>  'tr_month_march',
                    'std'           =>  'March',
                    'type'          =>  'text',
                );
                $field['tr_month_april'] = array(
                    'name'          =>  __( 'April', 'better-studio' ),
                    'id'            =>  'tr_month_april',
                    'std'           =>  'April',
                    'type'          =>  'text',
                );
                $field['tr_month_may'] = array(
                    'name'          =>  __( 'May', 'better-studio' ),
                    'id'            =>  'tr_month_may',
                    'std'           =>  'May',
                    'type'          =>  'text',
                );
                $field['tr_month_june'] = array(
                    'name'          =>  __( 'June', 'better-studio' ),
                    'id'            =>  'tr_month_june',
                    'std'           =>  'June',
                    'type'          =>  'text',
                );
                $field['tr_month_july'] = array(
                    'name'          =>  __( 'July', 'better-studio' ),
                    'id'            =>  'tr_month_july',
                    'std'           =>  'July',
                    'type'          =>  'text',
                );
                $field['tr_month_august'] = array(
                    'name'          =>  __( 'August', 'better-studio' ),
                    'id'            =>  'tr_month_august',
                    'std'           =>  'August',
                    'type'          =>  'text',
                );
                $field['tr_month_september'] = array(
                    'name'          =>  __( 'September', 'better-studio' ),
                    'id'            =>  'tr_month_september',
                    'std'           =>  'September',
                    'type'          =>  'text',
                );
                $field['tr_month_october'] = array(
                    'name'          =>  __( 'October', 'better-studio' ),
                    'id'            =>  'tr_month_october',
                    'std'           =>  'October',
                    'type'          =>  'text',
                );
                $field['tr_month_november'] = array(
                    'name'          =>  __( 'November', 'better-studio' ),
                    'id'            =>  'tr_month_november',
                    'std'           =>  'November',
                    'type'          =>  'text',
                );
                $field['tr_month_december'] = array(
                    'name'          =>  __( 'December', 'better-studio' ),
                    'id'            =>  'tr_month_december',
                    'std'           =>  'December',
                    'type'          =>  'text',
                );

            $field[] = array(
                'name'  =>  __( 'Days Name Translations', 'better-studio' ),
                'id'    =>  'tr_day',
                'type'  =>  'heading',
            );
                $field['tr_days_sat'] = array(
                    'name'          =>  __( 'Sat', 'better-studio' ),
                    'id'            =>  'tr_days_sat',
                    'std'           =>  'Sat',
                    'type'          =>  'text',
                );
                $field['tr_days_sun'] = array(
                    'name'          =>  __( 'Sun', 'better-studio' ),
                    'id'            =>  'tr_days_sun',
                    'std'           =>  'Sun',
                    'type'          =>  'text',
                );
                $field['tr_days_mon'] = array(
                    'name'          =>  __( 'Mon', 'better-studio' ),
                    'id'            =>  'tr_days_mon',
                    'std'           =>  'Mon',
                    'type'          =>  'text',
                );
                $field['tr_days_tue'] = array(
                    'name'          =>  __( 'Tue', 'better-studio' ),
                    'id'            =>  'tr_days_tue',
                    'std'           =>  'Tue',
                    'type'          =>  'text',
                );
                $field['tr_days_wed'] = array(
                    'name'          =>  __( 'Wed', 'better-studio' ),
                    'id'            =>  'tr_days_wed',
                    'std'           =>  'Wed',
                    'type'          =>  'text',
                );
                $field['tr_days_thu'] = array(
                    'name'          =>  __( 'Thu', 'better-studio' ),
                    'id'            =>  'tr_days_thu',
                    'std'           =>  'Thu',
                    'type'          =>  'text',
                );
                $field['tr_days_fri'] = array(
                    'name'          =>  __( 'Fri', 'better-studio' ),
                    'id'            =>  'tr_days_fri',
                    'std'           =>  'Fri',
                    'type'          =>  'text',
                );

        $field[] = array(
            'name'      =>  __( 'Backup & Restore' , 'better-studio' ),
            'id'        =>  'backup_restore',
            'type'      =>  'tab',
            'icon'      =>  'fa-cogs',
            'margin-top'=>  '30',
        );
            $field[] = array(
                'name'      =>  __( 'Backup / Export', 'better-studio' ),
                'id'        =>  'backup_export_options',
                'type'      =>  'export',
                'file_name' =>  'betterweather-options-backup',
                'panel_id'  =>  'better_weather_options',
                'desc'      =>  __( 'This allows you to create a backup of your options and settings. Please note, it will not backup anything else.', 'better-studio' )
            );
            $field[] = array(
                'name'      =>  __( 'Restore / Import', 'better-studio' ),
                'id'        =>  'import_restore_options',
                'type'      =>  'import',
                'desc'      =>  __( '<strong>It will override your current settings!</strong> Please make sure to select a valid backup file.', 'better-studio' )
            );

        $options['better_weather_options'] = array(
            'config' => array(
                'parent'                =>    'better-studio',
                'name'                  =>    __( 'Better Weather', 'better-studio' ),
                'page_title'            =>    __( 'Better Weather', 'better-studio' ),
                'menu_title'            =>    __( 'Better Weather', 'better-studio' ),
                'capability'            =>    'manage_options',
                'menu_slug'             =>    __( 'BetterWeather', 'better-studio' ),
                'icon_url'              =>    null,
                'position'              =>    30,
                'exclude_from_export'   =>    false,
            ),
            'panel-name'          => _x( 'Better Weather Options', 'Panel title', 'better-studio' ),
            'fields' => $field
        );

        return $options;
    }


    /**
     * Setups Shortcodes
     *
     * @param $shortcodes
     */
    function setup_shortcodes( $shortcodes ){

        require_once BETTER_WEATHER_DIR_PATH . 'includes/shortcodes/class-better-weather-shortcode.php';
        require_once BETTER_WEATHER_DIR_PATH . 'includes/widgets/class-better-weather-widget.php';
        $shortcodes['BetterWeather'] = array(
            'shortcode_class'   =>  'Better_Weather_Shortcode',
            'widget_class'      =>  'Better_Weather_Widget',
        );


        require_once BETTER_WEATHER_DIR_PATH . 'includes/shortcodes/class-better-weather-inline-shortcode.php';
        require_once BETTER_WEATHER_DIR_PATH . 'includes/widgets/class-better-weather-inline-widget.php';
        $shortcodes['BetterWeather-inline'] = array(
            'shortcode_class'   =>  'Better_Weather_Inline_Shortcode',
            'widget_class'      =>  'Better_Weather_Inline_Widget',
        );

        return $shortcodes;
    }


    /**
     * Used for cutting Forecast.io data to smaller size for performance issues
     *
     * @param $today_data
     * @param $past_day_data
     * @return array
     */
    function create_result_data( $today_data , $past_day_data ){

        $result = array();

        $result['latitude'] = $today_data->latitude;
        $result['longitude'] = $today_data->longitude;
        $result['timezone'] = $today_data->timezone;
        $result['currently'] = $today_data->currently;

        // temperatureMin
        if(isset($past_day_data->temperatureMin))
            $result['currently']->temperatureMin = $past_day_data->temperatureMin;
        else
            $result['currently']->temperatureMin = __( 'NA', 'better-studio' );

        // temperatureMin
        if(isset($past_day_data->temperatureMax))
            $result['currently']->temperatureMax = $past_day_data->temperatureMax;
        else
            $result['currently']->temperatureMax = __( 'NA', 'better-studio' );

        // sunriseTime
        if(isset($past_day_data->sunriseTime))
            $result['currently']->sunriseTime = $past_day_data->sunriseTime ;
        else
            $result['currently']->sunriseTime = __( 'NA', 'better-studio' );

        // sunsetTime
        if(isset($past_day_data->sunsetTime))
            $result['currently']->sunsetTime = $past_day_data->sunsetTime ;
        else
            $result['currently']->sunsetTime = __( 'NA', 'better-studio' );

        $counter = -1;

        foreach ( $today_data->daily->data as $day){

            if($counter == -1){
                $counter++;
                continue;
            }

            if($counter > 4)
                break;
            else
                $counter++;

            $result['daily'][$counter] = array(
                'dayName'  =>  date('D', $day->time ),
                'time'  =>  $day->time,
                'icon'  =>  $day->icon
            );
        }

        return $result;
    }


    /**
     * Used for finding current user IP and Geo Location Data
     *
     * @return bool|string
     */
    function get_user_geo_location(){

        // get user info's by ip
        if( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ){
            $user_ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){
            $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $user_ip = $_SERVER['REMOTE_ADDR'];
        }

        // return false in local hosts
        if( $user_ip == '127.0.0.1' ){
            return false;
        }

        $user_geo_location = wp_remote_get( "http://bw-api.better-studio.net/get-geo.php?ip=" . $user_ip );

        if( ! isset( $user_geo_location['body'] ) || $user_geo_location['body'] == FALSE ){
            return false;
        }

        $user_geo_location = json_decode( $user_geo_location['body'] );

        if( $user_geo_location->statusCode != 'OK' )
            return false;

        return $user_geo_location->latitude . ',' . $user_geo_location->longitude;

    }


    /**
     * Retrieved data from Forecast.io or cache and return it
     *
     * Action Callback: wp_ajax
     *
     * @return string
     */
    function ajax_callback(){

        // Checks API Key
        if( isset( $_POST["apikey"] ) && $_POST["apikey"] != "" && $_POST["apikey"] != "false" ){
            $apikey = $_POST["apikey"];
        }else{
            echo json_encode(
                array(
                    'status'	=> 'error',
                    'msg'  	    => __( 'Better Weather Error: No API Key provided! Obtain API Key from https://developers.forecast.io/', 'better-studio' ),
                    'data'      => 'no data'
                )
            );
            die();
        }

        // Check location
        if( isset( $_POST["location"] ) && $_POST["location"] != "" ){
            $location = $_POST["location"];
        }else{
            $location = "35.6705,139.7409";
        }

        // If visitor location
        if( isset( $_POST["visitor_location"] ) && $_POST["visitor_location"] ){
            $visitor_location = TRUE;
            $_l = $this->get_user_geo_location();

            if( ! is_bool( $_l ) )
                $location = $_l;

        }else{
            $visitor_location = FALSE;
        }

        // Pretty name used for caching
        $pretty_location_name = str_replace(
            array( ".", "/", "\\", ",", " " ) ,
            "" ,
            trim( $location )
        );

        // If cache is older than 30min, get new data or error if triggered
        if( ( $data = get_transient( 'bw_location_' . $pretty_location_name ) ) === FALSE || $visitor_location == TRUE ){

            // retrieving Today content
            $today_data = wp_remote_get( "https://api.forecast.io/forecast/$apikey/$location?exclude=hourly,flags,alerts,minutely" );

            if( is_wp_error($today_data) || ! isset($today_data['body']) || $today_data['body'] == FALSE ){
                echo json_encode(
                    array(
                        'status'	=>  'error',
                        'msg'  	    =>  __( 'BetterWeather Error: No any data received from Forecast.io!.', 'better-studio' ),
                        'data'      =>  $today_data
                    )
                );
                die();
            }

            if ( $today_data['body'] == "Forbidden" ) {
                echo json_encode(
                    array(
                        'status'	=>  'error',
                        'msg'  	    =>  __( 'Better Weather Error: Provided API key is incorrect!.', 'better-studio' ),
                        'data'      =>  __( 'no data', 'better-studio' )
                    )
                );
                die();
            }

            $today_data = json_decode( $today_data['body'] ) ;

            // hack for getting today min/max temperature and sunset sunrise time!
            if( date('Y M d', $today_data->daily->data[0]->time ) == date('Y M d', $today_data->currently->time ) ){
                $past_day_data = $today_data->daily->data[0];
            }else{
                $past_day_data = wp_remote_get("https://api.forecast.io/forecast/$apikey/$location," . strtotime( "-1 day", time() ) . '?exclude=currently,hourly,flags,alerts,minutely');
                $past_day_data = json_decode( $past_day_data['body'] );
                $past_day_data = $past_day_data->daily->data[0];
            }

            $data = $this->create_result_data( $today_data , $past_day_data );

            if( $visitor_location == FALSE )
                set_transient( 'bw_location_' . $pretty_location_name, $data, MINUTE_IN_SECONDS * 30 );

        }

        echo json_encode(
            array(
                'status'	=>  'succeed',
                'msg'  	    =>  __( 'Data retrieved successfully.', 'better-studio' ),
                'data'      =>  $data
            )
        );

        die();

    }


    /**
     * Register BetterWeather VisualComposer support
     */
    function register_vc_support(){

        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            return;
        }

        // Visual composer widget
        vc_map(
            array(
                "name"              =>  __( "BetterWeather Widget", 'better-studio' ),
                "base"              =>  "BetterWeather",
                "class"             =>  "",
                "controls"          =>  "full",
                "icon"              => BETTER_WEATHER_DIR_URL . 'includes/assets/img/logo.png',
                "category"          =>  __( 'Content', 'better-studio' ),
                'admin_enqueue_css' =>  BETTER_WEATHER_DIR_URL . 'includes/assets/css/vc-style.css',
                "params"            => array(
                    array(
                        "type"          =>  "textfield",
                        "heading"       =>  __( "Location", 'better-studio' ),
                        "admin_label"   =>  true,
                        "param_name"    =>  "location",
                        "value"         =>  "35.6705,139.7409",
                        "description"   =>  __( "Enter location ( latitude,longitude ) for showing forecast.", 'better-studio' ) .'<br>'. '<a target="_blank" href="http://better-studio.net/plugins/better-weather/stand-alone/#how-to-find-location">' . __("How to find location values!?", 'better-studio') .'</a>'
                    ),
                    array(
                        "type"          =>  "textfield",
                        "heading"       =>  __( "Location Custom Name", 'better-studio' ),
                        "param_name"    =>  "location_name",
                        "admin_label"   =>  true,
                        "value"         =>  "",
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => __( 'Show Location Name?', 'better-studio' ),
                        'param_name'    => 'show_location',
                        'value'         => array(
                            __( 'Yes', 'better-studio' )  => 'on',
                            __( 'No', 'better-studio' ) => 'off',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Show Date?', 'better-studio' ),
                        'param_name'    =>  'show_date',
                        'value'         =>  array(
                            __( 'Yes', 'better-studio' )  => 'on',
                            __( 'No', 'better-studio' ) => 'off',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Widget Style', 'better-studio' ),
                        'param_name'    =>  'style',
                        "admin_label"   =>  true,
                        'value'         => array(
                            __( 'Modern Style', 'better-studio' ) => 'modern',
                            __( 'Normal Style', 'better-studio' ) => 'normal',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Show next 4 days forecast!?', 'better-studio' ),
                        'param_name'    =>  'next_days',
                        'value'         =>  array(
                            __( 'Yes', 'better-studio' ) => 'on',
                            __( 'No', 'better-studio' )  => 'off',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Background Style', 'better-studio' ),
                        'param_name'    =>  'bg_type',
                        "admin_label"   =>  true,
                        'value'         =>  array(
                            __( 'Natural Photo', 'better-studio' ) => 'natural',
                            __( 'Static Color', 'better-studio' )  => 'static',
                        ),
                    ),
                    array(
                        "type"          =>  "colorpicker",
                        "holder"        =>  "div",
                        "class"         =>  "",
                        "heading"       =>  __( "Background Color", 'better-studio' ),
                        "param_name"    =>  "bg_color",
                        "value"         =>  '#4f4f4f',
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Icons Style', 'better-studio' ),
                        'param_name'    =>  'icons_type',
                        'value'         => array(
                            __( 'Animated Icons', 'better-studio' ) => 'animated',
                            __( 'Static Icons', 'better-studio' )  => 'static',
                        ),
                    ),
                    array(
                        "type"          =>  "colorpicker",
                        "holder"        =>  "div",
                        "class"         =>  "",
                        "heading"       =>  __( "Font Color", 'better-studio' ),
                        "param_name"    =>  "font_color",
                        "value"         =>  '#fff',
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Temperature Unit', 'better-studio' ),
                        'param_name'    =>  'unit',
                        'value'         =>  array(
                            __( 'Celsius', 'better-studio' ) => 'C',
                            __( 'Fahrenheit', 'better-studio' )  => 'F',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Show Temperature Unit In Widget!?', 'better-studio' ),
                        'param_name'    =>  'show_unit',
                        'value'         => array(
                            __( 'No', 'better-studio' ) => 'off',
                            __( 'Yes', 'better-studio' )  => 'on',
                        ),
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => __( 'Auto detect user location via IP!?', 'better-studio' ),
                        'param_name'    => 'visitor_location',
                        'value'         => array(
                            __( 'No', 'better-studio' )  => 'off',
                            __( 'Yes', 'better-studio' ) => 'on',
                        ),
                        "description" => __( 'Before using this you must read <a target="_blank" href="http://better-studio.net/plugins/better-weather/wp/#requests-note">this note</a>.', 'better-studio' ),
                    ),
                )
            )
        );

        // Visual composer inline
        vc_map(
            array(
                "name"              => __( "BetterWeather Inline", 'better-studio' ),
                "base"              => "BetterWeather-inline",
                "class"             => "",
                "controls"          => "full",
                "icon"              => BETTER_WEATHER_DIR_URL . 'includes/assets/img/logo.png',
                "category"          => __( 'Content', 'better-studio' ),
                'admin_enqueue_css' => BETTER_WEATHER_DIR_URL . 'includes/assets/css/vc-style.css',
                "params"            => array(
                    array(
                        "type"          =>  "textfield",
                        "holder"        =>  "div",
                        "class"         =>  "",
                        "heading"       =>  __( "Location:", 'better-studio' ),
                        "param_name"    =>  "location",
                        "value"         =>  "35.6705,139.7409",
                        "description"   =>  __( "Enter location ( latitude,longitude ) for showing forecast.", 'better-studio' ) .'<br>'. '<a target="_blank" href="http://better-studio.net/plugins/better-weather/stand-alone/#how-to-find-location">' . __("How to find location values!?", 'better-studio') .'</a>'
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Inline Size:', 'better-studio' ),
                        'param_name'    =>  'inline_size',
                        'value'         =>  array(
                            __( 'Large', 'better-studio' ) => 'large',
                            __( 'medium', 'better-studio' )  => 'medium',
                            __( 'small', 'better-studio' )  => 'small',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Icons Style:', 'better-studio' ),
                        'param_name'    =>  'icons_type',
                        'value'         =>  array(
                            __( 'Animated Icons', 'better-studio' ) => 'animated',
                            __( 'Static Icons', 'better-studio' )  => 'static',
                        ),
                    ),
                    array(
                        "type"          =>  "colorpicker",
                        "holder"        =>  "div",
                        "class"         =>  "",
                        "heading"       =>  __( "Font Color:", 'better-studio' ),
                        "param_name"    =>  "font_color",
                        "value"         =>  '#fff'
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Temperature Unit', 'better-studio' ),
                        'param_name'    =>  'unit',
                        'value'         =>  array(
                            __( 'Celsius', 'better-studio' ) => 'C',
                            __( 'Fahrenheit', 'better-studio' )  => 'F',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Show Temperature Unit In Widget!?', 'better-studio' ),
                        'param_name'    =>  'show_unit',
                        'value'         =>  array(
                            __( 'No', 'better-studio' ) => 'off',
                            __( 'Yes', 'better-studio' )  => 'on',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Auto detect user location via IP!?', 'better-studio' ),
                        'param_name'    =>  'visitor_location',
                        'value'         =>  array(
                            __( 'No', 'better-studio' )  => 'off',
                            __( 'Yes', 'better-studio' ) => 'on',
                        ),
                        "description"   =>  __( "Please note Forecast.io free accounts API calls per day is just 1000 and with enabling autodetect location you must do some pay to Forecast.io for calls over 1000!", 'better-studio' )
                    ),
                )
            )
        );
    }


    /**
     * return api key that saved in option panel
     * @return string|bool
     */
    static function get_API_Key(){

        return Better_Framework::options()->get( 'api_key', 'better_weather_options' );

    }
}

// Check if Visual Composer is installed
if( defined( 'WPB_VC_VERSION' ) ) {

    if( ! class_exists( "WPBakeryShortCode" ) ){
        class WPBakeryShortCode{

        }
    }

    /**
     * Wrapper for WPBakeryShortCode Class for handling editor
     */
    class Better_Weather_VC_Shortcode_Extender extends WPBakeryShortCode{

        function __construct( $settings ){

            // Base BF Class For Styling
            if( isset( $settings['class'] ) ){
                $settings['class'] .= ' bf-vc-field';
            }else{
                $settings['class'] = 'bf-vc-field';
            }

            // Height Class For Styling
            if( isset( $settings['wrapper_height'] ) ){

                if( $settings['wrapper_height'] == 'full' ){
                    $settings['class'] .= ' bf-full-height';
                }

            }

            parent::__construct( $settings );
        }

        /**
         * Prints out the styles needed to render the element icon for the back end interface.
         * Only performed if the 'icon' setting is a valid URL.
         */
        public function printIconStyles() {

            if ( ! filter_var( $this->settings( 'icon' ), FILTER_VALIDATE_URL ) ) {
                return;
            }

            echo "
            <style>
                .wpb_content_element[data-element_type='" . esc_attr( $this->settings['base'] ) . "'] .wpb_element_wrapper,
                .vc_shortcodes_container[data-element_type='" . esc_attr( $this->settings['base'] ) . "'] {
                    background-image: url(" . esc_url( $this->settings['icon']  ) . ") ;
                }
                .wpb-content-layouts .wpb-layout-element-button[data-element='" . esc_attr( $this->settings['icon'] ) . "'] .vc-element-icon {
                    background-image: url(" . esc_url( $this->settings['icon']  ) . ");
                }
                #" . $this->settings['base'] . " .vc-element-icon{
                    background-image: url(" . esc_url( $this->settings['icon']  ) . ") ;
                }
                li[data-element=" . $this->settings['base'] . "]{
                    background-color: #F9FDFF !important;
                    border-color: #9cd4eb !important;
                }
            </style>";
        }
    }
}