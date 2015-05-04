<?php


/**
 * BetterMag Content Listing 4
 */
class BM_Content_Listing_4_Shortcode extends BM_Listing_Shortcode{

    function __construct(  ){

        $id = 'bm_content_listing_4';

        $this->name = __( 'Content Listing 4', 'better-studio' );

        $this->description = __( '2 Column, Thumbnail listing left', 'better-studio' );

        $this->icon = ( BETTER_MAG_ADMIN_ASSETS_URI . 'images/vc-' . $id . '.png' );

        $options = array(
            'defaults'  => array(
                'title'     =>  '',
                'hide_title'=>  0,
                'icon'      =>  '',

                'category'  =>  '',
                'tag'       =>  '',
                'count'     =>  5,
                'order_by'  =>  'date',
                'order'     =>  'DESC',
                'show_read_more'    =>  0,
            ),

            'have_widget'   => false,
            'have_vc_add_on'=> true,
        );

        parent::__construct( $id , $options );

    }


    /**
     * Handle displaying of shortcode
     *
     * @param $atts
     * @param $content
     * @return string
     */
    function display( array $atts  , $content = '' ){
        ob_start();

        if( empty( $atts['count'] ) || intval( $atts['count'] ) < 1 )
            $atts['count'] = 5;


        $args = array(
            'post_type'         =>  array( 'post' ),
            'posts_per_page'    =>  $atts['count'],
            'order'             =>  $atts['order'],
            'orderby'             =>  $atts['order_by'],
        );

        if( $atts['order_by'] == 'reviews' ){
            $args['orderby'] = 'date';
            $args['meta_key'] = '_bs_review_enabled';
            $args['meta_value'] = '1';
        }

        if( $atts['category'] != __( 'All Posts', 'better-studio' ) && ! empty( $atts['category'] ) ){
            $args['category_name'] = $atts['category'];
        }

        if( $atts['tag'] ){
            $args['tag_slug__and'] = explode( ',', $atts['tag'] );
        }

        if( is_front_page() ){
            $args = Better_Mag::posts()->update_query_for_duplicate_posts( $args );
        }

        $this->decision_showing_of_term_banner( $atts );

        Better_Mag::posts()->set_query( new WP_Query( apply_filters( 'better-mag/content-listing-4/args', $args ) ) );

        $this->the_block_title( $atts );

        // Trick for saving first post for later ;)
        if( Better_Mag::posts()->have_posts() ){
            Better_Mag::posts()->the_post();
        }

        ?>
        <div class="row block-listing block-listing-4">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 vertical-right-line"><?php

                Better_Mag::generator()->set_attr( "hide-meta-author-if-review", true );

                Better_Mag::generator()->blocks()->listing_thumbnail();

                Better_Mag::generator()->set_attr( "hide-meta-author-if-review", false );

                ?></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><?php

                Better_Mag::posts()->get_query()->rewind_posts();

                if( Better_Mag::posts()->have_posts() ){
                    Better_Mag::posts()->the_post();
                    Better_Mag::generator()->blocks()->block_modern();
                }

                ?>
            </div>
        </div><?php

        Better_Mag::posts()->clear_query();
        Better_Mag::generator()->clear_atts();

        return ob_get_clean();
    }

}

class WPBakeryShortCode_bm_content_listing_4 extends BM_VC_Shortcode_Extender { }