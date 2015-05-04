<?php

// Prevent Direct Access
defined( 'ABSPATH' ) or die;

/**
 * BF Admin Panel Main Class
 *
 * @package BetterFramework
 * @since 1.0
 */
class Better_Admin_Panel {


    /**
     * Holds everything about the front-end template
     *
     * @since 1.0
     * @access public
     * @var array
     */
    public $template = array();


    /**
     * contains id of BetterStudio menu
     *
     * @var string
     */
    private $better_studio_main_menu_id = '';


    /**
     * Init Function
     *
     * Hook Initial Functions
     *
     * @static
     * @since 1.0
     * @access public
     * @return Better_Admin_Panel
     */
    public static function init(){

        $class = __CLASS__;
        return new $class;

    }


    /**
     * Constructor Function
     *
     * @since 1.0
     * @access public
     * @return \Better_Admin_Panel
     */
    public function __construct(){

        // loads all fields
        if( count( Better_Framework::options()->options ) <= 0 ){
            return;
        }

        add_action( 'admin_menu', array( $this, 'add_menu' ) );

        add_action( 'better-framework/panel/save', array( $this, 'handle_saving_option_panel' ) );

        add_action( 'better-framework/panel/reset', array( $this, 'reset_options') );

        add_action( 'better-framework/panel/import', array( $this, 'handle_ajax_import' ) );

        add_action( 'admin_init', array( $this, 'handle_export_download' ) );

        add_filter( 'better-framework/css/backend', array( $this, 'panel_custom_css') );

    }


    /**
     * Hook register menus to WordPress
     *
     * @since 1.0
     * @access public
     * @return void
     */
    public function add_menu(){

        $options  = array();

        foreach( Better_Framework::options()->options as $id => $menu_config ) {

            if( ! isset( $menu_config['config']['position'] ) )
                $menu_config['config']['position'] = 90;

            if( isset( $menu_config['theme-panel'] ) ){
                $menu_config['config']['theme-panel'] = true;
            }

            $menu_config['config']['id'] = $id;

            $options[$id] = $menu_config['config'];
        }


        // Adds admin pages that are outside of BetterStudio main menu
        foreach( $options as $id => $menu_config ){

            if( isset( $menu_config['parent'] ) && $menu_config['parent'] != 'better-studio' ){

                $this->add_wp_menu_page( $menu_config );
                unset( $options[$id] );
            }

        }


        // Sorts items with position sub array key
        usort( $options, array( $this, "usort_cmp_by_position" ) );

        // When there is only one item in BetterStudio main menu
        if( count( $options ) == 1 ){

            $options = current( $options );

            // Save main menu id tat will be used for hiding
            $this->better_studio_main_menu_id = 'better-studio/' . $menu_config['id'];

            // Adds main better studio menu page
            $this->add_wp_menu_page( array(
                'id'                    =>    $this->better_studio_main_menu_id,
                'slug'                  =>    $this->better_studio_main_menu_id ,
                'parent'                =>    false,
                'name'                  =>    __( '<strong>Better</strong>Studio', 'better-studio' ),
                'page_title'            =>    __( '<strong>Better</strong>Studio', 'better-studio' ),
                'menu_title'            =>    __( '<strong>Better</strong>Studio', 'better-studio' ),
                'capability'            =>    'manage_options',
                'menu_slug'             =>    $this->better_studio_main_menu_id,
                'icon_url'              =>    BF_URI.'assets/img/better-studio-menu-logo.png'  ,
                'position'              =>    99,
                'exclude_from_export'   =>    false,
            ) );

            // Updates main menu page for new main sub menu
            $this->add_wp_menu_page( array(
                'id'                    =>    $this->better_studio_main_menu_id,
                'slug'                  =>    $this->better_studio_main_menu_id,
                'parent'                =>    $this->better_studio_main_menu_id,
                'name'                  =>    $options['name'],
                'page_title'            =>    $options['page_title'],
                'menu_title'            =>    $options['menu_title'],
                'capability'            =>    'manage_options',
                'menu_slug'             =>    $this->better_studio_main_menu_id,
                'icon_url'              =>    null,
                'position'              =>    99,
                'exclude_from_export'   =>    false,
            ) );

            // Adds another temp item to force menu for having sub menu
            $this->add_wp_menu_page( array(
                'id'                    =>    '',
                'slug'                  =>    '' ,
                'parent'                =>    $this->better_studio_main_menu_id,
                'name'                  =>    '',
                'page_title'            =>    '',
                'menu_title'            =>    '',
                'capability'            =>    'manage_options',
                'menu_slug'             =>    'extera',
                'icon_url'              =>    null,
                'position'              =>    99,
                'exclude_from_export'   =>    false,
            ) );


            // Add style for hiding temp sub menu with css
            add_action('admin_head', array( $this, 'admin_head_remove_temp_sub_menu') , 999);

        }else{

            foreach( $options as $id => $menu_config ){

                // Adds main menu and update sub menu
                if( empty( $this->better_studio_main_menu_id ) ){

                    // Save main menu id tat will be used for hiding
                    $this->better_studio_main_menu_id = 'better-studio/' . $menu_config['id'];

                    // Adds main better studio menu page
                    $this->add_wp_menu_page( array(
                        'id'                    =>    $this->better_studio_main_menu_id,
                        'slug'                  =>    $this->better_studio_main_menu_id,
                        'parent'                =>    false,
                        'name'                  =>    __( '<strong>Better</strong>Studio', 'better-studio' ),
                        'page_title'            =>    __( '<strong>Better</strong>Studio', 'better-studio' ),
                        'menu_title'            =>    __( '<strong>Better</strong>Studio', 'better-studio' ),
                        'capability'            =>    'manage_options',
                        'menu_slug'             =>    'better-studio',
                        'icon_url'              =>    BF_URI.'assets/img/better-studio-menu-logo.png'  ,
                        'position'              =>    99,
                        'exclude_from_export'   =>    false,
                    ) );

                    // Updates main menu page for new main sub menu
                    $this->add_wp_menu_page( array(
                        'id'                    =>    $this->better_studio_main_menu_id,
                        'slug'                  =>    $this->better_studio_main_menu_id,
                        'parent'                =>    $this->better_studio_main_menu_id,
                        'name'                  =>    $menu_config['name'],
                        'page_title'            =>    $menu_config['page_title'],
                        'menu_title'            =>    $menu_config['menu_title'],
                        'capability'            =>    'manage_options',
                        'menu_slug'             =>    'better-studio',
                        'icon_url'              =>    null,
                        'position'              =>    99,
                        'exclude_from_export'   =>    false,
                    ));

                }
                // add sub menu for main menu
                else{

                    $menu_config['parent'] = $this->better_studio_main_menu_id;

                    $this->add_wp_menu_page( $menu_config );

                }

            }

        }

    }


