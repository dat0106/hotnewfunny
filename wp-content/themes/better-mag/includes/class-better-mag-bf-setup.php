<?php


/******* Table Of Content
 *
 * 1. => BetterFramework Features
 *
 * 2. => Widget Custom CSS
 *
 * 3. => Meta Box Options
 *      3.1. => General Post Options
 *      3.2. => Page Layout Style
 *      3.3. => WooCommerce Product Page Options
 *      3.4. => Pages Slider Options
 *
 * 4. => Taxonomy Options
 *      4.1. => Category Options
 *      4.2. => Tag Options
 *
 * 5. => Admin Panel
 *      5.1. => General Options
 *
 *      5.2. => Header Options
 *
 *      5.3. => Footer Options
 *
 *      5.4. => Content & Listing Options
 *
 *      5.5. => Typography Options
 *              5.5.1. => General Typography
 *              5.5.2. => Blog Listing Typography
 *              5.5.3. => Modern Listing Typography
 *              5.5.4. => Highlight Listing Typography
 *              5.5.5. => Thumbnail Listing Typography
 *              5.5.6. => Simple Listing Typography
 *              5.5.7. => Header Typography
 *              5.5.8. => Pages/Posts Content Typography
 *
 *      5.6. => Color Options
 *              5.6.1. => General Colors
 *              5.6.2. => Header
 *              5.6.3. => Main Navigation
 *              5.6.4. => Main Navigation - Drop Down Sub Menu
 *              5.6.5. => Main Navigation - Mega Menu
 *              5.6.6. => Breadcrumb
 *              5.6.7. => Slider
 *              5.6.8. => News Ticker
 *              5.6.9. => Page Title
 *              5.6.10. => Section/Listing Title
 *              5.6.11. => Sidebar Widget Title
 *              5.6.12. => Footer
 *              5.6.13. => Back to top
 *
 *      5.7. => Social Counter Options ( Removed -> Moved to Better Social Counter Plugin )
 *
 *      5.8. => WooCommerce Options
 *
 *      5.8. => Custom Javascript / CSS
 *
 *      5.10. => Import & Export
 *
 * 6. => Setup Shortcodes
 *      6.1. => BetterFramework Shortcodes
 *      6.2. => BetterMag Shortcodes
 *
 * 7. => Menu Options
 *
 * 8. => Breadcrumb
 *
 */


/**
 * Setup BetterFramework for BetterMag
 */
class Better_Mag_BF_Setup {

    function __construct(){

        define( 'BETTER_MAG_ADMIN_ASSETS_URI' , get_template_directory_uri() . '/includes/admin-assets/' );
        define( 'BETTER_MAG_PATH', get_template_directory().'/' );
        define( 'BETTER_MAG_URI', get_template_directory_uri().'/' );


        // Register included BF to loader ( After Plugins )
        add_filter( 'better-framework/loader', array( $this, 'register_better_framework' ), 100 );

        // Enable needed sections
        add_filter( 'better-framework/sections' , array( $this , 'setup_bf_features' ), 100 );

        // Admin panel options
        add_filter( 'better-framework/panel/options' , array( $this , 'setup_option_panel' ), 100 );

        // Meta box options
        add_filter( 'better-framework/metabox/options' , array( $this , 'setup_bf_metabox' ), 100 );

        // Taxonomy options
        add_filter( 'better-framework/taxonomy/options' , array( $this , 'taxonomy_options' ), 100 );

        // Menus options
        add_filter( 'better-framework/menu/options', array( $this, 'setup_custom_menu_fields' ), 100 );

        // Breadcrumb config
        add_filter( 'better-framework/breadcrumb/options', array( $this, 'bf_breadcrumb_options'), 100 );

        // Active and new shortcodes
        add_filter( 'better-framework/shortcodes', array( $this, 'setup_shortcodes' ), 100 );

        // Define special sidebars to BF
        add_filter( 'better-framework/sidebars/locations/top-bar' , array( $this , 'special_top_bar_sidebar_locations' ), 100 );
        add_filter( 'better-framework/sidebars/locations/footer-bar' , array( $this , 'special_footer_sidebar_locations' ), 100 );

        // Define general widget fields and values
        add_filter( 'better-framework/widgets/options/general' , array( $this , 'widgets_general_fields' ), 100 );
        add_filter( 'better-framework/widgets/options/general/heading_color/default' , array( $this , 'general_widget_heading_color_field_default' ), 100 );
        add_filter( 'better-framework/widgets/options/general/heading_bg/default' , array( $this , 'general_widget_heading_bg_field_default' ), 100 );

        // Define custom css for widgets
        add_filter( 'better-framework/css/widgets' , array( $this, 'widgets_custom_css' ), 100 );

        // Adds New User Fields
        add_filter( 'user_contactmethods', array( $this, 'add_user_meta' ) );

    }


    /**
     * Registers included version of BF to BF loader
     *
     * @param $frameworks
     * @return array
     */
    function register_better_framework( $frameworks ){

        $frameworks[] = array(
            'version'   =>  '1.3.2',
            'path'      =>  dirname( __FILE__ ) . '/libs/better-framework/',
            'uri'       =>  get_template_directory_uri() . '/includes/libs/better-framework/',
        );

        return $frameworks;
    }


    /**
     * Setups features of BetterFramework for BetterMag
     *
     * @param $features
     * @return array
     */
    function setup_bf_features($features){

        /**
         * 1. => BetterFramework Features
         */
        $features['admin_panel'] = true;
        $features['meta_box'] = true;
        $features['taxonomy_meta_box'] = true;
        $features['load_in_frontend'] = false;
        $features['chat_post_formatter'] = true;
        $features['better-menu'] = true;
        $features['vc-extender'] = true;
        $features['custom-css-pages'] = true;

        if( function_exists( 'is_woocommerce' ) ){
            $features['woocommerce'] = true;
        }

        if( class_exists( 'bbpress' ) ){
            $features['bbpress'] = true;
        }

        return $features;
    }


    /**
     * Filter BetterMag special top-bar sidebar locations for widgets
     */
    function special_top_bar_sidebar_locations( $locations ){

        $locations[] = 'top-bar-left';
        $locations[] = 'top-bar-right';
        $locations[] = 'aside-logo';

        return $locations;

    }

    /**
     * Filter BetterMag special top-bar sidebar locations for widgets
     */
    function special_footer_sidebar_locations( $locations ){

        $locations[] = 'footer-lower-left-column';
        $locations[] = 'footer-lower-right-column';

        return $locations;

    }


    /**
     * Filter BetterMag widgets general fields
     *
     * @param $fields
     * @return array
     */
    function widgets_general_fields( $fields ){

        $fields[] = 'heading_color';

        return $fields;

    }


    /**
     * Default value for widget title heading color
     *
     * @param $value
     * @return string
     */
    function general_widget_heading_color_field_default( $value ){

        return Better_Mag::get_option( 'color_widget_title_text_bg_color' );

    }


    /**
     * Widgets Custom css parameters
     *
     * @param $fields
     * @return array
     */
    function widgets_custom_css( $fields ){

        /**
         * 2. => Widget Custom CSS
         */

        switch( get_option( '__better_mag__theme_options_current_style' ) ){

            case "dark":
            case "full-dark":
            case "black":
            case "full-black":
            case "green":
            case "blue1":
                $fields[] = array(
                    'field' => 'heading_color',
                    array(
                        'selector'  => array(
                            '%%widget-id%% .section-heading'
                        ),
                        'prop'      => array(
                            'border-bottom-color' => '%%value%%'
                        ),
                    ),
                    array(
                        'selector'  => array(
                            '%%widget-id%% .section-heading .h-title',
                            '%%widget-id%%.footer-larger-widget .section-heading',
                        ),
                        'prop'      => array(
                            'background-color' => '%%value%%'
                        ),
                    ),
                    array(
                        'selector'  => '%%widget-id%% .section-heading' ,
                        'prop'      => array(
                            'background-color' => '%%value%%'
                        ),
                    )
                );
                break;

            case "clean-beige":
            case "clean":
                $fields[] = array(
                    'field' => 'heading_color',
                    array(
                        'selector'  => array(
                            '%%widget-id%% .section-heading'
                        ),
                        'prop'      => array(
                            'border-bottom-color'   =>  '%%value%%',
                            'border-top-color'      =>  '%%value%%',
                        ),
                    ),
                    array(
                        'selector'  =>  '%%widget-id%% .section-heading .h-title' ,
                        'prop'      =>  'color',
                    )

                );
                break;

            default:
                $fields[] = array(
                    'field' => 'heading_color',
                    array(
                        'selector'  => array(
                            '%%widget-id%% .section-heading'
                        ),
                        'prop'      => array(
                            'border-bottom-color' => '%%value%%'
                        ),
                    ),
                    array(
                        'selector'  => '%%widget-id%% .section-heading .h-title' ,
                        'prop'      => array(
                            'background-color' => '%%value%%'
                        ),
                    )

                );

        }

        return $fields;
    }


