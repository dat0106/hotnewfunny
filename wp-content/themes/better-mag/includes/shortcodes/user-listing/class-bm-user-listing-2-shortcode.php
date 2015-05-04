<?php

/**
 * BetterMag User Listing 2
 */
class BM_User_Listing_2_Shortcode extends BF_Shortcode {

    function __construct(){

        $id = 'bm_user_listing_2';

        $this->name = __( 'User Listing 2', 'better-studio' );

        $this->description = __( '', 'js_composer' );

        $this->icon = ( BETTER_MAG_ADMIN_ASSETS_URI . 'images/vc-' . $id . '.png' );

        $options = array(
            'defaults' => array(

                'title'             =>  __( 'Authors', 'better-studio' ),
                'hide_title'        =>  0,
                'icon'              =>  'fa-users',
                'order'             =>  'ASC',
                'orderby'           =>  'ID',
                'role'              =>  'Author',
                'column'            =>  '2',
                'count'             =>  5,
                'show_total'        =>  0,
                'exclude'           =>  '',
                'show_posts_count'  => 0,
            ),

            'have_widget'       => false,
            'have_vc_add_on'    => true,
        );

        parent::__construct($id, $options);

    }


    /**
     * Used for showing listing title
     */
    function the_block_title( &$atts, &$user_query ){

        if( $atts['hide_title'] ){
            return false;
        }

        $atts['title-class'] = '';

        // Add icon
        if( $atts['icon'] )
            $atts['icon'] = '<i class="fa ' . $atts['icon'] . '"></i> ';
        else
            $atts['icon'] = '';

        $other_links = array();

        if( $atts['show_total'] ){

            $other_links[] = array(
                'title'     =>  __( 'Total: ', 'better-studio' ) . $user_query->total_users,
                'href'      =>  '#total',
            );

        }

        Better_Mag::generator()->blocks()->get_extended_block_title( $atts['icon'] . $atts['title'], false, $other_links, true );
    }



    /**
     * Handle displaying of shortcode
     *
     * @param $atts
     * @param $content
     * @return string
     */
    function display(array $atts, $content = ''){

        ob_start();

        $_user_query_args = array(
            'orderby'   =>  $atts['orderby'],
            'order'   =>  $atts['order'],
            'number'    =>  $atts['count']
        );

        if( $atts['role'] != 'read' ){
            $_user_query_args['role'] = $atts['role'];
        }
        
        if( $atts['show_total'] ){

            $_user_query_args['count_total'] = true;

        }

        if( $atts['exclude'] ){
            $_user_query_args['exclude'] = explode( ',', $atts['exclude'] );
        }

        $_user_query = new WP_User_Query( apply_filters( 'better-mag/user-listing-2/args', $_user_query_args ) );


        switch( $atts['column'] ){

            case 3:
                $before = '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
                break;

            case 4:
                $before = '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">';
                break;

            case 2:
            default:
                $before = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';

        }

        ?>
        <div class="row user-listing user-listing-2"><?php

            echo '<div class="col-lg-12 title-row">';
            $this->the_block_title( $atts, $_user_query );
            echo '</div>';

            if( $atts['show_posts_count'] ){
                Better_Mag::generator()->set_attr( 'user-show-post-count', true );
            }

            if( ! empty( $_user_query->results ) ){

                foreach( $_user_query->results as $user ){

                    Better_Mag::generator()->set_attr( 'user-object', $user );

                    echo $before;

                    Better_Mag::generator()->blocks()->block_user_modern();

                    echo '</div>';
                }

            }

        ?></div><?php

        Better_Mag::posts()->clear_query();
        Better_Mag::generator()->clear_atts();

        return ob_get_clean();
    }

