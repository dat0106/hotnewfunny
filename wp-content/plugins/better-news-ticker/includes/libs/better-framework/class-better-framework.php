<?php


/**
 * Class Better_Framework
 */
class Better_Framework{


    /**
     * Version of BF
     *
     * @var string
     */
    public $version  = '1.3.2';


    /**
     * Defines which sections should be include in BF
     *
     * @since 1.0
     * @access public
     * @var array
     */
    public $sections = array(
        'admin_panel'		    => true,    // For initializing BF theme option panel generator
        'meta_box' 			    => true,    // For initializing BF meta box generator
        'taxonomy_meta_box'     => false,   // For initializing BF taxonomy meta box generator
        'load_in_frontend'      => false,   // For loading all BF in frontend, disable this for better performance
        'chat_post_formatter'   => false,   // Includes BF lib for formatting chat post type content
        'better-menu'           => false,   // Includes better menu
        'custom-css-fe'         => true,    // For initializing BF Front End Custom CSS Generator
        'custom-css-be'         => true,    // For initializing BF Back End ( WP Admin ) Custom CSS Generator
        'custom-css-pages'      => false,    // For initializing BF Pages Custom CSS
        'assets_manager'        => true,    // For initializing BF custom css generator
        'vc-extender'           => false,   // For initializing VC functionality extender
        'woocommerce'           => false,   // For initializing WooCommerce functionality
        'bbpress'               => false,   // For initializing bbPress functionality
    );


    /**
     * Inner array of instances
     *
     * @var array
     */
    protected static $instances = array();


