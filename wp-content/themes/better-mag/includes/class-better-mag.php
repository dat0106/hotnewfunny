<?php

/**
 * BetterMag Theme
 */
class Better_Mag {

    /**
     * Inner array of objects live instances like generator
     *
     * @var array
     */
    protected static $instances = array();


    function __construct(){

        // Performs the Bf setup
        add_action( 'better-framework/after_setup', array( $this, 'theme_init' )  );

        // Clears BF caches
        add_action( 'after_switch_theme', array( $this, 'after_theme_switch' ) );
        add_action( 'switch_theme', array( $this, 'after_theme_switch' ) );

        // Remove pages from search result
        add_filter( 'pre_get_posts', array( $this, 'pre_get_posts') );

        // Fire ups gallery slider
        $this->gallery_slider();

    }


    /**
     * clears last BF caches for avoiding conflict
     */
    function after_theme_switch(){

        // Clears BF transients for preventing of happening any problem
        delete_transient( '__better_framework__widgets_css' );
        delete_transient( '__better_framework__panel_css' );
        delete_transient( '__better_framework__menu_css' );
        delete_transient( '__better_framework__terms_css' );
        delete_transient( '__better_framework__final_fe_css' );
        delete_transient( '__better_framework__final_fe_css_version' );
        delete_transient( '__better_framework__backend_css' );

        // Delete all pages css transients
        global $wpdb;
        $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE %s", '_bf_post_css_%' ) );

    }


    /**
     * Used for retrieving WooCommerce class of BetterMag
     *
     * @return BM_WooCommerce | false
     */
    public static function wooCommerce(){

        if( ! function_exists('is_woocommerce') ){
            return false;
        }

        if ( isset(self::$instances['woocommerce']) ) {
            return self::$instances['woocommerce'];
        }

        require_once BETTER_MAG_PATH . 'includes/class-bm-woocommerce.php';

        $generator = apply_filters( 'better-mag/woocommerce', 'BM_WooCommerce' );

        // if filtered class not exists or not 1 child of BM_WooCommerce class
        if( ! class_exists($generator) || ! is_subclass_of( $generator, 'BM_WooCommerce' ) )
            $generator = 'BM_WooCommerce';

        self::$instances['woocommerce'] = new $generator;
        return self::$instances['woocommerce'];

    }


    /**
     * Used for retrieving bbPress class of BetterMag
     *
     * @return BM_bbPress | false
     */
    public static function bbPress(){

        if( ! class_exists('bbpress') ){
            return false;
        }

        if ( isset(self::$instances['bbpress']) ) {
            return self::$instances['bbpress'];
        }

        require_once BETTER_MAG_PATH . 'includes/class-bm-bbpress.php';

        $generator = apply_filters( 'better-mag/bbpress', 'BM_bbPress' );

        // if filtered class not exists or not 1 child of BM_bbPress class
        if( ! class_exists($generator) || ! is_subclass_of( $generator, 'BM_bbPress' ) )
            $generator = 'BM_bbPress';

        self::$instances['bbpress'] = new $generator;
        return self::$instances['bbpress'];

    }


    /**
     * Used for retrieving generator of BetterMag
     *
     * @return BM_Block_Generator
     */
    public static function generator(){

        if ( isset(self::$instances['generator']) ) {
            return self::$instances['generator'];
        }

        $generator = apply_filters( 'better-mag/generator', 'BM_Block_Generator' );

        // if filtered class not exists or not 1 child of BM_Block_Generator class
        if( ! class_exists($generator) || ! is_subclass_of( $generator, 'BF_Block_Generator' ) )
            $generator = 'BM_Block_Generator';

        self::$instances['generator'] = new $generator;
        return self::$instances['generator'];

    }


    /**
     * Used for extending gallery slider
     *
     * @return Better_Gallery_Slider
     */
    public static function gallery_slider(){

        if ( isset(self::$instances['gallery-slider']) ) {
            return self::$instances['gallery-slider'];
        }

        require_once 'class-better-gallery-slider.php';

        $generator = 'Better_Gallery_Slider';

        self::$instances['gallery-slider'] = new $generator;
        return self::$instances['gallery-slider'];

    }


    /**
     * Used for retrieving post meta
     *
     * uses BM_Posts
     *
     * @param null $key
     * @param bool $default
     * @return string
     */
    public static function get_meta( $key = null, $default = true ){

        return apply_filters( 'better-mag/meta/' . $key, self::posts()->get_meta( $key, get_the_ID(), $default ) );

    }


    /**
     * Used for printing post meta
     *
     * uses BM_Posts
     *
     * @param null $key
     * @param bool $default
     * @return string
     */
    public static function echo_meta( $key = null, $default = true ){

        return apply_filters( 'better-mag/meta/' . $key, self::posts()->get_meta( $key, get_the_ID(), $default ) );

    }


    /**
     * Used for retrieving options simply and safely for next versions
     *
     * @param $option_key
     * @return mixed|null
     */
    public static function get_option( $option_key ){

        return Better_Framework::options()->get( $option_key, '__better_mag__theme_options' );

    }


    /**
     * Used for printing options simply and safely for next versions
     *
     * @param $option_key
     * @return mixed|null
     */
    public static function echo_option( $option_key ){

        echo Better_Framework::options()->get( $option_key, '__better_mag__theme_options' );

    }


