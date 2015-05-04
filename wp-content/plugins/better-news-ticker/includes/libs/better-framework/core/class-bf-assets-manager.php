<?php

/**
 * Handles enqueue scripts and styles for preventing conflict and also multiple version of assets in on page
 */
class BF_Assets_Manager {


    function __construct(){

        // Registers styles
        add_action( 'better-framework/after_setup', array( $this, 'register_styles' ) );

        // Registers scripts
        add_action( 'better-framework/after_setup', array( $this, 'register_scripts' ) );

    }


    /**
     * Registers Styles
     */
    function register_styles(){


        //
        //
        // General
        //
        //

        // Fontawesome
        wp_register_style( 'bf-fontawesome', BF_URI . 'assets/css/font-awesome.min.css', array(), Better_Framework::self()->version );

        // Better Social Font Icon
        wp_register_style( 'bf-better-social-font-icon', BF_URI . 'assets/css/better-social-font-icon.css', array(), Better_Framework::self()->version );

        // Magnific Popup
        wp_register_style( 'bf-pretty-photo', BF_URI . 'assets/css/pretty-photo.css', array(), Better_Framework::self()->version );



        //
        //
        // Admin Styles
        //
        //

        // BF Used Plugins CSS
        wp_register_style( 'bf-admin-plugins', BF_URI . 'assets/css/admin-plugins.css', array(), Better_Framework::self()->version );

        // Codemirror (syntax highlighter code editor) CSS
        wp_register_style( 'bf-codemirror-packs', BF_URI.'assets/css/codemirror-pack.css', array(), Better_Framework::self()->version );

        // Switchery CSS
        wp_register_style( 'bf-switchery', BF_URI . 'assets/css/switchery.min.css', array(), Better_Framework::self()->version );

        // BetterFramework admin style
        wp_register_style( 'bf-better-framework-admin', BF_URI . 'assets/css/admin-style.css', array(
            'bf-fontawesome',
            'bf-better-social-font-icon',
            'bf-admin-plugins',
            'bf-codemirror-packs',
            'bf-switchery'
        ), Better_Framework::self()->version );

        // BeterFramework admin RTL style
        wp_register_style( 'bf-better-framework-admin-rtl', BF_URI . 'assets/css/rtl-admin-style.css', array( 'bf-better-framework-admin' ), Better_Framework::self()->version );



        do_action( 'better-framework/assets-manager/register-styles' );

    }


    /**
     * Registers Styles
     */
    function register_scripts(){

        //
        //
        // General
        //
        //

        // Element Query
        wp_register_script( 'bf-element-query', BF_URI . 'assets/js/element-query.min.js', array(), Better_Framework::self()->version, true );

        // Element Query
        wp_register_script( 'bf-pretty-photo', BF_URI . 'assets/js/pretty-photo.js', array(), Better_Framework::self()->version, true );



        //
        //
        // Admin Scripts
        //
        //

        // BF Used Plugins JS File
        wp_register_script( 'bf-admin-plugins', BF_URI . 'assets/js/admin-plugins.js', array(), Better_Framework::self()->version, true );

        // Codemirror (syntax highlighter code editor) JS
        wp_register_script( 'bf-codemirror-pack', BF_URI . 'assets/js/codemirror-pack.js', array(), Better_Framework::self()->version, true );

        // Switchery JS
        wp_register_script( 'bf-switchery', BF_URI . 'assets/js/switchery.min.js', array(), Better_Framework::self()->version, true );


        // BetterFramework admin script
        // todo check for needed scripts and remove uneeded
        wp_register_script( 'bf-better-framework-admin', BF_URI . 'assets/js/admin-scripts.js', array(
            'jquery-ui-core',
            'jquery-ui-widget',
            'jquery-ui-slider',
            'jquery-ui-sortable',
            'jquery-ui-datepicker',
            'bf-admin-plugins',
            'bf-codemirror-pack',
            'bf-switchery',
        ), Better_Framework::self()->version, true );


        do_action( 'better-framework/assets-manager/register-scripts' );

    }


    /**
     * Enqueue styles safely
     *
     * @param $style_key
     */
    function enqueue_style( $style_key ){

        if( ! wp_style_is( 'bf-' . $style_key ) ){

            wp_enqueue_style( 'bf-' . $style_key );

        }

    }


    /**
     * Enqueue scripts safely
     *
     * @param $script_key
     */
    function enqueue_script( $script_key ){

        if( ! wp_style_is( 'bf-' . $script_key ) ){

            wp_enqueue_script( 'bf-' . $script_key );

        }

    }

}