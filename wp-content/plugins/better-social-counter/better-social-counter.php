<?php
/*
Plugin Name: Better Social Counter Widget
Plugin URI: http://betterstudio.com
Description: BetterStudio Social Counter Widget
Version: 1.0.1
Author: BetterStudio
Author URI: http://betterstudio.com
License: GPL2
*/

// Initialize Up Better Social Counter
Better_Social_Counter::self();

/**
 * Class Better_Social_Counter
 */
class Better_Social_Counter{


    /**
     * Contains BSC version number that used for assets for preventing cache mechanism
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

        define( 'BETTER_SOCIAL_COUNTER_DIR_URL' , plugin_dir_url( __FILE__ ) );
        define( 'BETTER_SOCIAL_COUNTER_DIR_PATH' , plugin_dir_path( __FILE__ ) );

        // Register included BF to loader
        add_filter( 'better-framework/loader', array( $this, 'better_framework_loader' ) );

        // Enable needed sections
        add_filter( 'better-framework/sections', array( $this, 'better_framework_sections' ) );

        // Admin panel options
        add_filter( 'better-framework/panel/options' , array( $this , 'setup_option_panel' ) );

        // Active and new shortcodes
        add_filter( 'better-framework/shortcodes', array( $this, 'setup_shortcodes' ) );

        // Initialize
        add_action( 'better-framework/after_setup', array( $this, 'init' ) );

        // Enqueue assets
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );

        // Enqueue admin scripts
        add_action( 'admin_enqueue_scripts', array( $this , 'admin_enqueue' ) );

        // Clear BF transients on plugin activation and deactivation
        register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
        register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivation' ) );

        // Includes BF loader if not included before
        require_once 'includes/libs/better-framework/init.php';

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
             * Main Better_Social_Counter Class
             */
            case 'self':
                $class = 'Better_Social_Counter';
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
     * Used for accessing alive instance of Better_Social_Counter
     *
     * static
     * @since 1.0
     * @return Better_Social_Counter
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

        return Better_Framework::options()->get( $option_key, 'better_social_counter_options' );

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
            'path'      =>  BETTER_SOCIAL_COUNTER_DIR_PATH . 'includes/libs/better-framework/',
            'uri'       =>  BETTER_SOCIAL_COUNTER_DIR_URL . 'includes/libs/better-framework/',
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