    /**
     * Handy function for sorting arrays with position sub value value
     *
     * @param $a
     * @param $b
     * @return mixed
     */
    private function usort_cmp_by_position($a, $b) {
        return $a["position"] - $b["position"];
    }


    /**
     * Adds style for hiding temp menu in BetterStudio main page menu
     */
    function admin_head_remove_temp_sub_menu() {

        echo '<style>#adminmenu li#toplevel_page_'. str_replace( array( '/'), '-', $this->better_studio_main_menu_id ) .' .wp-submenu li:nth-child(3){ display: none !important; }</style>';

    }


    /**
     * Adds menu page or sub page to WordPress
     *
     * @param bool|array $val
     */
    public function add_wp_menu_page(  $val = false ){

        if( $val == false )
            return;

        $val['parent'] = isset( $val['parent'] ) ? $val['parent'] : false;

        $name 		= str_replace(
            array(
                '_',
                '-'
            ),
            array(
                ' ',
                ' '
            ),
            $val['id']
        );

        $name = ucwords( $name );

        $val['page_title'] = isset( $val['page_title'] ) ? $val['page_title'] : ucfirst( $val['id'] );
        $val['menu_title'] = isset( $val['menu_title'] ) ? $val['menu_title'] : $name;
        $val['capability'] = isset( $val['capability'] ) ? $val['capability'] : 'manage_options';
        $val['icon_url']   = isset( $val['icon_url'] )   ?  $val['icon_url']   : null;

        if( isset( $val['slug'] ) ){
            $menu_slug = $val['slug'];
        }else{
            $menu_slug  = 'better-studio/' . $val['id'];
        }

        if( $val['parent'] == false ){

            call_user_func_array( 'add_menu'.'_page', array(
                    $val['page_title'],
                    $val['menu_title'],
                    $val['capability'],
                    $menu_slug,
                    array( $this, 'menu_callback' ),
                    $val['icon_url'],
                    $val['position']
                )
            );

        }else{

            call_user_func_array( 'add_subm'.'enu_page', array(
                    $val['parent'],
                    $val['page_title'],
                    $val['menu_title'],
                    $val['capability'],
                    $menu_slug,
                    array( $this, 'menu_callback' )
                )
            );

        }

    }


