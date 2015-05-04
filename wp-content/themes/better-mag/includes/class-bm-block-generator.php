<?php

/**
 * Used for generating listing, blocks and other display related things
 */
class BM_Block_Generator extends BF_Block_Generator{


    /**
     * Inner array of objects live instances like blocks
     *
     * @var array
     */
    protected static $instances = array();


    /**
     * Used for retrieving generator of BetterMag
     *
     * @return BM_Blocks
     */
    public static function blocks(){

        if ( isset(self::$instances['blocks']) ) {
            return self::$instances['blocks'];
        }

        $blocks = apply_filters( 'better-mag/blocks', 'BM_Blocks' );
        // It's version -1.5 compatibility
        $blocks = apply_filters( 'better_mag-blocks', $blocks );

        // if filtered class not exists or not child of BM_Blocks class
        if( ! class_exists( $blocks ) || ! is_subclass_of( $blocks, 'BM_Blocks' ) )
            $blocks = 'BM_Blocks';

        self::$instances['blocks'] = new $blocks;
        return self::$instances['blocks'];

    }


    /**
     * Setter for block_atts
     *
     *
     * ==> Parameters
     *
     * -> 'block-class'     => contain class that must be added to listing Ex: vertical-left-line
     *
     * -> 'count'           => count of posts for listing
     *
     * -> 'counter'         => current post location in loop
     *
     * -> 'hide-summary'    => used for hiding in listings
     *
     * -> 'hide-meta'=> used for hiding Meta
     *
     * -> 'hide-meta-author'=> used for hiding Post Author in Meta
     *
     * -> 'hide-meta-comment'=> used for hiding Comment in Meta
     *
     * -> 'thumbnail-size'  => used for specifying thumbnail size
     *
     * -> 'excerpt-length'  => used for specifying thumbnail size
     *
     * -> 'show-term-banner'  => used for showing term banner
     *
     * -> 'hide-meta-author-if-review'  =>
     *
     *
     * @param string $key
     * @param string $value
     * @internal param array $block_atts
     */
//    public static function set_attr( $key = '', $value = '' ){
//        parent::set_attr( $key, $value );
//    }


    /**
     * Returns post main category object
     *
     * @return array|mixed|null|object|WP_Error
     */
    public static function get_post_main_category(){

        // Fix for in category archive page and having multiple category
        if( is_category() ){
            if( has_category( get_query_var( 'cat' ) ) )
                $category = get_category( get_query_var( 'cat' ) );
            else{
                $category = current( get_the_category() );
            }
        }else{
            $category = current( get_the_category() );
        }

        return $category;
    }