    /**
     * Used for handling functionality related to posts and pages
     *
     * @return  BM_Posts
     */
    public static function posts(){

        if ( isset(self::$instances['bm-posts']) ) {
            return self::$instances['bm-posts'];
        }

        $bm_posts = apply_filters( 'better-mag/posts', 'BM_Posts' );

        // if filtered class not exists or not 1 child of BM_Posts class
        if( ! class_exists($bm_posts) || ! is_subclass_of( $bm_posts, 'BM_Posts' ) )
            $bm_posts = 'BM_Posts';

        self::$instances['bm-posts'] = new $bm_posts;
        return self::$instances['bm-posts'];

    }


    /**
     * Used for handling functionality related to posts and pages
     *
     * @return  BetterStudio_Review
     */
    public static function review(){

        if ( isset(self::$instances['review']) ) {
            return self::$instances['review'];
        }

        require_once BETTER_MAG_PATH . 'includes/libs/review/class-betterstudio-review.php';

        $review = apply_filters( 'better-mag/review', 'BetterStudio_Review' );

        // if filtered class not exists or not 1 child of BetterStudio_Review class
        if( ! class_exists( $review ) || ! is_subclass_of( $review, 'BetterStudio_Review' ) )
            $review = 'BetterStudio_Review';

        self::$instances['review'] = new $review;
        return self::$instances['review'];

    }


    /**
     * Setup and recommend plugins
     */
    public function setup_plugins(){

        require_once BETTER_MAG_PATH . '/includes/libs/class-tgm-plugin-activation.php';

        $plugins = array(

            // http://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=Better-Studio
            array(
                'name'                  => 'WPBakery Visual Composer',
                'slug'                  => 'js_composer',
                'source'                => get_template_directory_uri() . '/includes/libs/plugins/js_composer.zip',
                'required'              => true,
                'version'               => '4.3.4'
            ),

            // http://codecanyon.net/item/better-weather-wordpress-and-visual-composer-widget/7724257?ref=Better-Studio
            array(
                'name'               => 'BetterWeather - Better Weather Widget!',
                'slug'               => 'better-weather',
                'source'             => get_template_directory_uri() . '/includes/libs/plugins/better-weather.zip',
                'required'           => false,
                'version'               => '1.5.0.1'
            ),

            array(
                'name'               => 'BetterStudio Shortcodes',
                'slug'               => 'betterstudio-shortcodes',
                'source'             => get_template_directory_uri() . '/includes/libs/plugins/betterstudio-shortcodes.zip',
                'required'           => false,
                'version'               => '1.0.1'
            ),

            array(
                'name'               => 'Better Social Counter Widget',
                'slug'               => 'better-social-counter',
                'source'             => get_template_directory_uri() . '/includes/libs/plugins/better-social-counter.zip',
                'required'           => false,
                'version'               => '1.0.1'
            ),

            array(
                'name'               => 'Better News Ticker Widget',
                'slug'               => 'better-news-ticker',
                'source'             => get_template_directory_uri() . '/includes/libs/plugins/better-news-ticker.zip',
                'required'           => false,
                'version'               => '1.0.1'
            ),


            // https://wordpress.org/plugins/custom-sidebars/changelog/
            array(
                'name' => 'Custom sidebars',
                'slug' => 'custom-sidebars',
                'required' => false,
                'version'               => '2.1.0.0'
            ),

            // https://wordpress.org/plugins/wp-retina-2x/changelog/
            array(
                'name' => 'WP Retina 2x',
                'slug' => 'wp-retina-2x',
                'required' => false,
                'version'               => '2.2.0'
            ),

            // https://wordpress.org/plugins/contact-form-7/changelog/
            array(
                'name'   => 'Contact Form 7',
                'slug'   => 'contact-form-7',
                'required' => false,
                'version'               => '4.0.2'
            ),

            // https://wordpress.org/plugins/ajax-thumbnail-rebuild/changelog/
            array(
                'name'   => 'AJAX Thumbnail Rebuild',
                'slug'   => 'ajax-thumbnail-rebuild',
                'required' => false,
                'version'               => '1.12'
            ),


        );

        $config = array(
            'is_automatic' => true,
        );

        tgmpa( $plugins, $config );

        if( function_exists('vc_set_as_theme') ) vc_set_as_theme();
    }


    function theme_init() {

        // Setup plugins before WP and BF init
        $this->setup_plugins();

        // Include Helper
        require_once BETTER_MAG_PATH . 'includes/class-bm-helper.php';

        // include main generator file
        require_once BETTER_MAG_PATH . 'includes/class-bm-block-generator.php';
        require_once BETTER_MAG_PATH . 'includes/class-bm-blocks.php';

        // Include functionality for posts
        require_once BETTER_MAG_PATH . 'includes/class-bm-posts.php';

        // Init WooCommerce Support
        self::wooCommerce();

        // Init bbPress Support
        self::bbPress();

        // Init Review
        self::review();

        /*
		 * Enqueue assets (css, js)
		 */
        add_action( 'wp_enqueue_scripts', array($this, 'register_assets') );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

        /*
		 * Featured images settings
		 */
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 90, 60, array( 'center', 'center' ));                      // Image Thumbnail Size

        add_image_size( 'bigger-thumbnail', 110,    80,     array( 'center', 'center' ) );  // Main Post Image In Full Width