    /**
     * Get All Paths
     *
     * get all paths, such as template directories
     *
     * @since 1.0
     * @access public
     * @return array|bool
     */
    public function get_all_paths(){

        $id = $this->get_current_page_id();

        if( $id == false )
            return false;

        $i =  BF_PATH . '/includes/';

        $output = array();
        $output['custom-panel-main-default-template'] 	   = $i . 'templates/admin-panel/default/';
        $output['custom-panel-main-template-current-page'] = $i . "templates/admin-panel/{$id}/";
        $output['default-panel-main-template']			   = BF_PATH . "admin-panel/templates/default/";

        return $output;
    }


    /**
     * Get current page
     *
     * Return current page id
     *
     * static
     * @since 1.0
     * @access public
     * @return string
     */
    public function get_current_page_id(){

        if( ! isset( $_GET['page'] ) )
            return false;

        $page = explode( '/', $_GET['page'] );

        if( empty( $page[1] ) )
            return false;

        return $page[1];

    }


    /**
     * Get page data which is hooked to better-framework/panel/options
     *
     * @param string $ID Needed page ID
     *
     * @since 1.0
     * @access public
     * @return bool|array
     */
    public function get_page_data_by_id( $ID ){

        if( isset( Better_Framework::options()->options[$ID] ) ){

            return Better_Framework::options()->options[$ID];

        }

        return false;

    }


    /**
     * Get page current data
     *
     * @since 1.0
     * @access public
     * @return bool|array
     */
    public function get_current_page_data(){

        $id = $this->get_current_page_id();

        return $this->get_page_data_by_id( $id );
    }


    /**
     * Get Specific Panel Data
     *
     * @param (string) $panel_id The id of panel
     *
     * @since 1.0
     * @access public
     * @return bool|array
     */
    public function get_panel_values( $panel_id ){

        $id = $this->get_current_page_id();
        if( $id == false )
            return false;

        $option = get_option( $panel_id );

        if( empty( $option ) )
            return false;

        return $option ;
    }


    /**
     * Menu Callback
     *
     * The callback of add_menu_page which is about the front-end stuff
     *
     * todo add support for custom template for each panel
     *
     * @since 1.0
     * @access public
     * @return mixed
     */
    public function menu_callback(){

        $id     = $this->get_current_page_id();

        $data   = (array) $this->get_current_page_data();

        $values = $this->get_panel_values( $id );

        require_once "class-bf-admin-panel-front-end-generator.php";

        $front_end_instance = new BF_Admin_Panel_Front_End_Generator( $data, $id, $values );

        // Defined Template Tags
        $this->template = array(
            'id'     => $id,
            'data'   => $data,
            'tabs'   => $front_end_instance->get_tabs(),
            'fields' => $front_end_instance->get_fields(),
        );

        $paths = $this->get_all_paths();

        if( file_exists( $paths['custom-panel-main-template-current-page'] . 'main.php' ) )
            require_once $paths['custom-panel-main-template-current-page'] . 'main.php';
        else if( file_exists( $paths['custom-panel-main-default-template'] . 'main.php' ) )
            require_once $paths['custom-panel-main-default-template'] . 'main.php';
        else
            require_once $paths['default-panel-main-template'] . 'main.php';

    }


    /**
     * Handle Save Options
     *
     * @param array $args The variable that includes all options in array
     *
     * @since 1.0
     * @return void
     */
    public function handle_saving_option_panel( $args ) {

        $skin_state = $this->prepare_skin( $args['id'], $args['data'] );

        if( $this->add_option( $args['id'], $args['data'] ) !== false ){

            Better_Framework::factory( 'custom-css-fe' )->clear_cache( 'all' );

            $output = array(
                'status'	    => 'succeed',
                'msg'  	        => __( 'OK!', 'better-studio' ),
                'refresh'       => $skin_state,
            );



        }else{
            $output = array(
                'status'	=> 'error',
                'msg'  	    => __( 'ERROR!', 'better-studio' )
            );
        }

        if( $skin_state )
            Better_Framework::admin_notices()->add_notice( array( 'msg' => __( 'Pre-defined Skin and Styles updated.', 'better-studio' ) ) );

        echo json_encode( $output );
    }


