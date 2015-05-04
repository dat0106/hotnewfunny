<?php

/**
 * Helper functions for BetterFramework
 */
class BF_Helper {

    function __construct(){

        // Callback For Video Format auto-embed
        add_filter( 'better-framework/content/video-embed', array($this, 'video_auto_embed'));

    }


    /**
     * Filter Callback: Auto-embed video using a link
     *
     * @param string $content
     * @return string
     */
    public function video_auto_embed( $content ){

        global $wp_embed;

        if( ! is_object( $wp_embed ) ){
            return $content;
        }

        return $wp_embed->autoembed( $content );
    }


    /**
     * Convert newsticker to Newsticker, tab-widget to Tab_Widget, Block Listing 3 to Block_Listing_3 etc.
     *
     * @param $file_name
     * @param string $before Before class name
     * @param string $after After class name
     * @return string
     */
    public static  function get_file_to_class_name( $file_name , $before = '', $after = '' ){

        $class = str_replace(
            array( '/' , '-', ' ' ),
            '_',
            $file_name
        );

        $class = explode( '_', $class );

        $class = array_map('ucwords',$class);

        $class = implode( '_', $class );

        return $before . $class . $after;
    }


    /**
     * Used to check for the current post type, works when creating or editing a
     * new post, page or custom post type.
     *
     * @since	1.0
     * @return	string [custom_post_type], page or post
     */
    public static function get_current_post_type_admin(){

        // admin side
        if( is_admin() ){

            $uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : NULL ;

            if ( isset( $uri ) ){

                $uri_parts = parse_url($uri);

                $file = basename($uri_parts['path']);

                if( $uri AND in_array( $file, array( 'post.php', 'post-new.php' ) ) ){
                    $post_id = self::get_current_post_id_admin();

                    $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : NULL ;

                    $post_type = $post_id ? get_post_type($post_id) : $post_type ;

                    if (isset($post_type)){

                        return $post_type;

                    }
                    else{

                        // because of the 'post.php' and 'post-new.php' checks above, we can default to 'post'
                        return 'post';

                    }
                }
                // Pages custom css
                elseif( isset( $_GET['bs_per_page_custom_css'] ) && ! empty( $_GET['bs_per_page_custom_css'] ) ){

                    if( isset( $_GET['post_id'] ) && ! empty( $_GET['post_id'] ) ){

                        return get_post_type( $_GET['post_id'] );

                    }

                }
            }

        }
        // if used in front end
        else{

            return get_post_type( self::get_current_post_id_admin() );

        }


        return NULL;
    }


    /**
     * Used to get the current post id.
     *
     * @since	1.0
     * @return	int post ID
     */
    public static function get_current_post_id_admin(){

        global $post;

        $p_post_id = isset($_POST['post_ID']) ? $_POST['post_ID'] : null ;

        $g_post_id = isset($_GET['post']) ? $_GET['post'] : null ;

        $post_id = $g_post_id ? $g_post_id : $p_post_id ;

        $post_id = isset($post->ID) ? $post->ID : $post_id ;

        if (isset($post_id)){
            return (integer) $post_id;
        }

    }


    /**
     * Used for converting number to odd
     *
     * @param $number
     * @param bool $down
     * @return bool|int
     */
    public static function convert_number_to_odd( $number , $down = false){

        if( is_int( $number ) ){

            if( intval( $number ) % 2 == 0 ){
                return $number;
            }else{

                if( $down )
                    return intval( $number ) - 1;
                else
                    return intval( $number ) + 1;

            }

        }

        return false;

    }


    /**
     * var_dump on multiple inputs
     *
     * @return string
     */
    function var_dump(){

        ob_start();

        call_user_func_array( 'var_dump', func_get_args() );

        echo ob_get_clean();

    }


    /**
     * checks string for valid JSON
     *
     * @param $string
     * @return bool
     */
    function is_json( $string ){

        json_decode( $string );

        return json_last_error() == JSON_ERROR_NONE;

    }


    /**
     * print_r on multiple inputs
     *
     * @return string
     */
    function print_r(){

        $args = func_get_args();

        ob_start();

        call_user_func_array( 'print_r', $args );

        echo '<pre style="direction:ltr;text-align:left;">' . ob_get_clean() . '</pre>';

    }


} 