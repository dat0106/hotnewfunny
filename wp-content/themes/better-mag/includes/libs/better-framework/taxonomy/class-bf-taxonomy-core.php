<?php
/**
 * Manage all functionality for generating fields and retrieving fields data from them
 */
class BF_Taxonomy_Core {

    /**
     * Contain all options that retrieved from better-framework/taxonomy/options and used for generating forms
     *
     * @var array
     */
    private $taxonomy_options = array();


    /**
     *
     */
    function __construct(){

        $this->load_options();

        add_action( 'admin_init', array( $this, 'register_taxonomies' ) );

    }


    /**
     * Filter all taxonomy options
     */
    function load_options(){

        $this->taxonomy_options = apply_filters( 'better-framework/taxonomy/options', array() );

    }


    /**
     * Register taxonomy fields
     */
    function register_taxonomies(){
        foreach( $this->taxonomy_options as $taxonomy ){
            new BF_Taxonomy_Meta_Field( $taxonomy );
        }
    }


    /**
     * Return all taxonomy options
     *
     * @return array
     */
    public function get_taxonomy_options(){

        return $this->taxonomy_options;

    }


    /**
     * Used For retrieving meta of term
     *
     * @param $term_id
     * @param $meta_id
     * @param bool $default
     * @return bool
     */
    public function get_term_meta( $term_id, $meta_id, $default = false ){

        if( $output = get_option( 'bf_term_' . $term_id ) ){

            if( isset( $output[$meta_id] ) ){
                return $output[$meta_id];
            }

        }

        return $default;

    }
}