    /**
     * Setup custom metaboxes for BetterMag
     *
     * @param $options
     * @return array
     */
    function setup_bf_metabox( $options ){

        /**
         * 3. => Meta Box Options
         */

        /**
         * 3.1. => General Post Options
         */
        $options['general_post_metabox'] = array(
            'config' => array(
                'title'         =>  __( 'General Post Options', 'better-studio' ),
                'pages'         =>  array( 'post' ),
                'context'       =>  'normal',
                'prefix'        =>  false,
                'priority'      =>  'high'
            ),
            'panel-id'  => '__better_mag__theme_options',
            'fields' => array(

                '_bm_featured_post' => array(
                    'name'          =>  __( 'Is featured post!?', 'better-studio' ),
                    'id'            =>  '_bm_featured_post',
                    'std'           =>  '0' ,
                    'type'          =>  'switchery',
                ),

                '_bm_disable_post_featured' => array(
                    'name'          =>  __( 'Disable Featured Image/Video?', 'better-studio' ),
                    'id'            =>  '_bm_disable_post_featured',
                    'std'           =>  '0' ,
                    'type'          =>  'switchery',
                ),

                '_featured_video_code' => array(
                    'name'          =>  __( 'Featured Video Code', 'better-studio' ),
                    'id'            =>  '_featured_video_code',
                    'desc'          =>  __( 'Paste YouTube, Vimeo or self hosted video URL then player automatically will be generated.', 'better-studio' ),
                    'type'          =>  'textarea',
                    'std'           =>  '',
                    'post_format'   =>  array( 'video' )

                ),

                '_gallery_images_bg_slides' => array(
                    'name'          =>  __( 'Show Gallery Images as Background Slide Show!?', 'better-studio' ),
                    'id'            =>  '_gallery_images_bg_slides',
                    'desc'          =>  __( 'Enabling this will be shows images of first gallery in post as background slide show in post single page', 'better-studio' ),
                    'type'          =>  'switchery',
                    'std'           =>  '',
                    'post_format'   =>  array( 'gallery' )
                ),
            )
        );


        /**
         * 3.2. => Page Layout Style
         */
        $fields = array();

        $fields['_hide_page_title'] = array(
            'name'          =>  BF_Helper::get_current_post_type_admin() == 'post' ? __( 'Hide Post Title?', 'better-studio' ) : __( 'Hide Page Title?', 'better-studio' ),
            'id'            =>  '_hide_page_title',
            'type'          =>  'switchery',
            'std'           =>  '0'
        );

        if( BF_Helper::get_current_post_type_admin() == 'post' )
            $fields['_hide_post_meta'] = array(
                'name'          =>  __( 'Hide Post Meta?', 'better-studio' ),
                'id'            =>  '_hide_post_meta',
                'desc'          =>  __( 'Enabling this will hides post meta (date, author etc) in post single page.', 'better-studio' ),
                'type'          =>  'switchery',
                'std'           =>  '0'
            );

        $fields['_default_sidebar_layout'] = array(
            'name'          =>  BF_Helper::get_current_post_type_admin() == 'post' ? __( 'Post Sidebar Layout', 'better-studio' ) : __( 'Page Sidebar Layout', 'better-studio' ),
            'id'            =>  '_default_sidebar_layout',
            'std'           =>  'default',
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'desc'          =>  __( 'Select the sidebar layout for page. <br><br> <strong>Note:</strong> Default option image shows what style selected for default sidebar layout in theme options.', 'better-studio' ),
            'options'       =>  array(
                'default'   =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-' . Better_Mag::get_option( 'default_sidebar_layout' ) . '.png',
                    'label'     =>  __( 'Default', 'better-studio' ),
                ),
                'left'      =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-left.png',
                    'label'     =>  __( 'Left Sidebar', 'better-studio' ),
                ),
                'right'     =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-right.png',
                    'label'     =>  __( 'Right Sidebar', 'better-studio' ),
                ),
                'no-sidebar'=>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-no-sidebar.png',
                    'label'     =>  __( 'No Sidebar', 'better-studio' ),
                ),
            )
        );

        $fields['_layout_style'] = array(
            'name'          =>  __( 'Layout Style', 'better-studio' ),
            'id'            =>  '_layout_style',
            'std'           =>  'default',
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'desc'          =>  __( 'Select page layout style. <br><br> <strong>Note:</strong> Default option image shows default style that selected for page in theme options.', 'better-studio' ),
            'options'       =>  array(
                'default'   =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-' . Better_Mag::get_option( 'layout_style' ) .'.png',
                    'label'     =>  __( 'Default', 'better-studio' ),
                ),
                'full-width'=>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-full-width.png',
                    'label'     =>  __( 'Full Width', 'better-studio' ),
                ),
                'boxed'     =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-boxed.png',
                    'label'     =>  __( 'Boxed', 'better-studio' ),
                ),
                'boxed-padded'=> array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-boxed-padded.png',
                    'label'     =>  __( 'Boxed (Padded)', 'better-studio' ),
                ),
            )
        );

        $fields['_bg_color'] = array(
            'name'          =>  __( 'Page Background Color', 'better-studio' ),
            'id'            =>  '_bg_color',
            'type'          =>  'color',
            'std'           =>  Better_Mag::get_option( 'bg_color' ),
            'save-std'      =>  false,
            'desc'          =>  __( 'Setting a body background image below will override it.', 'better-studio' ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        'body',
                        'body.boxed',
                    ),
                    'prop'      => array(
                        'background-color' => '%%value%%'
                    )
                )
            ),
        );

        $fields['_bg_image'] = array(
            'name'          =>  __( 'Page Background Image', 'better-studio' ),
            'id'            =>  '_bg_image',
            'type'          =>  'background_image',
            'std'           =>  '',
            'save-std'      =>  false,
            'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
            'desc'          =>  __( 'Use light patterns in non-boxed layout. For patterns, use a repeating background. Use photo to fully cover the background with an image. Note that it will override the background color option.', 'better-studio' ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        'body'
                    ),
                    'prop'      => array( 'background-image' ),
                    'type'      => 'background-image'
                )
            ),
        );

        $fields['_header_bg_color'] = array(
            'name'          =>  __( 'Header Background Color', 'better-studio' ),
            'id'            =>  '_header_bg_color',
            'type'          =>  'color',
            'std'           =>  Better_Mag::get_option( 'header_bg_color' ),
            'save-std'      =>  false,
            'desc'          =>  __( 'Setting a header background pattern below will override it.','better-studio'),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        'body .header'
                    ),
                    'prop'      => array(
                        'background-color' => '%%value%%'
                    )
                )
            )
        );

        $fields['_header_bg_image'] = array(
            'name'          =>  __( 'Header Background Image', 'better-studio' ),
            'id'            =>  '_header_bg_image',
            'type'          =>  'background_image',
            'std'           =>  array( 'img' => '', 'type' => 'cover' ),
            'save-std'      =>  false,
            'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
            'desc'          =>  __( 'Please use a background pattern that can be repeated. Note that it will override the header background color option.','better-studio'),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        'body .header'
                    ),
                    'prop'      => array( 'background-image' ),
                    'type'      => 'background-image'
                )
            ),

        );

        $options['page_layout_metabox'] = array(
            'config'    =>  array(
                'title'     =>  __( 'Page Layout Style Options', 'better-studio' ),
                'pages'     =>  array( 'post', 'page' ),
                'context'   =>  'normal',
                'prefix'    =>  false,
                'priority'  =>  'high'
            ),
            'fields' => $fields,
            'panel-id'  => '__better_mag__theme_options',
        );


        /**
         * 3.3. => WooCommerce Product Page Options
         */
        if( function_exists( 'is_woocommerce' ) ){

            $fields = array();

            $fields['_default_sidebar_layout'] = array(
                'name'          =>  __( 'Product Sidebar Layout', 'better-studio' ),
                'id'            =>  '_default_sidebar_layout',
                'std'           =>  'default',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'desc'          =>  __( 'Select the sidebar layout for product. <br><br> <strong>Note:</strong> Default option image shows what style selected for default sidebar layout in theme options.', 'better-studio' ),
                'options'       =>  array(
                    'default'   =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-' . Better_Mag::get_option( 'shop_sidebar_layout' ) . '.png',
                        'label'     =>  __( 'Default', 'better-studio' ),
                    ),
                    'left'      =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-left.png',
                        'label'     =>  __( 'Left Sidebar', 'better-studio' ),
                    ),
                    'right'     =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-right.png',
                        'label'     =>  __( 'Right Sidebar', 'better-studio' ),
                    ),
                    'no-sidebar'=>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-no-sidebar.png',
                        'label'     =>  __( 'No Sidebar', 'better-studio' ),
                    ),
                )
            );

            $fields['_layout_style'] = array(
                'name'          =>  __( 'Layout Style', 'better-studio' ),
                'id'            =>  '_layout_style',
                'std'           =>  'default',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'desc'          =>  __( 'Select page layout style. <br><br> <strong>Note:</strong> Default option image shows default style that selected for page in theme options.', 'better-studio' ),
                'options'       =>  array(
                    'default'   =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-' . Better_Mag::get_option( 'layout_style' ) .'.png',
                        'label'     =>  __( 'Default', 'better-studio' ),
                    ),
                    'full-width'=>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-full-width.png',
                        'label'     =>  __( 'Full Width', 'better-studio' ),
                    ),
                    'boxed'     =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-boxed.png',
                        'label'     =>  __( 'Boxed', 'better-studio' ),
                    ),
                    'boxed-padded'=> array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-boxed-padded.png',
                        'label'     =>  __( 'Boxed (Padded)', 'better-studio' ),
                    ),
                )
            );
            $fields['_bg_color'] = array(
                'name'          =>  __( 'Page Background Color', 'better-studio' ),
                'id'            =>  '_bg_color',
                'type'          =>  'color',
                'std'           =>  Better_Mag::get_option( 'bg_color' ),
                'save-std'      =>  false,
                'desc'          =>  __( 'Setting a body background image below will override it.', 'better-studio' ),
                'css'           =>  array(
                    array(
                        'selector'  => array(
                            'body',
                            'body.boxed',
                        ),
                        'prop'      => 'background-color'
                    )
                ),
            );

            $fields['_bg_image'] = array(
                'name'          =>  __( 'Page Background Image', 'better-studio' ),
                'id'            =>  '_bg_image',
                'type'          =>  'background_image',
                'std'           =>  '',
                'save-std'      =>  false,
                'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
                'desc'          =>  __( 'Use light patterns in non-boxed layout. For patterns, use a repeating background. Use photo to fully cover the background with an image. Note that it will override the background color option.', 'better-studio' ),
                'css'           =>  array(
                    array(
                        'selector'  => array(
                            'body'
                        ),
                        'prop'      => 'background-image',
                        'type'      => 'background-image'
                    )
                ),
            );

            $fields['_header_bg_color'] = array(
                'name'          =>  __( 'Header Background Color', 'better-studio' ),
                'id'            =>  '_header_bg_color',
                'type'          =>  'color',
                'std'           =>  Better_Mag::get_option( 'header_bg_color' ),
                'save-std'      =>  false,
                'desc'          =>  __( 'Setting a header background pattern below will override it.','better-studio'),
                'css'           =>  array(
                    array(
                        'selector'  => array(
                            'body .header'
                        ),
                        'prop'      => array(
                            'background-color' => '%%value%%'
                        )
                    )
                )
            );

            $fields['_header_bg_image'] = array(
                'name'          =>  __( 'Header Background Image', 'better-studio' ),
                'id'            =>  '_header_bg_image',
                'type'          =>  'background_image',
                'std'           =>  array( 'img' => '', 'type' => 'cover' ),
                'save-std'      =>  false,
                'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
                'desc'          =>  __( 'Please use a background pattern that can be repeated. Note that it will override the header background color option.','better-studio'),
                'css'           =>  array(
                    array(
                        'selector'  => array(
                            'body .header'
                        ),
                        'prop'      => array( 'background-image' ),
                        'type'      => 'background-image'
                    )
                ),

            );

            $options['woocommerce_layout_metabox'] = array(
                'config'    =>  array(
                    'title'     =>  __( 'Product Layout Style Options', 'better-studio' ),
                    'pages'     =>  array( 'product' ),
                    'context'   =>  'normal',
                    'prefix'    =>  false,
                    'priority'  =>  'high'
                ),
                'fields' => $fields,
                'panel-id'  => '__better_mag__theme_options',
            );
        }



        /**
         * 3.4. => Pages Slider Options
         */
        $fields = array();

        $fields['_show_slider'] = array(
            'name'          =>  __( 'Show Slider', 'better-studio' ),
            'id'            =>  '_show_slider',
            'type'          =>  'switchery',
            'std'           =>  '0'
        );

        $fields['_slider_just_featured'] = array(
            'name'          =>  __( 'Just Featured Posts in Slider?', 'better-studio' ),
            'id'            =>  '_slider_just_featured',
            'std'           =>  '0' ,
            'type'          =>  'switchery',
            'desc'          =>  __( 'Turn Off for showing latest posts in slider or On for showing posts that specified as featured posts in slider.', 'better-studio' )
        );

        $fields['_slider_style'] = array(
            'name'          =>  __( 'Slider Layout Style', 'better-studio' ),
            'id'            =>  '_slider_style',
            'std'           =>  'default',
            'save_default'  =>  false,
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'options'       =>  array(
                'default' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-' . Better_Mag::get_option( 'slider_style' ) . '.png',
                    'label'     =>  __( 'Default', 'better-studio' ),
                ),
                'style-1' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-1.png',
                    'label'     =>  __( 'Style 1', 'better-studio' ),
                ),
                'style-2' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-2.png',
                    'label'     =>  __( 'Style 2', 'better-studio' ),
                ),
                'style-3' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-3.png',
                    'label'     =>  __( 'Style 3', 'better-studio' ),
                ),
                'style-4' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-4.png',
                    'label'     =>  __( 'Style 4', 'better-studio' ),
                ),
                'style-5' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-5.png',
                    'label'     =>  __( 'Style 5', 'better-studio' ),
                ),
                'style-6' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-6.png',
                    'label'     =>  __( 'Style 6', 'better-studio' ),
                ),
                'style-7' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-7.png',
                    'label'     =>  __( 'Style 7', 'better-studio' ),
                ),
                'style-8' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-8.png',
                    'label'     =>  __( 'Style 8', 'better-studio' ),
                ),
                'style-9' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-9.png',
                    'label'     =>  __( 'Style 9', 'better-studio' ),
                ),
                'style-10' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-10.png',
                    'label'     =>  __( 'Style 10', 'better-studio' ),
                ),
            )
        );
        $fields['_slider_bg_color'] = array(
            'name'          =>  __( 'Slider Background Color', 'better-studio' ),
            'id'            =>  '_slider_bg_color',
            'desc'          =>  __( 'Customize slider background color.', 'better-studio' ),
            'type'          =>  'color',
            'std'           =>  Better_Mag::get_option( 'slider_bg_color' ),
            'save-std'      =>  false,
            'css'           =>  array(
                array(
                    'selector'  => 'body .main-slider-wrapper' ,
                    'prop'      => array('background-color')
                )
            ),
        );
        $fields['_slider_cats'] = array(
            'name'          =>  __( 'Slider Categories', 'better-studio' ),
            'id'            =>  '_slider_cats',
            'type'          =>  'ajax_select',
            'std'           =>  Better_Mag::get_option( 'slider_cats' ),
            'desc'          =>  __( 'Select categories for showing post of them in slider. you can use combination of multiple category and tag.', 'better-studio' ),
            'placeholder'   =>  __("Search and find category...", 'better-studio'),
            "callback"      => 'BF_Ajax_Select_Callbacks::cats_callback',
            "get_name"      => 'BF_Ajax_Select_Callbacks::cat_name',
        );

        $fields['_slider_tags'] = array(
            'name'          =>  __( 'Slider Tags', 'better-studio' ),
            'id'            =>  '_slider_tags',
            'type'          =>  'ajax_select',
            'std'           =>  Better_Mag::get_option( 'slider_tags' ),
            'desc'          =>  __( 'Select tags for showing post of them in slider. you can use combination of multiple category and tag.', 'better-studio' ),
            'placeholder'   =>  __("Search and find tag...", 'better-studio'),
            "callback"      => 'BF_Ajax_Select_Callbacks::tags_callback',
            "get_name"      => 'BF_Ajax_Select_Callbacks::tag_name',
        );
        $options['pages_slider_option'] = array(
            'config'    =>  array(
                'title'     =>  __( 'Page Slider', 'better-studio' ),
                'pages'     =>  array( 'page' ),
                'context'   =>  'normal',
                'prefix'    =>  false,
                'priority'  =>  'high'
            ),
            'fields' => $fields,
            'panel-id'  => '__better_mag__theme_options',
        );

        return $options;

    } //setup_bf_metabox


    /**
     * Setup custom taxonomy options for BetterMag
     *
     * @param $options
     * @return array
     */
    function taxonomy_options( $options ){

        /**
         * 4. => Taxonomy Options
         */

        /**
         * 4.1. => Category Options
         */
        $fields['term_color'] = array(
            'name'          =>  __( 'Category Color', 'better-studio' ),
            'id'            =>  'term_color',
            'type'          =>  'color',
            'std'           =>  Better_Mag::get_option( 'theme_color' ),
            'save-std'      =>  false,
            'desc'          =>  __( 'This color will be used in several areas such as navigation and listing blocks.', 'better-studio' ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        'body.category-%%id%% .the-content a:hover',
                        '.block-modern.main-term-%%id%% .rating-stars span:before',
                        '.blog-block.main-term-%%id%% .rating-stars span:before',
                        '.block-highlight.main-term-%%id%% .rating-stars span:before',
                        '.listing-thumbnail li.main-term-%%id%% .rating-stars span:before',
                        '.widget .tab-read-more.term-%%id%% a:hover',
                        '.tab-content-listing .tab-read-more.term-%%id%% a',
                    ),
                    'prop'      => array(
                        'color' =>   '%%value%%'
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .menu > li.menu-term-%%id%%:hover > a',
                        '.main-menu .menu > li.current-menu-ancestor.menu-term-%%id%% > a',
                        '.main-menu .menu > li.current-menu-parent.menu-term-%%id%% > a',
                        '.main-menu .menu > li.current-menu-item.menu-term-%%id%% > a',
                        '.section-heading.tab-heading.active-term-%%id%%',
                        '.section-heading.term-%%id%%',
                        '.section-heading.extended.tab-heading.term-%%id%%',
                        'body.category-%%id%% .widget.widget_recent_comments a:hover',
                    ),
                    'prop'      => array(
                        'border-bottom-color' =>   '%%value%%'
                    )
                ),
                array(
                    'selector'  => array(
                        '.term-title.term-%%id%% a',
                        'body.category-%%id%% .main-slider-wrapper .flex-control-nav li a.flex-active,body.category-%%id%% .main-slider-wrapper .flex-control-nav li:hover a',
                        'body.category-%%id%% .page-heading:before',
                        'body.category-%%id%% .btn-read-more',
                        '.section-heading.term-%%id%% span.h-title',
                        '.section-heading.extended.tab-heading li.other-item.main-term.active.term-%%id%% a',
                        '.section-heading.extended.tab-heading li.other-item.term-%%id%%:hover a',
                        '.section-heading.extended.tab-heading.term-%%id%% .other-links .other-item.active a',
                    ),
                    'prop'      => array(
                        'background-color'  =>   '%%value%%',
                        'color'             =>   '#FFF',
                    )
                ),
                array(
                    'selector'  => array(
                        '.blog-block.main-term-%%id%% .btn-read-more',
                        '.block-modern.main-term-%%id%% .rating-bar span',
                        '.blog-block.main-term-%%id%% .rating-bar span',
                        '.block-highlight.main-term-%%id%% .rating-bar span',
                        '.listing-thumbnail li.main-term-%%id%% .rating-bar span',
                    ),
                    'prop'      => array(
                        'background-color'  =>   '%%value%%',
                    )
                ),
                array(
                    'selector'  =>  array(
                        '.widget.widget_nav_menu li.menu-term-%%id%% > a:hover',
                    ),
                    'prop'      =>  array(
                        'border-color' => "%%value%%",
                        'background-color'  =>   '%%value%%',
                    )
                ),
                array(
                    'selector'  =>  array(
                        'body.category-%%id%% ::selection',
                    ),
                    'prop'      =>  array( 'background' )
                ),
                array(
                    'selector'  =>  array(
                        'body.category-%%id%% ::-moz-selection'
                    ),
                    'prop'      =>  array( 'background' )
                ),

            ),
            'css-clean'           =>  array(
                array(
                    'selector'  => array(
                        'body.category-%%id%% .the-content a:hover',
                        '.block-modern.main-term-%%id%% .rating-stars span:before',
                        '.blog-block.main-term-%%id%% .rating-stars span:before',
                        '.block-highlight.main-term-%%id%% .rating-stars span:before',
                        '.listing-thumbnail li.main-term-%%id%% .rating-stars span:before',
                        '.section-heading.tab-heading.active-term-%%id%%',
                        '.section-heading.extended.tab-heading.term-%%id%%',
                        '.section-heading.extended.tab-heading li.other-item.term-%%id%%:hover a',
                        '.section-heading.extended.tab-heading.term-%%id%% .other-links .other-item.active a',
                        '.section-heading.term-%%id%% span.h-title',
                        '.widget .tab-read-more.term-%%id%% a:hover',
                        '.tab-content-listing .tab-read-more.term-%%id%% a',
                    ),
                    'prop'      => array(
                        'color' =>   '%%value%%'
                    )
                ),
                array(
                    'selector'  =>  array(
                        '.widget.widget_nav_menu li.menu-term-%%id%% > a:hover',
                    ),
                    'prop'      =>  array(
                        'border-color' => "%%value%%",
                        'background-color'  =>   '%%value%%',
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .menu > li.menu-term-%%id%%:hover > a',
                        '.main-menu .menu > li.current-menu-ancestor.menu-term-%%id%% > a',
                        '.main-menu .menu > li.current-menu-parent.menu-term-%%id%% > a',
                        '.main-menu .menu > li.current-menu-item.menu-term-%%id%% > a',
                        '.section-heading.term-%%id%%',
                        'body.category-%%id%% .widget.widget_recent_comments a:hover',
                    ),
                    'prop'      => array(
                        'border-color' =>   '%%value%%'
                    )
                ),
                array(
                    'selector'  => array(
                        '.section-heading.extended.tab-heading.term-%%id%%',
                    ),
                    'prop'      => array(
                        'border-color' =>   '%%value%%'
                    )
                ),
                array(
                    'selector'  => array(
                        '.term-title.term-%%id%% a',
                        'body.category-%%id%% .main-slider-wrapper .flex-control-nav li a.flex-active,body.category-%%id%% .main-slider-wrapper .flex-control-nav li:hover a',
                        'body.category-%%id%% .page-heading:before',
                        'body.category-%%id%% .btn-read-more',
                        'body.category-%%id%% .btn-read-more',
                    ),
                    'prop'      => array(
                        'background-color'  =>   '%%value%%',
                        'color'             =>   '#FFF',
                    )
                ),
                array(
                    'selector'  => array(
                        '.blog-block.main-term-%%id%% .btn-read-more',
                        '.block-modern.main-term-%%id%% .rating-bar span',
                        '.blog-block.main-term-%%id%% .rating-bar span',
                        '.block-highlight.main-term-%%id%% .rating-bar span',
                        '.listing-thumbnail li.main-term-%%id%% .rating-bar span',
                    ),
                    'prop'      => array(
                        'background-color'  =>   '%%value%%',
                    )
                ),
                array(
                    'selector'  =>  array(
                        'body.category-%%id%% ::selection',
                    ),
                    'prop'      =>  array( 'background' )
                ),
                array(
                    'selector'  =>  array(
                        'body.category-%%id%% ::-moz-selection'
                    ),
                    'prop'      =>  array( 'background' )
                )

            ),
            'css-clean-beige'           =>  array(
                array(
                    'selector'  => array(
                        'body.category-%%id%% .the-content a:hover',
                        '.block-modern.main-term-%%id%% .rating-stars span:before',
                        '.blog-block.main-term-%%id%% .rating-stars span:before',
                        '.block-highlight.main-term-%%id%% .rating-stars span:before',
                        '.listing-thumbnail li.main-term-%%id%% .rating-stars span:before',
                        '.section-heading.tab-heading.active-term-%%id%%',
                        '.section-heading.extended.tab-heading.term-%%id%%',
                        '.section-heading.extended.tab-heading li.other-item.term-%%id%%:hover a',
                        '.section-heading.extended.tab-heading.term-%%id%% .other-links .other-item.active a',
                        '.section-heading.term-%%id%% span.h-title',
                        '.widget .tab-read-more.term-%%id%% a:hover',
                        '.tab-content-listing .tab-read-more.term-%%id%% a',
                    ),
                    'prop'      => array(
                        'color' =>   '%%value%%'
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .menu > li.menu-term-%%id%%:hover > a',
                        '.main-menu .menu > li.current-menu-ancestor.menu-term-%%id%% > a',
                        '.main-menu .menu > li.current-menu-parent.menu-term-%%id%% > a',
                        '.main-menu .menu > li.current-menu-item.menu-term-%%id%% > a',
                        '.section-heading.term-%%id%%',
                        'body.category-%%id%% .widget.widget_recent_comments a:hover',
                    ),
                    'prop'      => array(
                        'border-color' =>   '%%value%%'
                    )
                ),
                array(
                    'selector'  => array(
                        '.section-heading.extended.tab-heading.term-%%id%%',
                    ),
                    'prop'      => array(
                        'border-color' =>   '%%value%%'
                    )
                ),
                array(
                    'selector'  => array(
                        '.term-title.term-%%id%% a',
                        'body.category-%%id%% .main-slider-wrapper .flex-control-nav li a.flex-active,body.category-%%id%% .main-slider-wrapper .flex-control-nav li:hover a',
                        'body.category-%%id%% .page-heading:before',
                        'body.category-%%id%% .btn-read-more',
                        'body.category-%%id%% .btn-read-more',
                    ),
                    'prop'      => array(
                        'background-color'  =>   '%%value%%',
                        'color'             =>   '#FFF',
                    )
                ),
                array(
                    'selector'  => array(
                        '.blog-block.main-term-%%id%% .btn-read-more',
                        '.block-modern.main-term-%%id%% .rating-bar span',
                        '.blog-block.main-term-%%id%% .rating-bar span',
                        '.block-highlight.main-term-%%id%% .rating-bar span',
                        '.listing-thumbnail li.main-term-%%id%% .rating-bar span',
                    ),
                    'prop'      => array(
                        'background-color'  =>   '%%value%%',
                    )
                ),
                array(
                    'selector'  =>  array(
                        '.widget.widget_nav_menu li.menu-term-%%id%% > a:hover',
                    ),
                    'prop'      =>  array(
                        'border-color' => "%%value%%",
                        'background-color'  =>   '%%value%%',
                    )
                ),
                array(
                    'selector'  =>  array(
                        'body.category-%%id%% ::selection',
                    ),
                    'prop'      =>  array( 'background' )
                ),
                array(
                    'selector'  =>  array(
                        'body.category-%%id%% ::-moz-selection'
                    ),
                    'prop'      =>  array( 'background' )
                )

            ),

        );

        $fields[] = array(
            'name'          =>  __( 'Sidebar Layout', 'better-studio' ),
            'id'            =>  'sidebar_layout',
            'std'           =>  'default',
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'desc'          =>  __( 'Select the sidebar layout to use by default. This can be overridden per-page, per-post and per category.', 'better-studio' ),
            'options'       => array(
                'default' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-' . Better_Mag::get_option( 'default_sidebar_layout' ) . '.png',
                    'label'     =>  __( 'Default', 'better-studio' ),
                ),
                'left' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-left.png',
                    'label'     =>  __( 'Left Sidebar', 'better-studio' ),
                ),
                'right' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-right.png',
                    'label'     =>  __( 'Right Sidebar', 'better-studio' ),
                ),
                'no-sidebar'=>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-no-sidebar.png',
                    'label'     =>  __( 'No Sidebar', 'better-studio' ),
                ),
            )
        );

        $fields[] = array(
            'name'          =>  __( 'Show Slider in Archive', 'better-studio' ),
            'id'            =>  'show_slider',
            'type'          =>  'switchery',
            'std'           =>  '0'
        );

        $fields[] = array(
            'name'          =>  __( 'Just Featured Posts in Slider?', 'better-studio' ),
            'id'            =>  'slider_just_featured',
            'std'           =>  '1' ,
            'type'          =>  'switchery',
            'desc'          =>  __( 'Turn Off for showing latest posts of category in slider or On for showing posts that specified as featured post in this category as slider.', 'better-studio' )
        );

        $fields['slider_style'] = array(
            'name'          =>  __( 'Category Archive Slider Layout Style', 'better-studio' ),
            'id'            =>  'slider_style',
            'std'           =>  'default',
            'save_default'  =>  false,
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'options'       =>  array(
                'default' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-' . Better_Mag::get_option( 'slider_style' ) . '.png',
                    'label'     =>  __( 'Default', 'better-studio' ),
                ),
                'style-1' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-1.png',
                    'label'     =>  __( 'Style 1', 'better-studio' ),
                ),
                'style-2' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-2.png',
                    'label'     =>  __( 'Style 2', 'better-studio' ),
                ),
                'style-3' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-3.png',
                    'label'     =>  __( 'Style 3', 'better-studio' ),
                ),
                'style-4' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-4.png',
                    'label'     =>  __( 'Style 4', 'better-studio' ),
                ),
                'style-5' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-5.png',
                    'label'     =>  __( 'Style 5', 'better-studio' ),
                ),
                'style-6' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-6.png',
                    'label'     =>  __( 'Style 6', 'better-studio' ),
                ),
                'style-7' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-7.png',
                    'label'     =>  __( 'Style 7', 'better-studio' ),
                ),
                'style-8' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-8.png',
                    'label'     =>  __( 'Style 8', 'better-studio' ),
                ),
                'style-9' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-9.png',
                    'label'     =>  __( 'Style 9', 'better-studio' ),
                ),
                'style-10' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-10.png',
                    'label'     =>  __( 'Style 10', 'better-studio' ),
                ),
            )
        );

        $fields['slider_style'] = array(
            'name'          =>  __( 'Category Archive Slider Layout Style', 'better-studio' ),
            'id'            =>  'slider_style',
            'std'           =>  'default',
            'save_default'  =>  false,
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'options'       =>  array(
                'default' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-' . Better_Mag::get_option( 'slider_style' ) . '.png',
                    'label'     =>  __( 'Default', 'better-studio' ),
                ),
                'style-1' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-1.png',
                    'label'     =>  __( 'Style 1', 'better-studio' ),
                ),
                'style-2' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-2.png',
                    'label'     =>  __( 'Style 2', 'better-studio' ),
                ),
                'style-3' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-3.png',
                    'label'     =>  __( 'Style 3', 'better-studio' ),
                ),
                'style-4' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-4.png',
                    'label'     =>  __( 'Style 4', 'better-studio' ),
                ),
                'style-5' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-5.png',
                    'label'     =>  __( 'Style 5', 'better-studio' ),
                ),
                'style-6' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-6.png',
                    'label'     =>  __( 'Style 6', 'better-studio' ),
                ),
                'style-7' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-7.png',
                    'label'     =>  __( 'Style 7', 'better-studio' ),
                ),
                'style-8' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-8.png',
                    'label'     =>  __( 'Style 8', 'better-studio' ),
                ),
                'style-9' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-9.png',
                    'label'     =>  __( 'Style 9', 'better-studio' ),
                ),
                'style-10' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-10.png',
                    'label'     =>  __( 'Style 10', 'better-studio' ),
                ),
            )
        );

        $fields['slider_bg_color'] = array(
            'name'          =>  __( 'Slider Background Color', 'better-studio' ),
            'id'            =>  'slider_bg_color',
            'desc'          =>  __( 'Customize slider background color.', 'better-studio' ),
            'type'          =>  'color',
            'std'           =>  Better_Mag::get_option( 'slider_bg_color' ),
            'save-std'      =>  false,
            'css'           =>  array(
                array(
                    'selector'  => 'body.category-%%id%% .main-slider-wrapper' ,
                    'prop'      => array('background-color')
                )
            ),
        );

        $fields['listing_style'] = array(
            'name'          =>  __( 'Category Listing Style', 'better-studio' ),
            'id'            =>  'listing_style',
            'std'           =>   'default',
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'desc'          =>  __( 'This style used when browsing category archive page. Default option image shows what default style selected in theme options.', 'better-studio' ),
            'options'       =>  array(
                'default' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-' . Better_Mag::get_option( 'categories_listing_style' ) . '.png',
                    'label'     =>  __( 'Default', 'better-studio' ),
                ),
                'blog' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-blog.png',
                    'label'     =>  __( 'Blog Listing', 'better-studio' ),
                ),
                'modern' => array(
                    'img'       => BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-modern.png',
                    'label'     => __( 'Modern Listing', 'better-studio' ),
                ),
                'highlight' => array(
                    'img'       => BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-highlight.png',
                    'label'     => __( 'Highlight Listing', 'better-studio' ),
                ),
                'classic' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-classic.png',
                    'label'     =>  __( 'Classic Listing', 'better-studio' ),
                ),
            )
        );

        $fields['layout_style'] = array(
            'name'          =>  __( 'Category Archive Layout Style', 'better-studio' ),
            'id'            =>  'layout_style',
            'std'           =>  'default',
            'save_default'  =>  false,
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'desc'          =>  __( 'Select whether you want a boxed or a full width layout. Default option image shows what default style selected in theme options.', 'better-studio' ),
            'options'       =>  array(
                'default'   =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-' . Better_Mag::get_option( 'layout_style' ) . '.png',
                    'label'     =>  __( 'Default', 'better-studio' ),
                ),
                'full-width' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-full-width.png',
                    'label'     =>  __( 'Full Width', 'better-studio' ),
                ),
                'boxed' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-boxed.png',
                    'label'     =>  __( 'Boxed', 'better-studio' ),
                ),
                'boxed-padded' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-boxed-padded.png',
                    'label'     =>  __( 'Boxed (Padded)', 'better-studio' ),
                ),
            )
        );

        $fields['bg_color'] = array(
            'name'      =>  __( 'Body Background Color', 'better-studio' ),
            'id'        =>  'bg_color',
            'type'      =>  'color',
            'std'       =>  Better_Mag::get_option( 'bg_color' ),
            'save-std'  =>  false,
            'desc'      =>  __( 'Setting a body background image below will override it.', 'better-studio' ),
            'css'       =>  array(
                array(
                    'selector'  => array(
                        'body.category-%%id%%',
                    ),
                    'prop'      => array(
                        'background-color' =>   '%%value%%'
                    )
                ),
            )
        );

        $fields['bg_image'] = array(
            'name'      => __('Body Background Image','better-studio'),
            'id'        => 'bg_image',
            'type'      => 'background_image',
            'std'       => '',
            'upload_label'=> __( 'Upload Image', 'better-studio' ),
            'desc'      => __( 'Use light patterns in non-boxed layout. For patterns, use a repeating background. Use photo to fully cover the background with an image. Note that it will override the background color option.','better-studio'),
            'css'       => array(
                array(
                    'selector'  => array(
                        'body.category-%%id%%'
                    ),
                    'prop'      => array( 'background-image' ),
                    'type'      => 'background-image'
                )
            )
        );

        $options[] = array(
            'config' => array(
                'taxonomies'    => 'category'
            ),
            'panel-id'  => '__better_mag__theme_options',
            'fields' => $fields
        );

        /**
         * 4.2. => Tag Options
         */
        $fields = array();

        $fields['listing_style'] = array(
            'name'          =>  __( 'Tag Listing Style', 'better-studio' ),
            'id'            =>  'listing_style',
            'std'           =>   'default',
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'desc'          =>  __( 'This style used when browsing tag archive page. Default option image shows what default style selected in theme options.', 'better-studio' ),
            'options'       =>  array(
                'default' =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-' . Better_Mag::get_option( 'tags_listing_style' ) . '.png',
                    'label'     =>  __( 'Default', 'better-studio' ),
                ),
                'blog' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-blog.png',
                    'label'     =>  __( 'Blog Listing', 'better-studio' ),
                ),
                'modern' => array(
                    'img'       => BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-modern.png',
                    'label'     => __( 'Modern Listing', 'better-studio' ),
                ),
                'highlight' => array(
                    'img'       => BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-highlight.png',
                    'label'     => __( 'Highlight Listing', 'better-studio' ),
                ),
                'classic' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-classic.png',
                    'label'     =>  __( 'Classic Listing', 'better-studio' ),
                ),
            )
        );

        $fields['layout_style'] = array(
            'name'          =>  __( 'Tag Archive Layout Style', 'better-studio' ),
            'id'            =>  'layout_style',
            'std'           =>  'default',
            'save_default'  =>  false,
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'desc'          =>  __( 'Select whether you want a boxed or a full width layout. Default option image shows what default style selected in theme options.', 'better-studio' ),
            'options'       =>  array(
                'default'   =>  array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-' . Better_Mag::get_option( 'layout_style' ) . '.png',
                    'label'     =>  __( 'Default', 'better-studio' ),
                ),
                'full-width' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-full-width.png',
                    'label'     =>  __( 'Full Width', 'better-studio' ),
                ),
                'boxed' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-boxed.png',
                    'label'     =>  __( 'Boxed', 'better-studio' ),
                ),
                'boxed-padded' => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-boxed-padded.png',
                    'label'     =>  __( 'Boxed (Padded)', 'better-studio' ),
                ),
            )
        );

        $fields['bg_color'] = array(
            'name'          =>  __( 'Body Background Color', 'better-studio' ),
            'id'            =>  'bg_color',
            'type'          =>  'color',
            'std'           =>  Better_Mag::get_option( 'bg_color' ),
            'save-std'      =>  false,
            'desc'          =>  __( 'Setting a body background image below will override it.', 'better-studio' ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        'body.tag-%%id%%',
                    ),
                    'prop'      => array(
                        'background-color' =>   '%%value%%'
                    )
                ),
            )
        );

        $fields['bg_image'] = array(
            'name'          =>  __( 'Body Background Image', 'better-studio' ),
            'id'            =>  'bg_image',
            'type'          =>  'background_image',
            'std'           =>  '',
            'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
            'desc'          =>  __( 'Use light patterns in non-boxed layout. For patterns, use a repeating background. Use photo to fully cover the background with an image. Note that it will override the background color option.','better-studio'),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        'body.tag-%%id%%'
                    ),
                    'prop'      => array( 'background-image' ),
                    'type'      => 'background-image'
                )
            )
        );

        $options[] = array(
            'config' => array(
                'taxonomies'    => 'post_tag'
            ),
            'panel-id'  => '__better_mag__theme_options',
            'fields' => $fields
        );

        return $options;

    } //setup_bf_metabox


    /**
     * Setup setting panel for BetterMag
     *
     * 5. => Admin Panel
     *
     * @param $options
     * @return array
     */
    function setup_option_panel( $options ){

        $field = array();

        /**
         * 5.1. => General Options
         */
        $field[] = array(
            'name'      =>  __( 'General' , 'better-studio' ),
            'id'        =>  'general_settings',
            'type'      =>  'tab',
            'icon'      =>  'fa-gear'
        );

            $field['layout_style'] = array(
                'name'          =>  __( 'General Layout Style', 'better-studio' ),
                'id'            =>  'layout_style',
                'std'           =>  'full-width',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'desc'          =>  __( 'Select the layout you want, whether a boxed or a full width one. It affects every page and the whole layout. This option can be overridden on every page, post, category and tag.', 'better-studio' ),
                'options'       => array(
                    'full-width'    => array(
                        'img'           =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-full-width.png',
                        'label'         =>  __( 'Full Width', 'better-studio' ),
                    ),
                    'boxed'         => array(
                        'img'           =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-boxed.png',
                        'label'         =>  __( 'Boxed', 'better-studio' ),
                    ),
                    'boxed-padded'  => array(
                        'img'           =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-boxed-padded.png',
                        'label'         =>  __( 'Boxed (Padded)', 'better-studio' ),
                    ),
                )
            );

            $field[] = array(
                'name'          =>  __( 'General Sidebar Layout', 'better-studio' ),
                'id'            =>  'default_sidebar_layout',
                'std'           =>  'right',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'desc'          =>  __( 'Select the general sidebar you want to use by default. This option can be overridden on every page, post, category and tag.', 'better-studio' ),
                'options'       => array(
                    'left' => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-left.png',
                        'label'     =>  __( 'Left Sidebar', 'better-studio' ),
                    ),
                    'right' =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-right.png',
                        'label'     =>  __( 'Right Sidebar', 'better-studio' ),
                    ),
                    'no-sidebar'=>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-no-sidebar.png',
                        'label'     =>  __( 'No Sidebar', 'better-studio' ),
                    ),
                )
            );

            $field[] = array(
                'name'  =>  __( 'Effects and Animations', 'better-studio' ),
                'id'    =>  'effects_heading',
                'type'  =>  'heading',
            );
                $field[] = array(
                    'name'  =>  __( 'Enable Show/Hide Animation on Scroll','better-studio'),
                    'id'    =>  'animation_scroll',
                    'std'   =>  '1' ,
                    'type'  =>  'switchery',
                    'desc'  =>  __( 'Enabeling this option will add fade-in animation to images and some other elements when they are in browser view report area.', 'better-studio' ),
                );
                $field[] = array(
                    'name'  =>  __( 'Enable Image Zoom Animation on Hover','better-studio'),
                    'id'    =>  'animation_image_zoom',
                    'std'   =>  '1' ,
                    'type'  =>  'switchery',
                    'desc'  =>  __( 'Enabling this option will add zoom-in animation for listings and elements main image hover.', 'better-studio' ),
                );
                $field[] = array(
                    'name'  =>  __( 'Use Light Box For Images Link','better-studio'),
                    'id'    =>  'lightbox_is_enable',
                    'std'   =>  '1' ,
                    'type'  =>  'switchery',
                    'desc'  =>  __( 'With enabling this link for bigger size of images will be opened in same page with beautiful lightbox.', 'better-studio' ),
                );

            $field[] = array(
                'name'  =>  __( 'Back Top Button', 'better-studio' ),
                'id'    =>  'back_top_heading',
                'type'  =>  'heading',
            );
                $field[] = array(
                    'name'  =>  __( 'Show Back To Top Button','better-studio'),
                    'id'    =>  'back_to_top',
                    'std'   =>  '0' ,
                    'type'  =>  'switchery',
                    'desc'  =>  __( 'Enabling this option will add a "Back To Top" button to pages.', 'better-studio' ),
                );

            $field[] = array(
                'name'  =>  __('Favicons','better-studio'),
                'id'    =>  'favicon_heading',
                'type'  =>  'heading',
            );
                $field[] = array(
                    'name'  =>  __('Favicon (16x16)','better-studio'),
                    'id'    =>  'favicon_16_16',
                    'type'  =>  'media_image',
                    'std'           =>  '',
                    'desc'  =>  __('Default Favicon. 16px x 16px','better-studio'),
                    'media_title'   =>  __( 'Select or Upload Favicon', 'better-studio'),
                    'media_button'  =>  __( 'Select Favicon', 'better-studio'),
                    'upload_label'  =>  __( 'Upload Favicon', 'better-studio'),
                    'remove_label'  =>  __( 'Remove Favicon', 'better-studio'),
                );
                $field[] = array(
                    'name'  =>  __('Apple iPhone Icon (57x57)','better-studio'),
                    'id'    =>  'favicon_57_57',
                    'type'  =>  'media_image',
                    'desc'  =>  __('Icon for Classic iPhone','better-studio'),
                    'std'           =>  '',
                    'media_title'   =>  __( 'Select or Upload Favicon', 'better-studio'),
                    'media_button'  =>  __( 'Select Favicon', 'better-studio'),
                    'upload_label'  =>  __( 'Upload Favicon', 'better-studio'),
                    'remove_label'  =>  __( 'Remove Favicon', 'better-studio'),
                );
                $field[] = array(
                    'name'  =>  __('Apple iPhone Retina Icon (114x114)','better-studio'),
                    'id'    =>  'favicon_114_114',
                    'type'  =>  'media_image',
                    'desc'  =>  __('Icon for Retina iPhone','better-studio'),
                    'std'           =>  '',
                    'media_title'   =>  __( 'Select or Upload Favicon', 'better-studio'),
                    'media_button'  =>  __( 'Select Favicon', 'better-studio'),
                    'upload_label'  =>  __( 'Upload Favicon', 'better-studio'),
                    'remove_label'  =>  __( 'Remove Favicon', 'better-studio'),
                );
                $field[] = array(
                    'name'  =>  __('Apple iPad Icon (72x72)','better-studio'),
                    'id'    =>  'favicon_72_72',
                    'type'  =>  'media_image',
                    'desc'  =>  __('Icon for Classic iPad','better-studio'),
                    'std'           =>  '',
                    'media_title'   =>  __( 'Select or Upload Favicon', 'better-studio'),
                    'media_button'  =>  __( 'Select Favicon', 'better-studio'),
                    'upload_label'  =>  __( 'Upload Favicon', 'better-studio'),
                    'remove_label'  =>  __( 'Remove Favicon', 'better-studio'),
                );
                $field[] = array(
                    'name'  =>  __('Apple iPad Retina Icon (144x144)','better-studio'),
                    'id'    =>  'favicon_144_144',
                    'type'  =>  'media_image',
                    'desc'  =>  __('Icon for Retina iPad','better-studio'),
                    'std'           =>  '',
                    'media_title'   =>  __( 'Select or Upload Favicon', 'better-studio'),
                    'media_button'  =>  __( 'Select Favicon', 'better-studio'),
                    'upload_label'  =>  __( 'Upload Favicon', 'better-studio'),
                    'remove_label'  =>  __( 'Remove Favicon', 'better-studio'),
                );

        /**
         * 5.2. => Header Options
         */
        $field[] = array(
            'name'  =>  __( 'Header', 'better-studio' ),
            'id'    =>  'header_settings',
            'type'  =>  'tab',
            'icon'  =>  'feedback'
        );

            $field[] = array(
                'name'      =>  __( 'Logo', 'better-studio' ),
                'type'      =>  'heading',
            );
    
            $field['logo_position'] = array(
                'name'          =>   __( 'Logo Position', 'better-studio' ),
                'id'            =>  'logo_position',
                'desc'          =>   __( 'Select logo position in header. This will affect on "Logo Aside" sidebar location. If you select centered Logo Position the "Logo Aside" widget area will be removed.', 'better-studio' ),
                'std'           =>  'left',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'options' => array(
                    /* translators: For RTL Languages in this situation translate Left to Right and Right to Left!. */
                    'left'    =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/header-logo-left.png',
                        'label' =>  __( 'Left', 'better-studio' ),
                    ),
                    'center'    =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/header-logo-center.png',
                        'label' =>  __( 'Center', 'better-studio' ),
                    ),
                    'right'    =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/header-logo-right.png',
                        'label' =>  __( 'Right', 'better-studio' ),
                    ),
                ),
            );
    
            $field['logo_text'] = array(
                'name'          =>  __( 'Logo Text', 'better-studio' ),
                'id'            =>  'logo_text',
                'desc'          =>  __( 'The desired text will be used if logo images are not provided below.', 'better-studio' ),
                'std'           =>  get_option( 'blogname' ),
                'type'          =>  'text',
            );
    
            $field['logo_image'] = array(
                'name'          =>  __( 'Logo Image', 'better-studio' ),
                'id'            =>  'logo_image',
                'desc'          =>  __( 'By default, a text-based logo is created using your site title. But you can also upload an image-based logo here.', 'better-studio' ),
                'std'           =>  '',
                'type'          =>  'media_image',
                'media_title'   =>  __( 'Select or Upload Logo', 'better-studio'),
                'media_button'  =>  __( 'Select Image', 'better-studio'),
                'upload_label'  =>  __( 'Upload Logo', 'better-studio'),
                'remove_label'  =>  __( 'Remove Logo', 'better-studio'),
            );
    
            $field['logo_image_retina'] = array(
                'name'          =>  __( 'Logo Image Retina (2x)', 'better-studio' ),
                'id'            =>  'logo_image_retina',
                'desc'          =>  __( 'If you want to upload a Retina Image, It\'s Image Size should be exactly double in compare with your normal Logo. It requires WP Retina 2x plugin.', 'better-studio' ),
                'std'           =>  '',
                'type'          =>  'media_image',
                'media_title'   =>  __( 'Select or Upload Retina Logo', 'better-studio'),
                'media_button'  =>  __( 'Select Retina Image', 'better-studio'),
                'upload_label'  =>  __( 'Upload Retina Logo', 'better-studio'),
                'remove_label'  =>  __( 'Remove Retina Logo', 'better-studio'),
            );
    
            $field[] = array(
                'name'          =>  __( 'Show Site Tagline Below Logo', 'better-studio' ),
                'id'            =>  'show_site_description',
                'std'           =>  '0' ,
                'type'          =>  'switchery',
                'desc'          =>  __( 'Enabling this will add site Tagline below the logo.','better-studio'),
            );

            $field[] = array(
                'name'          =>  __( 'Show "Aside Logo" sidebar location on small screens?', 'better-studio' ),
                'id'            =>  'show_aside_logo_on_small',
                'std'           =>  '0' ,
                'type'          =>  'switchery',
                'desc'          =>  __( 'Enabling this will shows Aside Logo sidebar location on tablets and smartphones.','better-studio'),
            );

            $field[] = array(
                'name'      =>  __( 'Top Bar', 'better-studio' ),
                'type'      =>  'heading',
            );
    
            $field[] = array(
                'name'      =>  __('Disable Top Bar','better-studio'),
                'id'        =>  'disable_top_bar',
                'std'       =>  '0' ,
                'type'      =>  'switchery',
                'desc'      =>  __('Enabling this will disable the top bar element that appears above the logo area.','better-studio'),
            );
    
            $field[] = array(
                'name'      =>  __( 'Main Navigation', 'better-studio' ),
                'type'      => 'heading',
            );
            $field['main_menu_layout'] = array(
                'name'      =>  __( 'Main Navigation Layout Style', 'better-studio' ),
                'id'        => 'main_menu_layout',
                'desc'      =>  __( 'Select whether you want a boxed or a full width menu. ', 'better-studio' ),
                'std'       => 'boxed',
                'type'      => 'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'options'   => array(
                    'boxed' =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/header-menu-boxed.png',
                        'label' =>  __( 'Boxed', 'better-studio' ),
                    ),
                    'full-width'    =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/header-menu-full-width.png',
                        'label' =>  __( 'Full Width', 'better-studio' ),
                    ),
                ),
            );
            $field[] = array(
                'name'      =>  __( 'Sticky Navigation', 'better-studio' ),
                'id'        =>  'main_menu_sticky',
                'std'       =>  '0' ,
                'type'      =>  'switchery',
                'desc'      =>  __( 'This makes menu always visible at the top when the user scrolls.','better-studio'),
            );
            $field[] = array(
                'name'      =>  __( 'Show Search Icon in Main Navigation', 'better-studio' ),
                'id'        =>  'show_search_in_main_navigation',
                'std'       =>  '1' ,
                'type'      =>  'switchery',
                'desc'      =>  __( 'Enabling this will add search icon to the main navigation.', 'better-studio' ),
            );
            $field[] = array(
                'name'      =>  __( 'Show Random Post Link Icon in Main Navigation','better-studio'),
                'id'        =>  'show_random_post_link',
                'std'       =>  '0' ,
                'type'      =>  'switchery',
                'desc'      =>  __( 'Enabling this will adds random post icon link to the main navigation.','better-studio'),
            );
            $field[] = array(
                'name'      =>  __( 'Show User Login Button in Main Navigation', 'better-studio' ),
                'id'        =>  'main_navigation_show_user_login',
                'std'       =>  '0' ,
                'type'      =>  'switchery',
                'desc'      =>  __( 'Enabling this will add a button in main navigation for user login and also register if it\'s enabled below.','better-studio'),
            );
            $field[] = array(
                'name'      =>  __( 'Show User Register Form in Login Popup Modal?','better-studio'),
                'id'        =>  'main_navigation_show_user_register_in_modal',
                'std'       =>  '0' ,
                'type'      =>  'switchery',
                'desc'      =>  __( 'Enabling this will add register form in popup login modal.', 'better-studio' ),
            );
    
            $field[] = array(
                'name'      =>  __( 'Breadcrumb', 'better-studio' ),
                'type'      =>  'heading',
            );
            $field[] = array(
                'name'      =>  __( 'Show Breadcrumb?', 'better-studio' ),
                'id'        =>  'show_breadcrumb',
                'desc'      =>  __( 'Breadcrumbs are a hierarchy of links displayed below the main navigation. They are displayed on all pages but the home-page.', 'better-studio' ),
                'std'       =>  '1' ,
                'type'      =>  'switchery',
            );
            $field[] = array(
                'name'      =>  __( 'Show Breadcrumb on Homepage?', 'better-studio' ),
                'id'        =>  'show_breadcrumb_homepage',
                'desc'      =>  __( 'You can show breadcrumb in homepage with enabling this option.','better-studio'),
                'std'       =>  '0' ,
                'type'      =>  'switchery',
            );


        $field[] = array(
            'name'  =>  __( 'Slider', 'better-studio' ),
            'id'    =>  'slider_settings',
            'type'  =>  'tab',
            'icon'  =>  'fa-picture-o'
        );
            $field[] = array(
                'name'      =>  __( 'Show Slider in Home Page?', 'better-studio' ),
                'id'        =>  'show_slider',
                'std'       =>  '0' ,
                'type'      =>  'switchery',
            );
            $field[] = array(
                'name'      =>  __('Just Featured Posts in Slider?','better-studio'),
                'id'        =>  'slider_just_featured',
                'std'       =>  '1' ,
                'type'      =>  'switchery',
                'desc'      => __( 'With enabling this option only featured posts will be shown in the slider, and with disabling this option recent posts will be shown. ', 'better-studio' )
            );
    
            $field['slider_style'] = array(
                'name'      =>  __( 'Slider Style', 'better-studio' ),
                'id'        =>  'slider_style',
                'std'       =>  'style-1',
                'type'      =>  'image_radio',
                'desc'      =>  __( 'Select general slider style for home page and all categories. This can be overridden for every category and pages .', 'better-studio' ),
                'section_class' => 'style-floated-left bordered',
                'options' => array(
                    'style-1'    =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-1.png',
                        'label' =>  __( 'Style 1', 'better-studio' ),
                    ),
                    'style-2' =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-2.png',
                        'label' =>  __( 'Style 2', 'better-studio' ),
                    ),
                    'style-3' =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-3.png',
                        'label' =>  __( 'Style 3', 'better-studio' ),
                    ),
                    'style-4' =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-4.png',
                        'label' =>  __( 'Style 4', 'better-studio' ),
                    ),
                    'style-5' =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-5.png',
                        'label' =>  __( 'Style 5', 'better-studio' ),
                    ),
                    'style-6' =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-6.png',
                        'label' =>  __( 'Style 6', 'better-studio' ),
                    ),
                    'style-7' =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-7.png',
                        'label' =>  __( 'Style 7', 'better-studio' ),
                    ),
                    'style-8' =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-8.png',
                        'label' =>  __( 'Style 8', 'better-studio' ),
                    ),
                    'style-9' =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-9.png',
                        'label' =>  __( 'Style 9', 'better-studio' ),
                    ),
                    'style-10' =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/slider-style-10.png',
                        'label' =>  __( 'Style 10', 'better-studio' ),
                    ),
                )
            );
    
            $field[] = array(
                'name'  =>  __( 'Slider Categories', 'better-studio' ),
                'id'    =>  'slider_cats',
                'type'  =>  'ajax_select',
                'desc'  =>  __( 'Select a specified category to filter the posts in the slider. you can use a combination of categories and tags. Leave it empty for showing all posts without any category filter.', 'better-studio' ),
                'placeholder'  =>  __("Search and find category...", 'better-studio'),
                "callback" => 'BF_Ajax_Select_Callbacks::cats_callback',
                "get_name" => 'BF_Ajax_Select_Callbacks::cat_name',
            );
    
            $field[] = array(
                'name'  =>  __( 'Slider Tags', 'better-studio' ),
                'id'    =>  'slider_tags',
                'type'  =>  'ajax_select',
                'desc'  =>  __( 'Select a specified tag to filter the posts in the slider. you can use a combination of categories and tags. Leave it empty for showing all posts without any tag filter.', 'better-studio' ),
                'placeholder'  =>  __("Search and find tag...", 'better-studio'),
                "callback" => 'BF_Ajax_Select_Callbacks::tags_callback',
                "get_name" => 'BF_Ajax_Select_Callbacks::tag_name',
            );


        /**
         * 5.3. => Footer Options
         */
        $field[] = array(
            'name'      =>  __( 'Footer', 'better-studio' ),
            'id'        =>  'footer_settings',
            'type'      =>  'tab',
            'icon'      =>  'feedback'
        );
        $field[] = array(
            'name'      =>  __( 'Active Large Footer?', 'better-studio' ),
            'id'        =>  'footer_large_active',
            'desc'      =>  __( 'Enabling this will adds the large footer to appears above the lowest footer. Used to contain large widgets.', 'better-studio' ),
            'type'      =>  'switchery',
            'std'       =>  'checked'
        );
        $field[] = array(
            'name'          =>  __('Large Footer Columns','better-studio'),
            'id'            =>  'footer_large_columns',
            'std'           =>  '3' ,
            'type'          =>  'image_radio',
            'section_class' =>  'style-floated-left bordered',
            'desc'          =>  __( 'Select weather you will show larger footer in 2,3 or 4 columns.', 'better-studio' ),
            'options' => array(
                '4' => array(
                    'img' => BETTER_MAG_ADMIN_ASSETS_URI . 'images/footer-4-column.png',
                    'label' => __('4 Column','better-studio'),
                ),
                '3' => array(
                    'img' => BETTER_MAG_ADMIN_ASSETS_URI . 'images/footer-3-column.png',
                    'label' => __('3 Column','better-studio'),
                ),
                '2' => array(
                    'img' => BETTER_MAG_ADMIN_ASSETS_URI . 'images/footer-2-column.png',
                    'label' => __('2 Column','better-studio'),
                ),
            )
        );
        $field[] = array(
            'name'      =>  __( 'Active Lower Footer?', 'better-studio' ),
            'id'        =>  'footer_lower_active',
            'desc'      =>  __( 'Enabling this will adds the smaller footer at bottom.', 'better-studio' ),
            'type'      =>  'switchery',
            'std'       =>  'checked'
        );




        /**
         * 5.4. => Content & Listing Options
         */
        $field[] = array(
            'name'      =>  __( 'Page & Posts' , 'better-studio' ),
            'id'        =>  'listings_settings',
            'type'      =>  'tab',
            'icon'      =>  'fa-th'
        );
            $field['archive_listing_style'] = array(
                'name'          =>  __( 'Archives Content Listing Style', 'better-studio' ),
                'id'            =>  'archive_listing_style',
                'std'           =>  'blog',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'desc'          =>  __( 'This style is used while browsing default blog format, searching, date archives etc.', 'better-studio' ),
                'options'       =>  array(
                    'blog'  => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-blog.png',
                        'label'     =>  __( 'Blog Listing', 'better-studio' ),
                    ),
                    'modern' => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-modern.png',
                        'label'     =>  __( 'Modern Listing', 'better-studio' ),
                    ),
                    'highlight' => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-highlight.png',
                        'label'     =>  __( 'Highlight Listing', 'better-studio' ),
                    ),
                    'classic' => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-classic.png',
                        'label'     =>  __( 'Classic Listing', 'better-studio' ),
                    ),
                )
            );
            $field['categories_listing_style'] = array(
                'name'          =>  __( 'Categories Content Listing Style', 'better-studio' ),
                'id'            =>  'categories_listing_style',
                'std'           =>  'blog',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'desc'          =>  __( 'This style is used while browsing categories archive pages. This can be overridden for each category.', 'better-studio' ),
                'options'       =>  array(
                    'blog'      => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-blog.png',
                        'label'     =>  __( 'Blog Listing', 'better-studio' ),
                    ),
                    'modern'    => array(
                        'img'       => BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-modern.png',
                        'label'     => __( 'Modern Listing', 'better-studio' ),
                    ),
                    'highlight' => array(
                        'img'       => BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-highlight.png',
                        'label'     => __( 'Highlight Listing', 'better-studio' ),
                    ),
                    'classic' => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-classic.png',
                        'label'     =>  __( 'Classic Listing', 'better-studio' ),
                    ),
                )
            );
            $field['tags_listing_style'] = array(
                'name'          =>  __( 'Tags Content Listing Style', 'better-studio' ),
                'id'            =>  'tags_listing_style',
                'std'           =>  'blog',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'desc'          =>  __( 'This style is used while browsing tags archive pages. This can be overridden for each tag.', 'better-studio' ),
                'options'       =>  array(
                    'blog'      =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-blog.png',
                        'label'     =>  __( 'Blog Listing', 'better-studio' ),
                    ),
                    'modern'    =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-modern.png',
                        'label'     =>  __( 'Modern Listing', 'better-studio' ),
                    ),
                    'highlight' => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-highlight.png',
                        'label'     =>  __( 'Highlight Listing', 'better-studio' ),
                    ),
                    'classic' => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-classic.png',
                        'label'     =>  __( 'Classic Listing', 'better-studio' ),
                    ),
                )
            );
            $field['authors_listing_style'] = array(
                'name'          =>  __( 'Authors Content Listing Style', 'better-studio' ),
                'id'            =>  'authors_listing_style',
                'std'           =>  'blog',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'desc'          =>  __( 'This style is used while browsing authors archive page.', 'better-studio' ),
                'options'       =>  array(
                    'blog'      =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-blog.png',
                        'label'     =>  __( 'Blog Listing', 'better-studio' ),
                    ),
                    'modern'    =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-modern.png',
                        'label'     =>  __( 'Modern Listing', 'better-studio' ),
                    ),
                    'highlight' => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-highlight.png',
                        'label'     =>  __( 'Highlight Listing', 'better-studio' ),
                    ),
                    'classic' => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/listing-style-classic.png',
                        'label'     =>  __( 'Classic Listing', 'better-studio' ),
                    ),
                )
            );
        $field[] = array(
            'name'      =>  __( 'General','better-studio' ),
            'type'      =>  'heading',
        );
            $field[] = array(
                'name'          =>  __( 'No Duplicate Posts In Homepage Blocks?', 'better-studio' ),
                'id'            =>  'bm_remove_duplicate_posts',
                'type'          =>  'switchery',
                'desc'          =>  __( 'If you have a lot of content or when you are using latest posts slider, you can see duplicate in featured area and homepage blocks. enabling this feature will remove duplicates.', 'better-studio'),
                'std'           =>  0,
            );
            $field[] = array(
                'name'          =>  __( 'Blog Listing Excerpt Length', 'better-studio' ),
                'id'            =>  'blog_listing_excerpt_length',
                'type'          =>  'text',
                'std'           =>  22,
            );
            $field[] = array(
                'name'          =>  __( 'Show "Read More..." Link In Blog Listing?', 'better-studio' ),
                'id'            =>  'show_read_more_blog_listing',
                'type'          =>  'switchery',
                'std'           =>  'checked',
            );
            $field[] = array(
                'name'          =>  __( 'Modern Listing Excerpt Length', 'better-studio' ),
                'id'            =>  'modern_listing_excerpt_length',
                'type'          =>  'text',
                'std'           =>  22,
            );
            $field[] = array(
                'name'          =>  __( 'Show author information box in single page?', 'better-studio' ),
                'id'            =>  'content_show_author_box',
                'desc'          =>  __( 'Enabling this will be adds author information box to  bottom of posts single page.', 'better-studio' ),
                'type'          =>  'switchery',
                'std'           =>  'checked',
            );
            $field[] = array(
                'name'          =>  __( 'Show post categories in single page?', 'better-studio' ),
                'id'            =>  'content_show_categories',
                'type'          =>  'switchery',
                'std'           =>  'checked',
            );
            $field[] = array(
                'name'          =>  __( 'Show post tags in single page?', 'better-studio' ),
                'id'            =>  'content_show_tags',
                'type'          =>  'switchery',
                'std'           =>  'checked',
            );
            if( function_exists( 'wp_pagenavi' ) ){
                $field[] = array(
                    'name'          =>  __( 'Use WP-PageNavi Plugin For Pagination?', 'better-studio' ),
                    'id'            =>  'use_wp_pagenavi',
                    'type'          =>  'switchery',
                    'std'           =>  'checked'
                );
            }
        $field[] = array(
            'name'      =>  __( 'Meta Info Settings', 'better-studio' ),
            'type'      =>  'heading',
        );
            $field[] = array(
                'name'          =>  __( 'Show Post Author Inside Posts Meta Info?', 'better-studio' ),
                'id'            =>  'meta_show_author',
                'type'          =>  'switchery',
                'std'           =>  true,
                'desc'          =>  __( 'You can hide post author inside post meta info for all content listings with disabling this option.', 'better-studio' ),
            );
            $field[] = array(
                'name'          =>  __( 'Show Post Comment Count Inside Posts Meta Info?', 'better-studio' ),
                'id'            =>  'meta_show_comment',
                'type'          =>  'switchery',
                'std'           =>  true,
                'desc'          =>  __( 'You can hide post comments count inside post meta info for all content listings with disabling this option.', 'better-studio' ),
            );
            $field[] = array(
                'name'          =>  __( 'Post Date Format Inside Meta Info', 'better-studio' ),
                'id'            =>  'meta_date_format',
                'type'          =>  'text',
                'std'           =>  'M j, Y',
            );
            $field[] = array(
                'name'          =>  __( 'Hide Post Meta in Single Posts', 'better-studio' ),
                'id'            =>  'meta_hide_in_single',
                'type'          =>  'switchery',
                'std'           =>  false,
                'desc'          =>  __( 'You can hide post meta ( date, author and comments ) inside single posts with enabling this option.', 'better-studio' ),
            );

        $field[] = array(
            'name'      =>  __( 'Post Navigation Links','better-studio' ),
            'type'      =>  'heading',
        );
            $field[] = array(
                'name'          =>  __( 'Show Previous and Next Posts in Single Page?', 'better-studio' ),
                'id'            =>  'bm_content_show_post_navigation',
                'desc'          =>  __( 'Enabling this will add a Previous and Next post link in the single post page.', 'better-studio' ),
                'type'          =>  'switchery',
                'std'           =>  '0',
            );
            $field[] = array(
                'name'          =>  __( 'Previous and Nest Posts Style', 'better-studio' ),
                'desc'          =>  __( 'Select style of Previous and Next posts link in single page.', 'better-studio' ),
                'id'            =>  'bm_content_post_navigation_style',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left',
                'options'       =>  array(
                    'style-1'      =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/post-navigation-style-1.png',
                        'label'     =>  __( 'Style 1', 'better-studio' ),
                    ),
                    'style-2'    =>  array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/post-navigation-style-2.png',
                        'label'     =>  __( 'Style 2', 'better-studio' ),
                    ),
                ),
                'std'           =>  'style-1',
            );
        $field[] = array(
            'name'      =>  __( 'Related Posts','better-studio' ),
            'type'      =>  'heading',
        );
            $field[] = array(
                'name'          =>  __( 'Show related posts in single page?', 'better-studio' ),
                'id'            =>  'content_show_related_posts',
                'desc'          =>  __( 'Enabling this will be adds related posts in  bottom of posts single page.', 'better-studio' ),
                'type'          =>  'switchery',
                'std'           =>  'checked',
            );

            $field[] = array(
                'name'          =>  __( 'Related Posts Algorithm', 'better-studio' ),
                'id'            =>  'content_show_related_posts_type',
                'type'          =>  'select',
                'options'       =>  array(
                    'cat'           =>  __( 'by Category', 'better-studio' ),
                    'tag'           =>  __( 'by Tag', 'better-studio' ),
                    'author'        =>  __( 'by Author', 'better-studio' ),
                    'cat-tag'       =>  __( 'by Category & Tag', 'better-studio' ),
                    'cat-tag-author'=>  __( 'by Category ,Tag & Author', 'better-studio' ),
                ),
                'std'           =>  'cat',
            );


        $field[] = array(
            'name'      =>  __('Share Box','better-studio'),
            'type'      =>  'heading',
        );
            $field[] = array(
                'name'          =>  __( 'Show Share Box In Posts Page?', 'better-studio' ),
                'desc'          =>  __( 'Enabling this will adds share links in posts single page. You can change design and social sites will following options.', 'better-studio' ),
                'id'            =>  'content_show_share_box',
                'type'          =>  'switchery',
                'std'           =>  'checked',
            );
            $field[] = array(
                'name'          =>  __( 'Share Box Title', 'better-studio' ),
                'id'            =>  'content_show_share_title',
                'type'          =>  'text',
                'std'           =>  __( 'Share', 'better-studio' ),
            );
            $field[] = array(
                'name'          =>  __( 'Share Box Location', 'better-studio' ),
                'desc'          =>  __( 'Select location of share box in posts single page.', 'better-studio' ),
                'id'            =>  'bm_share_box_location',
                'type'          =>  'select',
                'options'       =>  array(
                    'top'           =>  __( 'Top of post', 'better-studio' ),
                    'bottom'        =>  __( 'Bottom of post', 'better-studio' ),
                    'bottom-top'    =>  __( 'Both Top & Bottom of post', 'better-studio' ),
                ),
                'std'           =>  'bottom',
            );
            $field[] = array(
                'name'          =>  __( 'Drag and Drop To Sort The Items', 'better-studio' ),
                'id'            =>  'social_share_list',
                'desc'          =>  __( 'Enabling sites will adds share link for them in single pages. You can reorder sites too.', 'better-studio' ),
                'type'          =>  'sorter_checkbox',
                'std'           =>  array(
                    'facebook'      =>  true,
                    'twitter'       =>  true,
                    'google_plus'   =>  true,
                    'pinterest'     =>  true,
                    'linkedin'      =>  true,
                    'tumblr'        =>  true,
                    'email'         =>  true,
                ),
                'options'       =>  array(
                    'facebook'      =>  array(
                        'label'         =>  '<i class="fa fa-facebook"></i> ' . __( 'Facebook', 'better-studio' ),
                        'css-class'     =>  'active-item'
                    ),
                    'twitter'       =>  array(
                        'label'         =>  '<i class="fa fa-twitter"></i> ' . __( 'Twitter', 'better-studio' ),
                        'css-class'     =>  'active-item'
                    ),
                    'google_plus'   =>  array(
                        'label'         =>  '<i class="fa fa-google-plus"></i> ' . __( 'Google+', 'better-studio' ),
                        'css-class'     =>  'active-item'
                    ),
                    'pinterest'     =>  array(
                        'label'         =>  '<i class="fa fa-pinterest"></i> ' . __( 'Pinterest', 'better-studio' ),
                        'css-class'     =>  'active-item'
                    ),
                    'linkedin'      =>  array(
                        'label'         =>  '<i class="fa fa-linkedin"></i> ' . __( 'Linkedin', 'better-studio' ),
                        'css-class'     =>  'active-item'
                    ),
                    'tumblr'        =>  array(
                        'label'         =>  '<i class="fa fa-tumblr"></i> ' . __( 'Tumblr', 'better-studio' ),
                        'css-class'     =>  'active-item'
                    ),
                    'email'         =>  array(
                        'label'         =>  '<i class="fa fa-envelope "></i> ' . __( 'Email', 'better-studio' ),
                        'css-class'     =>  'active-item'
                    ),
                ),
                'section_class'     =>  'bf-social-share-sorter',
            );

            $field[] = array(
                'name'          =>  __( 'Share Box Style', 'better-studio' ),
                'id'            =>  'share_box_style',
                'desc'          =>  __( 'Select style of sharing buttons.', 'better-studio' ),
                'std'           =>  'button',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left',
                'options'       =>  array(
                    'button'    =>  array(
                        'label'     =>  __( 'Button Style' , 'better-studio' ),
                        'img'       =>  BF_URI . 'assets/img/vc-social-share-button.png'
                    ),
                    'button-no-text' => array(
                        'label'     =>  __( 'Icon Button Style' , 'better-studio' ),
                        'img'       =>  BF_URI . 'assets/img/vc-social-share-button-no-text.png'
                    ),
                    'outline-button' => array(
                        'label'     =>  __( 'Outline Style' , 'better-studio' ),
                        'img'       =>  BF_URI . 'assets/img/vc-social-share-outline-button.png'
                    ),
                    'outline-button-no-text' => array(
                        'label'     =>  __( 'Icon Outline Style' , 'better-studio' ),
                        'img'       =>  BF_URI . 'assets/img/vc-social-share-outline-button-no-text.png'
                    ),
                ),
            );

            $field[] = array(
                'name'      =>  __( 'Show Colored Style?', 'better-studio' ),
                'id'        =>  'share_box_colored',
                'desc'      =>  __( 'Enabling this will be show social share buttons in color mode and disabling this will be show in gray mode.', 'better-studio' ),
                'type'      =>  'switchery',
                'std'       =>  'checked'
            );


        /**
         * 5.5. => Typography Options
         */
        $field[] = array(
            'name'      =>  __( 'Typography' , 'better-studio' ),
            'id'        =>  'typo_settings',
            'type'      =>  'tab',
            'icon'      =>  'fa-font'
        );

        /**
         * 5.5.1. => General Typography
         */

        $field[] = array(
            'name'      =>  __( 'Reset Typography settings', 'better-studio' ),
            'id'        =>  'reset_typo_settings',
            'type'      =>  'ajax_action',
            'button-name' =>  'Reset Typography',
            'callback'  =>  'Better_Mag::reset_typography_options',
            'confirm'  =>  __( 'Are you sure for resetting typography?', 'better-studio' ),
            'desc'      =>  __( 'This allows you to reset all typography fields to default.', 'better-studio' )
        );


        $field[] = array(
            'name'      =>  __( 'General Typography', 'better-studio' ),
            'type'      =>  'heading',
        );

        $field['typo_body'] = array(
            'name'          =>  __( 'Base Font (Body)', 'better-studio' ),
            'id'            =>  'typo_body',
            'type'          =>  'typography',
            'std'           =>  array(
                'family'    =>  'Roboto',
                'variant'   =>  '500',
                'subset'    =>  'latin',
                'size'      =>  '14',
                'align'     =>  'inherit',
                'transform' =>  'initial',
                'color'     =>  '#5f6569',
            ),
            'std-full-dark' =>  array(
                'family'    =>  'Roboto',
                'variant'   =>  '500',
                'subset'    =>  'latin',
                'size'      =>  '14',
                'align'     =>  'inherit',
                'transform' =>  'initial',
                'color'     =>  '#e6e6e6',
            ),
            'std-full-black'=>  array(
                'family'    =>  'Roboto',
                'variant'   =>  '500',
                'subset'    =>  'latin',
                'size'      =>  '14',
                'align'     =>  'inherit',
                'transform' =>  'initial',
                'color'     =>  '#e6e6e6',
            ),
            'std-beige'     =>  array(
                'family'    =>  'Roboto',
                'variant'   =>  '500',
                'subset'    =>  'latin',
                'size'      =>  '14',
                'align'     =>  'inherit',
                'transform' =>  'initial',
                'color'     =>  '#493c0c',
            ),
            'std-clean-beige'=>  array(
                'family'    =>  'Roboto',
                'variant'   =>  '500',
                'subset'    =>  'latin',
                'size'      =>  '14',
                'align'     =>  'inherit',
                'transform' =>  'initial',
                'color'     =>  '#493c0c',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'Base typography for body that will affect all elements that haven\'t specified typography style. ', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   => 'paragraph',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector'  =>  'body',
                    'type'      =>  'font',
                )
            ),
        );

        $field['typo_heading'] = array(
            'name'          => __( 'Base Heading Typography', 'better-studio' ),
            'id'            => 'typo_heading',
            'type'          => 'typography',
            'std'           => array(
                'family'        => 'Arvo',
                'variant'       => '400',
                'subset'        => 'latin',
                'align'         => 'initial',
                'transform'     => 'initial',
                'color'         => '#444444'
            ),
            'std-full-dark'  => array(
                'family'        => 'Arvo',
                'variant'       => '400',
                'subset'        => 'latin',
                'align'         => 'initial',
                'transform'     => 'initial',
                'color'         => '#e6e6e6'
            ),
            'std-full-black'    => array(
                'family'        => 'Arvo',
                'variant'       => '400',
                'subset'        => 'latin',
                'align'         => 'initial',
                'transform'     => 'initial',
                'color'         => '#e6e6e6'
            ),
            'std-beige'     => array(
                'family'        => 'Arvo',
                'variant'       => '400',
                'subset'        => 'latin',
                'align'         => 'initial',
                'transform'     => 'initial',
                'color'         => '#493c0c'
            ),
            'std-clean-beige'     => array(
                'family'        => 'Arvo',
                'variant'       => '400',
                'subset'        => 'latin',
                'align'         => 'initial',
                'transform'     => 'initial',
                'color'         => '#493c0c'
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'beige',
                'full-black',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'Base heading typography that will be set to all headings (h1,h2 etc) and all titles of sections and pages that must be bolder than other texts.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector'  => array(
                        'h1,h2,h3,h4,h5,h6',
                        '.header .logo a',
                        '.block-modern h2.title a',
                        '.main-menu .block-modern h2.title a',
                        '.blog-block h2 a',
                        '.main-menu .blog-block h2 a',
                        '.block-highlight .title',
                        '.listing-thumbnail h3.title a',
                        '.main-menu .listing-thumbnail h3.title a',
                        '.listing-simple li h3.title a',
                        '.main-menu .listing-simple li h3.title a',
                        '.widget li',
                    ),
                    'type'      => 'font',
                ),
                // WooCommerce Heading Style
                array(
                    'selector'  => array(
                        '.woocommerce ul.cart_list li a',
                        '.woocommerce ul.product_list_widget li a',
                        '.woocommerce-page ul.cart_list li a',
                        '.woocommerce-page ul.product_list_widget li a',
                        '.woocommerce ul.products li.product h3',
                        '.woocommerce-page ul.products li.product h3',
                        '.woocommerce-account .woocommerce .address .title h3',
                        '.woocommerce-account .woocommerce h2',
                        '.cross-sells h2',
                        '.related.products h2',
                        '.woocommerce #reviews h3',
                        '.woocommerce-page #reviews h3',
                        '.woocommerce-tabs .panel.entry-content h2',
                        '.woocommerce .shipping_calculator h2',
                        '.woocommerce .cart_totals h2',
                        'h3#order_review_heading',
                        '.woocommerce-shipping-fields h3',
                        '.woocommerce-billing-fields h3',
                    ),
                    'type'      => 'font',
                    'filter'    => array( 'woocommerce' ),
                ),

                // bbPress Heading Style
                array(
                    'selector'  =>  array(
                        '#bbpress-forums li.bbp-header .forum-titles .bbp-forum-info a',
                        '#bbpress-forums li.bbp-header .forum-titles .bbp-forum-info',
                        '#bbpress-forums li.bbp-header li.bbp-forum-topic-reply-count',
                        'li.bbp-forum-freshness',
                        'li.bbp-topic-freshness',
                        '#bbpress-forums li.bbp-forum-info .bbp-forum-title',
                        '#bbpress-forums p.bbp-topic-meta .bbp-author-name',
                        '#bbpress-forums .bbp-forums-list li',
                        'li.bbp-topic-freshness',
                        'li.bbp-topic-reply-posts-count',
                        'li.bbp-topic-title',
                        '#bbpress-forums p.bbp-topic-meta .bbp-author-name',
                        '#bbpress-forums div.bbp-reply-content .reply-meta .bbp-reply-post-author',
                        '.widget_display_stats dl dt',
                        '.widget_display_topics li a',
                        '.widget_display_topics li a.bbp-forum-title',
                        '.widget_display_replies li a.bbp-reply-topic-title',
                        '.widget_display_forums li a',
                    ),
                    'type'      =>  'font',
                    'filter'    =>  array( 'bbpress' ),
                ),

            ),
        );

        $field['typo_heading_page'] = array(
            'name'          => __( 'Pages/Posts Title Typography', 'better-studio' ),
            'id'            => 'typo_heading_page',
            'type'          => 'typography',
            'std'           => array(
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '18',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#444444'
            ),
            'std-full-dark' => array(
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '18',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-full-black' => array(
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '18',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-beige'     => array(
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '18',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'std-clean-beige'=> array(
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '18',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector'  => array(
                        '.page-heading',
                        '.page-heading span.h-title',
                    ),
                    'type'      => 'font',
                ),
            ),
        );

        $field['typo_heading_section'] = array(
            'name'          => __( 'Sections/Listings Title Typography', 'better-studio' ),
            'id'            => 'typo_heading_section',
            'type'          => 'typography',
            'std'           => array(
                'family'        =>  'Roboto',
                'variant'       =>  '500',
                'size'          =>  '14',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'uppercase',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector'  => array(
                        '.section-heading.extended .other-links .other-item a',
                        '.section-heading span.h-title',
                    ),
                    'type'      => 'font',
                ),
            ),
        );

        $field['typo_meta'] = array(
            'name'          =>  __( 'Base Meta Typography', 'better-studio' ),
            'id'            =>  'typo_meta',
            'type'          =>  'typography',
            'std'           =>  array(
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#919191',
            ),
            'std-full-dark' =>  array(
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#f7f7f7',
            ),
            'std-full-black' =>  array(
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#f7f7f7',
            ),
            'std-beige'     =>  array(
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'Base style for all posts, pages and listings meta data (date, author etc) sections. This can be overridden for each listings.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   => 'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.mega-menu .meta',
                        '.mega-menu .meta span',
                        '.mega-menu .meta a',
                        '.the-content .meta a',
                        '.meta a',
                        '.meta span',
                        '.meta',
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typo_excerpt'] = array(
            'name'          =>  __( 'Base Excerpt Typography', 'better-studio' ),
            'id'            =>  'typo_excerpt',
            'type'          =>  'typography',
            'std'           => array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#717171',
            ),
            'std-full-dark' => array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-full-black' => array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-beige'     => array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'std-clean-beige'=> array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'General excerpts typography. This can overridden for each listing.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  => true,
            'css'           =>  array(
                array(
                    'selector' => array(
                        '.blog-block .summary p, .blog-block .summary',
                        '.block-modern .summary p, .block-modern .summary',
                    ),
                    'type'  => 'font',
                )
            ),
        );



        /**
         * 5.5.8. => Pages/Posts Content Typography
         */
        $field[] = array(
            'name'  =>  __( 'Pages/Posts Content Typography', 'better-studio' ),
            'type'  =>  'heading',
        );

        $field['typ_content_text'] = array(
            'name'          =>  __( 'Posts/Pages Text Typography', 'better-studio' ),
            'id'            =>  'typ_content_text',
            'type'          =>  'typography',
            'std'           =>  array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'line_height'   =>  '24',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
                'color'         =>  '#5f6569',
            ),
            'std-full-dark' =>  array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'line_height'   =>  '24',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-full-black'=>  array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'line_height'   =>  '24',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-beige'     =>  array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'line_height'   =>  '24',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'std-clean-beige'     =>  array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'line_height'   =>  '24',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'preview'       =>  true,
            'preview_tab'   =>  'paragraph',
            'css-echo-default'  => true,
            'css'   => array(
                array(
                    'selector' => array(
                        '.the-content',
                        '.the-content p',
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typ_content_blockquote'] = array(
            'name'          =>  __( 'Blockquote Typography', 'better-studio' ),
            'id'            =>  'typ_content_blockquote',
            'type'          =>  'typography',
            'std'           =>  array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
            ),
            'std-full-dark' => array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
            ),
            'std-full-black'=>  array(
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'preview'       =>  true,
            'preview_tab'   =>  'paragraph',
            'css-echo-default'  => true,
            'css'   => array(
                array(
                    'selector' => array(
                        'blockquote',
                        'blockquote p',
                        '.the-content blockquote p',
                    ),
                    'type'  => 'font',
                )
            ),
        );



        /**
         * 5.5.7. => Header Typography
         */
        $field[] = array(
            'name'  =>  __('Header Typography','better-studio'),
            'type'  =>  'heading',
        );


        $field['typ_header_menu'] = array(
            'name'          =>  __( 'Menu Typography', 'better-studio' ),
            'id'            =>  'typ_header_menu',
            'type'          =>  'typography',
            'std'           =>  array(
                'family'        =>  'Roboto',
                'variant'       =>  '500',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'uppercase',
            ),
            'std-full-dark' =>  array(
                'family'        =>  'Roboto',
                'variant'       =>  '500',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'uppercase',
            ),
            'std-full-black'=>  array(
                'family'        =>  'Roboto',
                'variant'       =>  '500',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'uppercase',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.main-menu .menu a',
                        '.main-menu .menu li',
                        '.main-menu .main-menu-container.mobile-menu-container .mobile-button',
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typ_header_menu_badges'] = array(
            'name'          =>  __( 'Menu Badges Typography', 'better-studio' ),
            'id'            =>  'typ_header_menu_badges',
            'type'          =>  'typography',
            'std'           =>  array(
                'family'        =>  'Roboto',
                'variant'       =>  '500',
                'subset'        =>  'latin',
                'size'          =>  '11',
                'transform'     =>  'uppercase',
            ),
            'std-full-dark' =>  array(
                'family'        =>  'Roboto',
                'variant'       =>  '500',
                'subset'        =>  'latin',
                'size'          =>  '11',
                'transform'     =>  'uppercase',
            ),
            'std-full-black'=>  array(
                'family'        =>  'Roboto',
                'variant'       =>  '500',
                'subset'        =>  'latin',
                'size'          =>  '11',
                'transform'     =>  'uppercase',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.main-menu .menu .better-custom-badge',
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typ_header_logo'] = array(
            'name'          =>  __( 'Logo Text Typography', 'better-studio' ),
            'id'            =>  'typ_header_logo',
            'type'          =>  'typography',
            'std'           =>  array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '30',
                'transform'     =>  'initial',
                'color'         =>  '#444444'
            ),
            'std-full-dark' =>  array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '30',
                'transform'     =>  'initial',
                'color'         =>  '#3e6e6e6'
            ),
            'std-full-black'=>  array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '30',
                'transform'     =>  'initial',
                'color'         =>  '#3e6e6e6'
            ),
            'std-beige'     =>  array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '30',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'std-clean-beige'=>  array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '30',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can change logo text typography with enabling this option.', '' ),
            'preview'       => true,
            'preview_tab'   => 'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector' => array(
                        'body header .logo',
                        'body header .logo a'
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typ_header_site_desc'] = array(
            'name'          =>  __( 'Blog Description Typography', 'better-studio' ),
            'id'            =>  'typ_header_site_desc',
            'type'          =>  'typography',
            'std'           => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
                'color'         =>  '#444444'
            ),
            'std-full-dark'  => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-full-black' => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-beige' => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'std-clean-beige' => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '14',
                'align'         =>  'inherit',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can change typography of site description (below logo) typography with enabling this option.', '' ),
            'preview'       => true,
            'preview_tab'   => 'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector' => array(
                        'body header .site-description'
                    ),
                    'type'  => 'font',
                )
            ),
        );


        /**
         * 5.5.2. => Blog Listing Typography
         */
        $field[] = array(
            'name'  =>  __( 'Blog Listing Typography', 'better-studio' ),
            'type'  =>  'heading',
        );

        $field['typo_listing_blog_heading'] = array(
            'name'          =>  __( 'Blog Listing Heading Typography', 'better-studio' ),
            'id'            =>  'typo_listing_blog_heading',
            'type'          =>  'typography',
            'std'           =>  array(
                'enable'        => false,
                'family'        => 'Arvo',
                'variant'       => '400',
                'size'          => '15',
                'subset'        => 'latin',
                'align'         => 'initial',
                'transform'     => 'initial',
                'color'         => '#444444'
            ),
            'std-full-dark' =>  array(
                'enable'        => false,
                'family'        => 'Arvo',
                'variant'       => '400',
                'size'          => '15',
                'subset'        => 'latin',
                'align'         => 'initial',
                'transform'     => 'initial',
                'color'         => '#e6e6e6'
            ),
            'std-full-black' =>  array(
                'enable'        => false,
                'family'        => 'Arvo',
                'variant'       => '400',
                'size'          => '15',
                'subset'        => 'latin',
                'align'         => 'initial',
                'transform'     => 'initial',
                'color'         => '#e6e6e6'
            ),
            'std-beige'     =>  array(
                'enable'        => false,
                'family'        => 'Arvo',
                'variant'       => '400',
                'size'          => '15',
                'subset'        => 'latin',
                'align'         => 'initial',
                'transform'     => 'initial',
                'color'         => '#493c0c'
            ),
            'std-clean-beige'=>  array(
                'enable'        => false,
                'family'        => 'Arvo',
                'variant'       => '400',
                'size'          => '15',
                'subset'        => 'latin',
                'align'         => 'initial',
                'transform'     => 'initial',
                'color'         => '#493c0c'
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can override heading typography of blog listing elements with enabling this option.', '' ),
            'preview'       =>  true,
            'preview_tab'   => 'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.blog-block h2',
                        '.blog-block h2 a',
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typo_listing_blog_meta'] = array(
            'name'          =>  __( 'Blog Listing Meta Typography', 'better-studio' ),
            'id'            =>  'typo_listing_blog_meta',
            'type'          =>  'typography',
            'std'           => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#919191',
            ),
            'std-full-dark' => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-full-black'=> array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-beige'     => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'std-clean-beige'=> array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),

            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can override meta typography of blog listing elements with enabling this option.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  =>  true,
            'css'   => array(
                array(
                    'selector' => array(
                        '.mega-menu .blog-block .meta',
                        '.mega-menu .blog-block .meta span',
                        '.mega-menu .blog-block .meta a',
                        '.the-content .blog-block .meta a',
                        '.blog-block .meta a',
                        '.blog-block .meta span',
                        '.blog-block .meta',
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typo_listing_blog_excerpt'] = array(
            'name'          =>  __( 'Blog Listing Excerpt Typography', 'better-studio' ),
            'id'            =>  'typo_listing_blog_excerpt',
            'type'          =>  'typography',
            'std'           =>  array(
                'enable'        =>  false,
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#717171',
            ),
            'std-full-dark' =>  array(
                'enable'        =>  false,
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-full-black'=>  array(
                'enable'        =>  false,
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-beige'     =>  array(
                'enable'        =>  false,
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'std-clean-beige'=>  array(
                'enable'        =>  false,
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can override excerpt typography of blog listing elements with enabling this option.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  =>  true,
            'css'   => array(
                array(
                    'selector' => array(
                        '.blog-block .summary p, .blog-block .summary',
                    ),
                    'type'  => 'font',
                )
            ),
        );


        /**
         * 5.5.3. => Modern Listing Typography
         */
        $field[] = array(
            'name'  =>  __( 'Modern Listing Typography', 'better-studio' ),
            'type'  =>  'heading',
        );
        $field['typo_listing_modern_heading'] = array(
            'name'          =>  __( 'Modern Listing Heading typography', 'better-studio' ),
            'id'            =>  'typo_listing_modern_heading',
            'type'          =>  'typography',
            'std'           => array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '15',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#444444'
            ),
            'std-full-dark' => array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '15',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-full-black'=> array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '15',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-beige'     => array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '15',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'std-clean-beige'=> array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '15',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can override heading typography of modern listing elements with enabling this option.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   => 'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.block-modern h2.title',
                        '.block-modern h2.title a',
                        '.main-menu .block-modern h2.title',
                        '.main-menu .block-modern h2.title a',
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typo_listing_modern_meta'] = array(
            'name'          =>  __( 'Modern Listing Meta Typography', 'better-studio' ),
            'id'            =>  'typo_listing_modern_meta',
            'type'          =>  'typography',
            'std'           => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#919191',
            ),
            'std-full-dark'  => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-full-black'=> array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-beige'     => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'std-clean-beige'     => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'              =>  __( 'You can override meta typography of modern listing elements with enabling this option.', 'better-studio' ),
            'preview'           =>  true,
            'preview_tab'       =>  'title',
            'css-echo-default'  =>  true,
            'css'               =>  array(
                array(
                    'selector' => array(
                        '.the-content .block-modern .meta a',
                        '.block-modern .meta a',
                        '.block-modern .meta span',
                        '.block-modern .meta',
                        '.mega-menu .block-modern .meta',
                        '.mega-menu .block-modern .meta span',
                        '.mega-menu .block-modern .meta a',
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typo_listing_modern_excerpt'] = array(
            'name'          =>  __( 'Modern Listing Excerpt Typography', 'better-studio' ),
            'id'            =>  'typo_listing_modern_excerpt',
            'type'          =>  'typography',
            'std'           => array(
                'enable'        =>  false,
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#717171',
            ),
            'std-full-dark' => array(
                'enable'        =>  false,
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-full-black'=> array(
                'enable'        =>  false,
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-beige'     => array(
                'enable'        =>  false,
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'std-clean-beige'     => array(
                'enable'        =>  false,
                'family'        =>  'Roboto Slab',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '13',
                'line_height'   =>  '20',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          => __( 'You can override excerpt typography of modern listing elements with enabling this option.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  =>  true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.block-modern .summary p',
                        '.block-modern .summary',
                    ),
                    'type'  => 'font',
                )
            ),
        );


        /**
         * 5.5.4. => Highlight Listing Typography
         */
        $field[] = array(
            'name'  =>  __( 'Highlight Listing Typography', 'better-studio' ),
            'type'  =>  'heading',
        );
        $field['typo_listing_highlight_heading'] = array(
            'name'          =>  __( 'Highlight Listing Heading Typography', 'better-studio' ),
            'id'            =>  'typo_listing_highlight_heading',
            'type'          =>  'typography',
            'std'           =>  array(
                'enable'        => false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '15',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#444444'
            ),
            'std-full-dark' =>  array(
                'enable'        => false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '15',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-full-black'=>  array(
                'enable'        => false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '15',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-beige'     =>  array(
                'enable'        => false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '15',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'std-clean-beige'     =>  array(
                'enable'        => false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '15',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can override heading typography of highlight listing elements with enabling this option.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.listing-thumbnail h3.title',
                        '.listing-thumbnail h3.title a',
                        '.mega-menu .listing-thumbnail h3.title a',
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typo_listing_highlight_meta'] = array(
            'name'          =>  __( 'Highlight Listing Meta Typography', 'better-studio' ),
            'id'            =>  'typo_listing_highlight_meta',
            'type'          =>  'typography',
            'std'           => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#919191',
            ),
            'std-full-dark' => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-full-black'=> array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-beige'     => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'std-clean-beige'=> array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can override meta typography of highlight listing elements with enabling this option.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  =>  true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.the-content .block-highlight .meta a',
                        '.block-highlight .meta a',
                        '.block-highlight .meta span',
                        '.block-highlight .meta',
                        '.mega-menu .block-highlight .meta',
                        '.mega-menu .block-highlight .meta span',
                        '.mega-menu .block-highlight .meta a',
                    ),
                    'type'  => 'font',
                )
            ),
        );


        /**
         * 5.5.5. => Thumbnail Listing Typography
         */
        $field[] = array(
            'name'  =>  __( 'Thumbnail Listing Typography', 'better-studio' ),
            'id'    =>  'typo_listing_thumbnail_header',
            'type'  =>  'heading',
        );
        $field['typo_listing_thumbnail_heading'] = array(
            'name'          =>  __( 'Thumbnail Listing Heading Typography', 'better-studio' ),
            'id'            =>  'typo_listing_thumbnail_heading',
            'type'          =>  'typography',
            'std'           =>  array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '13',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#444444'
            ),
            'std-full-dark' =>  array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '13',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-full-black'=>  array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '13',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-beige'     =>  array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '13',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'std-clean-beige'=>  array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '13',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can override heading typography of thumbnail listing elements with enabling this option.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.listing-thumbnail h3.title a',
                        '.listing-thumbnail h3.title',
                        '.main-menu .listing-thumbnail h3.title',
                        '.main-menu .listing-thumbnail h3.title a',
                    ),
                    'type'  => 'font',
                )
            ),
        );

        $field['typo_listing_thumbnail_meta'] = array(
            'name'          =>  __( 'Thumbnail Listing Meta Typography', 'better-studio' ),
            'id'            =>  'typo_listing_thumbnail_meta',
            'type'          =>  'typography',
            'std'           => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#919191',
            ),
            'std-full-dark' => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-full-black'=> array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6',
            ),
            'std-beige'     => array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'std-clean-beige'=> array(
                'enable'        =>  false,
                'family'        =>  'Roboto',
                'variant'       =>  '400',
                'subset'        =>  'latin',
                'size'          =>  '12',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c',
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can override meta typography of thumbnail listing elements with enabling this option.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  =>  true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.the-content .listing-thumbnail li .meta a',
                        '.listing-thumbnail li .meta a',
                        '.listing-thumbnail li .meta span',
                        '.listing-thumbnail li .meta',
                    ),
                    'type'  => 'font',
                )
            ),
        );


        /**
         * 5.5.6. => Simple Listing Typography
         */
        $field[] = array(
            'name'  =>  __( 'Simple Listing Typography', 'better-studio' ),
            'type'  =>  'heading',
        );
        $field['typo_listing_simple_heading'] = array(
            'name'          => __( 'Simple Listing Heading Typography', 'better-studio' ),
            'id'            => 'typo_listing_simple_heading',
            'type'          => 'typography',
            'std'           => array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '13',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#444444'
            ),
            'std-full-dark' => array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '13',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-full-black'=> array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '13',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#e6e6e6'
            ),
            'std-beige'     => array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '13',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'std-clean-beige'     => array(
                'enable'        =>  false,
                'family'        =>  'Arvo',
                'variant'       =>  '400',
                'size'          =>  '13',
                'subset'        =>  'latin',
                'align'         =>  'initial',
                'transform'     =>  'initial',
                'color'         =>  '#493c0c'
            ),
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'You can override heading typography of simple listing elements with enabling this option.', 'better-studio' ),
            'preview'       =>  true,
            'preview_tab'   =>  'title',
            'css-echo-default'  => true,
            'css'           => array(
                array(
                    'selector' => array(
                        '.listing-simple li h3.title',
                        '.listing-simple li h3.title a',
                        '.main-menu .listing-simple li h3.title',
                        '.main-menu .listing-simple li h3.title a',
                    ),
                    'type'  => 'font',
                )
            ),
        );


        /**
         * 5.6. => Color Options
         */
        $field[] = array(
            'name'      =>  __( 'Style & Color', 'better-studio' ),
            'id'        =>  'color_settings',
            'type'      =>  'tab',
            'icon'      =>  'art'
        );
        $field['style'] = array(
            'name'          =>  __( 'Pre-defined Styles', 'better-studio' ),
            'id'            =>  'style',
            'std'           =>  'default',
            'type'          =>  'image_select',
            'section_class' =>  'style-floated-left bordered',
            'options'       => array(
                'default'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-better-mag-silver.png',
                    'label'     =>  __( 'Silver Skin (Default)', 'better-studio' ),
                ),
                'beige'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-better-mag-beige.png',
                    'label'     =>  __( 'Beige Skin', 'better-studio' ),
                ),
                'black'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-better-mag-black.png',
                    'label'     =>  __( 'Half Black Skin', 'better-studio' ),
                ),
                'full-black'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-better-mag-full-black.png',
                    'label'     =>  __( 'Full Black Skin', 'better-studio' ),
                ),
                'dark'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-better-mag-dark.png',
                    'label'     =>  __( 'Half Dark Skin', 'better-studio' ),
                ),
                'full-dark'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-better-mag-full-dark.png',
                    'label'     =>  __( 'Full Dark Skin', 'better-studio' ),
                ),
                'blue1'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-better-mag-blue1.png',
                    'label'     =>  __( 'Blue 1 Skin', 'better-studio' ),
                ),
                'blue2'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-better-mag-blue2.png',
                    'label'     =>  __( 'Blue 2 Skin', 'better-studio' ),
                ),
                'green'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-better-mag-green.png',
                    'label'     =>  __( 'Green Skin', 'better-studio' ),
                ),
                'clean'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-clean-mag-silver.png',
                    'label'     =>  __( 'Clean - Silver Skin', 'better-studio' ),
                ),
                'clean-beige'  => array(
                    'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/style-clean-mag-beige.png',
                    'label'     =>  __( 'Clean - Beige Skin', 'better-studio' ),
                ),

            ),
            'desc'          => __( 'Select a predefined style or create your own customized one below. <br><br> <strong>WARNING :</strong> With changing style some color and other options will be changes.', 'better-studio' )
        );

        /**
         * 5.6.1. => General Colors
         */
        $field[] = array(
            'name'      =>  __( 'General Colors', 'better-studio' ),
            'type'      =>  'heading',
        );
        $field['theme_color'] = array(
            'name'          =>   __( 'Theme Color', 'better-studio' ),
            'id'            =>  'theme_color',
            'type'          =>  'color',
            'std'           =>  '#e44e4f',
            'std-green'     =>  '#398315',
            'std-blue1'     =>  '#41638a',
            'std-blue2'     =>  '#0ca4dd',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'It is the contrast color for the theme. It will be used for all links, menu, category overlays, main page and many contrasting elements.', 'better-studio' ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-bg-color,.main-bg-color',
                        '.bf-news-ticker .heading',
                        '.main-menu .menu .better-custom-badge',
                        '.widget.widget_nav_menu .menu .better-custom-badge',
                        'body .mejs-controls .mejs-time-rail .mejs-time-current',
                        '.widget.widget_nav_menu li a:hover',
                        '.btn-read-more',
                        '.pagination > span,.pagination .wp-pagenavi a:hover,.pagination .page-numbers:hover',
                        '.pagination .wp-pagenavi .current,.pagination .current',
                        '.flex-control-nav li a.flex-active, .flex-control-nav li:hover a',
                        '.term-title a',
                        '.rating-bar span',
                        'input[type=submit],.button-primary,.btn-read-more',
                        '.main-menu .menu > li.random-post:hover > a',
                        '.main-menu .main-menu-container.mobile-menu-container .mobile-button .fa',
                        '.section-heading.extended .other-links .other-item:hover a',
                        '.section-heading.extended.tab-heading .other-links .other-item.active a',
                        '.page-heading:before',
                        'body .mejs-controls .mejs-time-rail .mejs-time-current',
                        '.comments li.comment.bypostauthor > article.comment .comment-edit-link',
                        '.comments li.comment.bypostauthor > article.comment .comment-reply-link',
                        '.comments .comment-respond #cancel-comment-reply-link',
                        '.comments .comment-respond .form-submit input[type=submit]',
                        '.widget.widget_nav_menu li a:hover',
                        '.betterstudio-review .verdict .overall',
                        '.error404 .content-column .search-form .search-submit',
                        '.main-menu .search-item .search-form:hover,.main-menu .search-item .search-form.have-focus',
                        'span.dropcap.square',
                        'span.dropcap.circle',
                        '.block-user-row .posts-count',
                        '.block-user-modern .posts-count',
                    ),
                    'prop'      => array(
                        'background-color' =>   '%%value%%',
                    )
                ),
                array(
                    'selector'  =>  array(
                        '.main-color',
                        '.bf-news-ticker ul.news-list li a:hover',
                        '.bf-news-ticker ul.news-list li a:focus',
                        '.rating-stars span:before',
                        '.footer-lower-wrapper a:hover',
                        '.bf-breadcrumb .trail-browse',
                        '.comments li.comment.bypostauthor > article.comment .comment-author a',
                        '.comments li.comment.bypostauthor > article.comment .comment-author',
                        '.widget.widget_calendar table td a',
                        '.widget .tagcloud a:hover',
                        'span.dropcap.circle-outline',
                        'span.dropcap.square-outline',
                        '.the-content.site-map ul li a:hover',
                        '.tab-content-listing .tab-read-more a',
                        '.widget .tab-read-more a:hover',
                        '.archive-section a:hover',
                    ),
                    'prop'      =>  array( 'color' )
                ),
                array(
                    'selector'  =>  array(
                        '.top-bar .widget.widget_nav_menu li:hover > a',
                    ),
                    'prop'      =>  array(
                        'background-color' => "%%value%% !important",
                    )
                ),
                array(
                    'selector'  =>  array(
                        '.main-menu .menu > li:hover > a',
                        '.main-menu .menu > .current-menu-ancestor > a',
                        '.main-menu .menu > .current-menu-parent > a',
                        '.main-menu .menu > .current-menu-item > a',
                        '.widget.widget_recent_comments a:hover',
                        '.footer-larger-widget.widget.widget_recent_comments a:hover',
                        '.comments li.comment.bypostauthor > article.comment',
                        '.section-heading.extended.tab-heading',
                    ),
                    'prop'      =>  array( 'border-bottom-color' )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .menu .better-custom-badge:after',
                    ),
                    'prop'      => array( 'border-top-color' )
                ),
                array(
                    'selector'  => array(
                        '.bf-news-ticker .heading:after',
                        '.main-menu .menu .sub-menu .better-custom-badge:after',
                        '.rtl .main-menu .mega-menu .menu-badge-right > a > .better-custom-badge:after',
                        'body .main-menu .menu .mega-menu .menu-badge-left > a > .better-custom-badge:after',
                    ),
                    'prop'      => array( 'border-left-color' )
                ),
                array(
                    'selector'  =>  array(
                        '.rtl .bf-news-ticker .heading:after',
                        '.main-menu .mega-menu .menu-badge-right > a > .better-custom-badge:after',
                        '.widget.widget_nav_menu .menu .better-custom-badge:after',
                    ),
                    'prop'      =>  array( 'border-right-color' )
                ),
                array(
                    'selector'  =>  array(
                        '.widget .tagcloud a:hover',
                        'span.dropcap.circle-outline',
                        'span.dropcap.square-outline',
                        '.better-gallery .fotorama__thumb-border',
                    ),
                    'prop'      =>  array( 'border-color' )
                ),
                array(
                    'selector'  =>  array(
                        'div.pp_default .pp_gallery ul li a:hover',
                        'div.pp_default .pp_gallery ul li.selected a',
                    ),
                    'prop'      =>  array( 'border-color' => '%%value%% !important' )
                ),
                array(
                    'selector'  =>  array(
                        '::selection'
                    ),
                    'prop'      =>  array( 'background' )
                ),
                array(
                    'selector'  =>  array(
                        '::-moz-selection'
                    ),
                    'prop'      =>  array( 'background' )
                ),
                // WooCommerce styles if is active
                array(
                    'selector'  =>  array(
                        '.bm-wc-cart .cart-link .total-items',
                        '.main-wrap ul.product_list_widget li del, .main-wrap ul.product_list_widget li .amount',
                        '.woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before',
                        '.woocommerce #content div.product p.price del, .woocommerce #content div.product span.price del, .woocommerce div.product p.price del, .woocommerce div.product span.price del, .woocommerce-page #content div.product p.price del, .woocommerce-page #content div.product span.price del, .woocommerce-page div.product p.price del, .woocommerce-page div.product span.price del, .woocommerce ul.products li.product .price del, .woocommerce-page ul.products li.product .price del',
                        '.woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price',
                        '.woocommerce .star-rating span:before,.woocommerce-page .star-rating span:before',
                        '.woocommerce p.stars a.star-1.active:after,.woocommerce p.stars a.star-2.active:after,.woocommerce p.stars a.star-3.active:after,.woocommerce p.stars a.star-4.active:after,.woocommerce p.stars a.star-5.active:after,.woocommerce-page p.stars a.star-1.active:after,.woocommerce-page p.stars a.star-2.active:after,.woocommerce-page p.stars a.star-3.active:after,.woocommerce-page p.stars a.star-4.active:after,.woocommerce-page p.stars a.star-5.active:after',
                        '.woocommerce #content table.cart a.remove,.woocommerce table.cart a.remove,.woocommerce-page #content table.cart a.remove,.woocommerce-page table.cart a.remove',
                    ),
                    'prop'      =>  'color',
                    'filter'    =>  array( 'woocommerce' ),
                ),
                array(
                    'selector'  =>  array(
                        '.woocommerce span.onsale, .woocommerce-page span.onsale, .woocommerce ul.products li.product .onsale, .woocommerce-page ul.products li.product .onsale',
                        'a.button.add_to_cart_button:hover',
                        '.woocommerce #content input.button:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce-page #content input.button:hover,.woocommerce-page #respond input#submit:hover,.woocommerce-page a.button:hover,.woocommerce-page button.button:hover,.woocommerce-page input.button:hover,.woocommerce #payment #place_order, .woocommerce-page #payment #place_order,.woocommerce #review_form #respond .form-submit input:hover,.woocommerce-page #review_form #respond .form-submit input:hover,button.button.single_add_to_cart_button.alt:hover',
                        '.woocommerce-account .woocommerce .address .title h3:before,.woocommerce-account .woocommerce h2:before,.cross-sells h2:before,.related.products h2:before,.woocommerce #reviews h3:before,.woocommerce-page #reviews h3:before,.woocommerce-tabs .panel.entry-content h2:before,.woocommerce .shipping_calculator h2:before,.woocommerce .cart_totals h2:before,h3#order_review_heading:before ,.woocommerce-shipping-fields h3:before ,.woocommerce-billing-fields h3:before ',
                        '.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active,.woocommerce div.product .woocommerce-tabs ul.tabs li.active,.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active,.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active',
                        '.woocommerce #content table.cart a.remove:hover,.woocommerce table.cart a.remove:hover,.woocommerce-page #content table.cart a.remove:hover,.woocommerce-page table.cart a.remove:hover',
                        '.woocommerce .cart-collaterals .shipping_calculator .button, .woocommerce-page .cart-collaterals .shipping_calculator .button,.woocommerce .cart .button.checkout-button,.woocommerce .cart .button:hover,.woocommerce .cart input.button:hover,.woocommerce-page .cart .button:hover,.woocommerce-page .cart input.button:hover',
                        '.main-wrap .mega-menu.cart-widget.widget_shopping_cart .buttons a',
                        '.main-wrap .widget.widget_price_filter .ui-slider-range',
                        '.main-wrap .widget.widget_price_filter .ui-slider .ui-slider-handle',
                        '.woocommerce .widget_layered_nav ul li.chosen a,.woocommerce-page .widget_layered_nav ul li.chosen a',
                        '.woocommerce #content .quantity .minus:hover,.woocommerce #content .quantity .plus:hover,.woocommerce .quantity .minus:hover,.woocommerce .quantity .plus:hover,.woocommerce-page #content .quantity .minus:hover,.woocommerce-page #content .quantity .plus:hover,.woocommerce-page .quantity .minus:hover,.woocommerce-page .quantity .plus:hover',
                    ),
                    'prop'      =>  'background-color',
                    'filter'    =>  array( 'woocommerce' ),
                ),
                array(
                    'selector'  =>  array(
                        '.woocommerce #content div.product .woocommerce-tabs ul.tabs,.woocommerce div.product .woocommerce-tabs ul.tabs,.woocommerce-page #content div.product .woocommerce-tabs ul.tabs,.woocommerce-page div.product .woocommerce-tabs ul.tabs',
                        '.woocommerce .widget_layered_nav ul li.chosen a,.woocommerce-page .widget_layered_nav ul li.chosen a',
                    ),
                    'prop'      =>  'border-bottom-color',
                    'filter'    =>  array( 'woocommerce' ),
                ),
                // bbPress styles if is active
                array(
                    'selector'  =>  array(
                        '#bbpress-forums li.bbp-forum-info.single-forum-info .bbp-forum-title:before',
                        '#bbpress-forums .bbp-forums-list li:before',
                        '#bbpress-forums p.bbp-topic-meta .freshness_link a',
                        '#bbpress-forums .bbp-forums-list li a',
                    ),
                    'prop'      =>  'color',
                    'filter'    =>  array( 'bbpress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#bbpress-forums #bbp-search-form #bbp_search_submit',
                        '#bbpress-forums li.bbp-header:before',
                        '#bbpress-forums button.user-submit, .bbp-submit-wrapper button',
                        '#bbpress-forums li.bbp-header:before',
                    ),
                    'prop'      =>  'background-color',
                    'filter'    =>  array( 'bbpress' ),
                ),
                // BuddyPress styles if is active
                array(
                    'selector'  =>  array(
                        '#buddypress .dir-search input[type=submit]',
                        '#buddypress div.item-list-tabs ul li.current a span',
                        '#buddypress div.item-list-tabs ul li.selected a span',
                        '#buddypress div.activity-meta a:hover',
                        '#buddypress div.item-list-tabs ul li a',
                        '#buddypress div#item-header div#item-meta a',
                        '#buddypress .acomment-meta a',
                        '#buddypress .activity-header a',
                        '#buddypress .comment-meta a',
                        '#buddypress .activity-list .activity-content .activity-inner a',
                        '#buddypress .activity-list .activity-content blockquote a',
                        '#buddypress table.profile-fields > tbody > tr > td.data a',
                        '#buddypress table.notifications a',
                        '#buddypress table#message-threads a',
                        '#buddypress div.messages-options-nav a',
                        '#buddypress ul.item-list li div.item-title a',
                        '#buddypress ul.item-list li h5 a',
                    ),
                    'prop'      =>  'color',
                    'filter'    =>  array( 'buddypress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#buddypress .dir-search input[type=submit]',
                        '#buddypress a.button,#buddypress a.button:hover,#buddypress button,#buddypress button:hover,#buddypress div.generic-button a,#buddypress div.generic-button a:hover,#buddypress input[type=button],#buddypress input[type=button]:hover,#buddypress input[type=reset],#buddypress input[type=reset]:hover,#buddypress input[type=submit],#buddypress input[type=submit]:hover,#buddypress ul.button-nav li a,#buddypress ul.button-nav li a:hover,a.bp-title-button:hover ,a.bp-title-button',
                    ),
                    'prop'      =>  'border-color',
                    'filter'    =>  array( 'buddypress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#buddypress a.button,#buddypress a.button:hover,#buddypress button,#buddypress button:hover,#buddypress div.generic-button a,#buddypress div.generic-button a:hover,#buddypress input[type=button],#buddypress input[type=button]:hover,#buddypress input[type=reset],#buddypress input[type=reset]:hover,#buddypress input[type=submit],#buddypress input[type=submit]:hover,#buddypress ul.button-nav li a,#buddypress ul.button-nav li a:hover,a.bp-title-button:hover ,a.bp-title-button',
                        '#buddypress div.item-list-tabs ul li.current a',
                        '#buddypress div.item-list-tabs ul li.selected a',
                        '#buddypress div.activity-meta a:hover span',
                    ),
                    'prop'      =>  'background',
                    'filter'    =>  array( 'buddypress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#buddypress div.item-list-tabs ul li a:hover span',
                    ),
                    'prop'      =>  array(
                        'background' => '%%value%%',
                        'color'      => '#fff',
                    ),
                    'filter'    =>  array( 'buddypress' ),
                ),
            ),
            'css-clean'           =>  array(
                array(
                    'selector'  => array(
                        '.main-bg-color,.main-bg-color',
                        '.bf-news-ticker .heading',
                        '.main-menu .menu .better-custom-badge',
                        '.widget.widget_nav_menu .menu .better-custom-badge',
                        'body .mejs-controls .mejs-time-rail .mejs-time-current',
                        '.widget.widget_nav_menu li a:hover',
                        '.btn-read-more',
                        '.pagination > span,.pagination .wp-pagenavi a:hover,.pagination .page-numbers:hover',
                        '.pagination .wp-pagenavi .current,.pagination .current',
                        '.flex-control-nav li a.flex-active, .flex-control-nav li:hover a',
                        '.term-title a',
                        '.rating-bar span',
                        'input[type=submit],.button-primary,.btn-read-more',
                        '.main-menu .menu > li.random-post:hover > a',
                        '.main-menu .main-menu-container.mobile-menu-container .mobile-button .fa',
                        '.page-heading:before',
                        'body .mejs-controls .mejs-time-rail .mejs-time-current',
                        '.comments li.comment.bypostauthor > article.comment .comment-edit-link',
                        '.comments li.comment.bypostauthor > article.comment .comment-reply-link',
                        '.comments .comment-respond #cancel-comment-reply-link',
                        '.comments .comment-respond .form-submit input[type=submit]',
                        '.widget.widget_nav_menu li a:hover',
                        '.betterstudio-review .verdict .overall',
                        '.error404 .content-column .search-form .search-submit',
                        '.main-menu .search-item .search-form:hover,.main-menu .search-item .search-form.have-focus',
                        'span.dropcap.square',
                        'span.dropcap.circle',
                        '.block-user-row .posts-count',
                        '.block-user-modern .posts-count',
                    ),
                    'prop'      => array(
                        'background-color' =>   '%%value%%',
                    )
                ),
                array(
                    'selector'  =>  array(
                        '.main-color',
                        '.bf-news-ticker ul.news-list li a:hover',
                        '.bf-news-ticker ul.news-list li a:focus',
                        '.rating-stars span:before',
                        '.footer-lower-wrapper a:hover',
                        '.bf-breadcrumb .trail-browse',
                        '.comments li.comment.bypostauthor > article.comment .comment-author a',
                        '.comments li.comment.bypostauthor > article.comment .comment-author',
                        '.widget.widget_calendar table td a',
                        '.widget .tagcloud a:hover',
                        '.section-heading.extended.tab-heading .other-links .other-item.active a',
                        '.section-heading.extended .other-links .other-item:hover a',
                        'span.dropcap.circle-outline',
                        'span.dropcap.square-outline',
                        '.widget .tab-read-more a:hover',
                        '.tab-content-listing .tab-read-more a',

                    ),
                    'prop'      =>  array( 'color' )
                ),
                array(
                    'selector'  =>  array(
                        '.top-bar .widget.widget_nav_menu li:hover > a',
                    ),
                    'prop'      =>  array(
                        'background-color' => "%%value%% !important"
                    )
                ),
                array(
                    'selector'  =>  array(
                        '.widget.widget_nav_menu li > a:hover',
                    ),
                    'prop'      =>  array(
                        'border-color' => "%%value%%",
                    )
                ),
                array(
                    'selector'  =>  array(
                        '.main-menu .menu > li:hover > a',
                        '.main-menu .menu > .current-menu-ancestor > a',
                        '.main-menu .menu > .current-menu-parent > a',
                        '.main-menu .menu > .current-menu-item > a',
                        '.widget.widget_recent_comments a:hover',
                        '.footer-larger-widget.widget.widget_recent_comments a:hover',
                        '.comments li.comment.bypostauthor > article.comment',
                        '.section-heading.extended.tab-heading',
                    ),
                    'prop'      =>  array( 'border-bottom-color' )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .menu .better-custom-badge:after',
                        '.section-heading.extended.tab-heading',
                    ),
                    'prop'      => array( 'border-top-color' )
                ),
                array(
                    'selector'  => array(
                        '.bf-news-ticker .heading:after',
                        '.main-menu .menu .sub-menu .better-custom-badge:after',
                        'body .main-menu .menu .mega-menu .menu-badge-left > a > .better-custom-badge:after',
                        '.rtl .main-menu .mega-menu .menu-badge-right > a > .better-custom-badge:after',
                    ),
                    'prop'      => array( 'border-left-color' )
                ),
                array(
                    'selector'  =>  array(
                        '.rtl .bf-news-ticker .heading:after',
                        '.main-menu .mega-menu .menu-badge-right > a > .better-custom-badge:after',
                        '.widget.widget_nav_menu .menu .better-custom-badge:after',
                    ),
                    'prop'      =>  array( 'border-right-color' )
                ),
                array(
                    'selector'  =>  array(
                        '.widget .tagcloud a:hover',
                        'span.dropcap.circle-outline',
                        'span.dropcap.square-outline',
                    ),
                    'prop'      =>  array( 'border-color' )
                ),
                array(
                    'selector'  =>  array(
                        '::selection'
                    ),
                    'prop'      =>  array( 'background' )
                ),
                array(
                    'selector'  =>  array(
                        '::-moz-selection'
                    ),
                    'prop'      =>  array( 'background' )
                ),
                // WooCommerce styles if is active
                array(
                    'selector'  =>  array(
                        '.bm-wc-cart .cart-link .total-items',
                        '.main-wrap ul.product_list_widget li del, .main-wrap ul.product_list_widget li .amount',
                        '.woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before',
                        '.woocommerce #content div.product p.price del, .woocommerce #content div.product span.price del, .woocommerce div.product p.price del, .woocommerce div.product span.price del, .woocommerce-page #content div.product p.price del, .woocommerce-page #content div.product span.price del, .woocommerce-page div.product p.price del, .woocommerce-page div.product span.price del, .woocommerce ul.products li.product .price del, .woocommerce-page ul.products li.product .price del',
                        '.woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price',
                        '.woocommerce .star-rating span:before,.woocommerce-page .star-rating span:before',
                        '.woocommerce p.stars a.star-1.active:after,.woocommerce p.stars a.star-2.active:after,.woocommerce p.stars a.star-3.active:after,.woocommerce p.stars a.star-4.active:after,.woocommerce p.stars a.star-5.active:after,.woocommerce-page p.stars a.star-1.active:after,.woocommerce-page p.stars a.star-2.active:after,.woocommerce-page p.stars a.star-3.active:after,.woocommerce-page p.stars a.star-4.active:after,.woocommerce-page p.stars a.star-5.active:after',
                        '.woocommerce #content table.cart a.remove,.woocommerce table.cart a.remove,.woocommerce-page #content table.cart a.remove,.woocommerce-page table.cart a.remove',
                    ),
                    'prop'      =>  'color',
                    'filter'    =>  array( 'woocommerce' ),
                ),
                array(
                    'selector'  =>  array(
                        '.woocommerce span.onsale, .woocommerce-page span.onsale, .woocommerce ul.products li.product .onsale, .woocommerce-page ul.products li.product .onsale',
                        'a.button.add_to_cart_button:hover',
                        '.woocommerce #content input.button:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce-page #content input.button:hover,.woocommerce-page #respond input#submit:hover,.woocommerce-page a.button:hover,.woocommerce-page button.button:hover,.woocommerce-page input.button:hover,.woocommerce #payment #place_order, .woocommerce-page #payment #place_order,.woocommerce #review_form #respond .form-submit input:hover,.woocommerce-page #review_form #respond .form-submit input:hover,button.button.single_add_to_cart_button.alt:hover',
                        '.woocommerce-account .woocommerce .address .title h3:before,.woocommerce-account .woocommerce h2:before,.cross-sells h2:before,.related.products h2:before,.woocommerce #reviews h3:before,.woocommerce-page #reviews h3:before,.woocommerce-tabs .panel.entry-content h2:before,.woocommerce .shipping_calculator h2:before,.woocommerce .cart_totals h2:before,h3#order_review_heading:before ,.woocommerce-shipping-fields h3:before ,.woocommerce-billing-fields h3:before ',
                        '.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active,.woocommerce div.product .woocommerce-tabs ul.tabs li.active,.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active,.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active',
                        '.woocommerce #content table.cart a.remove:hover,.woocommerce table.cart a.remove:hover,.woocommerce-page #content table.cart a.remove:hover,.woocommerce-page table.cart a.remove:hover',
                        '.woocommerce .cart-collaterals .shipping_calculator .button, .woocommerce-page .cart-collaterals .shipping_calculator .button,.woocommerce .cart .button.checkout-button,.woocommerce .cart .button:hover,.woocommerce .cart input.button:hover,.woocommerce-page .cart .button:hover,.woocommerce-page .cart input.button:hover',
                        '.main-wrap .mega-menu.cart-widget.widget_shopping_cart .buttons a',
                        '.main-wrap .widget.widget_price_filter .ui-slider-range',
                        '.main-wrap .widget.widget_price_filter .ui-slider .ui-slider-handle',
                        '.woocommerce .widget_layered_nav ul li.chosen a,.woocommerce-page .widget_layered_nav ul li.chosen a',
                        '.woocommerce #content .quantity .minus:hover,.woocommerce #content .quantity .plus:hover,.woocommerce .quantity .minus:hover,.woocommerce .quantity .plus:hover,.woocommerce-page #content .quantity .minus:hover,.woocommerce-page #content .quantity .plus:hover,.woocommerce-page .quantity .minus:hover,.woocommerce-page .quantity .plus:hover',
                    ),
                    'prop'      =>  'background-color',
                    'filter'    =>  array( 'woocommerce' ),
                ),
                array(
                    'selector'  =>  array(
                        '.woocommerce #content div.product .woocommerce-tabs ul.tabs,.woocommerce div.product .woocommerce-tabs ul.tabs,.woocommerce-page #content div.product .woocommerce-tabs ul.tabs,.woocommerce-page div.product .woocommerce-tabs ul.tabs',
                        '.woocommerce .widget_layered_nav ul li.chosen a,.woocommerce-page .widget_layered_nav ul li.chosen a',
                    ),
                    'prop'      =>  'border-bottom-color',
                    'filter'    =>  array( 'woocommerce' ),
                ),
                // bbPress styles if is active
                array(
                    'selector'  =>  array(
                        '#bbpress-forums li.bbp-forum-info.single-forum-info .bbp-forum-title:before',
                        '#bbpress-forums .bbp-forums-list li:before',
                    ),
                    'prop'      =>  'color',
                    'filter'    =>  array( 'bbpress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#bbpress-forums #bbp-search-form #bbp_search_submit',
                        '#bbpress-forums li.bbp-header:before',
                        '#bbpress-forums button.user-submit, .bbp-submit-wrapper button',
                        '#bbpress-forums li.bbp-header:before',
                    ),
                    'prop'      =>  'background-color',
                    'filter'    =>  array( 'bbpress' ),
                ),
                // BuddyPress styles if is active
                array(
                    'selector'  =>  array(
                        '#buddypress .dir-search input[type=submit]',
                        '#buddypress div.item-list-tabs ul li.current a span',
                        '#buddypress div.item-list-tabs ul li.selected a span',
                        '#buddypress div.activity-meta a:hover',
                        '#buddypress div.item-list-tabs ul li a',
                        '#buddypress div#item-header div#item-meta a',
                        '#buddypress .acomment-meta a',
                        '#buddypress .activity-header a',
                        '#buddypress .comment-meta a',
                        '#buddypress .activity-list .activity-content .activity-inner a',
                        '#buddypress .activity-list .activity-content blockquote a',
                        '#buddypress table.profile-fields > tbody > tr > td.data a',
                        '#buddypress table.notifications a',
                        '#buddypress table#message-threads a',
                        '#buddypress div.messages-options-nav a',
                        '#buddypress ul.item-list li div.item-title a',
                        '#buddypress ul.item-list li h5 a',
                    ),
                    'prop'      =>  'color',
                    'filter'    =>  array( 'buddypress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#buddypress .dir-search input[type=submit]',
                        '#buddypress a.button,#buddypress a.button:hover,#buddypress button,#buddypress button:hover,#buddypress div.generic-button a,#buddypress div.generic-button a:hover,#buddypress input[type=button],#buddypress input[type=button]:hover,#buddypress input[type=reset],#buddypress input[type=reset]:hover,#buddypress input[type=submit],#buddypress input[type=submit]:hover,#buddypress ul.button-nav li a,#buddypress ul.button-nav li a:hover,a.bp-title-button:hover ,a.bp-title-button',
                    ),
                    'prop'      =>  'border-color',
                    'filter'    =>  array( 'buddypress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#buddypress a.button,#buddypress a.button:hover,#buddypress button,#buddypress button:hover,#buddypress div.generic-button a,#buddypress div.generic-button a:hover,#buddypress input[type=button],#buddypress input[type=button]:hover,#buddypress input[type=reset],#buddypress input[type=reset]:hover,#buddypress input[type=submit],#buddypress input[type=submit]:hover,#buddypress ul.button-nav li a,#buddypress ul.button-nav li a:hover,a.bp-title-button:hover ,a.bp-title-button',
                        '#buddypress div.item-list-tabs ul li.current a',
                        '#buddypress div.item-list-tabs ul li.selected a',
                        '#buddypress div.activity-meta a:hover span',
                    ),
                    'prop'      =>  'background',
                    'filter'    =>  array( 'buddypress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#buddypress div.item-list-tabs ul li a:hover span',
                    ),
                    'prop'      =>  array(
                        'background' => '%%value%%',
                        'color'      => '#fff',
                    ),
                    'filter'    =>  array( 'buddypress' ),
                ),
            ),
            'css-clean-beige'=>  array(
                array(
                    'selector'  => array(
                        '.main-bg-color,.main-bg-color',
                        '.bf-news-ticker .heading',
                        '.main-menu .menu .better-custom-badge',
                        '.widget.widget_nav_menu .menu .better-custom-badge',
                        'body .mejs-controls .mejs-time-rail .mejs-time-current',
                        '.widget.widget_nav_menu li a:hover',
                        '.btn-read-more',
                        '.pagination > span,.pagination .wp-pagenavi a:hover,.pagination .page-numbers:hover',
                        '.pagination .wp-pagenavi .current,.pagination .current',
                        '.flex-control-nav li a.flex-active, .flex-control-nav li:hover a',
                        '.term-title a',
                        '.rating-bar span',
                        'input[type=submit],.button-primary,.btn-read-more',
                        '.main-menu .menu > li.random-post:hover > a',
                        '.main-menu .main-menu-container.mobile-menu-container .mobile-button .fa',
                        '.page-heading:before',
                        'body .mejs-controls .mejs-time-rail .mejs-time-current',
                        '.comments li.comment.bypostauthor > article.comment .comment-edit-link',
                        '.comments li.comment.bypostauthor > article.comment .comment-reply-link',
                        '.comments .comment-respond #cancel-comment-reply-link',
                        '.comments .comment-respond .form-submit input[type=submit]',
                        '.widget.widget_nav_menu li a:hover',
                        '.betterstudio-review .verdict .overall',
                        '.error404 .content-column .search-form .search-submit',
                        '.main-menu .search-item .search-form:hover,.main-menu .search-item .search-form.have-focus',
                        'span.dropcap.square',
                        'span.dropcap.circle',
                        '.block-user-row .posts-count',
                        '.block-user-modern .posts-count',
                    ),
                    'prop'      => array(
                        'background-color' =>   '%%value%%',
                    )
                ),
                array(
                    'selector'  =>  array(
                        '.main-color',
                        '.bf-news-ticker ul.news-list li a:hover',
                        '.bf-news-ticker ul.news-list li a:focus',
                        '.rating-stars span:before',
                        '.footer-lower-wrapper a:hover',
                        '.bf-breadcrumb .trail-browse',
                        '.comments li.comment.bypostauthor > article.comment .comment-author a',
                        '.comments li.comment.bypostauthor > article.comment .comment-author',
                        '.widget.widget_calendar table td a',
                        '.widget .tagcloud a:hover',
                        '.section-heading.extended.tab-heading .other-links .other-item.active a',
                        '.section-heading.extended .other-links .other-item:hover a',
                        'span.dropcap.circle-outline',
                        'span.dropcap.square-outline',
                        '.widget .tab-read-more a:hover',
                        '.tab-content-listing .tab-read-more a',
                    ),
                    'prop'      =>  array( 'color' )
                ),
                array(
                    'selector'  =>  array(
                        '.main-menu .menu > li:hover > a',
                        '.main-menu .menu > .current-menu-ancestor > a',
                        '.main-menu .menu > .current-menu-parent > a',
                        '.main-menu .menu > .current-menu-item > a',
                        '.widget.widget_recent_comments a:hover',
                        '.footer-larger-widget.widget.widget_recent_comments a:hover',
                        '.comments li.comment.bypostauthor > article.comment',
                        '.section-heading.extended.tab-heading',
                    ),
                    'prop'      =>  array( 'border-bottom-color' )
                ),
                array(
                    'selector'  =>  array(
                        '.top-bar .widget.widget_nav_menu li:hover > a',
                    ),
                    'prop'      =>  array(
                        'background-color' => "%%value%% !important"
                    )
                ),
                array(
                    'selector'  =>  array(
                        '.widget.widget_nav_menu li > a:hover',
                    ),
                    'prop'      =>  array(
                        'border-color' => "%%value%%",
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .menu .better-custom-badge:after',
                        '.section-heading.extended.tab-heading',
                    ),
                    'prop'      => array( 'border-top-color' )
                ),
                array(
                    'selector'  => array(
                        '.bf-news-ticker .heading:after',
                        '.main-menu .menu .sub-menu .better-custom-badge:after',
                        'body .main-menu .menu .mega-menu .menu-badge-left > a > .better-custom-badge:after',
                        '.rtl .main-menu .mega-menu .menu-badge-right > a > .better-custom-badge:after',
                    ),
                    'prop'      => array( 'border-left-color' )
                ),
                array(
                    'selector'  =>  array(
                        '.rtl .bf-news-ticker .heading:after',
                        '.main-menu .mega-menu .menu-badge-right > a > .better-custom-badge:after',
                        '.widget.widget_nav_menu .menu .better-custom-badge:after',
                    ),
                    'prop'      =>  array( 'border-right-color' )
                ),
                array(
                    'selector'  =>  array(
                        '.widget .tagcloud a:hover',
                        'span.dropcap.circle-outline',
                        'span.dropcap.square-outline',
                    ),
                    'prop'      =>  array( 'border-color' )
                ),
                array(
                    'selector'  =>  array(
                        '::selection'
                    ),
                    'prop'      =>  array( 'background' )
                ),
                array(
                    'selector'  =>  array(
                        '::-moz-selection'
                    ),
                    'prop'      =>  array( 'background' )
                ),
                // WooCommerce styles if is active
                array(
                    'selector'  =>  array(
                        '.bm-wc-cart .cart-link .total-items',
                        '.main-wrap ul.product_list_widget li del, .main-wrap ul.product_list_widget li .amount',
                        '.woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before',
                        '.woocommerce #content div.product p.price del, .woocommerce #content div.product span.price del, .woocommerce div.product p.price del, .woocommerce div.product span.price del, .woocommerce-page #content div.product p.price del, .woocommerce-page #content div.product span.price del, .woocommerce-page div.product p.price del, .woocommerce-page div.product span.price del, .woocommerce ul.products li.product .price del, .woocommerce-page ul.products li.product .price del',
                        '.woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price',
                        '.woocommerce .star-rating span:before,.woocommerce-page .star-rating span:before',
                        '.woocommerce p.stars a.star-1.active:after,.woocommerce p.stars a.star-2.active:after,.woocommerce p.stars a.star-3.active:after,.woocommerce p.stars a.star-4.active:after,.woocommerce p.stars a.star-5.active:after,.woocommerce-page p.stars a.star-1.active:after,.woocommerce-page p.stars a.star-2.active:after,.woocommerce-page p.stars a.star-3.active:after,.woocommerce-page p.stars a.star-4.active:after,.woocommerce-page p.stars a.star-5.active:after',
                        '.woocommerce #content table.cart a.remove,.woocommerce table.cart a.remove,.woocommerce-page #content table.cart a.remove,.woocommerce-page table.cart a.remove',
                    ),
                    'prop'      =>  'color',
                    'filter'    =>  array( 'woocommerce' ),
                ),
                array(
                    'selector'  =>  array(
                        '.woocommerce span.onsale, .woocommerce-page span.onsale, .woocommerce ul.products li.product .onsale, .woocommerce-page ul.products li.product .onsale',
                        'a.button.add_to_cart_button:hover',
                        '.woocommerce #content input.button:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce-page #content input.button:hover,.woocommerce-page #respond input#submit:hover,.woocommerce-page a.button:hover,.woocommerce-page button.button:hover,.woocommerce-page input.button:hover,.woocommerce #payment #place_order, .woocommerce-page #payment #place_order,.woocommerce #review_form #respond .form-submit input:hover,.woocommerce-page #review_form #respond .form-submit input:hover,button.button.single_add_to_cart_button.alt:hover',
                        '.woocommerce-account .woocommerce .address .title h3:before,.woocommerce-account .woocommerce h2:before,.cross-sells h2:before,.related.products h2:before,.woocommerce #reviews h3:before,.woocommerce-page #reviews h3:before,.woocommerce-tabs .panel.entry-content h2:before,.woocommerce .shipping_calculator h2:before,.woocommerce .cart_totals h2:before,h3#order_review_heading:before ,.woocommerce-shipping-fields h3:before ,.woocommerce-billing-fields h3:before ',
                        '.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active,.woocommerce div.product .woocommerce-tabs ul.tabs li.active,.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active,.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active',
                        '.woocommerce #content table.cart a.remove:hover,.woocommerce table.cart a.remove:hover,.woocommerce-page #content table.cart a.remove:hover,.woocommerce-page table.cart a.remove:hover',
                        '.woocommerce .cart-collaterals .shipping_calculator .button, .woocommerce-page .cart-collaterals .shipping_calculator .button,.woocommerce .cart .button.checkout-button,.woocommerce .cart .button:hover,.woocommerce .cart input.button:hover,.woocommerce-page .cart .button:hover,.woocommerce-page .cart input.button:hover',
                        '.main-wrap .mega-menu.cart-widget.widget_shopping_cart .buttons a',
                        '.main-wrap .widget.widget_price_filter .ui-slider-range',
                        '.main-wrap .widget.widget_price_filter .ui-slider .ui-slider-handle',
                        '.woocommerce .widget_layered_nav ul li.chosen a,.woocommerce-page .widget_layered_nav ul li.chosen a',
                        '.woocommerce #content .quantity .minus:hover,.woocommerce #content .quantity .plus:hover,.woocommerce .quantity .minus:hover,.woocommerce .quantity .plus:hover,.woocommerce-page #content .quantity .minus:hover,.woocommerce-page #content .quantity .plus:hover,.woocommerce-page .quantity .minus:hover,.woocommerce-page .quantity .plus:hover',
                    ),
                    'prop'      =>  'background-color',
                    'filter'    =>  array( 'woocommerce' ),
                ),
                array(
                    'selector'  =>  array(
                        '.woocommerce #content div.product .woocommerce-tabs ul.tabs,.woocommerce div.product .woocommerce-tabs ul.tabs,.woocommerce-page #content div.product .woocommerce-tabs ul.tabs,.woocommerce-page div.product .woocommerce-tabs ul.tabs',
                        '.woocommerce .widget_layered_nav ul li.chosen a,.woocommerce-page .widget_layered_nav ul li.chosen a',
                    ),
                    'prop'      =>  'border-bottom-color',
                    'filter'    =>  array( 'woocommerce' ),
                ),
                // bbPress styles if is active
                array(
                    'selector'  =>  array(
                        '#bbpress-forums li.bbp-forum-info.single-forum-info .bbp-forum-title:before',
                        '#bbpress-forums .bbp-forums-list li:before',
                    ),
                    'prop'      =>  'color',
                    'filter'    =>  array( 'bbpress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#bbpress-forums #bbp-search-form #bbp_search_submit',
                        '#bbpress-forums li.bbp-header:before',
                        '#bbpress-forums button.user-submit, .bbp-submit-wrapper button',
                        '#bbpress-forums li.bbp-header:before',
                    ),
                    'prop'      =>  'background-color',
                    'filter'    =>  array( 'bbpress' ),
                ),
                // BuddyPress styles if is active
                array(
                    'selector'  =>  array(
                        '#buddypress .dir-search input[type=submit]',
                        '#buddypress div.item-list-tabs ul li.current a span',
                        '#buddypress div.item-list-tabs ul li.selected a span',
                        '#buddypress div.activity-meta a:hover',
                        '#buddypress div.item-list-tabs ul li a',
                        '#buddypress div#item-header div#item-meta a',
                        '#buddypress .acomment-meta a',
                        '#buddypress .activity-header a',
                        '#buddypress .comment-meta a',
                        '#buddypress .activity-list .activity-content .activity-inner a',
                        '#buddypress .activity-list .activity-content blockquote a',
                        '#buddypress table.profile-fields > tbody > tr > td.data a',
                        '#buddypress table.notifications a',
                        '#buddypress table#message-threads a',
                        '#buddypress div.messages-options-nav a',
                        '#buddypress ul.item-list li div.item-title a',
                        '#buddypress ul.item-list li h5 a',
                    ),
                    'prop'      =>  'color',
                    'filter'    =>  array( 'buddypress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#buddypress .dir-search input[type=submit]',
                        '#buddypress a.button,#buddypress a.button:hover,#buddypress button,#buddypress button:hover,#buddypress div.generic-button a,#buddypress div.generic-button a:hover,#buddypress input[type=button],#buddypress input[type=button]:hover,#buddypress input[type=reset],#buddypress input[type=reset]:hover,#buddypress input[type=submit],#buddypress input[type=submit]:hover,#buddypress ul.button-nav li a,#buddypress ul.button-nav li a:hover,a.bp-title-button:hover ,a.bp-title-button',
                    ),
                    'prop'      =>  'border-color',
                    'filter'    =>  array( 'buddypress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#buddypress a.button,#buddypress a.button:hover,#buddypress button,#buddypress button:hover,#buddypress div.generic-button a,#buddypress div.generic-button a:hover,#buddypress input[type=button],#buddypress input[type=button]:hover,#buddypress input[type=reset],#buddypress input[type=reset]:hover,#buddypress input[type=submit],#buddypress input[type=submit]:hover,#buddypress ul.button-nav li a,#buddypress ul.button-nav li a:hover,a.bp-title-button:hover ,a.bp-title-button',
                        '#buddypress div.item-list-tabs ul li.current a',
                        '#buddypress div.item-list-tabs ul li.selected a',
                        '#buddypress div.activity-meta a:hover span',
                    ),
                    'prop'      =>  'background',
                    'filter'    =>  array( 'buddypress' ),
                ),
                array(
                    'selector'  =>  array(
                        '#buddypress div.item-list-tabs ul li a:hover span',
                    ),
                    'prop'      =>  array(
                        'background' => '%%value%%',
                        'color'      => '#fff',
                    ),
                    'filter'    =>  array( 'buddypress' ),
                ),
            ),

        );
        $field['bg_color'] = array(
            'name'          =>  __( 'Body Background Color', 'better-studio' ),
            'id'            =>  'bg_color',
            'type'          =>  'color',
            'std'           =>  '#ffffff',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#253545',
            'std-full-black'=>  '#2e2e2e',
            'std-beige'     =>  '#ffffff',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'Setting a body background image below will override it.', 'better-studio' ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        'body,body.boxed'
                    ),
                    'prop'      => array(
                        'background-color' => '%%value%%'
                    )
                )
            )
        );
        $field['bg_main_column_color'] = array(
            'name'          =>  __( 'Main Column Background Color', 'better-studio' ),
            'id'            =>  'bg_main_column_color',
            'type'          =>  'color',
            'std-full-dark' =>  '#293b4d',
            'std-full-black'=>  '#2b2b2b',
            'std-beige'     =>  '#ffffff',
            'style'         =>  array(
                'full-dark',
                'full-black',
                'beige',
            ),
            'desc'          =>  __( 'This will be used as main column background in "boxed" and "Boxed (Padded)" layout style.', 'better-studio' ),
            'css-full-dark' =>  array(
                array(
                    'selector'  => array(
                        '.boxed .main-wrap'
                    ),
                    'prop'      => array(
                        'background-color' => '%%value%%'
                    )
                )
            ),
            'css-full-black'=>  array(
                array(
                    'selector'  => array(
                        '.boxed .main-wrap'
                    ),
                    'prop'      => array(
                        'background-color' => '%%value%%'
                    )
                )
            ),
            'css-beige'=>  array(
                array(
                    'selector'  => array(
                        '.boxed .main-wrap'
                    ),
                    'prop'      => array(
                        'background-color' => '%%value%%'
                    )
                )
            ),

        );

        $field['bg_image'] = array(
            'name'          =>  __( 'Body Background Image', 'better-studio' ),
            'id'            =>  'bg_image',
            'type'          =>  'background_image',
            'std'           =>  '',
            'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
            'desc'          =>  __( 'Use light patterns in non-boxed layout. For patterns, use a repeating background. Use photo to fully cover the background with an image. Note that it will override the background color option.', 'better-studio' ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        'body'
                    ),
                    'prop'      => array( 'background-image' ),
                    'type'      => 'background-image'
                )
            )
        );

        $field['color_content_link'] = array(
            'name'          =>  __( 'Links color in the main content', 'better-studio' ),
            'id'            =>  'color_content_link',
            'type'          =>  'color',
            'desc'          =>  __( 'Changes all the links color within posts and pages.', 'better-studio'),
            'std'           =>  '#e44e4f',
            'std-green'     =>  '#398315',
            'std-blue1'     =>  '#41638a',
            'std-blue2'     =>  '#0ca4dd',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'       =>  array(
                array(
                    'selector'  => '.the-content a' ,
                    'prop'      => 'color'
                )
            )
        );

        $field['color_image_gradient'] = array(
            'name'          =>  __( 'Images overlay gradient color', 'better-studio' ),
            'id'            =>  'color_image_gradient',
            'type'          =>  'color',
            'desc'          =>  __( 'Changes all the links color within posts and pages.', 'better-studio'),
            'std'           =>  '#222222',
            'std-dark'      =>  '#0f1e2c',
            'std-full-dark' =>  '#0f1e2c',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'       =>  array(
                array(
                    'selector'  => array(
                        '.block-modern .meta',
                        '.block-highlight .content',
                    ),
                    'prop'      => array(
                        'background'    =>  "-moz-linear-gradient(top,  rgba(0,0,0,0) 0%, %%value%% 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,%%value%%));
    background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,%%value%% 100%);
    background: -o-linear-gradient(top,  rgba(0,0,0,0) 0%,%%value%% 100%);
    background: -ms-linear-gradient(top,  rgba(0,0,0,0) 0%,%%value%% 100%);
    background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,%%value%% 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='%%value%%',GradientType=0 );"
                    )
                )
            )
        );

        /**
         * 5.6.2. => Header
         */
        $field[] = array(
            'name'          =>  __( 'Header', 'better-studio' ),
            'type'          =>  'heading',
        );
        $field['topbar_bg_color'] = array(
            'name'          =>  __( 'Top Bar Background Color', 'better-studio' ),
            'id'            =>  'topbar_bg_color',
            'type'          =>  'color',
            'std'           =>  '#f2f2f2',
            'std-full-dark' =>  '#3c546b',
            'std-full-black'=>  '#3b3b3b',
            'std-beige'     =>  '#f5efd8',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#ffffff',
            'std-blue2'=> '#f1f8fb',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'       =>  array(
                array(
                    'selector'  => array(
                        '.top-bar',
                        '.top-bar .widget.widget_nav_menu ul.menu > li > a',
                    ),
                    'prop'      => 'background-color'
                )
            )
        );
        $field['topbar_bottom_line_color'] = array(
            'name'          =>  __( 'Top Bar Bottom Line Color', 'better-studio' ),
            'id'            =>  'topbar_bottom_line_color',
            'type'          =>  'border',
            'style'         =>  array(
                'clean',
                'clean-beige',
            ),
            'preview'       =>  true,
            'preview-css'   =>  'border-bottom: 1px solid #DFDFDF; border-top: none; border-left: none; border-right:none; width: 100%; height: 5px;',
            'std-clean'     =>  array(
                'bottom'    =>  array(
                    'width'     =>  '1',
                    'style'     =>  'solid',
                    'color'     =>  '#dfdfdf',
                ),
            ),
            'std-clean-beige'     =>  array(
                'bottom'    =>  array(
                    'width'     =>  '1',
                    'style'     =>  'solid',
                    'color'     =>  '#dbcd9b',
                ),
            ),
            'border'        =>  array(
                'bottom'        =>  array( 'width', 'style', 'color' ),
            ),
            'css-clean'           =>  array(
                array(
                    'selector'  => '.top-bar',
                    'type'      => 'border'
                )
            ),
            'css-clean-beige'=>  array(
                array(
                    'selector'  => '.top-bar',
                    'type'      => 'border'
                )
            ),
        );
        $field['header_bg_color'] = array(
            'name'          =>  __( 'Header Background Color', 'better-studio' ),
            'id'            =>  'header_bg_color',
            'type'          =>  'color',
            'std'           =>  '',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'desc'          =>  __( 'Setting a header background pattern below will override it.', 'better-studio' ),
            'css'           =>  array(
                array(
                    'selector'  => '.header' ,
                    'prop'      => 'background-color'
                )
            )
        );
        $field['header_bg_image'] = array(
            'name'          =>  __( 'Header Background Image', 'better-studio' ),
            'id'            =>  'header_bg_image',
            'type'          =>  'background_image',
            'std'           =>  '',
            'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
            'desc'          =>  __( 'Please use a background pattern that can be repeated. Note that it will override the background color option.', 'better-studio' ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.header'
                    ),
                    'prop'      => 'background-image',
                    'type'      => 'background-image'
                )
            )
        );

        /**
         * 5.6.3. => Main Navigation
         */
        $field[] = array(
            'name'      => __( 'Main Navigation', 'better-studio' ),
            'type'      => 'heading',
        );
        $field['menu_bg_color'] = array(
            'name'          =>  __( 'Menu Background Color', 'better-studio' ),
            'id'            =>  'menu_bg_color',
            'type'          =>  'color',
            'std'           =>  '#e0e0e0',
            'std-dark'      =>  '#304254',
            'std-full-dark' =>  '#3c546b',
            'std-black'     =>  '#3b3b3b',
            'std-full-black'=>  '#3b3b3b',
            'std-beige'     =>  '#f5edd0',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#ffffff',
            'std-green'     =>  '#77bb24',
            'std-blue1'     =>  '#4c75a4',
            'std-blue2'     =>  '#61bee1',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu',
                        '.main-menu.boxed .main-menu-container',
                    ),
                    'prop'      => array( 'background-color' )
                ),
            ),
            'css-clean'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu',
                        '.main-menu.boxed .main-menu-container',
                        '.main-menu .mobile-menu-container .mega-menu.style-link a',
                        '.main-menu .mobile-menu-container .menu li .sub-menu li',
                    ),
                    'prop'      => array( 'background-color' )
                ),
            ),
            'css-clean-beige'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu',
                        '.main-menu.boxed .main-menu-container',
                        '.main-menu .mobile-menu-container .mega-menu.style-link a',
                        '.main-menu .mobile-menu-container .menu li .sub-menu li',
                    ),
                    'prop'      => array( 'background-color' )
                ),
            ),


        );
        $field['menu_line_border_option_std'] = array(
            'name'          =>  __( 'Menu Separator Color in Responsive Navigation', 'better-studio' ),
            'id'            =>  'menu_line_border_option_std',
            'type'          =>  'color',
            'std'           =>  '#cacaca',
            'std-green'     =>  '#3f8f17',
            'std-blue1'     =>  '#35639a',
            'std-blue2'     =>  '#31a8d5',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css' =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .mega-menu.style-link .sub-menu li:first-child',
                        '.main-menu .mobile-menu-container .mega-menu.style-link li:first-child',
                        '.main-menu .mobile-menu-container .menu .sub-menu li:first-child',
                    ),
                    'prop'      => array(
                        'border-top-color'
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .menu li .sub-menu li',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li',
                        '.main-menu .mobile-menu-container .menu > li',
                        '.main-menu .main-menu-container.mobile-menu-container.active .mobile-button',
                    ),
                    'prop'      => array(
                        'border-bottom' => '1px solid %%value%%',
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .menu > li.alignright > a.children-button',
                        '.main-menu .mobile-menu-container .menu li .children-button',
                    ),
                    'prop'      => array(
                        'background-color' => '%%value%% !important'
                    )
                ),
            ),

        );
        $field['menu_line_border_option'] = array(
            'name'          =>  __( 'Menu Border Color', 'better-studio' ),
            'id'            =>  'menu_line_border_option',
            'desc'          =>  __( 'Border color for top, right, left and also line between links.', 'better-studio' ),
            'type'          =>  'color',
            'std-clean'     =>  '#c9c9c9',
            'std-clean-beige'=> '#dbcd9b',
            'style'         =>  array(
                'clean',
                'clean-beige',
            ),
            'css-clean'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu',
                        '.main-menu .mobile-menu-container .mega-menu.style-link .sub-menu li:first-child',
                        '.main-menu .mobile-menu-container .mega-menu.style-link li:first-child',
                        '.main-menu .mobile-menu-container .menu .sub-menu li:first-child',
                    ),
                    'prop'      => array(
                        'border-top-color'
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu',
                    ),
                    'prop'      => array(
                        'border-bottom-color'
                    ),
                    'before'    =>  '@media only screen and (max-width : 768px) {',
                    'after'     =>  '}',
                ),
                array(
                    'selector'  => array(
                        '.main-menu.boxed .main-menu-container',
                    ),
                    'prop'      => array(
                        'border-top-color',
                        'border-right-color',
                        'border-left-color',
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .main-menu-container',
                    ),
                    'prop'      => array(
                        'border-right-color',
                        'border-left-color',
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .menu > li.alignright > a:before',
                        '.main-menu .menu > li > a:before',
                    ),
                    'prop'      => array(
                        'background-color',
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .menu li .sub-menu li',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li',
                        '.main-menu.boxed .main-menu-container.mobile-menu-container',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li',
                        '.main-menu .mobile-menu-container .menu > li',
                        '.main-menu .main-menu-container.mobile-menu-container.active .mobile-button',
                    ),
                    'prop'      => array(
                        'border-bottom' => '1px solid %%value%%',
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .menu > li.alignright > a.children-button',
                        '.main-menu .mobile-menu-container .menu li .children-button',
                    ),
                    'prop'      => array( 'background-color' => '%%value%% !important' )
                ),
            ),
            'css-clean-beige' =>  array(
                array(
                    'selector'  => array(
                        '.main-menu',
                        '.main-menu .mobile-menu-container .mega-menu.style-link .sub-menu li:first-child',
                        '.main-menu .mobile-menu-container .mega-menu.style-link li:first-child',
                        '.main-menu .mobile-menu-container .menu .sub-menu li:first-child',
                    ),
                    'prop'      => array(
                        'border-top-color'
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu',
                    ),
                    'prop'      => array(
                        'border-bottom-color'
                    ),
                    'before'    =>  '@media only screen and (max-width : 768px) {',
                    'after'     =>  '}',
                ),
                array(
                    'selector'  => array(
                        '.main-menu.boxed .main-menu-container',
                    ),
                    'prop'      => array(
                        'border-top-color',
                        'border-right-color',
                        'border-left-color',
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .main-menu-container',
                    ),
                    'prop'      => array(
                        'border-right-color',
                        'border-left-color',
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .menu > li.alignright > a:before',
                        '.main-menu .menu > li > a:before',
                    ),
                    'prop'      => array(
                        'background-color',
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .menu li .sub-menu li',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li',
                        '.main-menu.boxed .main-menu-container.mobile-menu-container',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li',
                        '.main-menu .mobile-menu-container .menu > li',
                        '.main-menu .main-menu-container.mobile-menu-container.active .mobile-button',
                    ),
                    'prop'      => array(
                        'border-bottom' => '1px solid %%value%%',
                    )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .menu > li.alignright > a.children-button',
                        '.main-menu .mobile-menu-container .menu li .children-button',
                    ),
                    'prop'      => array( 'background-color' => '%%value%% !important' )
                ),
            ),

        );
        $field['menu_bottom_line_color'] = array(
            'name'          =>  __( 'Menu Border Below Color', 'better-studio' ),
            'id'            =>  'menu_bottom_line_color',
            'type'          =>  'color',
            'std'           =>  '#b7b7b7',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#707070',
            'std-full-black'=>  '#707070',
            'std-beige'     =>  '#d9c680',
            'std-clean-beige'=> '#d9c680',
            'std-green'     =>  '#509e29',
            'std-blue1'     =>  '#35639a',
            'std-blue2'     =>  '#31a8d5',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu',
                        '.main-menu.boxed .main-menu-container',
                    ),
                    'prop'      => array( 'border-bottom-color' )
                ),
                array(
                    'selector'  => array(
                        '.main-menu .menu>li.random-post>a',
                        '.main-menu .search-item .search-form',
                    ),
                    'prop'      => array( 'background-color' )
                ),

            ),
            'css-clean'    =>  array(
                array(
                    'selector'  => array(
                        '.main-menu',
                        '.main-menu.boxed .main-menu-container',
                        '.main-menu.boxed .main-menu-container.mobile-menu-container',
                    ),
                    'prop'      => array( 'border-bottom-color' )
                ),
            ),
            'css-clean-beige'=>  array(
                array(
                    'selector'  => array(
                        '.main-menu',
                        '.main-menu.boxed .main-menu-container',
                        '.main-menu.boxed .main-menu-container.mobile-menu-container',
                    ),
                    'prop'      => array( 'border-bottom-color' )
                ),
            ),
        );
        $field['menu_text_color'] = array(
            'name'          =>  __( 'Menu Text Color', 'better-studio' ),
            'id'            =>  'menu_text_color',
            'type'          =>  'color',
            'std'           =>  '#3b3b3b',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .menu>li>a',
                        '.main-menu .search-item .search-form .search-submit',
                        '.main-menu .main-menu-container.mobile-menu-container .mobile-button a',
                    ),
                    'prop'      => 'color'
                ),
            ),
            'css-clean'    =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .menu .sub-menu li a',
                        '.main-menu .mobile-menu-container .menu .mega-menu li a',
                        '.main-menu .menu>li>a',
                        '.main-menu .search-item .search-form .search-submit',
                        '.main-menu .main-menu-container.mobile-menu-container .mobile-button a',
                    ),
                    'prop'      => 'color'
                ),
            ),
            'css-clean-beige'    =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .menu .sub-menu li a',
                        '.main-menu .mobile-menu-container .menu .mega-menu li a',
                        '.main-menu .menu>li>a',
                        '.main-menu .search-item .search-form .search-submit',
                        '.main-menu .main-menu-container.mobile-menu-container .mobile-button a',
                    ),
                    'prop'      => 'color'
                ),
            ),
        );
        $field['menu_current_bg_color'] = array(
            'name'          =>  __( 'Menu Current Page Background Color', 'better-studio' ),
            'id'            =>  'menu_current_bg_color',
            'type'          =>  'color',
            'std'           =>  '#c8c8c8',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#e6dab0',
            'std-clean'     =>  '#e9e9e9',
            'std-clean-beige'=> '#f5edd0',
            'std-green'     =>  '#509e29',
            'std-blue1'     =>  '#35639a',
            'std-blue2'     =>  '#31a8d5',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active:hover > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active:hover > a',
                        '.main-menu .menu>.current-menu-ancestor>a',
                        '.main-menu .menu>.current-menu-parent>a',
                        '.main-menu .menu>.current-menu-item>a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link a',
                        '.main-menu .mobile-menu-container li.active > a',
                    ),
                    'prop'      => 'background-color'
                ),
            ),
            'css-clean'      =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active:hover > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active:hover > a',
                        '.main-menu .menu>.current-menu-ancestor>a',
                        '.main-menu .menu> .current-menu-parent>a',
                        '.main-menu .menu> .current-menu-item>a',
                        '.main-menu .mobile-menu-container .menu .current-menu-ancestor>a',
                        '.main-menu .mobile-menu-container .menu .current-menu-parent>a',
                        '.main-menu .mobile-menu-container .menu .current-menu-item>a',
                        '.main-menu .mobile-menu-container li.active > a',
                    ),
                    'prop'      => 'background-color'
                ),
            ),
            'css-clean-beige' =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active:hover > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active:hover > a',
                        '.main-menu .menu>.current-menu-ancestor>a',
                        '.main-menu .menu> .current-menu-parent>a',
                        '.main-menu .menu> .current-menu-item>a',
                        '.main-menu .mobile-menu-container .menu .current-menu-ancestor>a',
                        '.main-menu .mobile-menu-container .menu .current-menu-parent>a',
                        '.main-menu .mobile-menu-container .menu .current-menu-item>a',
                        '.main-menu .mobile-menu-container li.active > a',
                    ),
                    'prop'      => 'background-color'
                ),
            ),


        );
        $field['menu_current_font_color'] = array(
            'name'          =>  __( 'Menu Current Page Text Color', 'better-studio' ),
            'id'            =>  'menu_current_font_color',
            'type'          =>  'color',
            'std'           =>  '#3b3b3b',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#3b3b3b',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .menu > .current-menu-ancestor > a',
                        '.main-menu .menu > .current-menu-parent > a',
                        '.main-menu .menu > .current-menu-item > a',
                    ),
                    'prop'      => 'color'
                ),
            ),
            'css-clean'=>  array(
                array(
                    'selector'  => array(
                        'body .main-menu .mobile-menu-container .menu .current-menu-ancestor>a',
                        'body .main-menu .mobile-menu-container .menu .current-menu-parent>a',
                        'body .main-menu .mobile-menu-container .menu .current-menu-item>a',
                        '.main-menu .menu > .current-menu-ancestor > a',
                        '.main-menu .menu > .current-menu-parent > a',
                        '.main-menu .menu > .current-menu-item > a',
                    ),
                    'prop'      => 'color'
                ),
            ),
            'css-clean-beige'=>  array(
                array(
                    'selector'  => array(
                        'body .main-menu .mobile-menu-container .menu .current-menu-ancestor>a',
                        'body .main-menu .mobile-menu-container .menu .current-menu-parent>a',
                        'body .main-menu .mobile-menu-container .menu .current-menu-item>a',
                        '.main-menu .menu > .current-menu-ancestor > a',
                        '.main-menu .menu > .current-menu-parent > a',
                        '.main-menu .menu > .current-menu-item > a',
                    ),
                    'prop'      => 'color'
                ),
            ),


        );
        $field['menu_hover_bg_color'] = array(
            'name'          =>  __( 'Menu Hover Background Color', 'better-studio' ),
            'id'            =>  'menu_hover_bg_color',
            'type'          =>  'color',
            'std'           =>  '#c8c8c8',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#e6dab0',
            'std-clean'     =>  '#e9e9e9',
            'std-clean-beige'=> '#f5edd0',
            'std-green'     =>  '#509e29',
            'std-blue1'     =>  '#537fb1',
            'std-blue2'     =>  '#4eb5db',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li:hover > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active > a, .main-menu .mobile-menu-container .mega-menu.style-link > li.active:hover > a, .main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li > a',
                        '.main-menu .menu > li:hover > a',
                        '.main-menu .mobile-menu-container .menu > li.alignright > a.children-button',
                        '.main-menu .mobile-menu-container .menu li .children-button',
                        '.main-menu .mobile-menu-container .menu > li.alignright:hover > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li:hover > a',
                    ),
                    'prop'      => 'background-color'
                ),
            ),
            'css-clean'     =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li:hover > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active > a, .main-menu .mobile-menu-container .mega-menu.style-link > li.active:hover > a, .main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li > a',
                        '.main-menu .menu > li:hover > a',
                        '.main-menu .mobile-menu-container .menu .sub-menu li:hover > a',
                        '.main-menu .mobile-menu-container .menu > li.alignright:hover > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li:hover > a',
                    ),
                    'prop'      => 'background-color'
                ),
            ),
            'css-clean-beige'     =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li:hover > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li.active > a, .main-menu .mobile-menu-container .mega-menu.style-link > li.active:hover > a, .main-menu .mobile-menu-container .mega-menu.style-link > li.active .sub-menu li > a',
                        '.main-menu .menu > li:hover > a',
                        '.main-menu .mobile-menu-container .menu .sub-menu li:hover > a',
                        '.main-menu .mobile-menu-container .menu > li.alignright:hover > a',
                        '.main-menu .mobile-menu-container .mega-menu.style-link > li:hover > a',
                    ),
                    'prop'      => 'background-color'
                ),
            ),


        );
        $field['menu_hover_font_color'] = array(
            'name'          =>  __( 'Menu Hover Page Text Color', 'better-studio' ),
            'id'            =>  'menu_hover_font_color',
            'type'          =>  'color',
            'std'           =>  '#3b3b3b',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#3b3b3b',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .menu > li:hover > a',
                        '.main-menu .mobile-menu-container .menu > li.alignright:hover > a',
                    ),
                    'prop'      => 'color'
                ),
            ),
            'css-clean'     =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .menu > li:hover > a',
                        '.main-menu .mobile-menu-container .menu > li.alignright:hover > a',
                        '.main-menu .mobile-menu-container .menu .sub-menu li:hover > a',
                    ),
                    'prop'      => 'color'
                ),
            ),
            'css-clean-beige'=>  array(
                array(
                    'selector'  => array(
                        '.main-menu .menu > li:hover > a',
                        '.main-menu .mobile-menu-container .menu > li.alignright:hover > a',
                        '.main-menu .mobile-menu-container .menu .sub-menu li:hover > a',
                    ),
                    'prop'      => 'color'
                ),
            ),
        );

        /**
         * 5.6.4. => Main Navigation - Drop Down Sub Menu
         */
        $field[] = array(
            'name'      =>  __( 'Main Navigation - Drop Down Sub Menu', 'better-studio' ),
            'type'      =>  'heading',
        );

        $field['menu_sub_bg_color'] = array(
            'name'          =>  __( 'Sub Menu Background Color', 'better-studio' ),
            'id'            =>  'menu_sub_bg_color',
            'type'          =>  'color',
            'std'           =>  '#c8c8c8',
            'std-dark'      =>  '#304254',
            'std-full-dark' =>  '#304254',
            'std-black'     =>  '#3b3b3b',
            'std-full-black'=>  '#3b3b3b',
            'std-beige'     =>  '#e6dab0',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#ffffff',
            'std-green'     =>  '#73b352',
            'std-blue1'     =>  '#4c75a4',
            'std-blue2'     =>  '#55bae0',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.desktop-menu-container .menu > li > .sub-menu',
                        '.desktop-menu-container .menu > li > .sub-menu .sub-menu',
                    ),
                    'prop'      => array( 'background-color' )
                ),
                array(
                    'filter'    => array( 'woocommerce' ),
                    'selector'  => array(
                        '.desktop-menu-container .mega-menu.cart-widget.widget_shopping_cart ul.cart_list li',
                    ),
                    'prop'      => 'background-color'
                ),
            )
        );
        $field['menu_sub_text_color'] = array(
            'name'          =>  __( 'Sub Menu Text Color', 'better-studio' ),
            'id'            =>  'menu_sub_text_color',
            'type'          =>  'color',
            'std'           =>  '#3b3b3b',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#3b3b3b',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.desktop-menu-container .menu > li > .sub-menu li a',
                    ),
                    'prop'      => array( 'color' )
                ),
            )
        );
        $field['menu_sub_separator_color'] = array(
            'name'          =>  __( 'Sub Menu Separator Line Color', 'better-studio' ),
            'id'            =>  'menu_sub_separator_color',
            'type'          =>  'color',
            'std'           =>  '#b7b7b7',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#dbcd9b',
            'std-clean'     =>  '#b7b7b7',
            'std-clean-beige'=> '#f2e3bb',
            'std-green'     =>  '#61a33e',
            'std-blue1'     =>  '#4a719e',
            'std-blue2'     =>  '#45b5df',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.desktop-menu-container .menu>li>.sub-menu li',
                        '.desktop-menu-container .mega-menu.style-link > li',
                        '.desktop-menu-container .menu > li',
                    ),
                    'prop'      => array( 'border-bottom-color' )
                ),
            )
        );
        $field['menu_sub_border_color'] = array(
            'name'          =>  __( 'Sub Menu Border Color', 'better-studio' ),
            'id'            =>  'menu_sub_border_color',
            'type'          =>  'color',
            'std-clean'     =>  '#b7b7b7',
            'std-clean-beige'=> '#dbcd9b',
            'style'         =>  array(
                'clean',
                'clean-beige',
            ),
            'css-clean'           =>  array(
                array(
                    'selector'  => array(
                        '.desktop-menu-container .mega-menu.cart-widget.widget_shopping_cart',
                        '.desktop-menu-container .menu > li > .sub-menu',
                        '.desktop-menu-container .menu>li>.sub-menu .sub-menu',
                    ),
                    'prop'      => array(
                        'border-color'
                    )
                ),
            ),
            'css-clean-beige'      =>  array(
                array(
                    'selector'  => array(
                        '.desktop-menu-container .mega-menu.cart-widget.widget_shopping_cart',
                        '.desktop-menu-container .menu>li>.sub-menu',
                        '.desktop-menu-container .menu li>.sub-menu .sub-menu',
                    ),
                    'prop'      => array(
                        'border-color'
                    )
                ),
            ),

        );
        $field['menu_sub_current_bg_color'] = array(
            'name'          =>  __( 'Sub Menu Current Page Background Color','better-studio'),
            'id'            =>  'menu_sub_current_bg_color',
            'type'          =>  'color',
            'std'           =>  '#c8c8c8',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#dbcd9b',
            'std-clean'     =>  '#e9e9e9',
            'std-clean-beige'=> '#f5edd0',
            'std-green'     =>  '#509e29',
            'std-blue1'     =>  '#35639a',
            'std-blue2'     =>  '#3cb2de',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.desktop-menu-container .menu>li >.sub-menu li.current_page_item>a',
                        '.desktop-menu-container .menu>li >.sub-menu li.current-menu-item>a',
                        '.desktop-menu-container .menu>li >.sub-menu li.current-menu-parent>a',
                        '.desktop-menu-container .menu>li >.sub-menu li.current-menu-ancestor>a',

                    ),
                    'prop'      => 'background-color'
                ),
            )
        );
        $field['menu_sub_current_font_color'] = array(
            'name'          =>  __( 'Sub Menu Current Page Text Color', 'better-studio' ),
            'id'            =>  'menu_sub_current_font_color',
            'type'          =>  'color',
            'std'           =>  '#3b3b3b',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#3b3b3b',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.desktop-menu-container .menu>li>.sub-menu li.current_page_item>a',
                        '.desktop-menu-container .menu>li>.sub-menu li.current-menu-item>a',
                        '.desktop-menu-container .menu>li>.sub-menu li.current-menu-parent>a',
                        '.desktop-menu-container .menu>li>.sub-menu li.current-menu-ancestor>a',
                    ),
                    'prop'      => 'color'
                ),
            )
        );
        $field['menu_sub_hover_bg_color'] = array(
            'name'          =>  __( 'Sub Menu Hover Background Color', 'better-studio' ),
            'id'            =>  'menu_sub_hover_bg_color',
            'type'          =>  'color',
            'std'           =>  '#c8c8c8',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#dbcd9b',
            'std-clean'     =>  '#e9e9e9',
            'std-clean-beige'=> '#f5edd0',
            'std-green'     =>  '#5aad31',
            'std-blue1'     =>  '#537fb1',
            'std-blue2'     =>  '#3cb2de',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.desktop-menu-container .menu>li>.sub-menu>li:hover>a',
                        '.desktop-menu-container .menu>li>.sub-menu .sub-menu>li:hover>a',
                    ),
                    'prop'      => 'background-color'
                ),
                array(
                    'filter'    => array( 'woocommerce' ),
                    'selector'  => array(
                        '.desktop-menu-container .mega-menu.cart-widget.widget_shopping_cart ul.cart_list li:hover',
                    ),
                    'prop'      => array( 'background-color' )
                ),
            )
        );
        $field['menu_sub_hover_font_color'] = array(
            'name'          =>  __( 'Sub Menu Hover Text Color', 'better-studio' ),
            'id'            =>  'menu_sub_hover_font_color',
            'type'          =>  'color',
            'std'           =>  '#3b3b3b',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#3b3b3b',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.desktop-menu-container .menu>li>.sub-menu>li:hover>a',
                        '.desktop-menu-container .menu>li>.sub-menu .sub-menu>li:hover>a',
                    ),
                    'prop'      => 'color'
                ),
                array(
                    'filter'    => array( 'woocommerce' ),
                    'selector'  => array(
                        '.mega-menu.cart-widget.widget_shopping_cart ul.cart_list li',
                        '.mega-menu.cart-widget.widget_shopping_cart ul.cart_list a',
                        '.mega-menu.cart-widget.widget_shopping_cart ul.cart_list p',
                        '.main-wrap .widget_shopping_cart .total',
                        '.main-wrap .widget_shopping_cart .total .amount',
                        '.main-wrap ul.product_list_widget li .quantity',
                    ),
                    'prop'      => array( 'color' )
                ),
            )
        );


        /**
         * 5.6.5. => Main Navigation - Mega Menu
         */
        $field[] = array(
            'name'          =>  __( 'Main Navigation - Mega Menu', 'better-studio' ),
            'type'          =>  'heading',
        );
        $field['menu_mega_bg_color'] = array(
            'name'          =>  __( 'Mega Menu Background Color', 'better-studio' ),
            'id'            =>  'menu_mega_bg_color',
            'type'          =>  'color',
            'std'           =>  '#e0e0e0',
            'std-dark'      =>  '#304254',
            'std-full-dark' =>  '#304254',
            'std-black'     =>  '#3b3b3b',
            'std-full-black'=>  '#3b3b3b',
            'std-beige'     =>  '#e6dab0',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#ffffff',
            'std-green'     =>  '#73b352',
            'std-blue1'     =>  '#4c75a4',
            'std-blue2'     =>  '#91d4ef',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mega-menu',
                    ),
                    'prop'      => 'background-color'
                ),
            )
        );
        $field['menu_mega_links_bg_color'] = array(
            'name'          =>  __( 'Mega Menu Links Background Color', 'better-studio' ),
            'id'            =>  'menu_mega_links_bg_color',
            'type'          =>  'color',
            'std'           =>  '#c8c8c8',
            'std-dark'      =>  '#253442',
            'std-full-dark' =>  '#253442',
            'std-black'     =>  '#242424',
            'std-full-black'=>  '#242424',
            'std-beige'     =>  '#e0d19b',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#f5edd0',
            'std-green'     =>  '#5aad31',
            'std-blue1'     =>  '#436a97',
            'std-blue2'     =>  '#73cbee',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .menu > li > .mega-menu .mega-menu-links',
                    ),
                    'prop'      => 'background-color'
                ),
            )
        );
        $field['menu_mega_text_color'] = array(
            'name'          =>  __( 'Mega Menu Text Color', 'better-studio' ),
            'id'            =>  'menu_mega_text_color',
            'type'          =>  'color',
            'std'           =>  '#3b3b3b',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#3b3b3b',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.mega-menu.style-link > li > a',
                        '.main-menu .menu > li .sub-menu > li > a',
                        '.main-menu .mega-menu .listing-simple li h3.title a',
                        '.main-menu .mega-menu .block-modern h2.title a',
                        '.main-menu .mega-menu .listing-thumbnail h3.title a',
                        '.main-menu .mega-menu .blog-block h2 a',
                    ),
                    'prop'      => array( 'color' )
                ),
            )
        );
        $field['menu_mega_separator_color'] = array(
            'name'          =>  __( 'Mega Menu Separator Line Color', 'better-studio' ),
            'id'            =>  'menu_mega_separator_color',
            'type'          =>  'color',
            'std'           =>  '#b7b7b7',
            'std-dark'      =>  '#40576e',
            'std-full-dark' =>  '#40576e',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#dbcd9b',
            'std-clean'     =>  '#b7b7b7',
            'std-clean-beige'=> '#f2e3bb',
            'std-green'     =>  '#489d1e',
            'std-blue1'     =>  '#3d618b',
            'std-blue2'     =>  '#3eb3df',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.mega-menu.style-link > li > a',
                        '.mega-menu.style-category > li > a',
                        '.mega-menu.style-link li .sub-menu li',
                        '.mega-menu.style-category li .sub-menu li',
                        '.mega-menu .listing-simple li',
                        '.mega-menu .listing-thumbnail li',
                        '.main-menu .menu li .sub-menu.mega-menu-links .menu-item-has-children > a',
                        '.main-menu .menu li .mega-menu .sub-menu li',
                    ),
                    'prop'      => array( 'border-bottom-color' )
                ),
                array(
                    'selector'  => array(
                        '.mega-menu.style-link li .sub-menu .sub-menu li:first-child',
                    ),
                    'prop'      => 'border-top-color'
                ),
            )
        );
        $field['menu_mega_border_color'] = array(
            'name'          =>  __( 'Mega Menu Border Color', 'better-studio' ),
            'id'            =>  'menu_mega_border_color',
            'type'          =>  'color',
            'std-clean'     =>  '#b7b7b7',
            'std-clean-beige'=>  '#dbcd9b',
            'style'         =>  array(
                'clean',
                'clean-beige',
            ),
            'css-clean'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mega-menu',
                    ),
                    'prop'      => array( 'border-color' )
                ),
            ),
            'css-clean-beige'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .mega-menu',
                    ),
                    'prop'      => array( 'border-color' )
                ),
            ),

        );
        $field['menu_mega_current_bg_color'] = array(
            'name'          =>  __( 'Mega Menu Links Current Page Background Color','better-studio'),
            'id'            =>  'menu_mega_current_bg_color',
            'type'          =>  'color',
            'std'           =>  '#c8c8c8',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#dbcd9b',
            'std-clean'     =>  '#e9e9e9',
            'std-clean-beige'=> '#f5edd0',
            'std-green'     =>  '#509e29',
            'std-blue1'     =>  '#3b5e86',
            'std-blue2'     =>  '#4cbeeb',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .menu .mega-menu .sub-menu li.current_page_item>a',
                        '.main-menu .menu .mega-menu .sub-menu li.current-menu-item>a',
                        '.main-menu .menu .mega-menu .sub-menu li.current-menu-parent>a',
                        '.main-menu .menu .mega-menu .sub-menu li.current-menu-ancestor>a',
                    ),
                    'prop'      => 'background-color'
                ),
            )
        );
        $field['menu_mega_current_font_color'] = array(
            'name'          =>  __( 'Mega Menu Links Current Page Text Color', 'better-studio' ),
            'id'            =>  'menu_mega_current_font_color',
            'type'          =>  'color',
            'std'           =>  '#3b3b3b',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#3b3b3b',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .menu .mega-menu .sub-menu li.current_page_item>a',
                        '.main-menu .menu .mega-menu .sub-menu li.current-menu-item>a',
                        '.main-menu .menu .mega-menu .sub-menu li.current-menu-parent>a',
                        '.main-menu .menu .mega-menu .sub-menu li.current-menu-ancestor>a',
                    ),
                    'prop'      => 'color'
                ),
            )
        );
        $field['menu_mega_hover_bg_color'] = array(
            'name'          =>  __( 'Mega Menu Links Hover Background Color', 'better-studio' ),
            'id'            =>  'menu_mega_hover_bg_color',
            'type'          =>  'color',
            'std'           =>  '#d8d8d8',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#dbcd9b',
            'std-clean'     =>  '#e9e9e9',
            'std-clean-beige'=> '#f5edd0',
            'std-green'     =>  '#5aad31',
            'std-blue1'     =>  '#537fb1',
            'std-blue2'     =>  '#6bc7ec',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .menu .mega-menu li .sub-menu li:hover > a',
                        '.main-menu .menu > li > .mega-menu.style-category .mega-menu-links a:hover',
                    ),
                    'prop'      => 'background-color'
                ),
            )
        );
        $field['menu_mega_hover_font_color'] = array(
            'name'          =>  __( 'Mega Menu Links Hover Text Color', 'better-studio' ),
            'id'            =>  'menu_mega_hover_font_color',
            'type'          =>  'color',
            'std'           =>  '#3b3b3b',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#3b3b3b',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-menu .menu .mega-menu .sub-menu li:hover>a',
                    ),
                    'prop'      => 'color'
                ),
            )
        );
        $field['menu_mega_section_title_font_color'] = array(
            'name'          =>  __( 'Mega Menu Section Title Text Color', 'better-studio' ),
            'id'            =>  'menu_mega_section_title_font_color',
            'type'          =>  'color',
            'std'           =>  '#626262',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#626262',
            'std-clean-beige'=>  '',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.mega-menu .section-heading span.h-title',
                    ),
                    'prop'      => 'color'
                ),
            )
        );
        $field['menu_mega_section_title_bg_color'] = array(
            'name'          =>  __( 'Mega Menu Section Title Background Color', 'better-studio' ),
            'id'            =>  'menu_mega_section_title_bg_color',
            'type'          =>  'color',
            'std'           =>  '#F4F4F3',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#dbcd9b',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#dbcd9b',
            'std-green'     =>  '#3f8f17',
            'std-blue1'     =>  '#3b5e86',
            'std-blue2'     =>  '#31a8d5',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.mega-menu .section-heading span.h-title',
                    ),
                    'prop'      => 'background-color'
                ),
            ),
            'css-clean'           =>  array(
                array(
                    'selector'  => array(
                        '.mega-menu .section-heading',
                    ),
                    'prop'      => 'background-color'
                ),
            ),
            'css-clean-beige'           =>  array(
                array(
                    'selector'  => array(
                        '.mega-menu .section-heading',
                    ),
                    'prop'      => 'background-color'
                ),
            ),
        );
        $field['menu_mega_section_title_border_color'] = array(
            'name'          =>  __( 'Mega Menu Section Title Border Color', 'better-studio' ),
            'id'            =>  'menu_mega_section_title_border_color',
            'type'          =>  'color',
            'std'           =>  '#c9c9c9',
            'std-dark'      =>  '#4e7499',
            'std-full-dark' =>  '#4e7499',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#c7b987',
            'std-clean'     =>  '#c9c9c9',
            'std-clean-beige'=> '#d9c680',
            'std-green'     =>  '#3f8f17',
            'std-blue1'     =>  '#3b5e86',
            'std-blue2'     =>  '#31a8d5',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.mega-menu .section-heading',
                    ),
                    'prop'      => 'border-bottom-color'
                ),
            ),
            'css-clean'=>  array(
                array(
                    'selector'  => array(
                        '.mega-menu .section-heading',
                    ),
                    'prop'      => array(
                        'border-bottom-color',
                        'border-top-color',
                    )
                ),
            ),
            'css-clean-beige'=>  array(
                array(
                    'selector'  => array(
                        '.mega-menu .section-heading',
                    ),
                    'prop'      => array(
                        'border-bottom-color',
                        'border-top-color',
                    )
                ),
            ),
        );

        /**
         * 5.6.6. => Breadcrumb
         */
        $field[] = array(
            'name'          =>  __( 'Breadcrumb', 'better-studio' ),
            'type'          =>  'heading',
        );
        $field['color_breadcrumb_bg_color'] = array(
            'name'          =>  __( 'Breadcrumb Background Color', 'better-studio' ),
            'id'            =>  'color_breadcrumb_bg_color',
            'type'          =>  'color',
            'std'           =>  '#f2f2f2',
            'std-dark'      =>  '#304254',
            'std-full-dark' =>  '#304254',
            'std-black'     =>  '#3b3b3b',
            'std-full-black'=>  '#3b3b3b',
            'std-beige'     =>  '#f5edd0',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#ffffff',
            'std-green'     =>  '#67b20b',
            'std-blue1'     =>  '#49709c',
            'std-blue2'     =>  '#edf8fc',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.bf-breadcrumb-wrapper',
                        '.bf-breadcrumb-wrapper.boxed .bf-breadcrumb',
                    ),
                    'prop'      =>  'background-color'
                )
            )
        );
        $field['color_breadcrumb_font_color'] = array(
            'name'          =>  __( 'Breadcrumb Font Color', 'better-studio' ),
            'id'            =>  'color_breadcrumb_font_color',
            'type'          =>  'color',
            'std'           =>  '#444444',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#444444',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#f5fff0',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.bf-breadcrumb a',
                    ),
                    'prop'      =>  'color'
                )
            )
        );
        $field['color_breadcrumb_current_font_color'] = array(
            'name'          =>  __( 'Breadcrumb Current Page Text Color', 'better-studio' ),
            'id'            =>  'color_breadcrumb_current_font_color',
            'type'          =>  'color',
            'std'           =>  '#757d81',
            'std-dark'      =>  '#97b5d1',
            'std-full-dark' =>  '#97b5d1',
            'std-black'     =>  '#c4c4c4',
            'std-full-black'=>  '#c4c4c4',
            'std-beige'     =>  '#705e1f',
            'std-clean'     =>  '#757d81',
            'std-clean-beige'=> '#827440',
            'std-green'     =>  '#e4fada',
            'std-blue1'     =>  '#dae7f6',
            'std-blue2'     =>  '#dae7f6',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.bf-breadcrumb .sep',
                        '.bf-breadcrumb .trail-end',
                    ),
                    'prop'      =>  'color'
                )
            )
        );
        $field['color_breadcrumb_border_color'] = array(
            'name'          =>  __( 'Breadcrumb Border Color', 'better-studio' ),
            'id'            =>  'color_breadcrumb_border_color',
            'type'          =>  'color',
            'style'         =>  array(
                'clean',
                'clean-beige',
            ),
            'std-clean'     =>  '#c9c9c9',
            'std-clean-beige'=> '#d9c680',
            'css-clean'       => array(
                array(
                    'selector'  => array(
                        '.bf-breadcrumb-wrapper.boxed .bf-breadcrumb',
                    ),
                    'prop'      => 'border-color'
                ),
                array(
                    'selector'  => array(
                        '.bf-breadcrumb-wrapper',
                    ),
                    'prop'      => array(
                        'border-bottom-color',
                    )
                ),
                array(
                    'selector'  => array(
                        '.bf-breadcrumb-wrapper.boxed .bf-breadcrumb',
                    ),
                    'prop'      => array(
                        'border-top'    => '1px solid %%value%%'
                    ),
                    'before'    => '@media only screen and (max-width : 768px) {',
                    'after'     => '}',
                ),
                array(
                    'selector'  => array(
                        '.bf-breadcrumb-wrapper',
                    ),
                    'prop'      => array(
                        'border-top' => '1px solid %%value%%'
                    ),
                    'before'    => '@media only screen and (max-width : 768px) {',
                    'after'     => '}',
                ),
            ),
            'css-clean-beige'=> array(
                array(
                    'selector'  => array(
                        '.bf-breadcrumb-wrapper.boxed .bf-breadcrumb',
                    ),
                    'prop'      => 'border-color'
                ),
                array(
                    'selector'  => array(
                        '.bf-breadcrumb-wrapper',
                    ),
                    'prop'      => array(
                        'border-bottom-color',
                    )
                ),
                array(
                    'selector'  => array(
                        '.bf-breadcrumb-wrapper.boxed .bf-breadcrumb',
                    ),
                    'prop'      => array(
                        'border-top'    => '1px solid %%value%%'
                    ),
                    'before'    => '@media only screen and (max-width : 768px) {',
                    'after'     => '}',
                ),
                array(
                    'selector'  => array(
                        '.bf-breadcrumb-wrapper',
                    ),
                    'prop'      => array(
                        'border-top' => '1px solid %%value%%'
                    ),
                    'before'    => '@media only screen and (max-width : 768px) {',
                    'after'     => '}',
                ),
            ),

        );

        /**
         * 5.6.7. => Slider
         */
        $field[] = array(
            'name'          =>  __( 'Slider', 'better-studio' ),
            'type'          =>  'heading',
        );
        $field['slider_bg_color'] = array(
            'name'          =>  __( 'Slider Background Color', 'better-studio' ),
            'id'            =>  'slider_bg_color',
            'type'          =>  'color',
            'std'           =>  '#f2f2f2',
            'std-full-dark' =>  '#3c546b',
            'std-full-black'=>  '#3b3b3b',
            'std-beige'     =>  '#f5efd8',
            'std-clean'     =>  '#fcfcfc',
            'std-clean-beige'=> '#fffcf0',
            'std-green'     =>  '#f2f2f2',
            'std-blue2'     =>  '#f1f8fb',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => '.main-slider-wrapper' ,
                    'prop'      => 'background-color'
                )
            )
        );
        $field['slider_bg_image'] = array(
            'name'          =>  __( 'Slider Background Image', 'better-studio' ),
            'id'            =>  'slider_bg_image',
            'type'          =>  'background_image',
            'std'           =>  '',
            'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
            'desc'          =>  __( 'Please use a background pattern that can be repeated. Note that it will override the background color option.', 'better-studio' ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.main-slider-wrapper'
                    ),
                    'prop'      => array( 'background-image' ),
                    'type'      => 'background-image'
                )
            )
        );
        $field['slider_border_style'] = array(
            'name'          =>  __( 'Slider Border Style', 'better-studio' ),
            'id'            =>  'slider_border_style',
            'type'          =>  'border',
            'style'         =>  array(
                'clean',
                'clean-beige',
            ),
            'preview'       =>  true,
            'preview-css'   =>  'border-top: 1px solid #DFDFDF; border-bottom: 1px solid #DFDFDF; border-left: none; border-right:none; width: 100%; height: 55px;',
            'std-clean' => array(
                'top' => array(
                    'width' => '1',
                    'style' => 'solid',
                    'color' => '#dfdfdf',
                ),
                'bottom' => array(
                    'width' => '1',
                    'style' => 'solid',
                    'color' => '#dfdfdf',
                ),
            ),
            'std-clean-beige' => array(
                'top' => array(
                    'width' => '1',
                    'style' => 'solid',
                    'color' => '#d9c680',
                ),
                'bottom' => array(
                    'width' => '1',
                    'style' => 'solid',
                    'color' => '#d9c680',
                ),
            ),
            'border'    => array(
                'top'       =>  array( 'width', 'style', 'color' ),
                'bottom'    =>  array( 'width', 'style', 'color' ),
            ),
            'css-clean'       => array(
                array(
                    'selector'  => array(
                        '.main-slider-wrapper'
                    ),
                    'type'      => 'border'
                )
            ),
            'css-clean-beige'       => array(
                array(
                    'selector'  => array(
                        '.main-slider-wrapper'
                    ),
                    'type'      => 'border'
                )
            ),

        );

        /**
         * 5.6.8. => News Ticker
         */
        $field[] = array(
            'name'          =>  __( 'News Ticker', 'better-studio' ),
            'type'          =>  'heading',
        );
        $field['newsticker_bg_color'] = array(
            'name'          =>  __( 'News Ticker Background Color', 'better-studio' ),
            'id'            =>  'newsticker_bg_color',
            'type'          =>  'color',
            'std'           =>  '#e0e0e0',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#4d4d4d',
            'std-full-black'=>  '#4d4d4d',
            'std-beige'     =>  '#f7eecc',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#ffffff',
            'std-blue2'     =>  '#ecf7fb',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => '.bf-news-ticker' ,
                    'prop'      => 'background-color'
                )
            )
        );
        $field['newsticker_link_color'] = array(
            'name'          =>  __( 'News Ticker Links Color', 'better-studio' ),
            'id'            =>  'newsticker_link_color',
            'type'          =>  'color',
            'std'           =>  '#696969',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#705e1f',
            'std-clean-beige'=> '#705e1f',
            'std-blue2'     =>  '#31a8d5',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => '.bf-news-ticker ul.news-list li a' ,
                    'prop'      => 'color'
                )
            )
        );
        $field['newsticker_border_option'] = array(
            'name'          =>  __( 'News Ticker Border', 'better-studio' ),
            'id'            =>  'newsticker_border_option',
            'type'          =>  'border',
            'style'         =>  array(
                'clean',
                'clean-beige',
            ),
            'preview'       =>  true,
            'preview-css'   =>  'border: 1px solid #DDDDDD; width: 90%; height: 30px;',
            'std-clean' => array(
                'all' => array(
                    'width' => '1',
                    'style' => 'dashed',
                    'color' => '#dddddd',
                ),
            ),
            'std-clean-beige' => array(
                'all' => array(
                    'width' => '1',
                    'style' => 'dashed',
                    'color' => '#d9c680',
                ),
            ),
            'border'    => array(
                'all'    =>  array( 'width', 'style', 'color' ),
            ),
            'css-clean'       => array(
                array(
                    'selector'  => array(
                        '.bf-news-ticker .news-list'
                    ),
                    'type'      => 'border'
                )
            ),
            'css-clean-beige'=> array(
                array(
                    'selector'  => array(
                        '.bf-news-ticker .news-list'
                    ),
                    'type'      => 'border'
                )
            ),

        );

        /**
         * 5.6.9. => Page Title
         */
        $field[] = array(
            'name'      =>  __( 'Page Title', 'better-studio' ),
            'type'      =>  'heading',
        );

        $field['color_page_title_border_color'] = array(
            'name'          =>  __( 'Page Title Border Color', 'better-studio' ),
            'id'            =>  'color_page_title_border_color',
            'type'          =>  'color',
            'std'           =>  '#c9c9c9',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#878787',
            'std-full-black'=>  '#878787',
            'std-beige'     =>  '#d9c680',
            'std-clean'     =>  '#c9c9c9',
            'std-clean-beige'=> '#dbcd9b',
            'std-blue2'     =>  '#A7E5FC',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => '.page-heading' ,
                    'prop'      => 'border-bottom-color'
                ),
                array(
                    'filter'    => array( 'bbpress' ),
                    'selector'  => array(
                        '#bbpress-forums li.bbp-header'
                    ),
                    'prop'      => 'border-bottom-color'
                ),
                array(
                    'filter'    => array( 'woocommerce' ),
                    'selector'  => array(
                        'body.woocommerce-account .woocommerce .address .title h3',
                        'body.woocommerce-account .woocommerce h2',
                        'body .cross-sells h2',
                        'body .related.products h2',
                        'body.woocommerce #reviews h3',
                        'body.woocommerce-page #reviews h3',
                        'body .woocommerce-tabs .panel.entry-content h2',
                        'body.woocommerce .shipping_calculator h2',
                        'body.woocommerce .cart_totals h2',
                        'body h3#order_review_heading',
                        'body .woocommerce-shipping-fields h3',
                        'body .woocommerce-billing-fields h3',
                    ),
                    'prop'      => 'border-bottom-color'
                ),

            )
        );


        /**
         * 5.6.10. => Section/Listing Title
         */
        $field[] = array(
            'name'          =>  __( 'Section/Listing Title', 'better-studio' ),
            'type'          =>  'heading',
        );

        $field['color_section_title_font_color'] = array(
            'name'          =>  __( 'Section/Listing Title Font Color', 'better-studio' ),
            'id'            =>  'color_section_title_font_color',
            'type'          =>  'color',
            'std'           =>  '#626262',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'std-blue1'     =>  '#ffffff',
            'std-blue2'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.section-heading.extended .other-links .other-item a',
                        '.section-heading span.h-title a',
                        '.section-heading span.h-title',
                    ),
                    'prop'      => 'color'
                )
            ),

        );
        $field['color_section_title_bg_color'] = array(
            'name'          =>  __( 'Section/Listing Text Title Background Color', 'better-studio' ),
            'id'            =>  'color_section_title_bg_color',
            'type'          =>  'color',
            'std'           =>  '#e0e0e0',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#4a4a4a',
            'std-full-black'=>  '#4a4a4a',
            'std-beige'     =>  '#f5edd0',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#ffffff',
            'std-green'     =>  '#639e1b',
            'std-blue1'     =>  '#4c75a4',
            'std-blue2'     =>  '#61bee1',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.section-heading.extended .other-links .other-item a',
                        '.section-heading span.h-title'
                    ),
                    'prop'      => 'background-color'
                )
            ),
            'css-clean'=>  array(
                array(
                    'selector'  => array(
                        '.section-heading'
                    ),
                    'prop'      => 'background-color'
                )
            ),
            'css-clean-beige'=>  array(
                array(
                    'selector'  => array(
                        '.section-heading'
                    ),
                    'prop'      => 'background-color'
                )
            ),
        );
        $field['color_section_title_full_bg_color'] = array(
            'name'          =>  __( 'Section/Listing Title Background Gradient Color', 'better-studio' ),
            'id'            =>  'color_section_title_full_bg_color',
            'type'          =>  'color',
            'std'           =>  '#f5f5f6',
            'std-dark'      =>  '#eaf1f8',
            'std-full-dark' =>  '#172736',
            'std-black'     =>  '#f5f5f6',
            'std-full-black'=>  '#242424',
            'std-beige'     =>  '#fffae8',
            'std-clean'     =>  '#f5f5f6',
            'std-clean-beige'=> '#fffcef',
            'std-green'     =>  '#f6ffeb',
            'std-blue1'     =>  '#f2f7fd',
            'std-blue2'     =>  '#ecf7fb',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.content-column .section-heading'
                    ),
                    'prop'      => array(
                        'background'  => "-moz-linear-gradient(top, rgba(255,255,255,0) 0%, %%value%% 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(100%,%%value%%));
    background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%,%%value%% 100%);
    background: -o-linear-gradient(top, rgba(255,255,255,0) 0%,%%value%% 100%);
    background: -ms-linear-gradient(top, rgba(255,255,255,0) 0%,%%value%% 100%);
    background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,%%value%% 100%)",
                    )
                )
            ),
            'css-full-dark'           =>  array(
                array(
                    'selector'  => array(
                        '.content-column .section-heading'
                    ),
                    'prop'      => array(
                        'background'  => "-moz-linear-gradient(top, rgba(0,0,0,0) 0%, %%value%% 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,%%value%%));
    background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%,%%value%% 100%);
    background: -o-linear-gradient(top, rgba(0,0,0,0) 0%,%%value%% 100%);
    background: -ms-linear-gradient(top, rgba(0,0,0,0) 0%,%%value%% 100%);
    background: linear-gradient(to bottom, rgba(0,0,0,0) 0%,%%value%% 100%)",
                    )
                )
            ),
            'css-full-black'           =>  array(
                array(
                    'selector'  => array(
                        '.content-column .section-heading'
                    ),
                    'prop'      => array(
                        'background'  => "-moz-linear-gradient(top, rgba(0,0,0,0) 0%, %%value%% 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,%%value%%));
    background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%,%%value%% 100%);
    background: -o-linear-gradient(top, rgba(0,0,0,0) 0%,%%value%% 100%);
    background: -ms-linear-gradient(top, rgba(0,0,0,0) 0%,%%value%% 100%);
    background: linear-gradient(to bottom, rgba(0,0,0,0) 0%,%%value%% 100%)",
                    )
                )
            ),


        );
        $field['color_section_title_border_color'] = array(
            'name'          =>  __( 'Section/Listing Title Border Color', 'better-studio' ),
            'id'            =>  'color_section_title_border_color',
            'type'          =>  'color',
            'std'           =>  '#c9c9c9',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#446280',
            'std-black'     =>  '#3b3b3b',
            'std-full-black'=>  '#3b3b3b',
            'std-beige'     =>  '#d9c680',
            'std-clean'     =>  '#c9c9c9',
            'std-clean-beige'=> '#dbcd9b',
            'std-green'     =>  '#568f11',
            'std-blue1'     =>  '#4c75a4',
            'std-blue2'     =>  '#61bee1',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => '.section-heading' ,
                    'prop'      => 'border-bottom-color'
                )
            ),
            'css-clean'     =>  array(
                array(
                    'selector'  => array(
                        '.section-heading',
                        '.section-heading.extended.tab-heading',
                    ),
                    'prop'      => 'border-color'
                )
            ),
            'css-clean-beige'=>  array(
                array(
                    'selector'  => array(
                        '.section-heading',
                        '.section-heading.extended.tab-heading',
                    ),
                    'prop'      => 'border-color'
                )
            ),
        );

        /**
         * 5.6.11. => Sidebar Widget Title
         */
        $field[] = array(
            'name'      =>  __( 'Sidebar Widget Title', 'better-studio' ),
            'type'      =>  'heading',
        );
        $field['color_widget_title_bg_color'] = array(
            'name'          =>  __( 'Widget Title Background Color', 'better-studio' ),
            'id'            =>  'color_widget_title_bg_color',
            'type'          =>  'color',
            'std'           =>  '#f4f4f4',
            'std-dark'      =>  '#304254',
            'std-full-dark' =>  '#3c546b',
            'std-black'     =>  '#4a4a4a',
            'std-full-black'=>  '#4a4a4a',
            'std-beige'     =>  '#f5edd0',
            'std-clean'     =>  '',
            'std-clean-beige'=> '',
            'std-green'     =>  '#77bb24',
            'std-blue1'     =>  '#4c75a4',
            'std-blue2'     =>  '#d2f2ff',
            'style'         => array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => '.primary-sidebar-widget .section-heading' ,
                    'prop'      => 'background-color'
                )
            ),
            'css-dark'      =>  array(
                array(
                    'selector'  => array(
                        '.primary-sidebar-widget .section-heading',
                        '.footer-larger-widget .section-heading'
                    ),
                    'prop'      => 'background-color'
                )
            ),
            'css-full-dark'      =>  array(
                array(
                    'selector'  => array(
                        '.primary-sidebar-widget .section-heading',
                        '.footer-larger-widget .section-heading'
                    ),
                    'prop'      => 'background-color'
                )
            ),
            'css-black'      =>  array(
                array(
                    'selector'  => array(
                        '.primary-sidebar-widget .section-heading',
                        '.footer-larger-widget .section-heading'
                    ),
                    'prop'      => 'background-color'
                )
            ),
        );
        $field['color_widget_title_text_bg_color'] = array(
            'name'          =>  __( 'Widget Title Text Background Color', 'better-studio' ),
            'id'            =>  'color_widget_title_text_bg_color',
            'type'          =>  'color',
            'std'           =>  '#626262',
            'std-dark'      =>  '#304254',
            'std-full-dark' =>  '#3c546b',
            'std-black'     =>  '#4a4a4a',
            'std-full-black'=>  '#4a4a4a',
            'std-beige'     =>  '#e6d390',
            'std-green'     =>  '#77bb24',
            'std-blue1'     =>  '#4c75a4',
            'std-blue2'     =>  '#61bee1',
            'style'         => array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.widget .section-heading.extended .other-links .other-item a',
                        '.widget .section-heading span.h-title'
                    ),
                    'prop'      => 'background-color'
                )
            ),
        );
        $field['color_widget_title_text_color'] = array(
            'name'          =>  __( 'Widget Title Text Color', 'better-studio' ),
            'id'            =>  'color_widget_title_text_color',
            'type'          =>  'color',
            'std-clean'     =>  '#A3A3A3',
            'std-clean-beige'=> '#493c0c',
            'style'         => array(
                'clean',
                'clean-beige',
            ),
            'css-clean'           =>  array(
                array(
                    'selector'  => array(
                        '.widget .section-heading.extended .other-links .other-item a',
                        '.widget .section-heading span.h-title'
                    ),
                    'prop'      => 'color'
                )
            ),
            'css-clean-beige'=>  array(
                array(
                    'selector'  => array(
                        '.widget .section-heading.extended .other-links .other-item a',
                        '.widget .section-heading span.h-title'
                    ),
                    'prop'      => 'color'
                )
            ),

        );
        $field['color_widget_title_text_border_color'] = array(
            'name'          =>  __( 'Widget Title Text Border Color', 'better-studio' ),
            'id'            =>  'color_widget_title_text_border_color',
            'type'          =>  'color',
            'std'           =>  '#626262',
            'std-dark'      =>  '#304254',
            'std-full-dark' =>  '#3c546b',
            'std-black'     =>  '#4a4a4a',
            'std-full-black'=>  '#4a4a4a',
            'std-beige'     =>  '#ceb559',
            'std-clean'     =>  '#A3A3A3',
            'std-clean-beige'=> '#dbcd9b',
            'std-green'     =>  '#77bb24',
            'std-blue1'     =>  '#4c75a4',
            'std-blue2'     =>  '#61bee1',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.primary-sidebar-widget .section-heading',
                        '.footer-larger-widget .section-heading',
                        '.widget .section-heading.extended.tab-heading',
                    ),
                    'prop'      => 'border-color'
                )
            )
        );

        /**
         * 5.6.12. => Footer
         */
        $field[] = array(
            'name'          =>  __( 'Footer', 'better-studio' ),
            'type'          =>  'heading',
        );
        $field['color_large_footer_bg_color'] = array(
            'name'          =>  __( 'Large Footer Background Color', 'better-studio' ),
            'id'            =>  'color_large_footer_bg_color',
            'type'          =>  'color',
            'std'           =>  '#e0e0e0',
            'std-dark'      =>  '#334a61',
            'std-full-dark' =>  '#334a61',
            'std-black'     =>  '#575757',
            'std-full-black'=>  '#575757',
            'std-beige'     =>  '#f5efd8',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#334a61',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => '.footer-larger-wrapper' ,
                    'prop'      => 'background-color'
                )
            ),
            'css-dark'      =>  array(
                array(
                    'selector'  => array(
                        '.footer-larger-wrapper',
                        '.footer-larger-wrapper .widget.widget_nav_menu li a',
                    ),
                    'prop'      => 'background-color'
                ),
                array(
                    'selector'  => array(
                        '.footer-larger-widget .better-social-counter.style-clean .social-item',
                    ),
                    'prop'      => 'border-bottom-color'
                )
            ),
            'css-full-dark'      =>  array(
                array(
                    'selector'  => array(
                        '.footer-larger-wrapper',
                        '.footer-larger-wrapper .widget.widget_nav_menu li a',
                    ),
                    'prop'      => 'background-color'
                ),
                array(
                    'selector'  => array(
                        '.footer-larger-widget .better-social-counter.style-clean .social-item',
                    ),
                    'prop'      => 'border-bottom-color'
                )
            ),
            'css-green'      =>  array(
                array(
                    'selector'  => array(
                        '.footer-larger-wrapper',
                        '.footer-larger-wrapper .widget.widget_nav_menu li a',
                    ),
                    'prop'      => 'background-color'
                ),
                array(
                    'selector'  => array(
                        '.footer-larger-widget .better-social-counter.style-clean .social-item',
                    ),
                    'prop'      => 'border-bottom-color'
                )
            ),
            'css-black'      =>  array(
                array(
                    'selector'  => array(
                        '.footer-larger-wrapper',
                        '.footer-larger-wrapper .widget.widget_nav_menu li a',
                    ),
                    'prop'      => 'background-color'
                ),
                array(
                    'selector'  => array(
                        '.footer-larger-widget .better-social-counter.style-clean .social-item',
                    ),
                    'prop'      => 'border-bottom-color'
                )
            ),
            'css-beige'      =>  array(
                array(
                    'selector'  => array(
                        '.footer-larger-wrapper',
                        '.footer-larger-wrapper .widget.widget_nav_menu li a',
                    ),
                    'prop'      => 'background-color'
                ),
                array(
                    'selector'  => array(
                        '.footer-larger-widget .better-social-counter.style-clean .social-item',
                    ),
                    'prop'      => 'border-bottom-color'
                )
            ),
        );

        $field['color_large_footer_text_color'] = array(
            'name'          =>  __( 'Large Footer Text Color', 'better-studio' ),
            'id'            =>  'color_large_footer_text_color',
            'type'          =>  'color',
            'std'           =>  '#5f656b',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.footer-larger-wrapper',
                        '.footer-larger-wrapper .the-content',
                        '.footer-larger-wrapper .the-content p',
                        '.footer-larger-wrapper .the-content a',
                        '.footer-larger-widget .better-social-counter.style-clean .item-count',
                        '.footer-larger-widget .better-social-counter.style-clean .item-title',
                        '.footer-larger-wrapper .widget.widget_nav_menu li a',
                    ),
                    'prop'      => 'color'
                )
            ),

        );
        $field['footer_large_border_color'] = array(
            'name'          =>  __( 'Large Footer Border Color', 'better-studio' ),
            'id'            =>  'footer_large_border_color',
            'type'          =>  'border',
            'style'         =>  array(
                'clean',
                'clean-beige',
            ),
            'preview'       =>  true,
            'preview-css'   =>  'border: none; border-top: 1px solid #DDDDDD; width: 90%; height: 30px;',
            'std-clean' => array(
                'top' => array(
                    'width' => '2',
                    'style' => 'solid',
                    'color' => '#c9c9c9',
                ),
            ),
            'std-clean-beige'=> array(
                'top' => array(
                    'width' => '2',
                    'style' => 'solid',
                    'color' => '#dbcd9b',
                ),
            ),
            'border'    => array(
                'top'    =>  array( 'width', 'style', 'color' ),
            ),
            'css-clean'       => array(
                array(
                    'selector'  => array(
                        '.footer-larger-wrapper'
                    ),
                    'type'      => 'border'
                )
            ),
            'css-clean-beige'=> array(
                array(
                    'selector'  => array(
                        '.footer-larger-wrapper'
                    ),
                    'type'      => 'border'
                )
            ),
        );
        $field['color_lower_footer_bg_color'] = array(
            'name'          =>  __( 'Lower Footer Background Color', 'better-studio' ),
            'id'            =>  'color_lower_footer_bg_color',
            'type'          =>  'color',
            'std'           =>  '#cfcfcf',
            'std-dark'      =>  '#2c3f52',
            'std-full-dark' =>  '#2c3f52',
            'std-black'     =>  '#333333',
            'std-full-black'=>  '#333333',
            'std-beige'     =>  '#eedd9e',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#ffffff',
            'std-green'     =>  '#333333',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => '.footer-lower-wrapper' ,
                    'prop'      => 'background-color'
                )
            )
        );
        $field['color_lower_footer_text_color'] = array(
            'name'          =>  __( 'Lower Footer Text Color', 'better-studio' ),
            'id'            =>  'color_lower_footer_text_color',
            'type'          =>  'color',
            'std'           =>  '#5f6569',
            'std-dark'      =>  '#ffffff',
            'std-full-dark' =>  '#ffffff',
            'std-black'     =>  '#ffffff',
            'std-full-black'=>  '#ffffff',
            'std-beige'     =>  '#493c0c',
            'std-clean'     =>  '#5f6569',
            'std-clean-beige'=> '#493c0c',
            'std-green'     =>  '#ffffff',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'css'           =>  array(
                array(
                    'selector'  => array(
                        '.footer-lower-wrapper',
                        '.footer-lower-wrapper .the-content',
                        '.footer-lower-wrapper .the-content p',
                    ),
                    'prop'      => 'color'
                )
            )
        );
        $field['footer_lower_border_color'] = array(
            'name'          =>  __( 'Large Footer Border Color', 'better-studio' ),
            'id'            =>  'footer_lower_border_color',
            'type'          =>  'border',
            'style'         =>  array(
                'clean',
                'clean-beige',
            ),
            'preview'       =>  true,
            'preview-css'   =>  'border: none; border-top: 1px solid #DDDDDD; width: 90%; height: 30px;',
            'std-clean' => array(
                'top' => array(
                    'width' => '1',
                    'style' => 'solid',
                    'color' => '#c9c9c9',
                ),
            ),
            'std-clean-beige' => array(
                'top' => array(
                    'width' => '1',
                    'style' => 'solid',
                    'color' => '#dbcd9b',
                ),
            ),
            'border'    => array(
                'top'    =>  array( 'width', 'style', 'color' ),
            ),
            'css-clean'       => array(
                array(
                    'selector'  => array(
                        '.footer-lower-wrapper'
                    ),
                    'type'      => 'border'
                )
            ),
            'css-clean-beige'       => array(
                array(
                    'selector'  => array(
                        '.footer-lower-wrapper'
                    ),
                    'type'      => 'border'
                )
            ),
        );

        /**
         * 5.6.13. => Back to top
         */
        $field[] = array(
            'name'          =>  __( 'Back To Top', 'better-studio' ),
            'type'          =>  'heading',
        );
        $field['color_back_top_bg'] = array(
            'name'          =>  __( 'Back to Top Background Color', 'better-studio' ),
            'id'            =>  'color_back_top_bg',
            'type'          =>  'color',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'std'           =>  '#626262',
            'std-beige'     =>  '#626262',
            'std-black'     =>  '#3f3f3f',
            'std-dark'      =>  '#446280',
            'std-full-dark' =>  '#3f3f3f',
            'std-full-black'=>  '#446280',
            'std-green'     =>  '#3f8f17',
            'std-clean'     =>  '#ffffff',
            'std-clean-beige'=> '#ffffff',
            'std-blue1'     =>  '#4c75a4',
            'std-blue1'     =>  '#61bee1',
            'css'       => array(
                array(
                    'selector'  => array(
                        '.back-top'
                    ),
                    'prop'      => 'background',
                )
            ),
        );
        $field['color_back_top_color'] = array(
            'name'          =>  __( 'Back to Top Arrow Color', 'better-studio' ),
            'id'            =>  'color_back_top_color',
            'type'          =>  'color',
            'style'         =>  array(
                'default',
                'dark',
                'full-dark',
                'black',
                'full-black',
                'beige',
                'clean',
                'clean-beige',
                'green',
                'blue1',
                'blue2',
            ),
            'std'           =>  '#ffffff',
            'std-beige'     =>  '#705e1f',
            'std-clean-beige'=> '#705e1f',
            'std-clean'     =>  '#626262',
            'css'       => array(
                array(
                    'selector'  => array(
                        '.back-top'
                    ),
                    'prop'      => 'color',
                )
            ),
        );

        
        
        /**
         * 5.8. => WooCommerce Options
         */
        if( function_exists( 'is_woocommerce' ) ){

            $field[] = array(
                'name'      =>  __( 'WooCommerce' , 'better-studio' ),
                'id'        =>  'woocommerce_setings',
                'type'      =>  'tab',
                'icon'      =>  'fa-shopping-cart'
            );

            $field[] = array(
                'name'          =>  __( 'Shop Sidebar Layout', 'better-studio' ),
                'id'            =>  'shop_sidebar_layout',
                'std'           =>  'no-sidebar',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left bordered',
                'desc'          =>  __( 'Select the sidebar layout to use by default. This can be overridden per-page or per-post basis when creating a page or post.', 'better-studio' ),
                'options'       => array(
                    'left' => array(
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-left.png',
                        'label'     =>  __( 'Left Sidebar', 'better-studio' ),
                    ),
                    'right'    =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-right.png',
                        'label' =>  __( 'Right Sidebar', 'better-studio' ),
                    ),
                    'no-sidebar'    =>  array(
                        'img'   =>  BETTER_MAG_ADMIN_ASSETS_URI . 'images/sidebar-no-sidebar.png',
                        'label' =>  __( 'No Sidebar', 'better-studio' ),
                    ),
                )
            );

            $field[] = array(
                'name'      =>  __( 'Number Of Posts In Shop Archive Page', 'better-studio' ),
                'id'        =>  'shop_posts_per_page',
                'desc'      =>  __( 'Number of posts in shop archive pages and product categories page.', 'better-studio' ),
                'type'      =>  'text',
                'std'       =>  '12'
            );

            $field[] = array(
                'name'      =>  __( 'Show Shopping Cart in Main Navigation', 'better-studio' ),
                'id'        =>  'show_shopping_cart_in_menu',
                'std'       =>  '1' ,
                'type'      =>  'switchery',
                'desc'      =>  __( 'When enabled, a cart icon is shown in the main navigation to the right side.', 'better-studio' ),
            );

        } // is_woocommerce



        /**
         * 5.9. => Custom Javascript / CSS
         */
        $field[] = array(
            'name'      =>  __( 'Custom JS/CSS/Code' , 'better-studio' ),
            'id'        =>  'custom_css_js_settings',
            'type'      =>  'tab',
            'icon'      =>  'fa-cogs',
            'margin-top'=>  '10',
        );
            $field[] = array(
                'name'      =>  __( 'Header HTML Code', 'better-studio' ),
                'id'        =>  'custom_header_code',
                'std'       =>  '',
                'type'      =>  'textarea',
                'desc'      =>  __( 'This code will be placed before &lt;/head&gt; tag in html. Useful if you have an external script that requires it.', 'better-studio' )
            );
            $field[] = array(
                'name'      =>  __( 'Footer HTML Code', 'better-studio' ),
                'id'        =>  'custom_footer_code',
                'std'       =>  '',
                'type'      =>  'textarea',
                'desc'      =>  __( 'This code will be placed before &lt;/body&gt; tag in html. Use for Google Analytics or similar external scripts.', 'better-studio' )
            );
            $field[] = array(
                'name'      =>  __( 'Custom CSS', 'better-studio' ),
                'id'        =>  'custom_css_code',
                'type'      =>  'textarea',
                'std'       =>  '',
                'desc'      =>  __( 'Custom CSS will be added at end of all other customizations and thus can be used to overwrite rules. Less chances of specificity wars.', 'better-studio' )
            );


        /**
         * 5.10. => Import & Export
         */
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
                'file_name' =>  'bettermag-options-backup',
                'panel_id'  =>  '__better_mag__theme_options',
                'desc'      =>  __( 'This allows you to create a backup of your options and settings. Please note, it will not backup anything else.', 'better-studio' )
            );
            $field[] = array(
                'name'      =>  __( 'Restore / Import', 'better-studio' ),
                'id'        =>  'import_restore_options',
                'type'      =>  'import',
                'desc'      =>  __( '<strong>It will override your current settings!</strong> Please make sure to select a valid backup file.', 'better-studio' )
            );


        $options['__better_mag__theme_options'] = array(
            'panel-name'          => _x( 'Theme Options', 'Panel title', 'better-studio' ),
            'theme-panel'   =>  true,
            'fields'        =>  $field,

            'config' => array(
                'name' 				  => __( 'Theme Options', 'better-studio' ),
                'parent' 			  => 'better-studio',
                'page_title'		  => __( 'Theme Options', 'better-studio' ),
                'menu_title'		  => __( 'Theme Options', 'better-studio' ),
                'capability' 		  => 'manage_options',
                'menu_slug' 		  => __( 'Theme Options', 'better-studio' ),
                'icon_url'  		  => null,
                'position'  		  => 10,
                'exclude_from_export' => false,
            ),
        );

        return $options;
    } //setup_option_panel


    /**
     * Setups Shortcodes for BetterMag
     *
     * 6. => Setup Shortcodes
     *
     * @param $shortcodes
     */
    function setup_shortcodes( $shortcodes ){

        require_once BETTER_MAG_PATH . 'includes/class-bm-vc-shortcode-extender.php';

        /**
         * 6.1. => BetterFramework Shortcodes
         */
        $shortcodes['social-share'] = array();
        $shortcodes['about'] = array();
        $shortcodes['advertisement-code'] = array();
        $shortcodes['advertisement-image'] = array();
        $shortcodes['twitter'] = array();
        $shortcodes['likebox'] = array();
        $shortcodes['flickr'] = array();

        /**
         * 6.2. => BetterMag Shortcodes
         */

        require_once BETTER_MAG_PATH . 'includes/shortcodes/class-bm-block-title-shortcode.php';
        $shortcodes['bm-block-title'] = array(
            'shortcode_class'   =>  'BM_Block_Title_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/class-bm-feedburner-shortcode.php';
        $shortcodes['feedburner'] = array(
            'shortcode_class'   =>  'BM_Feedburner_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/class-bm-posts-listing-shortcode.php';
        require_once BETTER_MAG_PATH . 'includes/widgets/class-bm-posts-listing-widget.php';
        $shortcodes['bm-posts-listing'] = array(
            'shortcode_class'   =>  'BM_Posts_Listing_Shortcode',
            'widget_class'      =>  'BM_Posts_Listing_Widget',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/class-bm-recent-tab-shortcode.php';
        require_once BETTER_MAG_PATH . 'includes/widgets/class-bm-recent-tab-widget.php';
        $shortcodes['bm-recent-tab'] = array(
            'shortcode_class'   =>  'BM_Recent_Tab_Shortcode',
            'widget_class'      =>  'BM_Recent_Tab_Widget',
        );

        // WooCommerce cart widget
        if( function_exists('is_woocommerce') ){
            require_once BETTER_MAG_PATH . 'includes/shortcodes/class-bm-wc-cart-shortcode.php';
            require_once BETTER_MAG_PATH . 'includes/widgets/class-bm-wc-cart-widget.php';
            $shortcodes['bm-wc-cart'] = array(
                'shortcode_class'   =>  'BM_WC_Cart_Shortcode',
                'widget_class'      =>  'BM_WC_Cart_Widget',
            );
        }

        // Base Class For BetterMag Listings
        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-listing.php';

        // Content Listing Shortcodes + VC Add-ons

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-tab-listing-shortcode.php';
        $shortcodes['bm-content-tab-listing'] = array(
            'shortcode_class'   =>  'BM_Content_Tab_Listing_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-1-shortcode.php';
        $shortcodes['bm-content-listing-1'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_1_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-2-shortcode.php';
        $shortcodes['bm-content-listing-2'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_2_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-3-shortcode.php';
        $shortcodes['bm-content-listing-3'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_3_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-4-shortcode.php';
        $shortcodes['bm-content-listing-4'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_4_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-5-shortcode.php';
        $shortcodes['bm-content-listing-5'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_5_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-6-shortcode.php';
        $shortcodes['bm-content-listing-6'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_6_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-7-shortcode.php';
        $shortcodes['bm-content-listing-7'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_7_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-8-shortcode.php';
        $shortcodes['bm-content-listing-8'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_8_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-9-shortcode.php';
        $shortcodes['bm-content-listing-9'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_9_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-10-shortcode.php';
        $shortcodes['bm-content-listing-10'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_10_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-11-shortcode.php';
        $shortcodes['bm-content-listing-11'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_11_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-12-shortcode.php';
        $shortcodes['bm-content-listing-12'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_12_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-13-shortcode.php';
        $shortcodes['bm-content-listing-13'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_13_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-14-shortcode.php';
        $shortcodes['bm-content-listing-14'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_14_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-15-shortcode.php';
        $shortcodes['bm-content-listing-15'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_15_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-16-shortcode.php';
        $shortcodes['bm-content-listing-16'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_16_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-17-shortcode.php';
        $shortcodes['bm-content-listing-17'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_17_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-18-shortcode.php';
        $shortcodes['bm-content-listing-18'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_18_Shortcode',
        );

        require_once BETTER_MAG_PATH . 'includes/shortcodes/content-listing/class-bm-content-listing-19-shortcode.php';
        $shortcodes['bm-content-listing-19'] = array(
            'shortcode_class'   =>  'BM_Content_Listing_19_Shortcode',
        );


        // Slider Listings Shortcodes + VC Add-ons
        require_once BETTER_MAG_PATH . 'includes/shortcodes/slider-listing/class-bm-slider-listing-1-10-shortcode.php';
        $shortcodes['bm-slider-listing-1'] = array( 'shortcode_class'   =>  'BM_Slider_Listing_1_Shortcode' );
        $shortcodes['bm-slider-listing-2'] = array( 'shortcode_class'   =>  'BM_Slider_Listing_2_Shortcode' );
        $shortcodes['bm-slider-listing-3'] = array( 'shortcode_class'   =>  'BM_Slider_Listing_3_Shortcode' );
        $shortcodes['bm-slider-listing-4'] = array( 'shortcode_class'   =>  'BM_Slider_Listing_4_Shortcode' );
        $shortcodes['bm-slider-listing-5'] = array( 'shortcode_class'   =>  'BM_Slider_Listing_5_Shortcode' );
        $shortcodes['bm-slider-listing-6'] = array( 'shortcode_class'   =>  'BM_Slider_Listing_6_Shortcode' );
        $shortcodes['bm-slider-listing-7'] = array( 'shortcode_class'   =>  'BM_Slider_Listing_7_Shortcode' );
        $shortcodes['bm-slider-listing-8'] = array( 'shortcode_class'   =>  'BM_Slider_Listing_8_Shortcode' );
        $shortcodes['bm-slider-listing-9'] = array( 'shortcode_class'   =>  'BM_Slider_Listing_9_Shortcode' );
        $shortcodes['bm-slider-listing-10'] = array( 'shortcode_class'   =>  'BM_Slider_Listing_10_Shortcode' );


        require_once BETTER_MAG_PATH . 'includes/shortcodes/slider-listing/class-bm-slider-listing-11-shortcode.php';
        $shortcodes['bm-slider-listing-11'] = array(
            'shortcode_class'   =>  'BM_Slider_Listing_11_Shortcode',
        );
        require_once BETTER_MAG_PATH . 'includes/shortcodes/slider-listing/class-bm-slider-listing-12-shortcode.php';
        $shortcodes['bm-slider-listing-12'] = array(
            'shortcode_class'   =>  'BM_Slider_Listing_12_Shortcode',
        );


        // User Listing Shortcodes + VC Add-ons
        require_once BETTER_MAG_PATH . 'includes/shortcodes/user-listing/class-bm-user-listing-1-shortcode.php';
        $shortcodes['bm-user-listing-1'] = array(
            'shortcode_class'   =>  'BM_User_Listing_1_Shortcode',
        );
        require_once BETTER_MAG_PATH . 'includes/shortcodes/user-listing/class-bm-user-listing-2-shortcode.php';
        $shortcodes['bm-user-listing-2'] = array(
            'shortcode_class'   =>  'BM_User_Listing_2_Shortcode',
        );

        return $shortcodes;
    }


    /**
     * Filter callback: Custom menu fields
     *
     * 7. => Menu Options
     *
     */
    public function setup_custom_menu_fields( $fields ){

        $_fields = array(

            'mega_menu_heading' =>  array(
                'id'            =>  'mega_menu_heading',
                'type'          =>  'heading',
                'name'          =>  __( 'Mega Menu', 'better-studio' ),
                'parent_only'   =>  false,
            ),

            'mega_menu' => array(
                'id'            =>  'mega_menu',
                'panel-id'      =>  '__better_mag__theme_options',
                'name'          =>  __( 'Mega Menu Type', 'better-studio' ),
                'type'          =>  'image_select',
                'class'         =>  '',
                'std'           =>  'disabled',
                'default_text'  =>  'Chose one',
                'list_style'    =>  'grid-2-column', // single-row, grid-2-column, grid-3-column
                'width'         =>  'wide',
                'parent_only'   => false,
                'options'       =>  array(
                    'disabled'  =>  array(
                        'label'     =>  __( 'Disabled', 'better-studio' ),
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI. 'images/mega-menu-disabled.png'
                    ),
                    'link'      =>  array(
                        'label'     =>  __( 'Links - 2 Column', 'better-studio' ) ,
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI. 'images/mega-menu-link-2-column.png'
                    ),
                    'link-3-column' =>  array(
                        'label'     =>  __( 'Links - 3 Column', 'better-studio' ) ,
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI. 'images/mega-menu-link-3-column.png'
                    ),
                    'link-4-column' =>  array(
                        'label'     =>  __( 'Links - 4 Column', 'better-studio' ) ,
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI. 'images/mega-menu-link-4-column.png'
                    ),
                    'category-recent-left'  =>  array(
                        'label'     =>  __('Category Recent (Menu Left)', 'better-studio' ) ,
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI. 'images/mega-menu-category-recent-left.png'
                    ),
                    'category-recent-right'  =>  array(
                        'label'     =>  __('Category Recent (Menu Right)', 'better-studio' ) ,
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI. 'images/mega-menu-category-recent-right.png'
                    ),
                    'category-left'  =>  array(
                        'label'     =>  __( 'Category Recent (Menu Left, Featured & Recent)', 'better-studio' ) ,
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI. 'images/mega-menu-category-left.png'
                    ),
                    'category-right'  =>  array(
                        'label'     =>  __('Category Recent (Menu Right, Featured & Recent)', 'better-studio' ) ,
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI. 'images/mega-menu-category-right.png'
                    ),
                    'category-simple-left'  =>  array(
                        'label'     =>  __('Category Recent (Menu Right, Featured & Simple Recent)', 'better-studio' ) ,
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI. 'images/mega-menu-category-simple-left.png'
                    ),
                    'category-simple-right'  =>  array(
                        'label'     =>  __('Category Recent (Menu Right, Featured & Simple Recent)', 'better-studio' ) ,
                        'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI. 'images/mega-menu-category-simple-right.png'
                    ),

                ),

            ),

            'mega_icon_settings' =>array(
                'id'            =>  'mega_icon_settings',
                'name'          =>  __( 'Menu Icon', 'better-studio' ),
                'type'          =>  'heading',
                'parent_only'   =>  false,
            ),
            'menu_icon'     =>array(
                'id'            =>  'menu_icon',
                'panel-id'      =>  '__better_mag__theme_options',
                'name'          =>  __( 'Icon', 'better-studio' ),
                'type'          =>  'icon_select',
                'class'         =>  '',
                'options'       =>  array( 'fontawesome' ),
                'std'           =>  'none',
                'std-clean'     =>  'none',
                'default_text'  =>  'Chose an Icon',
                'width'         =>  'thin',
                'list_style'    =>  'grid-3-column',
                'parent_only'   =>  false,
            ),
            'hide_menu_title' =>array(
                'id'            =>  'hide_menu_title',
                'panel-id'      =>  '__better_mag__theme_options',
                'name'          =>  __( 'Show Just Icon?', 'better-studio' ),
                'type'          =>  'checkbox',
                'class'         =>  '',
                'std'           =>  '0',
                'width'         =>  'thin',
                'parent_only'   =>  false,
            ),
            'mega_badge_settings' => array(
                'id'            =>  'mega_badge_settings',
                'panel-id'      =>  '__better_mag__theme_options',
                'name'          =>  __( 'Menu Badge', 'better-studio' ),
                'type'          =>  'heading',
                'parent_only'   =>  false,
            ),
            'badge_label' => array(
                'id'            =>  'badge_label',
                'panel-id'      =>  '__better_mag__theme_options',
                'name'          =>  __( 'Badge Label', 'better-studio' ),
                'type'          =>  'text',
                'std'           =>  '',
                'class'         =>  '',
                'width'         =>  'wide',
                'parent_only'   =>  false
            ),
            'badge_position' => array(
                'id'            =>  'badge_position',
                'panel-id'      =>  '__better_mag__theme_options',
                'name'          =>  __( 'Badge Position', 'better-studio' ),
                'type'          =>  'select',
                'std'           =>  'right',
                'class'         =>  '',
                'width'         =>  'thin',
                'parent_only'   =>  false,
                'options'       =>  array(
                    'left'      =>  __( 'Left', 'better-studio' ),
                    'right'     =>  __( 'Right', 'better-studio' ),
                )
            ),
            'badge_bg_color' => array(
                'id'            =>  'badge_bg_color',
                'panel-id'      =>  '__better_mag__theme_options',
                'name'          =>  __( 'Badge Background Color', 'better-studio' ),
                'type'          =>  'color',
                'class'         =>  '',
                'std'           =>  Better_Mag::get_option( 'theme_color' ),
                'save-std'      =>  false,
                    'width'         =>  'thin',
                    'parent_only'   => false,
                    'css'           => array(
                        array(
                            'selector'  => array(
                                '%%id%% > a > .better-custom-badge',
                                '.widget.widget_nav_menu .menu %%class%% .better-custom-badge',
                            ),
                            'prop'      => array( 'background-color' )
                        ),
                         array(
                            'selector'  => array(
                                '%%id%% > a > .better-custom-badge:after',
                            ),
                            'prop'      => array( 'border-top-color' )
                        ),
                        array(
                            'selector'  => array(
                                '.main-menu .menu .sub-menu %%id%%.menu-badge-left > a >.better-custom-badge:after',
                            ),
                            'prop'      => array( 'border-left-color' )
                        ),
                        array(
                            'selector'  => array(
                                '.widget.widget_nav_menu .menu %%class%% .better-custom-badge:after',
                                '.main-menu .mega-menu %%id%%.menu-badge-right > a > .better-custom-badge:after',
                            ),
                            'prop'      => array( 'border-right-color' )
                        ),

                    )
                ),
            'badge_font_color' => array(
                'id'            =>  'badge_font_color',
                'panel-id'      =>  '__better_mag__theme_options',
                'name'          =>  __( 'Badge Font Color', 'better-studio' ),
                'type'          =>  'color',
                'class'         =>  '',
                'std'           =>  '#fff',
                'save-std'      =>  false,
                'width'         =>  'thin',
                'parent_only'   =>  false,
                'css'           =>  array(
                    array(
                        'selector'  => array(
                            '%%id%% > a > .better-custom-badge',
                        ),
                        'prop'      => array( 'color' )
                    ),
                ),

            ),
        );

        return array_merge( $fields , $_fields );

    } // setup_custom_menu_fields


    /**
     * Filter callback: Breadcrumb Options
     *
     * 8. => Breadcrumb
     *
     */
    public function bf_breadcrumb_options( $options ){

        $options['labels']  =  array(
            'home'      => '<i class="fa fa-home"></i> ' . __( 'Home', 'better-studio' ),
            'browse'    => __( 'You are at:', 'better-studio' ),

        );

        if( ! is_rtl() )
            $options['separator'] = '<i class="fa fa-angle-double-right"></i>';
        else
            $options['separator'] = '<i class="fa fa-angle-double-left"></i>';

        return $options;

    } // bf_breadcrumb_options


    /**
     * Callback For Adding User New Contact Fields
     *
     * @param $profile_fields
     * @return mixed
     */
    function add_user_meta( $profile_fields ) {

        $profile_fields['twitter_url']  = __( 'Twitter URL', 'better-studio');
        $profile_fields['facebook_url'] = __( 'Facebook URL', 'better-studio');
        $profile_fields['gplus_url']    = __( 'Google+ URL', 'better-studio');
        $profile_fields['linkedin_url'] = __( 'Linkedin URL', 'better-studio');
        $profile_fields['github_url']   = __( 'Github URL', 'better-studio');

        return $profile_fields;
    }

} 