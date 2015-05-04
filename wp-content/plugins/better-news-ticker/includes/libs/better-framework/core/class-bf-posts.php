<?php


/**
 * Contain Functionality Related To Posts and Pages That Used In Themes
 */
class BF_Posts {

    /**
     * Contain instance of WP_Query that used in blocks and listings
     *
     * @var WP_Query
     */
    static private $query = null;


    /**
     * Setter for query
     *
     * @param \WP_Query $query
     */
    public static function set_query( &$query ){
        self::$query = $query;
    }


    /**
     * Getter for query
     *
     * @return \WP_Query
     */
    public static function get_query(){
        return self::$query;
    }


    /**
     * Used for clearing query
     */
    public static function clear_query( $reset_query = true ){

        self::$query = null;

        if( $reset_query )
            wp_reset_query();
    }


    /**
     * Appeared posts queue for removing theme in next queries for removing duplicate posts
     *
     * @var array
     */
    static private $appeared_posts = array();


    /**
     * @return array
     */
    public static function get_appeared_posts(){
        return self::$appeared_posts;
    }


    /**
     * Adds post to appeared posts queue
     *
     * @param $appeared_post
     */
    public static function add_appeared_post( $appeared_post ){
        self::$appeared_posts[] = $appeared_post;
    }


    /**
     * Clears appeared posts queue
     */
    public static function clear_appeared_posts(){
        self::$appeared_posts = array();
    }


    /**
     * Check if post has an image attached.
     *
     * @return bool
     */
    public function has_post_thumbnail(){
        return has_post_thumbnail();
    }


    /**
     * Wrapper for the_content()
     *
     * @see the_content()
     */
    public function the_content( $more_link_text = null, $strip_teaser = false ){

        // Post Links
        $post_links_attr = array(
            'before'=> '<div class="pagination"><span class="current">' . __( 'Pages:', 'better-studio' ) . '</span>',
            'after' => '</div>',
            'echo'  =>  0,
            'pagelink'         => '<span>%</span>',

        );

        if( get_post_format() == 'gallery' ) {

            $content = get_the_content( $more_link_text, $strip_teaser );
            $content = $this->_strip_shortcode_gallery( $content );
            $content = str_replace(']]>', ']]&gt;', apply_filters( 'better-framework/content/the_content', apply_filters( 'the_content', $content ) ) );
            $content .= wp_link_pages( $post_links_attr );
            echo '<div class="the-content bf-clearfix">' . $content . '</div>';

            return;
        }

        // All Post Formats
        echo '<div class="the-content bf-clearfix">' . apply_filters( 'better-framework/content/the_content', apply_filters( 'the_content', get_the_content( $more_link_text, $strip_teaser ) ) ) . wp_link_pages( $post_links_attr )  . '</div>';
    }


    /**
     * Custom excerpt
     *
     * @param  integer $length
     * @param  string|null $text
     * @param bool $echo
     * @return string
     */
    public function excerpt( $length = 24, $text = null, $echo = true ){

        // If text not defined get excerpt
        if( ! $text ){

            // have a manual excerpt?
            if( has_excerpt( get_the_ID() ) ){

                if( $echo ){
                    echo apply_filters( 'the_excerpt', get_the_excerpt() );
                    return;
                }else
                    return apply_filters( 'the_excerpt', get_the_excerpt() );

            }else{

                $text = get_the_content('');

            }

        }

        $text = strip_shortcodes( $text );
        $text = str_replace( ']]>', ']]&gt;', $text );

        // get plaintext excerpt trimmed to right length
        $excerpt = wp_trim_words( $text, $length, '&hellip;' );

        // fix extra spaces
        $excerpt = trim( str_replace('&nbsp;', ' ', $excerpt ) );

        // After strip shortcode if there was not any other text then you must get the content with the_excerpt filter that runs shortcodes 1 time ...
        if( strlen( $excerpt ) > 0 ){
            $excerpt = apply_filters( 'the_excerpt', $excerpt );
        }else{
            $excerpt = apply_filters( 'the_excerpt', $excerpt );
            $excerpt = wp_trim_words( $excerpt, $length, '&hellip;' );
            $excerpt = trim( str_replace('&nbsp;', ' ', $excerpt ) );
        }

        if( $echo )
            echo $excerpt;
        else
            return $excerpt;
    }


    /**
     * Deletes First Gallery Shortcode and Returns Content
     */
    public function _strip_shortcode_gallery( $content ){

        preg_match_all('/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER);

        if (!empty($matches)){

            foreach ($matches as $shortcode){

                if ( $shortcode[2] === 'gallery' ){

                    $pos = strpos($content, $shortcode[0]);

                    if ($pos !== false) {
                        return substr_replace($content, '', $pos, strlen($shortcode[0]));
                    }
                }
            }
        }

        return $content;
    }


    /**
     * Used For Retrieving Post First Gallery and Return Attachment IDs
     *
     * @param null $content
     * @return array|bool
     */
    public function get_first_gallery_ids( $content = null ){

        // whn current not defined
        if( ! $content ){
            global $post;

            $content = $post->post_content;
        }

        preg_match_all('/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER);

        if( ! empty($matches) ){

            foreach( $matches as $shortcode ){

                if( 'gallery' === $shortcode[2] ){

                    $atts = shortcode_parse_atts($shortcode[3]);

                    if (!empty($atts['ids'])) {
                        $ids = explode(',', $atts['ids']);

                        return $ids;
                    }
                }
            }
        }

        return false;
    }


    /**
     * Get Related Posts
     *
     * @param integer $count number of posts to return
     * @param string $type
     * @param integer|null $post_id
     * @return WP_Query
     */
    public function get_related( $count = 5, $type = 'cat', $post_id = null ){

        if( ! $post_id ){

            global $post;

            $post_id = $post->ID;

        }

        $args = array(
            'posts_per_page' => $count,
            'post__not_in' => array( $post_id )
        );

        switch( $type ){

            case 'cat':
                $args['category__in'] = wp_get_post_categories( $post_id );
                break;

            case 'tag':
                $args['tag__in'] = wp_get_object_terms( $post_id, 'post_tag', array( 'fields' => 'ids' ) );
                break;

            case 'author':
                $args['author'] = $post->post_author;
                break;

            case 'cat-tag':
                $args['category__in'] = wp_get_post_categories( $post_id );
                $args['tag__in'] = wp_get_object_terms( $post_id, 'post_tag', array( 'fields' => 'ids' ) );
                break;

            case 'cat-tag-author':
                $args['author'] = $post->post_author;
                $args['category__in'] = wp_get_post_categories( $post_id );
                $args['tag__in'] = wp_get_object_terms( $post_id, 'post_tag', array( 'fields' => 'ids' ) );
                break;

        }

        $related = new WP_Query( apply_filters( 'better-framework/posts/related/args', $args ) );

        return $related;

    }

}