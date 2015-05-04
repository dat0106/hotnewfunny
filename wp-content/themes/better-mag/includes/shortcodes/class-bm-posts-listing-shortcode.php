<?php

class BM_Posts_Listing_Shortcode extends BF_Shortcode{

    function __construct( $id, $options ){

        $id = 'bm_posts_listing';

        $this->widget_id = 'bm posts listing widget';

        $_options = array(
            'defaults' => array(

                'title'         =>  __( 'Posts', 'better-studio' ),
                'show_title'    =>  0,

                'style'         =>  'thumbnail',
                'order'         =>  'recent',
                'category'      =>  '',
                'tag'           =>  '',
                'count'         =>  5,
                'read_more'     =>  1,
            ),

            'have_widget'       => true,
            'have_vc_add_on'    => false,
        );

        $_options = wp_parse_args( $_options, $options );

        parent::__construct( $id, $_options );

    }

    /**
     * Handle displaying of shortcode
     *
     * @param array $atts
     * @param string $content
     * @return string
     */
    function display( array $atts  , $content = '' ){

        ob_start();

        if( empty( $atts['count'] ) )
            $atts['count'] = 5;

        $args = array(
            'post_type'         =>  array( 'post' ),
            'posts_per_page'    =>  $atts['count'],
        );

        $term = false;

        if( $atts['order'] == 'popular' ){
            $args['offset'] = 0;
            $args['orderby'] = 'comment_count';
        }

        if( $atts['category'] == 'bm-review-posts' ){
            $atts['category'] = 'All Posts';
            $args['meta_key'] = '_bs_review_enabled';
            $args['meta_value'] = '1';
        }

        if( $atts['category'] != 'All Posts' ){
            $args['cat'] = $atts['category'];
            $term = $args['cat'];
        }

        if( $atts['tag'] ){
            $args['tag__and'] = explode( ',', $atts['tag'] );
            $term = current( $args['tag__and'] );
        }

        if( is_front_page() ){
            $args = Better_Mag::posts()->update_query_for_duplicate_posts( $args );
        }

        Better_Mag::posts()->set_query( new WP_Query( $args ) );

        ?>
        <div class="bf-shortcode bm-popular-posts">
            <?php

            if( $atts['style'] == 'thumbnail' ){
                Better_Mag::generator()->set_attr( 'hide-meta-author-if-review', true );
                Better_Mag::generator()->blocks()->listing_thumbnail();
            }

            elseif( $atts['style'] == 'modern' ){

                Better_Mag::generator()->set_attr( 'show-term-banner', true );

                if( Better_Mag::posts()->have_posts() ){

                    while( Better_Mag::posts()->have_posts() ){
                        Better_Mag::posts()->the_post();

                        Better_Mag::generator()->blocks()->block_modern();

                    }

                }
            }

            elseif( $atts['style'] == 'highlight' ){

                Better_Mag::generator()->set_attr( 'show-term-banner', true );
                Better_Mag::generator()->set_attr( 'hide-meta-author-if-review', true );

                if( Better_Mag::posts()->have_posts() ){

                    while( Better_Mag::posts()->have_posts() ){
                        Better_Mag::posts()->the_post();

                        Better_Mag::generator()->blocks()->block_highlight();

                    }

                }
            }

            if( $atts['read_more'] && $term ){

                if( isset( $args['cat'] ) ){
                    $term = get_term( $term, 'category' );
                    echo '<div class="tab-read-more term-' . $term->term_id . '"><a href="' . get_term_link( $term, 'category' ) .'" title="'. __( 'Read More', 'better-studio' ) .'">'. __( 'Read More... ', 'better-studio' ) .'<i class="fa fa-chevron-' . ( is_rtl() ? 'left' : 'right' ) .'"></i></a></div>';
                }else{
                    $term = get_term( $term, 'post_tag' );
                    echo '<div class="tab-read-more term-' . $term->term_id . '"><a href="' . get_term_link( $term, 'post_tag' ) .'" title="'. __( 'Read More', 'better-studio' ) .'">'. __( 'Read More... ', 'better-studio' ) .'<i class="fa fa-chevron-' . ( is_rtl() ? 'left' : 'right' ) .'"></i></a></div>';
                }

            }


            ?>
        </div>
        <?php

        Better_Mag::posts()->clear_query();
        Better_Mag::generator()->clear_atts();

        return ob_get_clean();

    }

}