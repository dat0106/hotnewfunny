<?php

/**
 * Used for retrieving social data from social sites and caching them
 */
class Better_Social_Counter_Data_Manager {


    /**
     * Contain live instance object class
     *
     * @var Better_Social_Counter_Data_Manager
     */
    private static $instance;


    /**
     * Cached value for counts
     *
     * @var array
     */
    private $cache = array();


    /**
     * Contain sites that supported in class
     *
     * @var array
     */
    private $supported_sites = array(
        'facebook',
        'twitter',
        'google',
        'youtube',
        'dribbble',
        'vimeo',
        'delicious',
        'soundcloud',
        'github',
        'behance',
        'vk',
        'vine',
        'pinterest',
        'flickr',
        'steam'
    );


    /**
     * Used for retrieving instance of class
     *
     * @param bool $fresh
     * @return Better_Social_Counter_Data_Manager
     */
    public static function self( $fresh = false ){

        // get fresh instance
        if( $fresh ){
            self::$instance = new Better_Social_Counter_Data_Manager();
            return self::$instance;
        }

        if( isset( self::$instance ) && ( self::$instance instanceof Better_Social_Counter_Data_Manager ) )
            return self::$instance;

        self::$instance = new Better_Social_Counter_Data_Manager();

        return self::$instance;
    }


    /**
     * Used for retrieving data for a social site
     *
     * @param $id
     * @param bool $fresh
     * @return bool|mixed
     */
    public function get_transient( $id, $fresh = false ){

        if( isset( $this->cache[$id] ) && ! $fresh )
            return $this->cache[$id];

        // id = better framework social counter cache ;)
        $temp = get_transient( 'better_social_counter_data_' . $id );

        if( $temp === false )
            return false;

        $this->cache[$id] = $temp;

        return $temp;
    }


    /**
     * Save a value in WP cache system
     *
     * @param $id
     * @param $data
     * @return bool
     */
    public function set_transient( $id, $data ){

        return set_transient( 'better_social_counter_data_' . $id, $data, Better_Social_Counter::get_option( 'cache_time' ) * HOUR_IN_SECONDS );

    }

    /**
     * clear cache in WP cache system
     *
     * @param $id
     * @return bool
     */
    public function clear_transient( $id ){

        return delete_transient( 'better_social_counter_data_' . $id );

    }


    /**
     * Deletes cached data
     *
     * @param string $key
     */
    public static function clear_cache( $key = 'all' ){

        if( $key == 'all' ){

            global $wpdb;

            $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->options WHERE option_name LIKE %s", '_transient_better_social_counter_data_%' ) );
            $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->options WHERE option_name LIKE %s", '_transient_timeout_better_social_counter_data_%' ) );

        }else{

            self::self()->clear_transient( $key );

        }

    }


    /**
     * Format number to human friendly style
     *
     * @param $number
     * @return string
     */
    private function format_number( $number ){

        if( !is_numeric( $number ) ) return $number ;

        if( $number >= 1000000 )
            return round( ( $number / 1000 ) / 1000 , 1) . "M";

        elseif( $number >= 100000 )
            return round( $number / 1000, 0 ) . "k";

        else
            return @number_format( $number );

    }


    /**
     * used for getting sites data in out of class
     *
     * @param string $id
     * @return array
     */
    public static function get_full_data( $id = '' ){

        // at first create an instance of class
        self::self();

        // if id empty or invalid id
        if( empty( $id ) || ! in_array( $id, self::self()->supported_sites ) )
            return '';

        $id = str_replace( '-', '_', $id );

        $function = 'get_'.$id.'_full_data';

        if( method_exists( self::self(), $function ) ){

            return call_user_func( array( self::self(), $function ) );

        }else{
            return false;
        }

    }


    /**
     * used for getting sites data in out of class
     *
     * @param string $id
     * @return array
     */
    public static function get_short_data( $id = '' ){

        // at first create an instance of class
        self::self();

        // if id empty or invalid id
        if( empty( $id ) || ! in_array( $id, self::self()->supported_sites ) )
            return '';

        $id = str_replace( '-', '_', $id );

        $function = 'get_'.$id.'_short_data';

        if( method_exists( self::self(), $function ) ){

            return call_user_func( array( self::self(), $function ) );

        }else{
            return false;
        }

    }


