<?php

/**
 * BetterMag Helper Functions
 */
class BM_Helper {


    /**
     * Used For Finding Title Of Term in Tags And Cats
     *
     * @param $cat
     * @param $tag
     * @return string
     */
    public static function get_combined_term_title( $cat = '', $tag = array() ){

        if( $cat != 'All Posts' && ! empty( $cat )){
            $term = get_term_by( 'slug', $cat, 'category' );
            if( ! is_wp_error( $term ) ){
                return $term->name;
            }
        }

        if( is_array( $tag ) && isset( $tag[0] ) ){

            $term = get_term_by( 'slug', $tag[0], 'post_tag' );

            if( ! is_wp_error( $term ) ){
                return $term->name;
            }

        }

        return '';
    }
} 