    /**
     * Used for adding options
     *
     * @param null $ID
     * @param null $value
     * @return bool
     */
    public function add_option( $ID = null, $value = null ) {

        // if the parameters are not defined stop the proccess.
        if ( $ID === null || $value === null )
            return false;

        $old_value = get_option( $ID );

        if( $old_value === false ){
            return add_option( $ID, $value );
        }else{
            if( $old_value === $value ){
                return true;
            }else{
                delete_option( $ID );
                return add_option( $ID, $value );
            }
        }
    }


    /**
     * Prepare values of options before save for specified values for styles.
     *
     * Checks if "style" was changed then check all fields for custom value for new style and change them and returns changed option.
     *
     * @param $id
     * @param array $data
     * @return bool
     */
    function prepare_skin( $id, &$data = array() ){

        // if skin is not defined
        if( ! isset( Better_Framework::options()->options[$id]['fields']['style'] ) ) return false;

        // if data is empty or not added to function
        if( count( $data ) <= 0 ) return false;

        $current_style = Better_Framework::options()->get( 'style', $id );

        // if skin not changed
        if( $current_style == $data['style'] ) return false;

        // Update saved style
        update_option( $id . '_current_style', $data['style'] );

        $std_id = Better_Framework::options()->get_std_field_id( $id );

        foreach( (array) Better_Framework::options()->options[$id]['fields'] as $field ){

            // Not save if field have style filter
            if( ! isset( $field['style'] ) || ! in_array( $current_style, $field['style'] ) )  continue;

            // If field have std value then change current value std std value
            if( isset( $field[$std_id] ) ){
                $data[$field['id']] = $field[$std_id];
            }elseif( isset( $field['std'] ) ){
                $data[$field['id']] = $field['std'];
            }

        }

        return true;
    }


    /**
     * Reset All Options
     *
     * @since 1.0
     * @param $options
     * @return void
     */
    public function reset_options( $options ) {

        parse_str(
            $options['options'],
            $to_reset
        );

        update_option( $options['id'] . '_current_style', 'default' );

        if ( Better_Framework::options()->save_panel_options( $options['id'] ) !== false ){

            Better_Framework::factory('custom-css-fe')->clear_cache('all');

            echo json_encode(
                array(
                    'status'  => 'succeed',
                    'msg'	  => __( 'Options Reset.', 'better-studio' ),
                    'refresh' => true,
                )
            );
            Better_Framework::admin_notices()->add_notice( array( 'msg' => __( 'Options reset to defaults.', 'better-studio' ) ) );
        }
        else{

            echo json_encode(
                array(
                    'status' => 'error',
                    'msg'	 => __( 'An error occurred while resetting options.', 'better-studio' )
                )
            );

            Better_Framework::admin_notices()->add_notice( array( 'msg' => __( 'An error occurred while resetting options.', 'better-studio' ) ) );

        }

    }


    /**
     * Handle Ajax Import
     *
     * @since 1.0
     * @param $file
     * @return void
     */
    public function handle_ajax_import( $file ) {

        $data 	= file_get_contents( $file['tmp_name'] );
        $data 	= json_decode( $data, true );

        if ( $data === false || ! isset( $data['panel-id'] ) || empty( $data['panel-id'] ) || ! isset( $data['panel-data'] )){

            Better_Framework::admin_notices()->add_notice( array(
                'msg' => __( 'Imported data is not correct or was corrupted.', 'better-studio' ),
                'class' => 'error'
            ) );

            die( __( 'Imported data is not correct or was corrupted.', 'better-studio' ) );
        }


        // save options
        update_option( $data['panel-id'], $data['panel-data'] ) ;

        // Imports style
        if( isset( $data['panel-data']['style'] ) && ! empty( $data['panel-data']['style'] ) ){
            update_option( $data['panel-id'] . '_current_style', $data['panel-data']['style'] );
        }

        Better_Framework::factory('custom-css-fe')->clear_cache( 'all' );

        echo __( 'Theme Options successfully imported.', 'better-studio' );
        Better_Framework::admin_notices()->add_notice( array( 'msg' => __( 'Theme Options successfully imported.', 'better-studio' ) ) );


    }