    /**
     * Get remote data
     *
     * @param $url
     * @param bool $json
     * @return array|mixed|string
     */
    private function remote_get( $url, $json = true ) {

        $get_request = wp_remote_get( $url , array( 'timeout' => 18 , 'sslverify' => false ) );

        $request = wp_remote_retrieve_body( $get_request );

        if( $json )
            $request = @json_decode( $request , true );

        return $request;

    }


    /**
     * Used for checking if a social site fields is prepared for getting data
     *
     * @param $id
     * @return bool
     */
    public function is_active( $id ){

        if( ! in_array( $id, $this->supported_sites ) )
            return false;

        switch( $id ){

            case 'facebook':
                return Better_Social_Counter::get_option( 'facebook_page' ) !== '';
                break;

            case 'twitter':
                if( Better_Social_Counter::get_option( 'twitter_api_key' ) == ''     ||
                    Better_Social_Counter::get_option( 'twitter_api_secret' ) == ''  ||
                    Better_Social_Counter::get_option( 'twitter_username' ) == ''
                ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'google':
                if( Better_Social_Counter::get_option( 'google_page' ) == ''     ||
                    Better_Social_Counter::get_option( 'google_page_key' ) == ''
                ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'youtube':
                if( Better_Social_Counter::get_option( 'youtube_username' ) == '' ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'dribbble':
                if( Better_Social_Counter::get_option( 'dribbble_username' ) == '' ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'vimeo':
                if( Better_Social_Counter::get_option( 'vimeo_username' ) == '' ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'delicious':
                if( Better_Social_Counter::get_option( 'delicious_username' ) == '' ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'soundcloud':
                if( Better_Social_Counter::get_option( 'soundcloud_username' ) == '' ||
                    Better_Social_Counter::get_option( 'soundcloud_api_key' ) == ''
                ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'github':
                if( Better_Social_Counter::get_option( 'github_username' ) == '' ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'behance':
                if( Better_Social_Counter::get_option( 'behance_username' ) == '' ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'vk':
                if( Better_Social_Counter::get_option( 'vk_username' ) == '' ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'vine':
                if( Better_Social_Counter::get_option( 'vine_profile' ) == '' ||
                    Better_Social_Counter::get_option( 'vine_email' ) == ''   ||
                    Better_Social_Counter::get_option( 'vine_pass' ) == ''
                ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'pinterest':
                if( Better_Social_Counter::get_option( 'pinterest_username' ) == '' ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'flickr':
                if( Better_Social_Counter::get_option( 'flickr_group' ) == '' ||
                    Better_Social_Counter::get_option( 'flickr_key' ) == ''
                ){
                    return false;
                }else{
                    return true;
                }
                break;

            case 'steam':
                if( Better_Social_Counter::get_option( 'steam_group' ) == '' )
                    return false;
                return true;
                break;
        }


    }

    /**
     * Used for retrieving an array that contain sites list with specified active sites for widgets backend fields
     *
     * @return array
     */
    function get_widget_options_list(){

        $result = array();
        $active_items = array();

        //
        // Facebook
        //
        $facebook_active = $this->is_active( 'facebook' );

        $temp = array( 'facebook' => array(
            'label'     =>  'Facebook',
            'css-class' =>  $facebook_active ? 'active-item' : 'disable-item'
        ) );

        if( $facebook_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['facebook'] = $temp['facebook'];
        }


        //
        // Twitter
        //
        $twitter_active = $this->is_active( 'twitter' );

        $temp = array( 'twitter' => array(
            'label'     =>  'Twitter',
            'css-class' =>  $twitter_active ? 'active-item' : 'disable-item'
        ) );

        if( $twitter_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['twitter'] = $temp['twitter'];
        }


        //
        // Google+
        //
        $google_active = $this->is_active( 'google' );

        $temp = array( 'google' => array(
            'label'     =>  'Google+',
            'css-class' =>  $google_active ? 'active-item' : 'disable-item'
        ));

        if( $google_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['google'] = $temp['google'];
        }


        //
        // Youtube
        //
        $youtube_active = $this->is_active( 'youtube' );

        $temp = array( 'youtube' => array(
            'label'     =>  'Youtube',
            'css-class' =>  $youtube_active ? 'active-item' : 'disable-item'
        ));

        if( $youtube_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['youtube'] = $temp['youtube'];
        }


        //
        // Dribbble
        //
        $dribbble_active = $this->is_active( 'dribbble' );

        $temp = array( 'dribbble' => array(
            'label'     =>  'Dribbble',
            'css-class' =>  $dribbble_active ? 'active-item' : 'disable-item'
        ));

        if( $dribbble_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['dribbble'] = $temp['dribbble'];
        }


        //
        // Vimeo
        //
        $vimeo_active = $this->is_active( 'vimeo' );

        $temp = array( 'vimeo' => array(
            'label'     =>  'Vimeo',
            'css-class' =>  $vimeo_active ? 'active-item' : 'disable-item'
        ));

        if( $vimeo_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['vimeo'] = $temp['vimeo'];
        }


        //
        // Delicious
        //
        $delicious_active = $this->is_active( 'delicious' );

        $temp = array( 'delicious' => array(
            'label'     =>  'Delicious',
            'css-class' =>  $delicious_active ? 'active-item' : 'disable-item'
        ));

        if( $delicious_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['delicious'] = $temp['delicious'];
        }


        //
        // SoundCloud
        //
        $soundcloud_active = $this->is_active( 'soundcloud' );

        $temp = array( 'soundcloud' => array(
            'label'     =>  'SoundCloud',
            'css-class' =>  $soundcloud_active ? 'active-item' : 'disable-item'
        ));

        if( $soundcloud_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['soundcloud'] = $temp['soundcloud'];
        }


        //
        // Github
        //
        $github_active = $this->is_active( 'github' );

        $temp = array( 'github' => array(
            'label'     =>  'Github',
            'css-class' =>  $github_active ? 'active-item' : 'disable-item'
        ));

        if( $github_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['github'] = $temp['github'];
        }


        //
        // Behance
        //
        $behance_active = $this->is_active( 'behance' );

        $temp = array( 'behance' => array(
            'label'     =>  'Behance',
            'css-class' =>  $behance_active ? 'active-item' : 'disable-item'
        ));

        if( $behance_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['behance'] = $temp['behance'];
        }


        //
        // VK
        //
        $vk_active = $this->is_active( 'vk' );

        $temp = array( 'vk' => array(
            'label'     =>  'VK',
            'css-class' =>  $vk_active ? 'active-item' : 'disable-item'
        ));

        if( $vk_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['vk'] = $temp['vk'];
        }


        //
        // Vine
        //
        $vine_active = $this->is_active( 'vine' );

        $temp = array( 'vine' => array(
            'label'     =>  'Vine',
            'css-class' =>  $vine_active ? 'active-item' : 'disable-item'
        ));

        if( $vine_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['vine'] = $temp['vine'];
        }


        //
        // Pinterest
        //
        $pinterest = $this->is_active( 'pinterest' );

        $temp = array( 'pinterest' => array(
            'label'     =>  'Pinterest',
            'css-class' =>  $pinterest ? 'active-item' : 'disable-item'
        ));

        if( $pinterest ){
            $active_items =  $active_items + $temp;
        }else{
            $result['pinterest'] = $temp['pinterest'];
        }


        //
        // Flickr
        //
        $flickr_active = $this->is_active( 'flickr' );

        $temp = array( 'flickr' => array(
            'label'     =>  'Flickr',
            'css-class' =>  $flickr_active ? 'active-item' : 'disable-item'
        ));

        if( $flickr_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['flickr'] = $temp['flickr'];
        }


        //
        // Steam
        //
        $steam_active = $this->is_active( 'steam' );

        $temp = array( 'steam' => array(
            'label'     =>  'Steam',
            'css-class' =>  $steam_active ? 'active-item' : 'disable-item'
        ));

        if( $steam_active ){
            $active_items =  $active_items + $temp;
        }else{
            $result['steam'] = $temp['steam'];
        }


        // add active sites to top of list
        $result = $active_items + $result;

        return $result;
    }


    /**
     * Used for retrieving data for facebook
     */
    private function get_facebook_full_data( $id = 'facebook' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( 'facebook' ) === false ){

            $facebook_page = Better_Social_Counter::get_option( 'facebook_page' );

            if( $facebook_page !== '' ){
                try {
                    $data = $this->remote_get( "http://graph.facebook.com/" . $facebook_page );

                    if( isset($data['likes']) )
                        $result = (int) $data['likes'];
                    else
                        $result = 0;

                } catch (Exception $e) {}
            }

            if( ! isset( $result ) )
                $result = 0;

            $this->set_transient( 'facebook', array(
                'link'  => 'http://www.facebook.com/' . $facebook_page,
                'count' => $this->format_number( $result ),
                'title' => Better_Social_Counter::get_option( 'facebook_title' )
            ));

        }

        return $this->get_transient('facebook');
    }


    /**
     * Used for retrieving data for facebook
     */
    private function get_facebook_short_data( $id = 'facebook' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link'  => 'http://www.facebook.com/' . Better_Social_Counter::get_option( 'facebook_page' ),
            'title' => Better_Social_Counter::get_option( 'facebook_title' )
        );

    }


    /**
     * Used for retrieving data for facebook
     */
    private function get_twitter_full_data( $id = 'twitter' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient($id) !== false )
            return $this->get_transient($id);

        // get active token if exists
        $active_token = get_option( 'better_social_counter_twitter_token' );

        // getting new active auth bearer
        if( ! $active_token ){

            // preparing credentials
            $credentials = Better_Social_Counter::get_option( 'twitter_api_key' ) . ':' . Better_Social_Counter::get_option( 'twitter_api_secret' );

            $auth = base64_encode( $credentials );

            // http post arguments
            $args = array(
                'method' => 'POST',
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => array(
                    'Authorization' => 'Basic ' . $auth,
                    'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
                ),
                'body' => array( 'grant_type' => 'client_credentials' )
            );

            add_filter( 'https_ssl_verify', '__return_false' );

            $response = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );

            $keys = json_decode( wp_remote_retrieve_body( $response ) );

            if( $keys ) {
                update_option( 'better_social_counter_twitter_token', $keys->access_token );
                $active_token = $keys->access_token;
            }
        }

        $args = array(
            'httpversion' => '1.1',
            'blocking' => true,
            'headers' => array(
                'Authorization' => "Bearer $active_token"
            )
        );

        add_filter( 'https_ssl_verify', '__return_false' );

        $twitter_username = Better_Social_Counter::get_option( 'twitter_username' );

        $api_url = "https://api.twitter.com/1.1/users/show.json?screen_name=" . $twitter_username;

        $response = wp_remote_get( $api_url, $args );

        if( ! is_wp_error( $response ) ) {

            $followers = json_decode( wp_remote_retrieve_body( $response ) );

            $result = $followers->followers_count;
        }
        else{
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => 'http://twitter.com/' . $twitter_username,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'twitter_title' )
        ));

        return $this->get_transient($id);
    }


    /**
     * Used for retrieving data for facebook
     */
    private function get_twitter_short_data( $id = 'twitter' ){

        if( ! $this->is_active( $id ) )
            return false;

         return array(
            'link' => 'http://twitter.com/' . Better_Social_Counter::get_option( 'twitter_username' ),
            'title'=> Better_Social_Counter::get_option( 'twitter_title' )
        );

    }


    /**
     * Used for retrieving data for Google Plus
     */
    private function get_google_full_data( $id = 'google' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $google_page = Better_Social_Counter::get_option( 'google_page' );

        try{
            // Get googleplus data
            $googleplus_data = $this->remote_get( 'https://www.googleapis.com/plus/v1/people/'. $google_page .'?key=' . Better_Social_Counter::get_option( 'google_page_key' ) );

            if ( isset( $googleplus_data['circledByCount'] ) ) {

                $googleplus_count = (int) $googleplus_data['circledByCount'] ;

                $result = $googleplus_count;

            }

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => 'https://plus.google.com/' . $google_page,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'google_title' )
        ));

        return $this->get_transient($id);
    }


    /**
     * Used for retrieving data for Google Plus
     */
    private function get_google_short_data( $id = 'google' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => 'https://plus.google.com/' . Better_Social_Counter::get_option( 'google_page' ),
            'title'=> Better_Social_Counter::get_option( 'google_title' )
        );

    }


    /**
     * Used for retrieving data for Youtube
     */
    private function get_youtube_full_data( $id = 'youtube' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $youtube_username = Better_Social_Counter::get_option( 'youtube_username' );

        try{

            $data = $this->remote_get("http://gdata.youtube.com/feeds/api/users/" . $youtube_username . "?alt=json");

            $result = (int) $data['entry']['yt$statistics']['subscriberCount'];

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => 'http://youtube.com/' . Better_Social_Counter::get_option( 'youtube_type' ) .'/'. $youtube_username,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'youtube_title' )
        ));

        return $this->get_transient($id);
    }



    /**
     * Used for retrieving data for Youtube
     */
    private function get_youtube_short_data( $id = 'youtube' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => 'http://youtube.com/' . Better_Social_Counter::get_option( 'youtube_type' ) .'/'. Better_Social_Counter::get_option( 'youtube_username' ),
            'title'=> Better_Social_Counter::get_option( 'youtube_title' )
        );
    }