        load_plugin_textdomain( 'better-studio', false, 'better-social-counter/languages' );

    }


    /**
     * Enqueue css and js files
     */
    function enqueue_assets(){

        // Enqueue "Better Social Font Icon" from framework
        Better_Framework::assets_manager()->enqueue_style( 'better-social-font-icon' );

        // Element Query
        Better_Framework::assets_manager()->enqueue_script( 'element-query' );

        // Script
        wp_enqueue_script( 'better-social-counter', BETTER_SOCIAL_COUNTER_DIR_URL . 'js/script.js', array( 'jquery' ), Better_Social_Counter::get_version(), true );

        // Style
        wp_enqueue_style( 'better-social-counter', BETTER_SOCIAL_COUNTER_DIR_URL . 'css/style.css' , array(), Better_Social_Counter::get_version() );

    }


    /**
     *  Enqueue admin scripts
     */
    function admin_enqueue(){

        wp_enqueue_style( 'better-social-counter-admin', BETTER_SOCIAL_COUNTER_DIR_URL .'css/admin-style.css', array(), Better_Social_Counter::get_version() );

    }

    /**
     * Setups Shortcodes
     *
     * @param $shortcodes
     */
    function setup_shortcodes( $shortcodes ){

        require_once BETTER_SOCIAL_COUNTER_DIR_PATH . 'includes/shortcodes/class-better-social-counter-shortcode.php';

        require_once BETTER_SOCIAL_COUNTER_DIR_PATH . 'includes/widgets/class-better-social-counter-widget.php';

        $shortcodes['better-social-counter'] = array(
            'shortcode_class'   =>  'Better_Social_Counter_Shortcode',
            'widget_class'      =>  'Better_Social_Counter_Widget',
        );

        return $shortcodes;
    }


    /**
     * Clears all cache inside data base
     *
     * Callback
     *
     * @return array
     */
    public static function clear_cache_all(){

        Better_Social_Counter_Data_Manager::self()->clear_cache();

        return array(
            'status'  => 'succeed',
            'msg'	  => __( 'All Cache was cleaned.', 'better-studio' ),
        );

    }


    /**
     * Setup setting panel
     *
     * @param $options
     * @return array
     */
    function setup_option_panel( $options ){

        //
        // Facebook
        //
        $field[] = array(
            'name'      =>  __( 'Facebook', 'better-studio' ),
            'id'        =>  'facebook_tab',
            'type'      =>  'tab',
            'icon'      =>  'fa-facebook'
        );
        $field[] = array(
            'name'          =>  __( 'Instructions', 'better-studio' ),
            'id'       =>  'facebook-help',
            'type'          =>  'info',
            'std'           =>  __('<ol>
        <li>Copy the link to you facebook page</li>
        <li>Paste it in the "Link to you Facebook page" input box below</li>
      </ol>
                    ', 'better-studio' ),
            'state'         =>  'open',
            'info-type'     =>  'help',
            'section_class' =>  'widefat',
        );

        $field[] = array(
            'name'      =>  __( 'Page ID/Name', 'better-studio' ),
            'id'        =>  'facebook_page',
            'desc'      =>  __( 'Enter Your Facebook Page Name or ID.', 'better-studio' ),
            'type'      =>  'text',
            'std'       =>  'BetterSTU'
        );
        $field[] = array(
            'name'      =>  __( 'Text Below The Number', 'better-studio' ),
            'id'        =>  'facebook_title',
            'type'      =>  'text',
            'std'       =>  __( 'Likes', 'better-studio' )
        );


        //
        // Twitter
        //
        $field[] = array(
            'name'      =>  __( 'Twitter', 'better-studio' ),
            'id'        =>  'twitter_tab',
            'type'      =>  'tab',
            'icon'      =>  'fa-twitter'
        );
            $field[] = array(
                'name'          =>  __( 'Instructions', 'better-studio' ),
                'id'            =>  'twitter-help',
                'type'          =>  'info',
                'std'           =>  __('
        <p>You need to authenticate yourself to Twitter with creating an app for get access information to retrieve your followers count and display them on your page.</p><ol>
            <li>Go to <a href="http://goo.gl/tyCR5W" target="_blank">https://apps.twitter.com/app/new</a> and log in, if necessary</li>
            <li>Enter your Application Name, Description and your website address. You can leave the callback URL empty.</li>
            <li>Submit the form by clicking the Create your Twitter Application</li>
            <li>Go to the "Keys and Access Token" tab and copy the consumer key (API key) and consumer secret</li>
            <li>Paste them in the following input boxes</li>
          </ol>
                        ', 'better-studio' ),
                'state'         =>  'open',
                'info-type'     =>  'help',
                'section_class' =>  'widefat',
            );

            $field[] = array(
                'name'      =>  __( 'Username', 'better-studio' ),
                'id'        =>  'twitter_username',
                'desc'      =>  __( 'Enter Your Twitter Account Username.', 'better-studio' ),
                'type'      =>  'text',
                'std'       =>  'BetterSTU'
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'twitter_title',
                'type'      =>  'text',
                'std'       =>  __( 'Followers', 'better-studio' )
            );
            $field[] = array(
                'name'      =>  __( 'Consumer key', 'better-studio' ),
                'id'        =>  'twitter_api_key',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __('Consumer Secret','better-studio'),
                'id'        =>  'twitter_api_secret',
                'type'      =>  'text',
                'std'       =>  ''
            );


        //
        // Google+
        //
        $field[] = array(
            'name'      =>  __( 'Google+', 'better-studio' ),
            'id'        =>  'google_tab',
            'type'      =>  'tab',
            'icon'      =>  'fa-google-plus'
        );
            $field[] = array(
                'name'          =>  __( 'Instructions', 'better-studio' ),
                'id'            =>  'google-help',
                'type'          =>  'info',
                'std'           =>  __('
                <ul>
                <li>Create a project/app in <a href="http://goo.gl/UA0m6L" target="_blank">https://console.developers.google.com/project</a></li>
                <li>Inside your project go to <strong>APIs &amp; auth</strong> → <strong>APIs</strong> and turn on the <strong>Google+ API</strong></li>
                <li>Go to <strong>APIs &amp; auth</strong> →  <strong>APIs</strong> → <strong>Credentials</strong> → <strong>Public API access</strong> and click in the <strong>CREATE A NEW KEY</strong> button.</li>
                <li>Select the <strong>Browser key</strong> option and click in the <strong>CREATE</strong> button</li>
                <li>After you\'re done, Copy your API key and paste it in <strong>Page Key</strong> field.</li>
            </ul>
                                ', 'better-studio' ),
                'state'         =>  'open',
                'info-type'     =>  'help',
                'section_class' =>  'widefat',
            );
            $field[] = array(
                'name'      =>  __( 'Page ID/Name', 'better-studio' ),
                'id'        =>  'google_page',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __( 'Page Key', 'better-studio' ),
                'id'        =>  'google_page_key',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'google_title',
                'type'      =>  'text',
                'std'       =>  __( 'Followers', 'better-studio' )
            );


        //
        // Youtube
        //
        $field[] = array(
            'name'      =>  __( 'Youtube', 'better-studio' ),
            'id'        =>  'youtube_tab',
            'type'      =>  'tab',
            'icon'      =>  'fa-youtube'
        );
            $field[] = array(
                'name'      =>  __( 'Username or Channel ID', 'better-studio' ),
                'id'        =>  'youtube_username',
                'type'      =>  'text',
                'std'       =>  'betterstu'
            );
            $field[] = array(
                'name'      =>  __( 'Type', 'better-studio' ),
                'id'        =>  'youtube_type',
                'type'      =>  'select',
                'std'       =>  'chanel',
                'options'   =>  array(
                    'user'      =>  __('User', 'better-studio'),
                    'channel'   =>  __('Channel', 'better-studio'),
                )
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'youtube_title',
                'type'      =>  'text',
                'std'       =>  __( 'Subscribers', 'better-studio' )
            );


        //
        // Dribbble
        //
        $field[] = array(
            'name'      =>  __( 'Dribbble', 'better-studio' ),
            'id'        =>  'dribbble_tab',
            'type'      =>  'tab',
            'icon'      =>  'fa-dribbble'
        );
            $field[] = array(
                'name'      =>  __( 'UserName', 'better-studio' ),
                'id'        =>  'dribbble_username',
                'type'      =>  'text',
                'std'       =>  'better-studio'
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'dribbble_title',
                'type'      =>  'text',
                'std'       =>  __( 'Followers', 'better-studio' )
            );


        //
        // Vimeo
        //
        $field[] = array(
            'name'      =>  __( 'Vimeo', 'better-studio' ),
            'id'        =>  'vimeo_tab',
            'type'      =>  'tab',
            'icon'      =>  'fa-vimeo-square'
        );
            $field[] = array(
                'name'      =>  __( 'Channel Username or Channel Slug', 'better-studio' ),
                'id'        =>  'vimeo_username',
                'type'      =>  'text',
                'std'       =>  'nicetype'
            );
            $field[] = array(
                'name'      =>  __( 'Type', 'better-studio' ),
                'id'        =>  'vimeo_type',
                'type'      =>  'select',
                'std'       =>  'channel',
                'options'   =>  array(
                    'user'      =>  __( 'User', 'better-studio' ),
                    'channel'   =>  __( 'Channel', 'better-studio' ),
                )
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'vimeo_title',
                'type'      =>  'text',
                'std'       =>  __( 'Subscribers', 'better-studio' )
            );


        //
        // Delicious
        //
        $field[] = array(
            'name'      =>  __( 'Delicious', 'better-studio' ),
            'id'        =>  'delicious_title',
            'type'      =>  'tab',
            'icon'      =>  'fa-delicious'
        );
            $field[] = array(
                'name'      =>  __( 'UserName', 'better-studio' ),
                'id'        =>  'delicious_username',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'  =>  __('Text Below The Number','better-studio'),
                'id'    =>  'delicious_title',
                'type'  =>  'text',
                'std'   =>  __('Followers', 'better-studio')
            );


        //
        // SoundCloud
        //
        $field[] = array(
            'name'      =>  __( 'SoundCloud', 'better-studio' ),
            'id'        =>  'soundcloud_title',
            'type'      =>  'tab',
            'icon'      =>  'fa-soundcloud'
        );
            $field[] = array(
                'name'          =>  __( 'Instructions', 'better-studio' ),
                'id'            =>  'soundcloud-help',
                'type'          =>  'info',
                'std'           =>  __('
                                <ul>
                <li>Go To <a href="http://goo.gl/ZYjZhb" target="_blank">Your Applications</a> page.</li>
                <li>Click On "<strong>Register a new application</strong>" Button.</li>
                <li>Enter Your App Name and click on "<strong>Register</strong>".</li>
                <li>Check "<strong>Yes, I have read and accepted the Developer Policies</strong>" and Click on "<strong>Save App</strong>" Button</li>
                <li>Copy the "<strong>Client ID</strong>" and it in "<strong>API Key</strong>" input box.</li>
            </ul>
                                                ', 'better-studio' ),
                'state'         =>  'open',
                'info-type'     =>  'help',
                'section_class' =>  'widefat',
            );
            $field[] = array(
                'name'      =>  __( 'UserName', 'better-studio' ),
                'id'        =>  'soundcloud_username',
                'type'      =>  'text',
                'std'       =>  'muse'
            );
            $field[] = array(
                'name'      =>  __( 'API Key', 'better-studio' ),
                'id'        =>  'soundcloud_api_key',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'soundcloud_title',
                'type'      =>  'text',
                'std'       =>  __( 'Followers', 'better-studio' )
            );


        //
        // Github
        //
        $field[] = array(
            'name'      =>  __( 'Github', 'better-studio' ),
            'id'        =>  'github_title',
            'type'      =>  'tab',
            'icon'      =>  'fa-github'
        );
            $field[] = array(
                'name'      =>  __( 'UserName', 'better-studio' ),
                'id'        =>  'github_username',
                'type'      =>  'text',
                'std'       =>  'better-studio'
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'github_title',
                'type'      =>  'text',
                'std'       =>  __( 'Followers', 'better-studio' )
            );


        //
        // Behance
        //
        $field[] = array(
            'name'      =>  __( 'Behance', 'better-studio' ),
            'id'        =>  'behance_title',
            'type'      =>  'tab',
            'icon'      =>  'fa-behance'
        );
            $field[] = array(
                'name'          =>  __( 'Instructions', 'better-studio' ),
                'id'            =>  'behance-help',
                'type'          =>  'info',
                'std'           =>  __('
                            <ul>
                                <li>Go To <a href="http://goo.gl/UVclJh" target="_blank"><strong>Manage Your Applications → Register a New App</strong></a> page.</li>
                                <li>Click On "<strong>Register a new App</strong>" Button.</li>
                                <li>Enter Your App Name, Your Blog URL and Description. Then click on "<strong>Register Your App</strong>".</li>
                                <li>Copy the "<strong>API KEY / CLIENT ID</strong>" and paste it in "API Key" input box.</li>
                            </ul>
                                                        ', 'better-studio' ),
                'state'         =>  'open',
                'info-type'     =>  'help',
                'section_class' =>  'widefat',
            );
            $field[] = array(
                'name'      =>  __( 'UserName', 'better-studio' ),
                'id'        =>  'behance_username',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __('API Key','better-studio'),
                'id'        =>  'behance_api_key',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __('Text Below The Number','better-studio'),
                'id'        =>  'behance_title',
                'type'      =>  'text',
                'std'       =>  __('Followers', 'better-studio')
            );

        // Instagram
        //        $field[] = array(
        //            'name'  =>  __('Instagram','better-studio'),
        //            'id'    =>  'instagram_title',
        //            'type'  =>  'heading',
        //        );
        //            $field[] = array(
        //                'name'  =>  __('UserName','better-studio'),
        //                'id'    =>  'instagram_username',
        //                'type'  =>  'text',
        //                'std'   =>  ''
        //            );
        //            $field[] = array(
        //                'name'  =>  __('Access Token Key','better-studio'),
        //                'id'    =>  'instagram_access_token',
        //                'type'  =>  'text',
        //                'std'   =>  ''
        //            );
        //            $field[] = array(
        //                'name'  =>  __('Text Below The Number','better-studio'),
        //                'id'    =>  'instagram_title',
        //                'type'  =>  'text',
        //                'std'   =>  __('Followers', 'better-studio')
        //            );


        //
        // vk
        //
        $field[] = array(
            'name'      =>  __( 'VK', 'better-studio' ),
            'id'        =>  'vk_title',
            'type'      =>  'tab',
            'icon'      =>  'fa-vk'
        );
            $field[] = array(
                'name'      =>  __( 'Community ID/Name', 'better-studio' ),
                'id'        =>  'vk_username',
                'type'      =>  'text',
                'std'       =>  'applevk'
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'vk_title',
                'type'      =>  'text',
                'std'       =>  __( 'Members', 'better-studio' )
            );


        //
        // Vine
        //
        $field[] = array(
            'name'      =>  __( 'Vine', 'better-studio' ),
            'id'        =>  'vine_title',
            'type'      =>  'tab',
            'icon'      =>  'fa-vine'
        );
            $field[] = array(
                'name'      =>  __( 'Profile URL', 'better-studio' ),
                'id'        =>  'vine_profile',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __( 'Account Email', 'better-studio' ),
                'id'        =>  'vine_email',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __( 'Account Password', 'better-studio' ),
                'id'        =>  'vine_pass',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'vine_title',
                'type'      =>  'text',
                'std'       =>  __( 'Followers', 'better-studio' )
            );


        //
        // Pinterest
        //
        $field[] = array(
            'name'      =>  __( 'Pinterest', 'better-studio' ),
            'id'        =>  'pinterest_title',
            'type'      =>  'tab',
            'icon'      =>  'fa-pinterest'
        );
            $field[] = array(
                'name'      =>  __( 'UserName', 'better-studio' ),
                'id'        =>  'pinterest_username',
                'type'      =>  'text',
                'std'       =>  'betterstudio'
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'pinterest_title',
                'type'      =>  'text',
                'std'       =>  __( 'Followers', 'better-studio' )
            );


        //
        // Flickr
        //
        $field[] = array(
            'name'      =>  __( 'Flickr', 'better-studio' ),
            'id'        =>  'flickr_title',
            'type'      =>  'tab',
            'icon'      =>  'fa-flickr'
        );
            $field[] = array(
                'name'          =>  __( 'Instructions', 'better-studio' ),
                'id'            =>  'flickr-help',
                'type'          =>  'info',
                'std'           =>  __('
                            <ul>
                                <li>Go to <a href="http://goo.gl/bE9Fz1" target="_blank">Create App</a> page.</li>
                                <li>Click on <strong>APPLY FOR A NON-COMMERCIAL KEY</strong> button.</li>
                                <li>Fill out the form:
                                <br>
                                    <ol>
                                        <li><strong>What\'s the name of your app? </strong> enter any name for the Application.</li>
                                        <li><strong>What are you building?</strong> enter a description for the app.</li>
                                        <li>Check the "<strong>What are you building?....</strong>" checkbox.</li>
                                        <li>Check the "<strong>I agree to comply with the Flickr API Terms of Use.</strong>" checkbox.</li>
                                        <li>Click on <strong>Register</strong> Button.</li>
                                    </ol><p></p>
                                </li>
                                <li>From the <a href="http://goo.gl/tZkovw" target="blank">Applications page</a> Copy the <strong>Key</strong> of your APP.</li>
                                <li>And paste it in "API Key" input box.</li>
                            </ul>
                                                                ', 'better-studio' ),
                'state'         =>  'open',
                'info-type'     =>  'help',
                'section_class' =>  'widefat',
            );
            $field[] = array(
                'name'      =>  __( 'Group ID', 'better-studio' ),
                'id'        =>  'flickr_group',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __( 'API Key', 'better-studio' ),
                'id'        =>  'flickr_key',
                'type'      =>  'text',
                'std'       =>  ''
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'flickr_title',
                'type'      =>  'text',
                'std'       =>  __( 'Followers', 'better-studio' )
            );

        //
        // Steam
        //
        $field[] = array(
            'name'      =>  __( 'Steam', 'better-studio' ),
            'id'        =>  'steam_title',
            'type'      =>  'tab',
            'icon'      =>  'fa-steam'
        );
            $field[] = array(
                'name'      =>  __( 'Group Slug', 'better-studio' ),
                'id'        =>  'steam_group',
                'type'      =>  'text',
                'std'       =>  'steammusic'
            );
            $field[] = array(
                'name'      =>  __( 'Text Below The Number', 'better-studio' ),
                'id'        =>  'steam_title',
                'type'      =>  'text',
                'std'       =>  __( 'Members', 'better-studio' )
            );




        //
        // Typography
        //
        $field[] = array(
            'name'      =>  __( 'Typography' , 'better-studio' ),
            'id'        =>  'typography',
            'type'      =>  'tab',
            'icon'      =>  'fa-font',
            'margin-top'=>  '10',
        );

            $field['typo_title'] = array(
                'name'          =>  __( 'Social Sites Follow Text Typography', 'better-studio' ),
                'id'            =>  'typo_title',
                'type'          =>  'typography',
                'std'           => array(
                    'enable'        =>  false,
                    'family'        =>  'Lato',
                    'variant'       =>  '400',
                    'subset'        =>  'latin',
                    'size'          =>  '12',
                    'transform'     =>  'initial',
                ),
                'desc'          =>  __( 'You can change typography of sites follow texts with enabling this option.', 'better-studio' ),
                'preview'       =>  true,
                'preview_tab'   =>  'title',
                'css-echo-default'  =>  true,
                'css'           => array(
                    array(
                        'selector' => array(
                            '.better-social-counter.style-modern .item-title',
                            '.better-social-counter.style-box .item-title',
                            '.better-social-counter.style-clean .item-title',
                            '.better-social-counter.style-button .item-title',
                        ),
                        'type'  => 'font',
                    )
                ),
            );
            $field['typo_count'] = array(
                'name'          =>  __( 'Social Sites Followers Count Number Typography', 'better-studio' ),
                'id'            =>  'typo_count',
                'type'          =>  'typography',
                'std'           => array(
                    'enable'        =>  false,
                    'family'        =>  'Lato',
                    'variant'       =>  '700',
                    'subset'        =>  'latin',
                    'size'          =>  '14',
                    'transform'     =>  'initial',
                ),
                'desc'          =>  __( 'You can change typography of sites followers count text with enabling this option.', 'better-studio' ),
                'preview'       =>  true,
                'preview_tab'   =>  'title',
                'css-echo-default'  =>  true,
                'css'           => array(
                    array(
                        'selector' => array(
                            '.better-social-counter.style-box .item-count',
                            '.better-social-counter.style-clean .item-count',
                            '.better-social-counter.style-modern .item-count',
                            '.better-social-counter.style-button .item-count',
                        ),
                        'type'  => 'font',
                    )
                ),
            );


        //
        // Caching Options
        //
        $field[] = array(
            'name'      =>  __( 'Caching Options' , 'better-studio' ),
            'id'        =>  'cache_options_title',
            'type'      =>  'tab',
            'icon'      =>  'fa-database',
        );
            $field[] = array(
                'name'      =>  __( 'Maximum Lifetime of Cache', 'better-studio' ),
                'id'        =>  'cache_time',
                'type'      =>  'select',
                'std'       =>  2,
                'options'   =>  array(

                    1   =>  __( '1 hours', 'better-studio' ),
                    2   =>  __( '2 hours', 'better-studio' ),
                    3   =>  __( '3 hours', 'better-studio' ),
                    4   =>  __( '4 hours', 'better-studio' ),
                    5   =>  __( '5 hours', 'better-studio' ),
                    6   =>  __( '6 hours', 'better-studio' ),
                    7   =>  __( '7 hours', 'better-studio' ),
                    8   =>  __( '8 hours', 'better-studio' ),
                    9   =>  __( '9 hours', 'better-studio' ),
                    10  =>  __( '10 hours', 'better-studio' ),
                    11  =>  __( '11 hours', 'better-studio' ),
                    12  =>  __( '12 hours', 'better-studio' ),
                    13  =>  __( '13 hours', 'better-studio' ),
                    14  =>  __( '14 hours', 'better-studio' ),
                    15  =>  __( '15 hours', 'better-studio' ),
                    16  =>  __( '16 hours', 'better-studio' ),
                    17  =>  __( '17 hours', 'better-studio' ),
                    18  =>  __( '18 hours', 'better-studio' ),
                    19  =>  __( '19 hours', 'better-studio' ),
                    20  =>  __( '20 hours', 'better-studio' ),
                    21  =>  __( '21 hours', 'better-studio' ),
                    22  =>  __( '22 hours', 'better-studio' ),
                    23  =>  __( '23 hours', 'better-studio' ),
                    24  =>  __( '24 hours', 'better-studio' ),

                )
            );
            $field[] = array(
                'name'      =>  __( 'Clear Data Base Saved Caches', 'better-studio' ),
                'id'        =>  'cache_clear_all',
                'type'      =>  'ajax_action',
                'button-name' =>  'Clear All Caches',
                'callback'  =>  'Better_Social_Counter::clear_cache_all',
                'confirm'  =>  __( 'Are you sure for deleting all caches?', 'better-studio' ),
                'desc'      =>  __( 'This allows you to clear all caches that are saved in data base.', 'better-studio' )
            );


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

        $options['better_social_counter_options'] = array(
            'config' => array(
                'parent'                =>    'better-studio',
                'name'                  =>    __( 'Better Social Counter', 'better-studio' ),
                'page_title'            =>    __( 'Better Social Counter', 'better-studio' ),
                'menu_title'            =>    __( 'Better Social Counter', 'better-studio' ),
                'capability'            =>    'manage_options',
                'menu_slug'             =>    __( 'BetterSocialCounter', 'better-studio' ),
                'icon_url'              =>    null,
                'position'              =>    20,
                'exclude_from_export'   =>    false,
            ),
            'panel-name'          => _x( 'Better Social Counter Options', 'Panel title', 'better-studio' ),
            'fields' => $field
        );

        return $options;
    }

}