        add_image_size( 'main-full',        1140,   530,    array( 'center', 'center' ) );  // Main Post Image In Full Width

        add_image_size( 'main-post',        750,    350,    array( 'center', 'center' ) );  // Post Image In Normal ( With Sidebar )
        add_image_size( 'main-block',       360,    200,    array( 'center', 'center' ) );  // Main Post Image For Block Listings

        add_image_size( 'slider-1',         360,    165,    array( 'center', 'center' ) );
        add_image_size( 'slider-2',         360,    195,    array( 'center', 'center' ) );
        add_image_size( 'slider-3',         165,    135,    array( 'center', 'center' ) );
        add_image_size( 'slider-4',         263,    350,    array( 'center', 'center' ) );
        add_image_size( 'slider-5',         555,    350,    array( 'center', 'center' ) );
        add_image_size( 'slider-6',         1140,   350,    array( 'center', 'center' ) );

        add_image_size( 'bgs-375',          0,      375,    true                        );



        /*
         * Post formats
         */
        add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio' ) );

        /*
         * This feature enables post and comment RSS feed links to head.
         */
        add_theme_support( 'automatic-feed-links' );

        /*
         * i18n
         */
        load_theme_textdomain( 'better-studio', get_template_directory() . '/languages' );

        /*
         * Register menus
         */
        register_nav_menu( 'main-menu', __( 'Main Navigation', 'better-studio' ) );


        // in 3.5 content_width removed, add it for oebmed
        global $content_width;

        if ( ! isset( $content_width ) )
            $content_width = 1170;

        // Add Ability to setting short code in text widget
        add_filter('widget_text', 'do_shortcode');

        // Implements editor styling
        add_editor_style();

        // Add filters to generating custom menus
        add_filter( 'better-framework/menu/mega/end_lvl', array($this, 'generate_better_menu'));

        // enqueue in header
        add_action( 'wp_head', array( $this, 'wp_head' ));

        // enqueue in footer
        add_action( 'wp_footer', array( $this, 'wp_footer' ));

        // add custom classes to body
        add_filter( 'body_class' , array( $this, 'filter_body_class' ) );

        // Enqueue admin scripts
        add_action( 'admin_enqueue_scripts', array( $this , 'admin_enqueue' ) );

        // Used for adding orderby rand to WP_User_Query
        add_action( 'pre_user_query', array( $this , 'action_pre_user_query' ) );