    /**
     * Used for retrieving data for Dribbble
     */
    private function get_dribbble_full_data( $id = 'dribbble' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $dribbble_username = Better_Social_Counter::get_option( 'dribbble_username' );

        try{

            $data = $this->remote_get( "http://api.dribbble.com/" . $dribbble_username );

            $result = (int) $data['followers_count'];

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => 'http://dribbble.com/' . $dribbble_username,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'dribbble_title' )
        ));

        return $this->get_transient($id);
    }


    /**
     * Used for retrieving data for Dribbble
     */
    private function get_dribbble_short_data( $id = 'dribbble' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => 'http://dribbble.com/' . Better_Social_Counter::get_option( 'dribbble_username' ),
            'title'=> Better_Social_Counter::get_option( 'dribbble_title' )
        );
    }


    /**
     * Used for retrieving data for Vimeo
     */
    private function get_vimeo_full_data( $id = 'vimeo' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $vimeo_type = Better_Social_Counter::get_option( 'vimeo_type' );
        $vimeo_username = Better_Social_Counter::get_option( 'vimeo_username' );

        try {
            if( $vimeo_type == 'user' ){

                $data = $this->remote_get( "http://vimeo.com/api/v2/" . $vimeo_username . "/info.json" );

                $result = ( (int) $data['total_videos_uploaded']) + ( (int) $data['total_videos_appears_in'] );

            }elseif( $vimeo_type == 'channel' ){

                $data = $this->remote_get( "http://vimeo.com/api/v2/channel/" . $vimeo_username . "/info.json" );

                $result = (int) $data['total_subscribers'];

            }

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;


        $link = 'http://vimeo.com/';

        if( $vimeo_type == 'channel' ){

            $link .= 'channels/' . $vimeo_username;

        }else{

            $link .= $vimeo_username;

        }

        $this->set_transient( $id, array(
            'link' => $link,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'vimeo_title' )
        ));

        return $this->get_transient($id);
    }


    /**
     * Used for retrieving data for Vimeo
     */
    private function get_vimeo_short_data( $id = 'vimeo' ){

        if( ! $this->is_active( $id ) )
            return false;

        $vimeo_username = Better_Social_Counter::get_option( 'vimeo_username' );

        $vimeo_type = Better_Social_Counter::get_option( 'vimeo_type' );

        $link = 'http://vimeo.com/';

        if( $vimeo_type == 'channel' ){
            $link .= 'channels/' . $vimeo_username;
        }else{
            $link .= $vimeo_username;
        }

        return array(
            'link' => $link,
            'title'=> Better_Social_Counter::get_option( 'vimeo_title' )
        );
    }


    /**
     * Used for retrieving data for Delicious
     */
    private function get_delicious_full_data( $id = 'delicious' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $delicious_username = Better_Social_Counter::get_option( 'delicious_username' );

        try{

            $data = $this->remote_get( "http://feeds.delicious.com/v2/json/userinfo/" . $delicious_username );

            $result = (int) $data[2]['n'];

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => "http://delicious.com/" . $delicious_username,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'delicious_title' )
        ));

        return $this->get_transient( $id );
    }


    /**
     * Used for retrieving data for Delicious
     */
    private function get_delicious_short_data( $id = 'delicious' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => "http://delicious.com/" . Better_Social_Counter::get_option( 'delicious_username' ),
            'title'=> Better_Social_Counter::get_option( 'delicious_title' )
        );
    }


    /**
     * Used for retrieving data for SoundCloud
     */
    private function get_soundcloud_full_data( $id = 'soundcloud' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $soundcloud_username = Better_Social_Counter::get_option( 'soundcloud_username' );

        try{

            $data = $this->remote_get("http://api.soundcloud.com/users/" . $soundcloud_username . ".json?consumer_key=" . Better_Social_Counter::get_option( 'soundcloud_api_key' ) );

            $result = (int) $data['followers_count'];

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => "http://soundcloud.com/" . $soundcloud_username,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'soundcloud_title' )
        ));

        return $this->get_transient($id);
    }


    /**
     * Used for retrieving data for SoundCloud
     */
    private function get_soundcloud_short_data( $id = 'soundcloud' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => "http://soundcloud.com/" . Better_Social_Counter::get_option( 'soundcloud_username' ),
            'title'=> Better_Social_Counter::get_option( 'soundcloud_title' )
        );

    }


    /**
     * Used for retrieving data for Github
     * TODO: add git hub repositories count
     */
    private function get_github_full_data( $id = 'github' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $github_username = Better_Social_Counter::get_option( 'github_username' );

        try{

            $data = $this->remote_get("https://api.github.com/users/" . $github_username );

            $result = (int) $data['followers'];

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => "http://github.com/" . $github_username,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'github_title' )
        ));

        return $this->get_transient( $id );
    }


    /**
     * Used for retrieving data for Github
     * TODO: add git hub repositories count
     */
    private function get_github_short_data( $id = 'github' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => "http://github.com/" . Better_Social_Counter::get_option( 'github_username' ),
            'title'=> Better_Social_Counter::get_option( 'github_title' )
        );
    }


    /**
     * Used for retrieving data for behance
     */
    private function get_behance_full_data( $id = 'behance' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $behance_username = Better_Social_Counter::get_option( 'behance_username' );

        try{

            $data = $this->remote_get("http://www.behance.net/v2/users/". $behance_username . "?api_key=" . Better_Social_Counter::get_option( 'behance_api_key' ) );

            $result = (int) $data['user']['stats']['followers'];

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => "http://www.behance.net/" . $behance_username,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'behance_title' )
        ));

        return $this->get_transient($id);
    }


    /**
     * Used for retrieving data for behance
     */
    private function get_behance_short_data( $id = 'behance' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => "http://www.behance.net/" . Better_Framework::options()->get( 'behance_username', '__better_mag__theme_options' ),
            'title'=> Better_Framework::options()->get( 'behance_title', '__better_mag__theme_options' )
        );
    }


    /**
     * Used for retrieving data for VK
     */
    private function get_vk_full_data( $id = 'vk' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $vk_username = Better_Social_Counter::get_option( 'vk_username' );

        try{

            $data = $this->remote_get( "http://api.vk.com/method/groups.getById?gid=". $vk_username ."&fields=members_count" );

            $result = (int) $data['response'][0]['members_count'];

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => "http://vk.com/" . $vk_username,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'vk_title' )
        ));

        return $this->get_transient( $id );
    }


    /**
     * Used for retrieving data for VK
     */
    private function get_vk_short_data( $id = 'vk' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => "http://vk.com/" . Better_Social_Counter::get_option( 'vk_username' ),
            'title'=> Better_Social_Counter::get_option( 'vk_title' )
        );
    }


    /**
     * Used for retrieving data for Vine
     */
    private function get_vine_full_data( $id = 'vine' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );


        try{
            if( ! class_exists( 'BF_Vine' ) )
                require_once BF_PATH . 'libs/class-bf-vine.php';

            $vine = new BF_Vine( Better_Social_Counter::get_option( 'vine_email' ), Better_Social_Counter::get_option( 'vine_pass' ) );

            $result = $vine->me();

            $result = $result['followerCount'];

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => "http://vk.com/" . Better_Social_Counter::get_option( 'vine_profile' ),
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'vine_title' )
        ));

        return $this->get_transient($id);
    }


    /**
     * Used for retrieving data for Vine
     */
    private function get_vine_short_data( $id = 'vine' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => "http://vk.com/" . Better_Social_Counter::get_option( 'vine_profile' ),
            'title'=> Better_Social_Counter::get_option( 'vine_title' )
        );
    }


    /**
     * Used for retrieving data for Pinterest
     */
    private function get_pinterest_full_data( $id = 'pinterest' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $pinterest_username = Better_Social_Counter::get_option( 'pinterest_username' );

        try{

            $html = $this->remote_get( "http://www.pinterest.com/" . $pinterest_username , false);

            $doc = new DOMDocument();

            @$doc->loadHTML($html);

            $metas = $doc->getElementsByTagName('meta');

            for( $i = 0; $i < $metas->length; $i++ ){

                $meta = $metas->item( $i );

                if( $meta->getAttribute('name') == 'pinterestapp:followers' ){

                    $result = $meta->getAttribute('content');

                    break;

                }

            }

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => "http://www.pinterest.com/" . $pinterest_username,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'pinterest_title' )
        ));

        return $this->get_transient($id);
    }


    /**
     * Used for retrieving data for Pinterest
     */
    private function get_pinterest_short_data( $id = 'pinterest' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => "http://www.pinterest.com/" . Better_Framework::options()->get( 'pinterest_username', '__better_mag__theme_options' ),
            'title'=> Better_Framework::options()->get( 'pinterest_title', '__better_mag__theme_options' )
        );
    }


    /**
     * Used for retrieving data for Flickr
     */
    private function get_flickr_full_data( $id = 'flickr' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $flickr_group = Better_Social_Counter::get_option( 'flickr_group' );

        try{

            $data = $this->remote_get( "https://api.flickr.com/services/rest/?method=flickr.groups.getInfo&api_key=" . Better_Social_Counter::get_option( 'flickr_key' ) . "&group_id=" . $flickr_group ."&format=json&nojsoncallback=1" );

            $result = (int) $data['group']['members']['_content'];

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => "https://www.flickr.com/groups/" . $flickr_group,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'flickr_title' )
        ));

        return $this->get_transient( $id );
    }


    /**
     * Used for retrieving data for Flickr
     */
    private function get_flickr_short_data( $id = 'flickr' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => "https://www.flickr.com/groups/" . Better_Social_Counter::get_option( 'flickr_group' ),
            'title'=> Better_Social_Counter::get_option( 'flickr_title' )
        );
    }


    /**
     * Used for retrieving data for Steam
     */
    private function get_steam_full_data( $id = 'steam' ){

        if( ! $this->is_active( $id ) )
            return false;

        if( $this->get_transient( $id ) !== false )
            return $this->get_transient( $id );

        $steam_group = Better_Social_Counter::get_option( 'steam_group' );

        try{

            $data = $this->remote_get( "http://steamcommunity.com/groups/" . $steam_group . "/memberslistxml" , false );

            $data = @new SimpleXmlElement( $data );

            $result =  (int) $data->groupDetails->memberCount;

        }catch( Exception $e ){
            $result = 0;
        }

        if( ! isset( $result ) )
            $result = 0;

        $this->set_transient( $id, array(
            'link' => "http://steamcommunity.com/groups/" . $steam_group,
            'count'=> $this->format_number( $result ),
            'title'=> Better_Social_Counter::get_option( 'steam_title' )
        ));

        return $this->get_transient( $id );
    }


    /**
     * Used for retrieving data for Steam
     */
    private function get_steam_short_data( $id = 'steam' ){

        if( ! $this->is_active( $id ) )
            return false;

        return array(
            'link' => "http://steamcommunity.com/groups/" . Better_Social_Counter::get_option( 'steam_group' ),
            'title'=> Better_Social_Counter::get_option( 'steam_title' )
        );
    }

}