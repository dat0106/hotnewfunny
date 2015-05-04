<?php

/**
 * BetterStudio Review Functionality
 */
class BetterStudio_Review {

    /**
     * Contains alive instance of BetterStudio_Review_Generator
     *
     * @var BetterStudio_Review_Generator
     */
    protected static $generator = array();


    function __construct(){

        // Generator Class
        require_once BETTER_MAG_PATH . 'includes/libs/review/class-betterstudio-review-generator.php';
        self::generator();

        add_filter( 'better-framework/metabox/options' , array( $this , 'register_review_fields' ), 20 );

        add_action( 'init', array( $this, 'wp_init' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' )  );

        add_filter( 'betterstudio-editor-shortcodes', array( $this, 'register_shortcode_to_editor' ) );
    }


    /**
     * Used for retrieving instance of generator
     *
     * @param $fresh
     * @return BetterStudio_Review_Generator
     */
    public static function generator( $fresh = false ){

        if( self::$generator != null && ! $fresh ){
            return self::$generator;
        }

        return self::$generator = new BetterStudio_Review_Generator();
    }


    /**
     * Action Callback: WordPress Init
     */
    public function wp_init(){

        // Registers shortcode
        add_shortcode( 'review', array( $this, 'review_shortcode' ) );

    }


    /**
     * Action Callback: Registers Admin Style
     */
    public function admin_enqueue_scripts(){

        if( Better_Framework::self()->get_current_page_type() == 'metabox' ){

            wp_enqueue_style( 'betterstudio-review-admin', BETTER_MAG_URI . '/includes/libs/review/css/admin-style.css', array(), null );

            wp_enqueue_script( 'betterstudio-review-admin', BETTER_MAG_URI . '/includes/libs/review/js/admin-script.js' );

            wp_localize_script(
                'betterstudio-review-admin',
                'betterstudio_review',
                apply_filters(
                    'betterstudio_review_localize_items',
                    array(
                        'overall_rating'  => __( 'Overall Rating', 'better-studio'),
                    )
                )
            );

        }

    }


    /**
     * Filter Callback: Registers shortcode to BetterStudio Editor Shortcodes Plugin
     *
     * TODO Add sample shortcodes
     *
     * @param $shortcodes
     * @return mixed
     */
    public function register_shortcode_to_editor( $shortcodes ){

        $_shortcodes = array();

        $_shortcodes['sep' . time()] = array(
            'type'          =>  'separator',
        );

        $_shortcodes['reviews'] = array(
            'type'          =>  'menu',
            'label'         =>  __( 'Reviews', 'better-studio' ),
            'register'      =>  false,
            'items'         =>  array(

                'review-stars'  => array(
                    'type'          =>  'button',
                    'label'         =>  __( 'Review Stars', 'better-studio' ),
                    'register'      =>  false,
                    'content'       =>  '[review type="stars"]',
                ),

                'review-percentage' => array(
                    'type'          =>  'button',
                    'label'         =>  __( 'Review Percentage', 'better-studio' ),
                    'register'      =>  false,
                    'content'       =>  '[review type="percentage"]',
                ),

                'review-points' => array(
                    'type'          =>  'button',
                    'label'         =>  __( 'Review Points', 'better-studio' ),
                    'register'      =>  false,
                    'content'       =>  '[review type="points"]',
                ),

            )
        );

        return $shortcodes + $_shortcodes;
    }


    /**
     * Shortcode: Review Shortcode Handler
     *
     * @param $atts
     * @param null $content
     * @return string
     */
    public function review_shortcode( $atts, $content = null ){

        return self::generator()->generate_block( $atts );

    }


    /**
     * Registers review admin fields with BetterFramework
     *
     * @param $options
     * @return mixed
     */
    public function register_review_fields( $options ){

        $options['bs_review_metabox'] = array(
            'config'        => array(
                'title'         => __( 'Review Options', 'better-studio' ),
                'pages'         => array( 'post' ),
                'context'       => 'normal',
                'prefix'        => false,
                'priority'      => 'normal'
            ),
            'fields'        => array(

                '_bs_review_enabled' => array(
                    'name'          =>  __( 'Enable Review?', 'better-studio' ),
                    'id'            =>  '_bs_review_enabled',
                    'std'           =>  '0' ,
                    'type'          =>  'switchery',
                ),

                '_bs_review_pos' => array(
                    'name'          =>  __( 'Layout Style', 'better-studio' ),
                    'id'            =>  '_bs_review_pos',
                    'std'           =>  'top',
                    'type'          =>  'radio',
                    'section_class' =>  'style-floated-left bordered',
                    'desc'          =>  __( 'Select postion of review box on single page or not showing that. You can select "Do not display!" option and use shortcode to showing review box inside post text.', 'better-studio' ),
                    'options'       =>  array(
                        'none'          =>  __( 'Do not display!', 'better-studio' ),
                        'top'           =>  __( 'Top', 'better-studio' ),
                        'bottom'        =>  __( 'Bottom', 'better-studio' ),
                    )
                ),

                '_bs_review_rating_type' => array(
                    'name'          =>  __( 'Show Rating As', 'better-studio' ),
                    'id'            =>  '_bs_review_rating_type',
                    'std'           =>  'stars',
                    'type'          =>  'image_radio',
                    'section_class' =>  'style-floated-left bordered',
                    'options'       =>  array(
                        'stars'         =>  array(
                            'img'           =>  BETTER_MAG_URI . 'includes/libs/review/img/review-star.png',
                            'label'         =>  __( 'Stars', 'better-studio' ),
                        ),
                        'percentage'    =>  array(
                            'img'           =>  BETTER_MAG_URI . 'includes/libs/review/img/review-bar.png',
                            'label'         =>  __( 'Percentage', 'better-studio' ),
                        ),
                        'points'        =>  array(
                            'img'           =>  BETTER_MAG_URI . 'includes/libs/review/img/review-point.png',
                            'label'         =>  __( 'Points', 'better-studio' ),
                        )
                    )
                ),

                '_bs_review_heading' => array(
                    'name'          =>  __( 'Heading (optional)', 'better-studio' ),
                    'id'            =>  '_bs_review_heading',
                    'std'           =>  '' ,
                    'type'          =>  'text',
                ),

                '_bs_review_verdict' => array(
                    'name'          =>  __( 'Verdict', 'better-studio' ),
                    'id'            =>  '_bs_review_verdict',
                    'std'           =>  __( 'Awesome', 'better-studio' ),
                    'type'          =>  'text',
                ),

                '_bs_review_verdict_summary' => array(
                    'name'          =>  __( 'Verdict Summary', 'better-studio' ),
                    'id'            =>  '_bs_review_verdict_summary',
                    'std'           =>  '' ,
                    'type'          =>  'textarea',
                ),

                '_bs_review_criteria' => array(
                    'name'          =>  __( 'Criteria', 'better-studio' ),
                    'id'            =>  '_bs_review_criteria',
                    'type'          =>  'repeater',
                    'save-std'      =>  true,
                    'std'           =>  array(),
                    'add_label'     =>  __( 'Add Criteria', 'better-studio' ),
                    'delete_label'  =>  __( 'Delete Criteria', 'better-studio' ),
                    'item_title'    =>  __( 'Criteria', 'better-studio' ),
                    'options'       =>  array(
                        'label' => array(
                            'name'          =>  __( 'Label', 'better-studio' ),
                            'id'            =>  'label',
                            'std'           =>  '' ,
                            'type'          =>  'text',
                            'section_class' =>  'bs-review-field-label',
                            'repeater_item' =>  true
                        ),
                        'rate' => array(
                            'name'          =>  __( 'Rating / 10', 'better-studio' ),
                            'id'            =>  'rate',
                            'type'          =>  'text',
                            'section_class' =>  'bs-review-field-rating',
                            'repeater_item' =>  true
                        ),
                    )
                ),

                '_bs_review_extra_desc' => array(
                    'name'          =>  __( 'Extra Verdict Description in Bottom of Review Box', 'better-studio' ),
                    'id'            =>  '_bs_review_extra_desc',
                    'std'           =>  '' ,
                    'type'          =>  'textarea',
                ),
            )
        );

        return $options;
    }

}