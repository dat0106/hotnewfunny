<?php

/**
 * Generate all front end codes for better weather
 *
 * IMPORTANT NOTE: Do not create directly instance from this class! just use BW_Generator_Factory factory for getting instance
 */
class BW_Frontend {


    /**
     * Stores all widgets
     * @var array
     */
    var $widgets = array();


    function init(){

        add_action( 'wp_enqueue_scripts' , array( $this , 'register_assets' ) , 9 );
        add_action( 'wp_enqueue_scripts' , array( $this , 'enqueue_assets' ) , 11 );

    }


    /**
     * Before enqueue register frontend assets for ability to change the assets outside of plugin
     */
    function register_assets(){

        wp_register_script( 'skycons', BETTER_WEATHER_DIR_URL . 'includes/libs/better-weather/js/skycons.js', array( 'jquery' ), Better_Weather::get_version(), true );

        wp_register_script( 'better-weather', BETTER_WEATHER_DIR_URL . 'includes/libs/better-weather/js/betterweather.min.js', array( 'jquery', 'skycons' ), Better_Weather::get_version(), true );

        wp_register_script( 'better-weather-widgets', BETTER_WEATHER_DIR_URL . 'includes/assets/js/better-weather-widgets.js', array( 'jquery', 'skycons', 'better-weather' ), Better_Weather::get_version(), true );

        wp_register_style( 'better-weather', BETTER_WEATHER_DIR_URL . 'includes/libs/better-weather/css/bw-style.min.css', array(), Better_Weather::get_version() );

    }


    /**
     * Enqueue styles and scripts that before registered
     */
    function enqueue_assets(){

        Better_Framework::assets_manager()->enqueue_script( 'element-query' );

        wp_enqueue_script( 'better-weather-widgets' );

        wp_enqueue_style( 'better-weather' );

        $local_texts = array(
            "url"       =>  admin_url( 'admin-ajax.php' ),
            "action"    =>  'bw_ajax',
            "apiKey"    =>  Better_Weather::get_API_Key() ,
            "monthList" =>  array(
                'January'       =>  Better_Framework::options()->get( 'tr_month_january', 'better_weather_options' ),
                'February'      =>  Better_Framework::options()->get( 'tr_month_february', 'better_weather_options' ),
                'March'         =>  Better_Framework::options()->get( 'tr_month_march', 'better_weather_options' ),
                'April'         =>  Better_Framework::options()->get( 'tr_month_april', 'better_weather_options' ),
                'May'           =>  Better_Framework::options()->get( 'tr_month_may', 'better_weather_options' ),
                'June'          =>  Better_Framework::options()->get( 'tr_month_june', 'better_weather_options' ),
                'July'          =>  Better_Framework::options()->get( 'tr_month_july', 'better_weather_options' ),
                'August'        =>  Better_Framework::options()->get( 'tr_month_august', 'better_weather_options' ),
                'September'     =>  Better_Framework::options()->get( 'tr_month_september', 'better_weather_options' ),
                'October'       =>  Better_Framework::options()->get( 'tr_month_october', 'better_weather_options' ),
                'November'      =>  Better_Framework::options()->get( 'tr_month_november', 'better_weather_options' ),
                'December'      =>  Better_Framework::options()->get( 'tr_month_december', 'better_weather_options' ),
            ),
            "daysList"  =>  array(
                'Sat'           =>  Better_Framework::options()->get( 'tr_days_sat', 'better_weather_options' ),
                'Sun'           =>  Better_Framework::options()->get( 'tr_days_sun', 'better_weather_options' ),
                'Mon'           =>  Better_Framework::options()->get( 'tr_days_mon', 'better_weather_options' ),
                'Tue'           =>  Better_Framework::options()->get( 'tr_days_tue', 'better_weather_options' ),
                'Wed'           =>  Better_Framework::options()->get( 'tr_days_wed', 'better_weather_options' ),
                'Thu'           =>  Better_Framework::options()->get( 'tr_days_thu', 'better_weather_options' ),
                'Fri'           =>  Better_Framework::options()->get( 'tr_days_fri', 'better_weather_options' ),
            ),
            "stateList" =>  array(
                'clear'         =>  Better_Framework::options()->get( 'tr_forecast_clear', 'better_weather_options' ),
                'rain'          =>  Better_Framework::options()->get( 'tr_forecast_rain', 'better_weather_options' ),
                'snow'          =>  Better_Framework::options()->get( 'tr_forecast_snow', 'better_weather_options' ),
                'sleet'         =>  Better_Framework::options()->get( 'tr_forecast_sleet', 'better_weather_options' ),
                'wind'          =>  Better_Framework::options()->get( 'tr_forecast_wind', 'better_weather_options' ),
                'fog'           =>  Better_Framework::options()->get( 'tr_forecast_fog', 'better_weather_options' ),
                'cloudy'        =>  Better_Framework::options()->get( 'tr_forecast_cloudy', 'better_weather_options' ),
                'mostly_cloudy' =>  Better_Framework::options()->get( 'tr_forecast_mostly_cloudy', 'better_weather_options' ),
                'partly_cloudy' =>  Better_Framework::options()->get( 'tr_forecast_partly_cloudy', 'better_weather_options' ),
                'thunderstorm'  =>  Better_Framework::options()->get( 'tr_forecast_thunderstorm', 'better_weather_options' ),
                'drizzle'       =>  Better_Framework::options()->get( 'tr_forecast_drizzle', 'better_weather_options' ),
                'light_rain'    =>  Better_Framework::options()->get( 'tr_forecast_light_rain', 'better_weather_options' ),
                'overcast'      =>  Better_Framework::options()->get( 'tr_forecast_overcast', 'better_weather_options' ),
                'breezy_and_Partly_Cloudy'     =>   Better_Framework::options()->get( 'tr_forecast_breezy_and_partly_cloudy', 'better_weather_options' ),
                'humid_and_mostly_cloudy'      =>   Better_Framework::options()->get( 'tr_forecast_humid_and_mostly_cloudy', 'better_weather_options' ),
            )
        );

        wp_localize_script( 'better-weather' , 'BW_Localized' , $local_texts );

    }


    /**
     * Used for generating HTML attribute string
     *
     * @param string $id
     * @param string $val
     * @return string
     */
    private function html_attr( $id ='' , $val='' ){

        if( is_bool( $val ) ){

            if( $val )
                $val = "true";
            else
                $val = "false";

        }

        return 'data-' . $id . '="' . $val . '" ';
    }


    /**
     * Generate widget
     *
     * @param $options
     * @param bool $echo
     * @return mixed|void
     */
    function generate( $options , $echo = true){

        $id = $this->get_unique_id();
        $this->widgets[$id] = $options;

        $output = '<';

        if( isset( $options['mode'] ) && $options['mode']=='inline' ){
            $output .= 'span id="'. $id .'" class="better-weather-inline" ';
        }else{
            $output .= 'div id="'. $id .'" class="better-weather" ';
        }

        foreach ( (array) $options as $key => $value ){
            $output .= $this->html_attr( $key , $value );
        }

        if( isset( $options['mode'] ) && $options['mode']=='inline' ){
            $output .= '></span>';
        }else{
            $output .= '></div>';
        }

        if( $echo )
            echo $output;
        else
            return $output;
    }


    /**
     * Generate unique id widgets
     *
     * @return string
     */
    function get_unique_id(){

        return 'bw-'. uniqid();

    }

}