    public static function get_main_slider(){

        // Slider For Home Page
        if( is_home() || is_front_page() ){

            if( Better_Mag::get_option( 'show_slider' ) ){

                $args = array(
                    'post_type'     => 'post',
                    'posts_per_page'=> 10
                );

                if( Better_Mag::get_option( 'slider_cats' ) ){
                    $args['cat'] = Better_Mag::get_option( 'slider_cats' );
                }

                if( Better_Mag::get_option( 'slider_tags' ) ){
                    $args['tag__in'] = Better_Mag::get_option( 'slider_tags' );
                }

                if( Better_Mag::get_option( 'slider_just_featured' ) ){
                    $args['meta_key'] = '_bm_featured_post';
                    $args['meta_value'] = '1';
                }

                Better_Mag::posts()->set_query( new WP_Query( apply_filters( 'better-mag/main-slider/home/args', $args ) ) );

                unset( $args );

                Better_Mag::generator()->blocks()->print_main_slider( Better_Mag::get_option( 'slider_style' ) );

                Better_Mag::posts()->clear_query();
                Better_Mag::generator()->clear_atts();
            }
        }
        // Slider For Categories
        elseif( is_category() ){

            if( Better_Framework::taxonomy_meta()->get_term_meta( get_query_var('cat'), 'show_slider') ){
                $args = array(
                    'post_type'     => 'post',
                    'posts_per_page'=> 10,
                    "cat"           => get_query_var('cat'),
                );

                if( Better_Framework::taxonomy_meta()->get_term_meta( get_query_var('cat'), 'slider_just_featured' )){
                    $args['meta_key'] = '_bm_featured_post';
                    $args['meta_value'] = '1';
                }

                Better_Mag::posts()->set_query( new WP_Query( apply_filters( 'better-mag/main-slider/category/args', $args ) ) );
                unset( $args );

                if( Better_Framework::taxonomy_meta()->get_term_meta( get_query_var('cat'), 'slider_style' ) != 'default' )
                    Better_Mag::generator()->blocks()->print_main_slider( Better_Framework::taxonomy_meta()->get_term_meta( get_query_var('cat'), 'slider_style' ) );
                else
                    Better_Mag::generator()->blocks()->print_main_slider( Better_Mag::get_option( 'slider_style' ) );

                Better_Mag::posts()->clear_query();
            }
        }
        // Slider For Pages
        elseif( is_page() ){

            if( Better_Mag::get_meta( 'show_slider', false ) ){

                $args = array(
                    'post_type'     => 'post',
                    'posts_per_page'=> 10,
                );


                if( Better_Mag::get_meta( 'slider_cats' ) ){
                    $args['cat'] = Better_Mag::get_meta( 'slider_cats' );
                }elseif( Better_Mag::get_option( 'slider_cats' ) ){
                    $args['cat'] = Better_Mag::get_option( 'slider_cats' );
                }

                if( Better_Mag::get_meta( 'slider_tags' ) ){
                    $args['tag__in'] = Better_Mag::get_meta( 'slider_tags' );
                }if( Better_Mag::get_option( 'slider_tags' ) ){
                    $args['tag__in'] = Better_Mag::get_option( 'slider_tags' );
                }

                if( Better_Mag::get_meta( 'slider_just_featured' ) ){
                    $args['meta_key'] = '_bm_featured_post';
                    $args['meta_value'] = '1';
                }

                Better_Mag::posts()->set_query( new WP_Query( apply_filters( 'better-mag/main-slider/page/args', $args ) ) );
                unset( $args );

                if( Better_Mag::get_meta( 'slider_style' ) != 'default' )
                    Better_Mag::generator()->blocks()->print_main_slider( Better_Mag::get_meta( 'slider_style' ) );
                else
                    Better_Mag::generator()->blocks()->print_main_slider( Better_Mag::get_option( 'slider_style' ) );

                Better_Mag::posts()->clear_query();
            }
        }

    }


    /**
     * Filter For Generating BetterFramework Shortcodes Title
     *
     * @param $atts
     * @return mixed
     */
    public static function filter_bf_shortcodes_title( $atts ){

        if( ! $atts['title'] )
            return '';

        return Better_Mag::generator()->blocks()->get_block_title( $atts['title'], false, false );
    }


    /**
     * Read more link
     *
     * @param string $text
     * @param bool $echo
     * @return string
     */
    public function excerpt_read_more( $text = '', $echo = true ){

        $output = '';
        if( empty( $text ) ){
            $text = __( 'Read More', 'better-studio' );
        }

        if( is_feed() ){
            return ' [...]';
        }

        // add more link if enabled in options
        if( Better_Mag::get_option( 'show_read_more_blog_listing' ) ) {
            $output = '<a class="btn btn-read-more" href="'. get_permalink( get_the_ID() ) . '" title="'. esc_attr($text) . '">'. $text .'</a>';
        }

        if( $echo )
            echo $output;
        else
            return $output;
    }

}

// Add filter for VC elements add-on
$generator = apply_filters( 'better-mag/generator', 'BM_Block_Generator' );
if( ! class_exists($generator) || ! is_subclass_of( $generator, 'BF_Block_Generator' ) )
    $generator = 'BM_Block_Generator';
add_filter( 'better-framework/shortcodes/title', array( $generator, 'filter_bf_shortcodes_title' ) );