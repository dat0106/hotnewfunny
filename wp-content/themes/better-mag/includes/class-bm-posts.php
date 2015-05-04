<?php


/**
 * Contain Functionality Related To Posts and Pages
 */
class BM_Posts extends BF_Posts {


    /**
     * Updates query args for removing duplicate posts if needed.
     *
     * @param array $args
     * @return array
     */
    public function update_query_for_duplicate_posts( $args = array() ){

        if( Better_Mag::get_option( 'bm_remove_duplicate_posts' ) ){

            $args['post__not_in'] = Better_Mag::posts()->get_appeared_posts();

        }

        return $args;

    }


    /**
     * Used For Checking Have Posts in Advanced Way!
     *
     * @return bool
     */
    public function have_posts(  ){

        if( ! is_a( Better_Mag::posts()->get_query(), 'WP_Query' ) ){
            global $wp_query;

            Better_Mag::posts()->set_query( $wp_query );
        }

        // if count customized
        if( Better_Mag::generator()->get_attr( 'count', '' ) ){

            if( Better_Mag::generator()->get_attr( 'counter', 1 ) > ( Better_Mag::generator()->get_attr( 'count' ) ) ){
                return false;
            }else{
                if( self::get_query()->current_post + 1 < self::get_query()->post_count ){
                    return true;
                }
                else{
                    return false;
                }
            }


        }else{
            return self::get_query()->current_post + 1 < self::get_query()->post_count;
        }

    }


    /**
     * Custom the_post for custom counter functionality
     */
    public function the_post(){

        // if count customized
        if( Better_Mag::generator()->get_attr( 'count', '' ) ){

            Better_Mag::generator()->set_attr( 'counter', intval( Better_Mag::generator()->get_attr( 'counter', 1 ) ) + 1 );

        }


        // default the_post
        self::get_query()->the_post();

        // Adds .last-item to last item in loop
        // or loop with specific count
        if( Better_Mag::generator()->get_attr( 'count' ) ){
            if( Better_Mag::generator()->get_attr( 'count' ) == Better_Mag::generator()->get_attr( 'counter' ) ){
                Better_Mag::generator()->set_attr_class( 'last-item' );
            }
        }
        elseif( Better_Mag::posts()->get_query()->current_post + 1 === Better_Mag::posts()->get_query()->post_count ){
            Better_Mag::generator()->set_attr_class( 'last-item' );
        }

        // Add post id to appeared posts queue for removing duplicate
        Better_Mag::posts()->add_appeared_post( get_the_ID() );

    }



    /**
     * Wrapper for the_content()
     *
     * @see the_content()
     */
    public function the_content( $more_link_text = null, $strip_teaser = false ){

        // Post Links
        $post_links_attr = array(
            'before'=> '<div class="pagination"><span class="current">' . __( 'Pages:', 'better-studio' ) . ' </span>',
            'after' => '</div>',
            'echo'  =>  0,
            'pagelink'         => '<span>%</span>',

        );

        $class = '';

        if( is_page() ){
            $class = 'page-content';
        }elseif( is_singular() ){
            $class = 'post-content';
        }

        if( get_post_format() == 'gallery' && ! Better_Mag::get_meta( 'bm_disable_post_featured' ) ){

            $content = get_the_content( $more_link_text, $strip_teaser );
            $content = $this->_strip_shortcode_gallery( $content );
            $content = str_replace(']]>', ']]&gt;', apply_filters( 'better-framework/content/the_content', apply_filters( 'the_content', $content ) ) );
            $content .= wp_link_pages( $post_links_attr );
            echo '<div class="the-content ' . $class . ' clearfix">' . $content . '</div>';

            return;
        }

        // All Post Formats
        echo '<div class="the-content ' . $class . ' clearfix">' . apply_filters( 'better-framework/content/the_content', apply_filters( 'the_content', get_the_content( $more_link_text, $strip_teaser ) ) ) . wp_link_pages( $post_links_attr )  . '</div>';
    }


    /**
     * Used For Generating Single Post/Page Title
     *
     * @param bool $link
     * @param string $heading
     */
    public function the_title( $link = false, $heading = 'h1' ){

        if( ! $this->get_meta( 'hide_page_title' ) )
            if( $link )
                Better_Mag::generator()->blocks()->get_page_title( get_the_title(), get_permalink( get_the_ID() ), true, $heading, '' );
            else
                Better_Mag::generator()->blocks()->get_page_title( get_the_title(), false, true, $heading, '' );

    }


    /**
     * Used For Generating Post Meta
     */
    public function the_post_meta(){

        if( ! $this->get_meta( 'hide_post_meta' ) && Better_Mag::get_option( 'meta_hide_in_single' ) == false )
            Better_Mag::generator()->blocks()->partial_meta();

    }


    /**
     * Used for retrieving post and page meta
     *
     * @param null $key
     * @param null $post_id
     * @param bool|null $default
     * @param string $prefix
     * @return mixed|void
     */
    function get_meta( $key = null, $post_id = null, $default = false, $prefix = '_' ){

        if( ! $post_id ){
            global $post;
            $post_id = $post->ID;
        }

        if( is_int( $post_id ) && is_string( $key ) ){

            $meta = get_post_meta( $post_id, $prefix . $key, true );

            // If Meta check for default value
            if( empty($meta) && $default ){

                $defaults = array(
                    'bm_disable_post_featured'  => false,
                    'hide_page_title'           => false,
                    'hide_post_meta'            => false,
                    'gallery_images_bg_slides'  => false,
                );

                if( isset( $defaults[$key] ) ){
                    return apply_filters( 'better-mag/meta/' . $key . '/value', $defaults[$key] );
                }

            }else{
                return apply_filters( 'better-mag/meta/' . $key . '/value', $meta );
            }

        }

        return apply_filters( 'better-mag/meta/' . $key . '/value', '' );

    }



    /**
     * Used for printing post and page meta
     *
     * @param null $key
     * @param null $post_id
     * @param bool|null $default
     * @param string $prefix
     * @return mixed|void
     */
    function echo_meta( $key = null, $post_id = null, $default = false, $prefix = '_' ){

        echo $this->get_meta( $key, $post_id, $default, $prefix );

    }

}