    /**
     * Registers Visual Composer Add-on
     */
    function register_vc_add_on(){

        vc_map(array(
            "name"      => $this->name,
            "base"      => $this->id,
            "icon"      => $this->icon,
            "description"      => $this->description,
            "weight"    => 10,

            "wrapper_height"    => 'full',

            "category" => __( 'Content', 'better-studio' ),
            "params" => array(


                array(
                    "type"          =>  'textfield',
                    "admin_label"   =>  true,
                    "heading"       =>  __( 'Number of Users', 'better-studio' ),
                    "param_name"    =>  'count',
                    "value"         =>  $this->defaults['count'],
                    "description"   =>  __( 'Configures number of users to show. default is 5.', 'better-studio' )
                ),

                array(
                    "type"      =>  'bf_switchery',
                    "heading"   =>  __( 'Show Each User Posts Count', 'better-studio'),
                    "param_name"=>  'show_posts_count',
                    "value"     =>  $this->defaults['show_posts_count'],
                    "description"   => __( 'Shows each user posts count.', 'better-studio'),
                ),

                array(
                    "type"      =>  'bf_switchery',
                    "heading"   =>  __( 'Show All Users Count', 'better-studio'),
                    "param_name"=>  'show_total',
                    "value"     =>  $this->defaults['show_total'],
                    "description"   => __( 'Show all users count number with current conditions.', 'better-studio'),
                ),
                array(
                    "type"          => 'bf_select',
                    "admin_label"   => true,
                    "heading"       => __( 'Order by', 'better-studio' ),
                    "param_name"    => 'orderby',
                    "value"         => $this->defaults['orderby'],
                    "options"       => array(
                        'ID'            =>  __( 'ID', 'better-studio' ),
                        'post_count'    =>  __( 'Post Count', 'better-studio' ),
                        'display_name'  =>  __( 'Display Name', 'better-studio' ),
                        'name'          =>  __( 'User Name', 'better-studio' ),
                        'nicename'      =>  __( 'Nicename', 'better-studio' ),
                        'email'         =>  __( 'Email', 'better-studio' ),
                        'rand'          =>  __( 'Random', 'better-studio' ),
                    ),
                ),

                array(
                    "type"          => 'bf_select',
                    "admin_label"   => true,
                    "heading"       => __( 'Order', 'better-studio' ),
                    "param_name"    => 'order',
                    "value"         => $this->defaults['order'],
                    "options"       => array(
                        'ASC'           =>  __( 'ASC', 'better-studio' ),
                        'DESC'          =>  __( 'DESC', 'better-studio' ),
                    ),
                ),

                array(
                    "type"          => 'bf_select',
                    "admin_label"   => true,
                    "heading"       => __( 'User Role', 'better-studio' ),
                    "param_name"    => 'role',
                    "value"         => $this->defaults['role'],
                    "options"       => array(
                        'read'          =>  __( 'All',      'better-studio' ),
                        'Super Admin'   =>  __( 'Super Admin',      'better-studio' ),
                        'Administrator' =>  __( 'Administrator',    'better-studio' ),
                        'Editor'        =>  __( 'Editor',           'better-studio' ),
                        'Author'        =>  __( 'Author',           'better-studio' ),
                        'Contributor'   =>  __( 'Contributor',      'better-studio' ),
                        'Subscriber'    =>  __( 'Subscriber',       'better-studio' ),
                    ),
                ),

                array(
                    "type"          => 'bf_select',
                    "admin_label"   => true,
                    "heading"       => __( 'Columns', 'better-studio' ),
                    "param_name"    => 'column',
                    "value"         => $this->defaults['column'],
                    "options"       => array(
                        '2'             =>  __( '2 Column', 'better-studio' ),
                        '3'             =>  __( '3 Column', 'better-studio' ),
                        '4'             =>  __( '4 Column', 'better-studio' ),
                    ),
                ),

                array(
                    "type"          =>  'textfield',
                    "admin_label"   =>  true,
                    "heading"       =>  __( 'Heading', 'better-studio' ),
                    "param_name"    =>  'title',
                    "value"         =>  $this->defaults['title'],
                ),

                array(
                    "type"          =>  'bf_icon_select',
                    "heading"       =>  __( 'Heading Icon (Optional)', 'better-studio' ),
                    "param_name"    =>  'icon',
                    "admin_label"   =>  true,
                    "value"         =>  $this->defaults['icon'],
                    "description"   =>  __( 'Select custom icon for listing.', 'better-studio' ),
                ),

                array(
                    "type"      =>  'bf_switchery',
                    "heading"   =>  __( 'Hide listing Heading?', 'better-studio'),
                    "param_name"=>  'hide_title',
                    "value"     =>  $this->defaults['hide_title'],
                    'section_class' =>  'style-floated-left bordered',
                    "description"   => __( 'You can hide listing heading with turning on this field.', 'better-studio'),
                ),

                array(
                    "type"          =>  'textfield',
                    "admin_label"   =>  true,
                    "heading"       =>  __( 'Exclude Users', 'better-studio' ),
                    "param_name"    =>  'exclude',
                    "value"         =>  $this->defaults['exclude'],
                    "description"   =>  __( 'Separate users IDs with comma ( , ) for excluding them from result.', 'better-studio' )
                ),

            )
        ));

    }

}

class WPBakeryShortCode_bm_user_listing_2 extends BM_VC_Shortcode_Extender { }
