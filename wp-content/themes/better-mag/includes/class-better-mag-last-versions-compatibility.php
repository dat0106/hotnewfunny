<?php


/**
 * Class Better_Mag_Last_Versions_Compatibility
 */
class Better_Mag_Last_Versions_Compatibility {


    function __construct(){

        // Before version 1.4 style compatibility
        add_action( 'better-framework/after_setup', array( $this, 'before_v_1_4_comp' ), 1 );


        // changes last bf_social_counter shortcode to new
        add_filter( 'content_edit_pre', array( $this, 'fix_shortcodes' ) );
        add_filter( 'the_content', array( $this, 'fix_shortcodes' ) );

    }

    function fix_shortcodes( $content ){

        $content =  str_replace( '[bf_social_counter', '[better-social-counter', $content );
        return str_replace( '[bf_news_ticker', '[better-news-ticker', $content );

    }

    /**
     * Prepare compatibility for versions before 1.4
     */
    function before_v_1_4_comp() {

        $comp_state = get_option( 'better_mag_comp_v_1_4' );
        $comp_state = false;

        if( $comp_state === false ){

            // Updates current style
            $style = get_option( '__better_mag__current_style' );
            if( $style != false ){
                add_option( '__better_mag__theme_options_current_style', $style );
                delete_option( '__better_mag__current_style' );
            }

            // Updates social counter widget id to new
            $sidebars_widgets = get_option( 'sidebars_widgets' );
            foreach( (array) $sidebars_widgets as $sidebar_location => $sidebar_value ){

                if( $sidebar_location == 'array_version' )
                    continue;

                foreach( (array) $sidebar_value as $widget_key => $widget_id ){

                    if( substr( $widget_id, 0, 14  )  == 'social-counter' ){

                        $sidebars_widgets[$sidebar_location][$widget_key] = 'better-'.$widget_id;

                    }elseif( substr( $widget_id, 0, 11  )  == 'news_ticker'  ){
                        $sidebars_widgets[$sidebar_location][$widget_key] = 'better-' . str_replace( '_', '-', $widget_id );
                    }

                }

            }

            update_option( 'sidebars_widgets', $sidebars_widgets );

            // Updates social counter widget id to new in custom sidebars
            $sidebars_widgets = get_option( 'cs_sidebars' );

            if( $sidebars_widgets !== false ){

                foreach( (array) $sidebars_widgets as $sidebar_location => $sidebar_value ){

                    if( $sidebar_location == 'array_version' )
                        continue;

                    foreach( (array) $sidebar_value as $widget_key => $widget_id ){

                        if(  substr( $widget_id, 0, 14  )  == 'social-counter' ){

                            $sidebars_widgets[$sidebar_location][$widget_key] = 'better-'.$widget_id;

                        }elseif( substr( $widget_id, 0, 11  )  == 'news_ticker'  ){

                            $sidebars_widgets[$sidebar_location][$widget_key] = 'better-' . str_replace( '_', '-', $widget_id );

                        }

                    }

                }
                update_option( 'cs_sidebars', $sidebars_widgets );

            }

            // Updates social counter widget data
            $social_counter_widget = get_option( 'widget_social-counter' );
            if( $social_counter_widget !== false ){
                delete_option( 'widget_social-counter' );
                update_option( 'widget_better-social-counter', $social_counter_widget );
            }

            // Updates news ticker widget data
            $news_ticker_widget = get_option( 'widget_news_ticker' );
            if( $news_ticker_widget !== false ){
                delete_option( 'widget_news_ticker' );
                update_option( 'widget_better-news-ticker', $news_ticker_widget );
            }

            // Save last compatibility for next compatibilities!
            add_option( 'better_mag_comp_v_1_4', Better_Framework::theme()->get( 'Version' ) );


        }


        // Social Counter options compatibility
        // options will be moved to "Better Social Counter" plugin automatically
        $theme_options = get_option( '__better_mag__theme_options' );
        if( $theme_options !== false && isset( $theme_options['facebook_page'] ) ){

            $social_counter_options = array();

            $fields = array(
                'facebook_page',
                'facebook_title',

                'twitter_username',
                'twitter_title',
                'twitter_api_key',
                'twitter_api_secret',

                'google_page',
                'google_page_key',
                'google_title',

                'youtube_username',
                'youtube_type',

                'dribbble_username',
                'dribbble_title',

                'vimeo_username',
                'vimeo_type',
                'vimeo_title',

                'delicious_username',
                'delicious_title',

                'soundcloud_username',
                'soundcloud_api_key',
                'soundcloud_title',

                'github_username',
                'github_title',

                'behance_username',
                'behance_api_key',
                'behance_title',

                'vk_username',
                'vk_title',

                'vine_profile',
                'vine_email',
                'vine_pass',
                'vine_title',

                'pinterest_username',
                'pinterest_title',

                'flickr_group',
                'flickr_key',
                'flickr_title',

                'steam_group',
                'steam_title',
            );


            foreach( $fields as $id ){

                if( isset( $theme_options[$id] ) ){

                    $social_counter_options[$id] = $theme_options[$id];

                    unset( $theme_options[$id] );

                }

            }

            update_option( '__better_mag__theme_options', $theme_options );

            update_option( 'better_social_counter_options', $social_counter_options );


            if( class_exists( 'Better_Social_Counter' ) ){
                Better_Framework::admin_notices()->add_notice( array(
                    'class' => 'updated',
                    'msg' => __( 'BetterMag social counter options successfully moved to <b>Better Social Counter</b> plugin options.', 'better-studio' ) . ' <a href="' . admin_url( 'options-general.php?page=better-studio/better_social_counter_options' )  .'"><i>' . __( 'Better Social Counter Options', 'better-studio' ) . '</i></a>'
                ) );
            }else{
                Better_Framework::admin_notices()->add_notice( array(
                    'class' => 'updated',
                    'msg' => __( 'BetterMag social counter options successfully moved to <b>Better Social Counter</b> plugin options.', 'better-studio' ) . ' <a href="' . admin_url( 'themes.php?page=install-required-plugins' )  .'"><i>' . __( 'Active/Install Better Social Counter Here', 'better-studio' ) . '</i></a>'
                ) );
            }
        }




    }



}