    /**
     * PHP Constructor Function
     *
     * @param array $sections default features
     *
     * @since 1.0
     * @access public
     */
    public function __construct( $sections = array() ){

        // define features of BF
        $this->sections = wp_parse_args( $sections, $this->sections );
        $this->sections = apply_filters( 'better-framework/sections', $this->sections );

        /**
         * BF General Functionality For Both Front End and Back End
         */
        self::factory( 'general' );

        self::factory( 'assets-manager' );

        /**
         * BF BetterMenu For Improving WP Menu Features
         */
        if($this->sections['better-menu']==true){
            self::factory( 'better-menu' );
        }


        /**
         * BF Widgets Manager
         */
        self::factory( 'widgets-manager' );


        /**
         * BF Shortcodes Manager
         */
        if( $this->sections['vc-extender'] == true ){
            require_once BF_PATH . 'vc-extend/class-bf-vc-shortcode-extender.php';
        }
        self::factory('shortcodes-manager');


        /**
         * BF Custom Generator For Front End
         */
        if( $this->sections['custom-css-fe'] ){
            self::factory('custom-css-fe');
        }

        /**
         * BF Custom Generator Pages and Posts in Front end
         */
        if( $this->sections['custom-css-pages'] ){
            self::factory('custom-css-pages');
        }


        /**
         * BF Custom Generator For Back End
         */
        if( $this->sections['custom-css-be'] ){
            self::factory( 'custom-css-be' );
        }


        /**
         * BF Lib For Styling Chat Post Format
         */
        if( $this->sections['chat_post_formatter'] == true ){
            require_once BF_PATH . 'libs/bf-chat-format.php';
        }


        /**
         * BF WooCommerce
         */
        if( $this->sections['woocommerce'] == true && function_exists( 'is_woocommerce' ) ){
            self::factory( 'woocommerce' );
        }


        /**
         * BF bbPress
         */
        if( $this->sections['bbpress'] == true && class_exists( 'bbpress' ) ){
            self::factory( 'bbpress' );
        }


        /**
         * Disable Loading BF Fully in Front End
         */
        if( ! is_admin() && $this->sections['load_in_frontend'] == false )
            return;


        /**
         * BF Core Functionality That Used in Back End
         */
        self::factory( 'admin-notice' );
        self::factory( 'core' , false , true );
        self::factory( 'color' );


        /**
         * BF Taxonomy Meta Box Generator
         */
        if($this->sections['taxonomy_meta_box']==true){
            self::factory( 'taxonomy-meta' );
        }


        /**
         * BF Post & Page Meta Box Generator
         */
        if($this->sections['meta_box']==true){
            self::factory( 'meta-box' );
        }


        /**
         * BF Visual Composer Extender
         */
        if($this->sections['vc-extender']==true){
            self::factory('vc-extender');
        }


        // Admin style and scripts
        if( is_admin() ){
            // Hook BF admin assets enqueue
            add_action( 'admin_enqueue_scripts', array( $this , 'enqueue' ));

            // Hook BF admin ajax requests
            add_action( 'wp_ajax_bf_ajax', array( $this, 'admin_ajax' ) );
            add_action( 'better-framework/panel/image-upload', array( $this , 'handle_file_upload' ) );
        }


        /**
         * BF Admin Panel Generator
         */
        if( $this->sections['admin_panel'] == true ){
            self::factory('admin-panel');
        }

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
             * Main BetterFramework Class
             */
            case 'self':
                $class = 'Better_Framework';
                break;

            /**
             * General Helper Functions
             */
            case 'helper':
                require_once BF_PATH . 'core/class-bf-helper.php';

                $class = 'BF_Helper';
                break;

            /**
             * BF General Functionality For Both Front End and Back End
             */
            case 'general':
                self::factory( 'helper' );
                require_once BF_PATH . 'admin-panel/class-bf-options.php';
                require_once BF_PATH . 'core/class-bf-query.php';
                require_once BF_PATH . 'core/class-bf-posts.php';
                require_once BF_PATH . 'core/class-bf-block-generator.php';

                return true;
                break;

            /**
             * BF_Options Used For Retrieving Theme Panel Options
             */
            case 'options':
                require_once BF_PATH . 'admin-panel/class-bf-options.php';

                $class = 'BF_Options';
                break;

            /**
             * BF BetterMenu For Improving WP Menu Features
             */
            case 'better-menu':
                require_once BF_PATH . 'menu/class-bf-menus.php';

                $class = 'BF_Menus';
                break;

            /**
             * BF Visual Composer Extender
             */
            case 'vc-extender':
                require_once BF_PATH . 'vc-extend/class-bf-vc-extender.php';

                $class = 'BF_VC_Extender';
                break;

            /**
             * BF Post & Page Meta Box Generator
             */
            case 'meta-box':
                require_once BF_PATH . 'metabox/class-bf-metabox-core.php';

                $class = 'BF_Metabox_Core';
                break;

            /**
             * BF Taxonomy Meta Box Generator
             */
            case 'taxonomy-meta':
                require_once BF_PATH . 'core/field-generator/class-bf-admin-fields.php';
                require_once BF_PATH . 'taxonomy/class-bf-taxonomy-front-end-generator.php';
                require_once BF_PATH . 'taxonomy/class-bf-taxonomy-meta-field.php';
                require_once BF_PATH . 'taxonomy/class-bf-taxonomy-core.php';

                $class = 'BF_Taxonomy_Core';
                break;

            /**
             * BF Admin Panel Generator
             */
            case 'admin-panel':
                require_once BF_PATH . 'admin-panel/class-better-admin-panel.php';

                $class = 'Better_Admin_Panel';
                break;

            /**
             * BF Shortcodes Manager
             */
            case 'shortcodes-manager':
                require_once BF_PATH . 'shortcode/class-bf-shortcodes-manager.php';

                $class = 'BF_Shortcodes_Manager';
                break;

            /**
             * BF Widgets
             */
            case 'widgets-manager':

                require_once BF_PATH . 'widget/class-bf-widget.php';
                require_once BF_PATH . 'widget/class-bf-widgets-manager.php';

                $class = 'BF_Widgets_Manager';
                break;


            /**
             * BF Widgets Field Generator
             */
            case 'widgets-field-generator':
                require_once BF_PATH . 'core/field-generator/class-bf-admin-fields.php';
                require_once BF_PATH . 'widget/class-bf-widgets-field-generator.php';

                return true;
                break;

            /**
             * BF Core Functionality That Used in Back End
             */
            case 'admin-notice':
                require_once BF_PATH . 'core/class-bf-admin-notices.php';

                $class = 'BF_Admin_Notices';
                break;

            /**
             * BF Core Functionality That Used in Back End
             */
            case 'core':
                require_once BF_PATH . 'core/field-generator/class-bf-google-fonts-helper.php';
                require_once BF_PATH . 'core/field-generator/class-bf-ajax-select-callbacks.php';
                require_once BF_PATH . 'core/field-generator/class-bf-admin-fields.php';
                require_once BF_PATH . 'core/class-bf-html-generator.php';

                return true;
                break;


            /**
             * BF Custom Generator For Front End
             */
            case 'custom-css-fe':
                require_once BF_PATH . 'core/custom-css/abstract-bf-custom-css.php';
                require_once BF_PATH . 'core/custom-css/class-bf-front-end-css.php';

                $class = 'BF_Front_End_CSS';
                break;

            /**
             * BF Custom Generator For Back End
             */
            case 'custom-css-be':
                require_once BF_PATH . 'core/custom-css/abstract-bf-custom-css.php';
                require_once BF_PATH . 'core/custom-css/class-bf-back-end-css.php';

                $class = 'BF_Back_End_CSS';
                break;

            /**
             * BF Custom Generator Pages and Posts in Front end
             */
            case 'custom-css-pages':
                require_once BF_PATH . 'core/custom-css/abstract-bf-custom-css.php';
                require_once BF_PATH . 'core/custom-css/class-bf-pages-css.php';

                $class = 'BF_Pages_CSS';
                break;

            /**
             * BF Color Used For Retrieving User Color Schema and Some Helper Functions For Changing Colors
             */
            case 'color':
                require_once BF_PATH . 'libs/class-bf-color.php';

                $class = 'BF_Color';
                break;

            /**
             * BF Color Used For Retrieving User Color Schema and Some Helper Functions For Changing Colors
             */
            case 'breadcrumb':
                require_once BF_PATH . 'libs/class-bf-breadcrumb.php';

                $class = 'BF_Breadcrumb';
                break;

            /**
             * BF Icon Factory Used For Handling FontIcons Actions
             */
            case 'icon-factory':
                require_once BF_PATH . 'libs/icons/class-bf-icons-factory.php';

                return true;

            /**
             * BF WooCommerce
             */
            case 'woocommerce':
                require_once BF_PATH . 'woocommerce/abstract-class-bf-woocommerce.php';

                return true;

            /**
             * BF bbPress
             */
            case 'bbpress':
                require_once BF_PATH . 'bbpress/abstract-class-bf-bbpress.php';

                return true;

            /**
             * Assets Manager
             */
            case 'assets-manager':
                require_once BF_PATH . 'core/class-bf-assets-manager.php';

                $class = 'BF_Assets_Manager';
                break;

            default:
                return null;
        }


