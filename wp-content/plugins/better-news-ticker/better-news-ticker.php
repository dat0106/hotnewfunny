<?php
/*
Plugin Name: Better News Ticker Widget
Plugin URI: http://betterstudio.com
Description: BetterStudio News Ticker Widget
Version: 1.0.1
Author: BetterStudio
Author URI: http://betterstudio.com
License: GPL2
*/

// Initialize Up Better News Ticker
Better_News_Ticker::self();


/**
 * Class Better_News_Ticker
 */
class Better_News_Ticker{


    /**
     * Contains BNT version number that used for assets for preventing cache mechanism
     *
     * @var string
     */
    private static $version = '1.0.1';


    /**
     * Inner array of instances
     *
     * @var array
     */
    protected static $instances = array();


    function __construct(){

        // Register included BF to loader
        add_filter( 'better-framework/loader', array( $this, 'better_framework_loader' ) );

        // Enable needed sections
        add_filter( 'better-framework/sections', array( $this, 'better_framework_sections' ) );

        // Admin panel options
        //add_filter( 'better-framework/panel/options' , array( $this , 'setup_option_panel' ) );

        // Active and new shortcodes
        add_filter( 'better-framework/shortcodes', array( $this, 'setup_shortcodes' ) );

        // Initialize
        add_action( 'better-framework/after_setup', array( $this, 'init' ) );

        // Enqueue assets
        //add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );

        // Enqueue admin scripts
        add_action( 'admin_enqueue_scripts', array( $this , 'admin_enqueue' ) );

        // Clear BF transients on plugin activation and deactivation
        //register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
        //register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivation' ) );

        // Includes BF loader if not included before
        require_once 'includes/libs/better-framework/init.php';

    }


    /**
     * Plugin Directory path
     *
     * @return string
     */
    public static function get_dir_path(){
        return plugin_dir_path( __FILE__ );
    }


    /**
     * Plugin Directory URL
     *
     * @return string
     */
    public static function get_dir_url(){
        return plugin_dir_url( __FILE__ );
    }


    /**
     * Returns BSC current Version
     *
     * @return string
     */
    public static function get_version(){

        return self::$version ;

    }


    /**
     * Clears BF transients for avoiding of happening any problem
     */
    function plugin_activation(){

        delete_transient( '__better_framework__final_fe_css' );
        delete_transient( '__better_framework__final_fe_css_version' );
        delete_transient( '__better_framework__backend_css' );

    }


    /**
     * Clears BF transients for avoiding of happening any problem
     */
    function plugin_deactivation(){

        delete_transient( '__better_framework__final_fe_css' );
        delete_transient( '__better_framework__final_fe_css_version' );
        delete_transient( '__better_framework__backend_css' );

    }


    /**
     * Build the required object instance
     *
     * @param string $object
     * @param bool $fresh
     * @param bool $just_include
     * @return null
     */
    public static function factory( $object = 'options', $fresh = false , $just_include = false ){

        if( isset( self::$instances[$object] ) && ! $fresh ){
            return self::$instances[$object];
        }

        switch( $object ){

            /**
             * Main Better_News_Ticker Class
             */
            case 'self':
                $class = 'Better_News_Ticker';
                break;

            default:
                return null;
        }


        // Just prepare/includes files
        if( $just_include )
            return;

        // don't cache fresh objects
        if( $fresh ){
            return new $class;
        }

        self::$instances[$object] = new $class;

        return self::$instances[$object];
    }


    /**
     * Used for accessing alive instance of Better_News_Ticker
     *
     * static
     * @since 1.0
     * @return Better_News_Ticker
     */
    public static function self(){

        return self::factory('self');

    }


    /**
     * Used for retrieving options simply and safely for next versions
     *
     * @param $option_key
     * @return mixed|null
     */
    public static function get_option( $option_key ){

        return Better_Framework::options()->get( $option_key, 'better_news_ticker_options' );

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
            'path'      =>  self::get_dir_path() . 'includes/libs/better-framework/',
            'uri'       =>  self::get_dir_url() . 'includes/libs/better-framework/',
        );

        return $frameworks;

    }


    /**
     * Activate BF needed sections
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

        load_plugin_textdomain( 'better-studio', false, 'better-news-ticker/languages' );

    }


    /**
     * Enqueue css and js files
     *
     * todo move styles inside plugin
     */
    function enqueue_assets(){

    }


    /**
     *  Enqueue admin scripts
     */
    function admin_enqueue(){

        wp_enqueue_style( 'better-new-ticker-admin', self::get_dir_url() .'css/admin-style.css', array(), self::get_version() );

    }


    /**
     * Setups Shortcodes
     *
     * @param $shortcodes
     */
    function setup_shortcodes( $shortcodes ){

        require_once self::get_dir_path() . 'includes/shortcodes/class-better-news-ticker-shortcode.php';

        require_once self::get_dir_path() . 'includes/widgets/class-better-news-ticker-widget.php';

        $shortcodes['better-news-ticker'] = array(
            'shortcode_class'   =>  'Better_News_Ticker_Shortcode',
            'widget_class'      =>  'Better_News_Ticker_Widget',
        );

        return $shortcodes;
    }


    /**
     * Setup setting panel
     *
     * @param $options
     * @return array
     */
    function setup_option_panel( $options ){

        //
        // Backup & Restore
        //
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
            'file_name' =>  'better-social-counter-options-backup',
            'panel_id'  =>  'better_social_counter_options',
            'desc'      =>  __( 'This allows you to create a backup of your options and settings. Please note, it will not backup anything else.', 'better-studio' )
        );
        $field[] = array(
            'name'      =>  __( 'Restore / Import', 'better-studio' ),
            'id'        =>  'import_restore_options',
            'type'      =>  'import',
            'desc'      =>  __( '<strong>It will override your current settings!</strong> Please make sure to select a valid backup file.', 'better-studio' )
        );

        $options['better_news_ticker_options'] = array(
            'config' => array(
                'parent'                =>    'better-studio',
                'name'                  =>    __( 'Better News Ticker', 'better-studio' ),
                'page_title'            =>    __( 'Better News Ticker', 'better-studio' ),
                'menu_title'            =>    __( 'Better News Ticker', 'better-studio' ),
                'capability'            =>    'manage_options',
                'menu_slug'             =>    __( 'BetterNewsTicker', 'better-studio' ),
                'icon_url'              =>    null,
                'position'              =>    20,
                'exclude_from_export'   =>    false,
            ),
            'panel-name'          => _x( 'Better News Ticker Options', 'Panel title', 'better-studio' ),
            'fields' => $field
        );

        return $options;
    }

}