    /**
     * Add Default Options After Theme Activated.
     *
     * @since 1.0
     * @return void
     */
    public function handle_export_download() {

        if( isset( $_POST['bf-export'] ) && $_POST['bf-export'] == 1 ){

            $options_array['panel-id'] = $_POST['panel_id'];
            $options_array['panel-data'] = get_option( $_POST['panel_id'] );

            // Custom file name for each theme
            if(  isset( $_POST['file_name'] ) && ! empty( $_POST['file_name'] ) ){
                $file_name = $_POST['file_name'] . '-';
            }else{
                $file_name = 'options-backup-';
            }

            $options_array = json_encode( $options_array );

            // No Cache
            header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
            header( 'Last-Modified: '. gmdate( 'D, d M Y H:i:s' ).' GMT' );
            header( 'Cache-Control: no-store, no-cache, must-revalidate' );
            header( 'Cache-Control: post-check=0, pre-check=0', false );
            header( 'Pragma: no-cache' );
            header( 'Content-Type: application/force-download' );
            header( 'Content-Length: '.strlen( $options_array ) );
            header( 'Content-Disposition: attachment; filename="' . $file_name . date( 'm-d-Y h:i:s a', time() ).'.json"' );
            die( $options_array );

        }

    }


    /**
     * Adds Custom CSS For BetterFramework Admin Panel
     *
     * @param $fields
     * @return array
     */
    function panel_custom_css( $fields ){

        $fields[] = array(
            'value' => "%%color-2%%",
            array(
                'selector'  => array(
                    '#bf-panel .bf-footer',
                    '.bf-header',
                    '#bf-nav>ul>li a',
                ),
                'prop'      => 'background-color',
            )
        );

        $fields[] = array(
            'value' => "%%color-3%%",
            array(
                'selector'  => array(
                    '#bf-panel .bf-footer .reset-sec',
                    '.bf-header .logo-sec',
                    '#bf-nav>ul>li a.active_tab',
                    '#bf-nav>ul>li a:hover',
                    '.bf-section-container.bf-admin-panel .bf-section:hover .bf-heading h3:before',
                    '.bf-section:hover .bf-heading h3:before',
                    '.bf-section-container .ui-slider .ui-slider-range',
                ),
                'prop'      => 'background-color' ,
            )
        );

        $fields[] = array(
            'value' => "%%color-3-60%%",
            array(
                'selector'  => array(
                    '.bf-section-container .ui-slider .ui-slider-range:after',
                ),
                'prop'      => 'background-color' ,
            )
        );


        $fields[] = array(
            'value' => "%%color-3%%",
            array(
                'selector'  => array(
                    '.bf-section-container .bf-select-icon .select-options .better-select-icon-options ul.options-list li.selected',
                ),
                'prop'      => array(
                    'background-color',
                    'border-color',
                ) ,
            )
        );

        $fields[] = array(
            'value' => "%%color-3%%",
            array(
                'selector'  => array(
                    '.bf-section-container .bf-select-icon .select-options .better-icons-category-list li.selected a',
                    '.bf-section-container .bf-select-icon .select-options .selected-option .fa',
                    '.bf-select-icon .select-options .better-select-icon-options ul.options-list li .fa',
                ),
                'prop'      => array(
                    'color',
                ) ,
            )
        );


        $fields[] = array(
            'value' => "%%color-1%%",
            array(
                'selector'  => array(
                    '#bf-main',
                ),
                'prop'      => 'background-color' ,
            )
        );

        $fields[] = array(
            'value' => "%%color-3%%",
            array(
                'selector'  => array(
                    '.bf-section-container .better-select-image.opened .select-options .better-select-image-options ul li.selected',
                    '.bf-section-container .bf-image-radio-option.checked img',
                ),
                'prop'      => 'border-color' ,
            )
        );
        $fields[] = array(
            'value' => "%%color-3%%",
            array(
                'selector'  => array(
                    '.bf-section-container.bf-menus .bf-section-heading .bf-section-heading-title h3',
                    '.bf-section-container .bf-section-heading .bf-section-heading-title h3',
                ),
                'prop'      => 'border-bottom-color' ,
            )
        );

        $fields[] = array(
            'value' => "%%color-3%%",
            array(
                'selector'  => array(
                    '.bf-section-container .better-social-counter-sorter .bf-sorter-list li.active-item',
                ),
                'prop'      => 'border-color' ,
            )
        );

        $fields[] = array(
            'value' => "%%color-3+200%%",
            array(
                'selector'  => array(
                    '.bf-section-container .better-social-counter-sorter .bf-sorter-list li.active-item',
                ),
                'prop'      => 'background-color' ,
            )
        );

        $fields[] = array(
            'value' => "%%color-3%%",
            array(
                'selector'  => array(
                    '.bf-section-container .better-social-counter-sorter .bf-sorter-list li.active-item:after',
                    '.bf-section-container .better-social-counter-sorter .bf-sorter-list li.active-item',
                ),
                'prop'      => 'color' ,
            )
        );

        return $fields;
    }
}