        // Just prepare/includes files
        if( $just_include )
            return;

        // don't cache fresh objects
        if ($fresh) {
            return new $class;
        }

        self::$instances[$object] = new $class;
        return self::$instances[$object];
    }

    /**
     * Used for accessing alive instance of Better_Framework
     *
     * static
     * @since 1.0
     * @return Better_Framework
     */
    public static function self(){

        return self::factory( 'self' );

    }


    /**
     * Used for getting options from BF_Options
     *
     * @param bool $fresh
     * @return BF_Options
     */
    public static function options( $fresh = false ){
        return self::factory( 'options', $fresh );
    }


    /**
     * Used for accessing shortcodes from BF_Shortcodes_Manager
     *
     * @param bool $fresh
     * @return BF_Shortcodes_Manager
     */
    public static function shortcodes( $fresh = false ){
        return self::factory( 'shortcodes-manager', $fresh );
    }


    /**
     * Used for accessing taxonomy meta from BF_Taxonomy_Core
     *
     * @param bool $fresh
     * @return BF_Taxonomy_Core
     */
    public static function taxonomy_meta( $fresh = false ){
        return self::factory( 'taxonomy-meta', $fresh );
    }


    /**
     * Used for accessing widget manager from BF_Widgets_Manager
     *
     * @param bool $fresh
     * @return BF_Widgets_Manager
     */
    public static function widget_manager( $fresh = false ){
        return self::factory( 'widgets-manager', $fresh );
    }


    /**
     * Used for accessing widget manager from BF_Widgets_Manager
     *
     * @param bool $fresh
     * @return BF_Breadcrumb
     */
    public static function breadcrumb( $fresh = false ){
        return self::factory( 'breadcrumb', $fresh );
    }


    /**
     * Used for accessing BF_Admin_Notices for adding notice to admin panel
     *
     * @param bool $fresh
     * @return BF_Admin_Notices
     */
    public static function admin_notices( $fresh = false ){
        return self::factory( 'admin-notice', $fresh );
    }


    /**
     * Used for accessing BF_Assets_Manager for enqueue styles and scripts
     *
     * @param bool $fresh
     * @return BF_Assets_Manager
     */
    public static function assets_manager( $fresh = false ){
        return self::factory( 'assets-manager', $fresh );
    }


    /**
     * Used for accessing BF_Helper for adding notice to admin panel
     *
     * @param bool $fresh
     * @return BF_Helper
     */
    public static function helper( $fresh = false ){
        return self::factory( 'helper', $fresh );
    }


    /**
     * Gets a WP_Theme object for a theme.
     *
     * @param bool $parent
     * @param bool $fresh
     * @param bool $cache_this
     * @return  WP_Theme
     */
    public static function theme( $parent = true, $fresh = false, $cache_this = true ){

        if( isset( self::$instances['theme'] ) && ! $fresh ){
            return self::$instances['theme'];
        }

        $theme = wp_get_theme();

        if( $parent && ( '' != $theme->get('Template') ) ){
            $theme = wp_get_theme( $theme->get('Template') );
        }

        if( $cache_this == true ){
            return self::$instances['theme'] = $theme;
        }else{
            return $theme;
        }

    }


    /**
     * Reference To HTML Generator Class
     *
     * static
     * @since 1.0
     * @return BF_HTML_Generator
     */
    public static function html(){
        return new BF_HTML_Generator;
    }


    /**
     * Handle BF Admin Enqueue's
     *
     * static
     * @since 1.0
     * @return object
     */
    public function enqueue(){

        // enqueue scripts if features enabled
        if( $this->sections['admin_panel'] == true  ||
            $this->sections['meta_box'] == true     ||
            $this->sections['better-menu'] == true  ||
            $this->sections['taxonomy_meta_box'] == true
        ){

            if( $this->get_current_page_type() != '' ){

                // Wordpress 3.5
                wp_enqueue_media();

                // BetterFramework Admin scripts
                Better_Framework::assets_manager()->enqueue_script( 'better-framework-admin' );

                if( ( $type = $this->get_current_page_type() ) == '' )
                    $type ='0';

                wp_localize_script(
                    'bf-better-framework-admin',
                    'bf',
                    apply_filters(
                        'better-framework/localized-items',
                        array(
                            'bf_ajax_url'       => admin_url( 'admin-ajax.php' ),
                            'nonce'			    => wp_create_nonce( 'bf_nonce' ),
                            'type'			    => $type,
                            'google_fonts'      => BF_Google_Fonts_Helper::get_all_fonts(),

                            // Localized Texts
                            'show_advanced_fields'  => __( 'Show Advanced Fields?', 'better-studio'),
                            'hide_advanced_fields'  => __( 'Hide Advanced Fields?', 'better-studio'),
                            'text_import_prompt'  => __( 'Do you really wish to override your current settings?', 'better-studio'),
                        )
                    )
                );


                // BetterFramework admin style
                Better_Framework::assets_manager()->enqueue_style( 'better-framework-admin' );

                // BetterFramework admin panel RTL style
                if( is_rtl() ){
                    Better_Framework::assets_manager()->enqueue_style( 'better-framework-admin-rtl' );
                }

            }
        }
    }


    /**
     * Used for finding current page type
     *
     * @return string
     */
    public function get_current_page_type( ){

        global $pagenow;

        $type = '';

        if( $pagenow == 'post-new.php' || $pagenow == 'post.php' )
            $type = 'metabox';

        elseif( $pagenow == 'edit-tags.php' )
            $type = 'taxonomy';

        elseif( $pagenow == 'widgets.php')
            $type = 'widgets';

        elseif( $pagenow == 'nav-menus.php')
            $type = 'menus';

        elseif( isset( $_GET['page'] ) && ( preg_match( '/^better-studio-/', $_GET['page'] ) || preg_match( '/^better-studio\//', $_GET['page'] ) ) )
            $type = 'panel';

        return $type;
    }


    /**
     * Handle Ajax File Uploads
     *
     * @param string $data The variable that includes all options in array
     *
     * @since 1.0
     * @return void
     */
    public function handle_file_upload( $data ) {
        if( !function_exists( 'wp_handle_upload' ) )
            require_once ABSPATH.'wp-admin/includes/file.php';

        $movefile = wp_handle_upload(
            $data,
            array(
                'test_form' => false
            )
        );

        if ( array_key_exists( 'error', $movefile ) )
            $upResults   = array(
                'status' => 'error',
                'msg'	 => $movefile['error']
            );
        else
            $upResults = array(
                'status' => 'succeed',
                'url'	 => $movefile['url'],
                'path'	 => $movefile['file']
            );

        echo json_encode( $upResults );
        die;

    }


    /**
     * Handle All Ajax Requests in Back-End
     *
     * @since 1.0
     * @return mixed
     */
    public function admin_ajax(){

        // Check Nonce
        if ( !isset( $_REQUEST['nonce'] ) || !isset( $_REQUEST['reqID'] ) )
            die(
            json_encode(
                array(
                    'status' => 'error',
                    'msg' 	 => __( 'Security Error!', 'better-studio' )
                )
            )
            );

        $_nonce = wp_verify_nonce( $_REQUEST['nonce'], 'bf_nonce' );

        // Check Nonce
        if ( $_nonce === false )
            die(
            json_encode(
                array(
                    'status' => 'error',
                    'msg' 	 => __( 'Security Error!', 'better-studio' )
                )
            )
            );

        $ID = $_REQUEST['reqID'];

        switch( $ID ){

            // Option Panel, Save Settings
            case( 'save_admin_panel_options' ):
                wp_parse_str( ltrim( rtrim( stripslashes( $_REQUEST['data'] ), '&' ), '&' ), $options );
                $data = array( 'id' => $_REQUEST['panelID'], 'data' => $options );
                do_action( 'better-framework/panel/save', $data );
                break;

            // Ajax Image Uploader
            case( 'image_upload' ):
                $data = $_FILES[ $_REQUEST['file_id'] ];
                do_action( 'better-framework/panel/image-upload', $data, $_REQUEST['file_id'] );
                break;

            // Option Panel, Reset Settings
            case( 'reset_options_panel' ):
                do_action( 'better-framework/panel/reset', array( 'id' => $_REQUEST['panelID'], 'options' => $_REQUEST['to_reset'] ) );
                break;

            // Option Panel, Ajax Select field
            case( 'ajax_action' ):

                $callback = isset( $_REQUEST['callback'] ) ? $_REQUEST['callback'] : '';
                $error_message = isset( $_REQUEST['error-message'] ) ? $_REQUEST['error-message'] : __( 'An error occurred while doing action.', 'better-studio' );

                if( ! empty( $callback) && is_callable( $callback ) && is_array( $to_return = call_user_func( $callback ) ) ){

                    echo json_encode( $to_return );

                }else{
                    echo json_encode(
                            array(
                                'status'  =>    'error',
                                'msg'	  =>    $error_message
                            )
                    );
                }
                break;

            // Option Panel, Ajax Select field
            case( 'ajax_field' ):

                if( isset( $_REQUEST['callback'] ) &&
                    is_callable( $_REQUEST['callback'] ) &&
                    is_array(
                        $to_return = call_user_func_array( $_REQUEST['callback'], array( $_REQUEST['key'] , $_REQUEST['exclude'] ) )
                    )
                )
                    echo count($to_return) === 0 ? -1 : json_encode( $to_return );

                break;

            // Option Panel, Import Settings
            case( 'import' ):
                $data = $_FILES['bf-import-file-input'];
                do_action( 'better-framework/panel/import', $data );
                break;

        }
        die;
    }

}


Better_Framework::self();