        /*
         * Register Sidebars
         */
        $this->register_sidebars();


    }


    /**
     * Enqueue css and js files
     *
     * Action Callback: wp_enqueue_scripts
     *
     */
    function register_assets(){

        // jquery and bootstrap
        wp_enqueue_script( 'better-mag-libs', get_template_directory_uri() . '/js/better-mag-libs.min.js', array( 'jquery' ), Better_Framework::theme()->get( 'Version' ), true );

        // Element Query
        Better_Framework::assets_manager()->enqueue_script( 'element-query' );

        // PrettyPhoto
        if( Better_Mag::get_option( 'lightbox_is_enable' ) ){
            Better_Framework::assets_manager()->enqueue_script( 'pretty-photo' );
            Better_Framework::assets_manager()->enqueue_style( 'pretty-photo' );
        }

        // BetterMag core scripts
        wp_enqueue_script( 'better-mag', get_template_directory_uri() . '/js/better-mag.js', array( 'jquery' ), Better_Framework::theme()->get( 'Version' ), true );

        wp_localize_script(
            'better-mag',
            'better_mag_vars',
            apply_filters(
                'better-mag/js/global-vars',
                array(
                    'text_navigation'       =>  __( 'Navigation', 'better-studio' ),
                )
            )
        );

        // Bootstrap style
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' , array(), Better_Framework::theme()->get( 'Version' ) );

        // Fontawesome
        Better_Framework::assets_manager()->enqueue_style( 'fontawesome' );

        // If a child theme is active, add the parent theme's style. this is good for performance and cache.
        if( is_child_theme() ){
            wp_enqueue_style( 'better-mag', trailingslashit( get_template_directory_uri() ) . 'style.css', array(), Better_Framework::theme()->get( 'Version' ) );
            // adds child theme version to the end of url of child theme style file
            wp_enqueue_style( 'better-mag-child', get_stylesheet_uri(), array(), Better_Framework::theme( false, true, false )->get('Version') );
        }
        // BetterMage core style
        else{
            wp_enqueue_style( 'better-mag', get_stylesheet_uri(), array(), Better_Framework::theme()->get('Version') );
        }

        if( is_rtl() ){
            wp_enqueue_style( 'better-mag-rtl', get_template_directory_uri()  . '/css/rtl.css', array( 'better-mag' ), Better_Framework::theme()->get( 'Version' ) );
        }

        // BetterMag Skins
        if( ( $style = get_option( '__better_mag__theme_options_current_style' ) ) != 'default' ){
            wp_enqueue_style( 'better-mag-style-' . $style, get_template_directory_uri() . '/css/style-' . $style . '.css', array( 'better-mag' ), Better_Framework::theme()->get( 'Version' ) );
        }

        if( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
            wp_enqueue_script( 'comment-reply' );
        }

    }


    /**
     * Registers dynamic sidebars
     */
    function register_sidebars(){

        register_sidebar( array(
            'name'          =>  __( 'Main Sidebar', 'better-studio' ),
            'id'            =>  'primary-sidebar',
            'description'   =>  __( 'Widgets in this area will be shown in the default sidebar.', 'better-studio' ),
            'before_title'  =>  '<h4 class="section-heading"><span class="h-title">',
            'after_title'   =>  '</span></h4>',
            'before_widget' =>  '<div id="%1$s" class="primary-sidebar-widget widget %2$s">',
            'after_widget'  =>  '</div>'
        ) );

        register_sidebar( array(
            'name'          =>  __( 'Aside Logo', 'better-studio' ),
            'id'            =>  'aside-logo',
            'description'   =>  __( ' Widgets in this area will shown in logo aside. Please place only one line widgets.', 'better-studio'),
            'before_title'  =>  '',
            'after_title'   =>  '',
            'before_widget' =>  '<div  id="%1$s" class="aside-logo-widget widget %2$s">',
            'after_widget'  =>  '</div>'
        ) );

        register_sidebar( array(
            'name'          =>  __( 'Top Bar - Left Column', 'better-studio' ),
            'id'            =>  'top-bar-left',
            'description'   =>  __('Please place only one line widgets.', 'better-studio'),
            'before_title'  =>  '',
            'after_title'   =>  '',
            'before_widget' =>  '<div  id="%1$s" class="top-bar-widget widget %2$s">',
            'after_widget'  =>  '</div>'
        ) );

        register_sidebar( array(
            'name'          =>  __('Top Bar - Right Column', 'better-studio'),
            'id'            =>  'top-bar-right',
            'description'   =>  __('Please place only one line widgets.', 'better-studio'),
            'before_title'  =>  '',
            'after_title'   =>  '',
            'before_widget' =>  '<div  id="%1$s" class="top-bar-widget widget %2$s">',
            'after_widget'  =>  '</div>'
        ));


        // Footer Larger Sidebars
        if( Better_Mag::get_option( 'footer_large_active' ) ){
            register_sidebar( array(
                'name'          =>  __( 'Larger Footer - Column 1', 'better-studio'),
                'id'            =>  'footer-column-1',
                'description'   =>   __( 'Widgets in this area will be shown in the footer larger column 1.', 'better-studio' ),
                'before_title'  =>  '<h4 class="section-heading"><span class="h-title">',
                'after_title'   =>  '</span></h4>',
                'before_widget' =>  '<div id="%1$s" class="footer-larger-widget larger-column-1 widget %2$s">',
                'after_widget'  =>  '</div>'
            ));

            register_sidebar( array(
                'name'          =>  __( 'Larger Footer - Column 2', 'better-studio'),
                'id'            =>  'footer-column-2',
                'description'   =>   __( 'Widgets in this area will be shown in the footer larger column 2.', 'better-studio' ),
                'before_title'  =>  '<h4 class="section-heading"><span class="h-title">',
                'after_title'   =>  '</span></h4>',
                'before_widget' =>  '<div id="%1$s" class="footer-larger-widget larger-column-2 widget %2$s">',
                'after_widget'  =>  '</div>'
            ));

            if( Better_Mag::get_option( 'footer_large_columns' ) >= 3 ){

                register_sidebar( array(
                    'name'          =>  __( 'Larger Footer - Column 3', 'better-studio'),
                    'id'            =>  'footer-column-3',
                    'description'   =>   __( 'Widgets in this area will be shown in the footer larger column 3.', 'better-studio' ),
                    'before_title'  =>  '<h4 class="section-heading"><span class="h-title">',
                    'after_title'   =>  '</span></h4>',
                    'before_widget' =>  '<div id="%1$s" class="footer-larger-widget larger-column-3 widget %2$s">',
                    'after_widget'  =>  '</div>'
                ));

            }
            if( Better_Mag::get_option( 'footer_large_columns' ) == 4 ){

                register_sidebar( array(
                    'name'          =>  __( 'Larger Footer - Column 4', 'better-studio'),
                    'id'            =>  'footer-column-4',
                    'description'   =>   __( 'Widgets in this area will be shown in the footer larger column 4.', 'better-studio' ),
                    'before_title'  =>  '<h4 class="section-heading"><span class="h-title">',
                    'after_title'   =>  '</span></h4>',
                    'before_widget' =>  '<div id="%1$s" class="footer-larger-widget larger-column-4 widget %2$s">',
                    'after_widget'  =>  '</div>'
                ) );

            }
        }


        // Footer Lower Sidebars
        if( Better_Mag::get_option( 'footer_lower_active' ) ){
            register_sidebar( array(
                'name'          =>  __( 'Lower Footer - Left Column', 'better-studio'),
                'id'            =>  'footer-lower-left-column',
                'description'   =>  __('Please place only one line widgets.', 'better-studio'),
                'before_title'  =>  '',
                'after_title'   =>  '',
                'before_widget' =>  '<div id="%1$s" class="footer-lower-widget lower-left-column widget %2$s">',
                'after_widget'  =>  '</div>'
            ) );

            register_sidebar( array(
                'name'          =>  __( 'Lower Footer - Right Column', 'better-studio'),
                'id'            =>  'footer-lower-right-column',
                'description'   =>  __('Please place only one line widgets.', 'better-studio'),
                'before_title'  =>  '',
                'after_title'   =>  '',
                'before_widget' =>  '<div id="%1$s" class="footer-lower-widget lower-right-column widget %2$s">',
                'after_widget'  =>  '</div>'
            ) );
        }

        // WooCommerce Sidebar
//        if( function_exists( 'is_woocommerce' ) ){
//            register_sidebar( array(
//                'name'          =>  __( 'WooCommerce Shop Sidebar', 'better-studio'),
//                'id'            =>  'woocommerce-sidebar',
//                'before_title'  =>  '<h4 class="section-heading"><span class="h-title">',
//                'after_title'   =>  '</span></h4>',
//                'before_widget' =>  '<div id="%1$s" class="primary-sidebar-widget widget %2$s">',
//                'after_widget'  =>  '</div>'
//            ) );
//
//        }

    }


    /**
     *  Enqueue anything in header
     */
    function wp_head(){

        // Favicon
        if( Better_Mag::get_option( 'favicon_16_16' ) != '' ) { ?><link rel="shortcut icon" href="<?php echo esc_url( Better_Mag::get_option( 'favicon_16_16' ) ); ?>"><?php }

        if( Better_Mag::get_option( 'favicon_57_57' ) != '' ) { ?><link rel="apple-touch-icon" href="<?php echo esc_url( Better_Mag::get_option( 'favicon_57_57' ) ); ?>"><?php }

        if( Better_Mag::get_option( 'favicon_114_114' ) != '' ) { ?><link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url( Better_Mag::get_option( 'favicon_114_114' ) ); ?>"><?php }

        if( Better_Mag::get_option( 'favicon_72_72' ) != '' ) { ?><link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url( Better_Mag::get_option( 'favicon_72_72' ) ); ?>"><?php }

        if( Better_Mag::get_option( 'favicon_144_144' ) != '' ) { ?><link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url( Better_Mag::get_option( 'favicon_144_144' ) ); ?>"><?php }

        // Header HTML Code
        echo Better_Mag::get_option( 'custom_header_code' );

        // Custom CSS Code
        echo '<style class="theme-panel-custom-css">' . Better_Mag::get_option( 'custom_css_code' ) . '</style>';

    }


    /**
     * Enqueue anything in footer
     *
     * Action Callback
     */
    function wp_footer(){

        // Footer HTML Code
        echo Better_Mag::get_option( 'custom_footer_code' );
    }


    /**
     *  Enqueue admin scripts
     */
    function admin_enqueue(){

        wp_enqueue_style( 'better-mag-admin', BETTER_MAG_ADMIN_ASSETS_URI .'css/admin-style.css', array(), Better_Framework::theme()->get( 'Version' ) );

    }


    /**
     * Customize body classes
     *
     * @param $classes
     * @return array
     */
    function filter_body_class( $classes ){

        $_default_layout = '';

        // Add scroll animation class if is enabled
        if( Better_Mag::get_option( 'animation_scroll' ) ){
            $classes[] = 'animation_scroll';
        }

        // Add image zoom animation class if is enabled
        if( Better_Mag::get_option( 'animation_image_zoom' ) ){
            $classes[] = 'animation_image_zoom';
        }

        // Adds enabled_back_to_top class for animation and style of bac to top button
        if( Better_Mag::get_option( 'back_to_top' ) ){
            $classes[] = 'enabled_back_to_top';
        }

        // Activates lighbox
        if( Better_Mag::get_option( 'lightbox_is_enable' ) ){
            $classes[] = 'active-lighbox';
        }

        // Pages and singles layout style
        if( is_singular() || is_page() ){

            // Force Gallery Post Format With BG Slide Show as Boxed
            if( get_post_format() == 'gallery' && Better_Mag::posts()->get_meta( 'gallery_images_bg_slides' ) ){
                $_default_layout = 'boxed-padded';
            }else{
                $_default_layout = get_post_meta( get_the_ID(), '_layout_style', true ) ;
            }

        }

        // Categories layout style
        elseif( is_category() ){

            $_default_layout = Better_Framework::taxonomy_meta()->get_term_meta( get_query_var('cat'), 'layout_style' );

        }

        // Tags layout style
        elseif( is_tag() ){

            $current_term = get_term_by( 'slug', get_query_var('tag'), 'post_tag' );

            $_default_layout = Better_Framework::taxonomy_meta()->get_term_meta( $current_term->term_id, 'layout_style' );

        }

        // Other Pages layout style
        if( empty( $_default_layout ) || $_default_layout == false || $_default_layout == 'default' ){

            $_default_layout = Better_Mag::get_option( 'layout_style' );

        }

        switch( $_default_layout ){

            case 'boxed':
                $classes[] = 'boxed';
                return $classes;
                break;

            case 'boxed-padded':
                $classes[] = 'boxed';
                $classes[] = 'boxed-padded';
                return $classes;
                break;

            case 'full-width':
                return $classes;
                break;

        }
    }


    /**
     * Generate Custom Mega Menu HTML
     *
     * @param array $args
     * @return string
     */
    public function generate_better_menu( $args ){

        // Extract arguments that passed from walker
        extract($args);

        switch( $item->mega_menu ){

            // Category Mega Menu
            case 'category-right':

                Better_Mag::generator()->set_attr( 'mega-menu-sub-menu', $sub_menu );
                Better_Mag::generator()->set_attr( 'mega-menu-item', $item );
                return Better_Mag::generator()->blocks()->mega_menu_category_right( false );

                break;

            case 'category-left':

                Better_Mag::generator()->set_attr( 'mega-menu-sub-menu', $sub_menu );
                Better_Mag::generator()->set_attr( 'mega-menu-item', $item );
                return Better_Mag::generator()->blocks()->mega_menu_category_left( false );

                break;

            case 'category-simple-right':

                Better_Mag::generator()->set_attr( 'mega-menu-sub-menu', $sub_menu );
                Better_Mag::generator()->set_attr( 'mega-menu-item', $item );
                return Better_Mag::generator()->blocks()->mega_menu_simple_right( false );

                break;

            case 'category-simple-left':

                Better_Mag::generator()->set_attr( 'mega-menu-sub-menu', $sub_menu );
                Better_Mag::generator()->set_attr( 'mega-menu-item', $item );
                return Better_Mag::generator()->blocks()->mega_menu_simple_left( false );

                break;


            case 'category-recent-left':

                Better_Mag::generator()->set_attr( 'mega-menu-sub-menu', $sub_menu );
                Better_Mag::generator()->set_attr( 'mega-menu-item', $item );
                return Better_Mag::generator()->blocks()->mega_menu_category_recent_left( false );

                break;


            case 'category-recent-right':

                Better_Mag::generator()->set_attr( 'mega-menu-sub-menu', $sub_menu );
                Better_Mag::generator()->set_attr( 'mega-menu-item', $item );
                return Better_Mag::generator()->blocks()->mega_menu_category_recent_right( false );

                break;

            case 'link-3-column':
            case 'link':
            case 'link-4-column':

                Better_Mag::generator()->set_attr( 'mega-menu-sub-menu', $sub_menu );

                if( $item->mega_menu == 'link'){
                    Better_Mag::generator()->set_attr( 'mega-menu-columns', 'link-2-column' );
                }else{
                    Better_Mag::generator()->set_attr( 'mega-menu-columns', $item->mega_menu );
                }

                return Better_Mag::generator()->blocks()->mega_menu_link( false );


                break;

        }

        return $sub_menu;
    }



    /**
     * Include Main Sidebar
     *
     * @see get_sidebar()
     */
    public static function get_sidebar( $sidebar = '' ){

        if( self::current_sidebar_layout() )
            get_sidebar( $sidebar );

    }


    /**
     * Return Sidebar Layout of Current Page if Any Sidebar Defined
     *
     * TODO: !!! add category support to sidebar layout
     */
    public static function current_sidebar_layout(){

        // From cached before
        if( isset( self::$instances['current_sidebar_layout'] ) && ! empty( self::$instances['current_sidebar_layout'] ) ){
            return  self::$instances['current_sidebar_layout'];
        }

        // Post and Page Sidebar
        if( is_singular() || is_page() ){

            // custom field values saved before
            if( false != ( $_default_layout = get_post_meta( get_the_ID(), '_default_sidebar_layout', true ) )){

                switch( $_default_layout ){

                    // Default settings from theme options
                    case 'default':
                        if( Better_Mag::get_option( 'default_sidebar_layout' ) == 'no-sidebar' ){
                            self::$instances['current_sidebar_layout'] = false;
                            return false;
                        }
                        else{
                            self::$instances['current_sidebar_layout'] = Better_Mag::get_option( 'default_sidebar_layout' );
                            return self::$instances['current_sidebar_layout'];
                        }

                        break;

                    // No Sidebar
                    case 'no-sidebar':
                        self::$instances['current_sidebar_layout'] = false;
                        return false;

                        break;

                    // Right And Left Side Sidebars
                    default:
                        self::$instances['current_sidebar_layout'] = $_default_layout;
                        return $_default_layout;

                }

            }

        }
        elseif( is_category() ){

            // custom field values saved before
            if( false != ( $_default_layout =Better_Framework::taxonomy_meta()->get_term_meta( get_query_var('cat'), 'sidebar_layout', 'default' ) ) ){

                switch( $_default_layout ){

                    // Default settings from theme options
                    case 'default':
                        if( Better_Mag::get_option( 'default_sidebar_layout' ) == 'no-sidebar' ){
                            self::$instances['current_sidebar_layout'] = false;
                            return false;
                        }
                        else{
                            self::$instances['current_sidebar_layout'] = Better_Mag::get_option( 'default_sidebar_layout' );
                            return self::$instances['current_sidebar_layout'];
                        }

                        break;

                    // No Sidebar
                    case 'no-sidebar':
                        self::$instances['current_sidebar_layout'] = false;
                        return false;

                        break;

                    // Right And Left Side Sidebars
                    default:
                        self::$instances['current_sidebar_layout'] = $_default_layout;
                        return $_default_layout;

                }

            }

        }

        if( Better_Mag::get_option( 'default_sidebar_layout' ) == 'no-sidebar' ){
            self::$instances['current_sidebar_layout'] = false;
            return false;
        }
        else{
            self::$instances['current_sidebar_layout'] = Better_Mag::get_option( 'default_sidebar_layout' );
            return self::$instances['current_sidebar_layout'];
        }

    }


    /**
     * Used for finding the content listing style of archive pages
     *
     * @return string
     */
    public static function get_page_listing_template(){

        // Category Page Listing Type
        if( is_category() ){

            // Retrieve from each category not general option
            if( Better_Framework::taxonomy_meta()->get_term_meta( get_query_var('cat'), 'listing_style', 'default' ) != 'default' ){

                if( Better_Framework::taxonomy_meta()->get_term_meta( get_query_var('cat'), 'listing_style', 'blog' ) == 'blog' )
                    return 'loop';
                else
                    return 'loop-' . Better_Framework::taxonomy_meta()->get_term_meta( get_query_var('cat'), 'listing_style', 'blog' );

            }
            // General options that specified for categories
            elseif( Better_Mag::get_option( 'categories_listing_style' ) == 'blog' ){
                return 'loop';
            }else{
                return 'loop-' . Better_Mag::get_option( 'categories_listing_style' );
            }

        }

        // Tag Page Listing Type
        elseif( is_tag() ){

            $current_term = get_term_by( 'slug', get_query_var('tag'), 'post_tag' );
            // Retrieve from each tag not general option
            if( Better_Framework::taxonomy_meta()->get_term_meta( $current_term->term_id, 'listing_style', 'default' ) != 'default' ){

                if( Better_Framework::taxonomy_meta()->get_term_meta( $current_term->term_id, 'listing_style', 'blog' ) == 'blog' )
                    return 'loop';
                else
                    return 'loop-' . Better_Framework::taxonomy_meta()->get_term_meta( $current_term->term_id, 'listing_style', 'blog' );

            }
            // General options that specified for tags
            elseif( Better_Mag::get_option( 'tags_listing_style' ) == 'blog' ){
                return 'loop';
            }else{
                return 'loop-' . Better_Mag::get_option( 'tags_listing_style' );
            }

        }

        // Authors Page Listing Type
        elseif( is_author() ){
            if( Better_Mag::get_option( 'authors_listing_style' ) == 'blog' ){
                return 'loop';
            }else{
                return 'loop-' . Better_Mag::get_option( 'authors_listing_style' );
            }
        }

        // Other Pages Like Front Simple Page, Search, Date...
        else{
            if( Better_Mag::get_option( 'archive_listing_style' ) == 'blog' ){
                return 'loop';
            }else{
                return 'loop-' . Better_Mag::get_option( 'archive_listing_style' );
            }
        }

    }


    /**
     * Adds random order by feature to WP_User_Query
     *
     * Action: pre_user_query
     *
     * @param $class
     * @return mixed
     */
    public function action_pre_user_query( $class ){

        if( 'rand' == $class->query_vars['orderby'] )
            $class->query_orderby = str_replace( 'user_login', 'RAND()', $class->query_orderby );

        return $class;

    }


    /**
     * callback for pre_get_posts action
     *
     * @param $query
     */
    public function pre_get_posts( $query ){

        // Limits search result to only posts
        if( $query->is_search ) {
            $query->set( 'post_type', 'post' );
        }

    }



    /**
     * Resets typography options to default
     *
     * Callback
     *
     * @return array
     */
    public static function reset_typography_options(){

        $theme_options = get_option( '__better_mag__theme_options' );

        $fields = Better_Framework::options()->options['__better_mag__theme_options']['fields'];

        $std_id = Better_Framework::options()->get_std_field_id( '__better_mag__theme_options' );

        if( isset( $fields['typo_body'][$std_id] ) ){
            $theme_options['typo_body'] = $fields['typo_body'][$std_id] ;
        }else{
            $theme_options['typo_body'] = $fields['typo_body']['std'] ;
        }

        if( isset( $fields['typo_heading'][$std_id] ) ){
            $theme_options['typo_heading'] = $fields['typo_heading'][$std_id] ;
        }else{
            $theme_options['typo_heading'] = $fields['typo_heading']['std'] ;
        }

        if( isset( $fields['typo_heading_page'][$std_id] ) ){
            $theme_options['typo_heading_page'] = $fields['typo_heading_page'][$std_id] ;
        }else{
            $theme_options['typo_heading_page'] = $fields['typo_heading_page']['std'] ;
        }

        if( isset( $fields['typo_heading_section'][$std_id] ) ){
            $theme_options['typo_heading_section'] = $fields['typo_heading_section'][$std_id] ;
        }else{
            $theme_options['typo_heading_section'] = $fields['typo_heading_section']['std'] ;
        }

        if( isset( $fields['typo_meta'][$std_id] ) ){
            $theme_options['typo_meta'] = $fields['typo_meta'][$std_id] ;
        }else{
            $theme_options['typo_meta'] = $fields['typo_meta']['std'] ;
        }

        if( isset( $fields['typo_excerpt'][$std_id] ) ){
            $theme_options['typo_excerpt'] = $fields['typo_excerpt'][$std_id] ;
        }else{
            $theme_options['typo_excerpt'] = $fields['typo_excerpt']['std'] ;
        }

        if( isset( $fields['typ_content_text'][$std_id] ) ){
            $theme_options['typ_content_text'] = $fields['typ_content_text'][$std_id] ;
        }else{
            $theme_options['typ_content_text'] = $fields['typ_content_text']['std'] ;
        }

        if( isset( $fields['typ_content_blockquote'][$std_id] ) ){
            $theme_options['typ_content_blockquote'] = $fields['typ_content_blockquote'][$std_id] ;
        }else{
            $theme_options['typ_content_blockquote'] = $fields['typ_content_blockquote']['std'] ;
        }

        if( isset( $fields['typ_header_menu'][$std_id] ) ){
            $theme_options['typ_header_menu'] = $fields['typ_header_menu'][$std_id] ;
        }else{
            $theme_options['typ_header_menu'] = $fields['typ_header_menu']['std'] ;
        }

        if( isset( $fields['typ_header_menu_badges'][$std_id] ) ){
            $theme_options['typ_header_menu_badges'] = $fields['typ_header_menu_badges'][$std_id] ;
        }else{
            $theme_options['typ_header_menu_badges'] = $fields['typ_header_menu_badges']['std'] ;
        }

        if( isset( $fields['typ_header_logo'][$std_id] ) ){
            $theme_options['typ_header_logo'] = $fields['typ_header_logo'][$std_id] ;
        }else{
            $theme_options['typ_header_logo'] = $fields['typ_header_logo']['std'] ;
        }

        if( isset( $fields['typ_header_site_desc'][$std_id] ) ){
            $theme_options['typ_header_site_desc'] = $fields['typ_header_site_desc'][$std_id] ;
        }else{
            $theme_options['typ_header_site_desc'] = $fields['typ_header_site_desc']['std'] ;
        }

        if( isset( $fields['typo_listing_blog_heading'][$std_id] ) ){
            $theme_options['typo_listing_blog_heading'] = $fields['typo_listing_blog_heading'][$std_id] ;
        }else{
            $theme_options['typo_listing_blog_heading'] = $fields['typo_listing_blog_heading']['std'] ;
        }

        if( isset( $fields['typo_listing_blog_meta'][$std_id] ) ){
            $theme_options['typo_listing_blog_meta'] = $fields['typo_listing_blog_meta'][$std_id] ;
        }else{
            $theme_options['typo_listing_blog_meta'] = $fields['typo_listing_blog_meta']['std'] ;
        }

        if( isset( $fields['typo_listing_blog_excerpt'][$std_id] ) ){
            $theme_options['typo_listing_blog_excerpt'] = $fields['typo_listing_blog_excerpt'][$std_id] ;
        }else{
            $theme_options['typo_listing_blog_excerpt'] = $fields['typo_listing_blog_excerpt']['std'] ;
        }

        if( isset( $fields['typo_listing_modern_heading'][$std_id] ) ){
            $theme_options['typo_listing_modern_heading'] = $fields['typo_listing_modern_heading'][$std_id] ;
        }else{
            $theme_options['typo_listing_modern_heading'] = $fields['typo_listing_modern_heading']['std'] ;
        }

        if( isset( $fields['typo_listing_modern_meta'][$std_id] ) ){
            $theme_options['typo_listing_modern_meta'] = $fields['typo_listing_modern_meta'][$std_id] ;
        }else{
            $theme_options['typo_listing_modern_meta'] = $fields['typo_listing_modern_meta']['std'] ;
        }

        if( isset( $fields['typo_listing_modern_excerpt'][$std_id] ) ){
            $theme_options['typo_listing_modern_excerpt'] = $fields['typo_listing_modern_excerpt'][$std_id] ;
        }else{
            $theme_options['typo_listing_modern_excerpt'] = $fields['typo_listing_modern_excerpt']['std'] ;
        }

        if( isset( $fields['typo_listing_highlight_heading'][$std_id] ) ){
            $theme_options['typo_listing_highlight_heading'] = $fields['typo_listing_highlight_heading'][$std_id] ;
        }else{
            $theme_options['typo_listing_highlight_heading'] = $fields['typo_listing_highlight_heading']['std'] ;
        }

        if( isset( $fields['typo_listing_highlight_meta'][$std_id] ) ){
            $theme_options['typo_listing_highlight_meta'] = $fields['typo_listing_highlight_meta'][$std_id] ;
        }else{
            $theme_options['typo_listing_highlight_meta'] = $fields['typo_listing_highlight_meta']['std'] ;
        }

        if( isset( $fields['typo_listing_thumbnail_heading'][$std_id] ) ){
            $theme_options['typo_listing_thumbnail_heading'] = $fields['typo_listing_thumbnail_heading'][$std_id] ;
        }else{
            $theme_options['typo_listing_thumbnail_heading'] = $fields['typo_listing_thumbnail_heading']['std'] ;
        }

        if( isset( $fields['typo_listing_thumbnail_meta'][$std_id] ) ){
            $theme_options['typo_listing_thumbnail_meta'] = $fields['typo_listing_thumbnail_meta'][$std_id] ;
        }else{
            $theme_options['typo_listing_thumbnail_meta'] = $fields['typo_listing_thumbnail_meta']['std'] ;
        }

        if( isset( $fields['typo_listing_simple_heading'][$std_id] ) ){
            $theme_options['typo_listing_simple_heading'] = $fields['typo_listing_simple_heading'][$std_id] ;
        }else{
            $theme_options['typo_listing_simple_heading'] = $fields['typo_listing_simple_heading']['std'] ;
        }

        update_option( '__better_mag__theme_options', $theme_options );

        delete_transient( '__better_framework__panel_css' );
        delete_transient( '__better_framework__final_fe_css' );
        delete_transient( '__better_framework__final_fe_css_version' );

        Better_Framework::admin_notices()->add_notice( array(
            'msg' => __( 'Typography options resets to default.', 'better-studio' )
        ) );

        return array(
            'status'  => 'succeed',
            'msg'	  => __( 'All Caches was cleaned.', 'better-studio' ),
            'refresh' => true
        );

    }

}