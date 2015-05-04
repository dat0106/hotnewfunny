<?php

/**
 * Better Social Counter Shortcode
 */
class Better_Social_Counter_Shortcode extends BF_Shortcode{

    function __construct(  $id , $options  ){

        $id = 'better-social-counter';

        $this->widget_id = 'better-social-counter';

        $this->name = __( 'Better Social Counter', 'better-studio' );

        $this->description = __( 'BetterSocial Counter Add-on', 'better-studio' );

        $this->icon = BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter.png';

        $options = array_merge( array(
            'defaults'      => array(
                'title'     => __( 'Stay With Us', 'better-studio'),
                'show_title'   => 1,
                'style'     => 'modern',
                'colored'   => 1,
                'columns'   => 4,
                'order'     => array(),
            ),
            'have_widget'   => true,
            'have_vc_add_on'=> true,
        ), $options );

        // need BF_Social_Counter class for retrieving data
        require_once BETTER_SOCIAL_COUNTER_DIR_PATH . 'includes/class-better-social-counter-data-manager.php';

        parent::__construct( $id , $options );

    }


    /**
     * Filter custom css codes for shortcode widget!
     *
     * @param $fields
     * @return array
     */
    function register_custom_css( $fields ){
        return $fields;
    }


    /**
     * Used for generating li for social list
     *
     * @param string $id
     * @return string
     */
    function get_full_li( $id = '' ){

        if( empty( $id ) ) return '';

        $data = Better_Social_Counter_Data_Manager::get_full_data( $id );

        if( ! $data ) return '';

        $output = '<li class="social-item '.$id.'">';
        $output .=    '<a href="'. $data['link'] .'" class="item-link">';
        $output .= '<i class="item-icon bsfi-' . $id . '"></i><span class="item-count">'. $data['count'] .'</span>';
        $output .= '<span class="item-title">'. $data['title'] .'</span></a></li>';

        return $output;
    }


    /**
     * Used for generating li for social list
     *
     * @param string $id
     * @return string
     */
    function get_short_li( $id = '' ){

        if( empty( $id ) ) return '';

        $data = Better_Social_Counter_Data_Manager::get_full_data( $id );

        if( ! $data ) return '';

        return '<li class="social-item ' . $id . '"><a href="'. $data['link'] .'"><i class="item-icon bsfi-' . $id . '"></i><span class="item-title">'. $data['title'] .'</span></a></li>';
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

        if( BF_Widgets_Manager::is_special_sidebar() )
            $style = 'button';
        else
            $style = $atts['style'];

        if( ! in_array( $style, array( 'clean', 'box', 'button', 'modern' ) ) )
            $style = 'clean';


        if( $atts['title'] && ! Better_Framework::widget_manager()->get_current_sidebar() && $atts['show_title']){
            $atts['element-type'] = $this->id;
            $result = apply_filters( 'better-framework/shortcodes/title', $atts );

            if( is_string( $result ) )
                echo $result;
        }

        ?>
        <div class="better-studio-shortcode bsc-clearfix better-social-counter style-<?php echo $style; ?> <?php echo $atts['colored'] == 1 ? 'colored' :''; ?> in-<?php echo $atts['columns']; ?>-col">
            <ul class="social-list bsc-clearfix"><?php
                if( ! is_array( $atts['order'] ) ){
                    $atts['order'] = explode( ',', $atts['order'] );
                    if( $style == 'button' ){
                        foreach( $atts['order'] as $site ){
                            echo $this->get_short_li( $site );
                        }
                    }else{
                        foreach( $atts['order'] as $site ){
                            echo $this->get_full_li( $site );
                        }
                    }
                }else{
                    if( $style == 'button' ){
                        foreach( $atts['order'] as $site_key => $site ){
                            echo $this->get_short_li( $site_key );
                        }
                    }else{
                        foreach( $atts['order'] as $site_key => $site ){
                            echo $this->get_full_li( $site_key );
                        }
                    }
                }
            ?>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }


    /**
     * Registers Visual Composer Add-on
     */
    function register_vc_add_on(){

        vc_map( array(
            "name"          =>  $this->name,
            "base"          =>  $this->id,
            "icon"          =>  $this->icon,
            "description"   =>  $this->description,
            "weight"        =>  1,
            "php_class_name"=>  'WPBakeryShortCode_better_social_counter',

            "wrapper_height"=>  'full',

            "category"      =>  __( 'Content', 'better-studio' ),

            "params"        => array(

                array(
                    "type"          =>  'textfield',
                    "admin_label"   =>  true,
                    "heading"       =>  __( 'Title', 'better-studio' ),
                    "param_name"    =>  'title',
                    "value"         =>  $this->defaults['title'],
                ),

                array(
                    "type"          =>  'bf_switchery',
                    "heading"       =>  __( 'Show Title?', 'better-studio'),
                    "param_name"    =>  'show_title',
                    "value"         =>  $this->defaults['show_title'],
                ),

                array(
                    'heading'       =>  __( 'Style', 'better-studio'),
                    'type'          =>  'bf_image_radio',
                    "admin_label"   =>  true,
                    "param_name"    =>  'style',
                    "value"         =>  $this->defaults['style'],
                    'section_class' =>  'style-floated-left',
                    'options'       =>  array(
                        'modern'=> array(
                            'label'     => __( 'Modern Style' , 'better-studio' ),
                            'img'       => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-modern.png'
                        ),
                        'clean' => array(
                            'label'     => __( 'Clean Style' , 'better-studio' ),
                            'img'       => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-clean.png'
                        ),
                        'box'       =>  array(
                            'label'     => __( 'Box Style', 'better-studio' ),
                            'img'       => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-box.png'
                        ),
                        'button'=> array(
                            'label'     => __( 'Button Style' , 'better-studio' ),
                            'img'       => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-button.png'
                        ),
                    ),
                ),

                array(
                    "type"          =>  'bf_switchery',
                    "heading"       =>  __( 'Show in colored  style?', 'better-studio'),
                    "param_name"    =>  'colored',
                    "value"         =>  $this->defaults['colored'],
                ),

                array(
                    "type"          =>  'bf_select',
                    "admin_label"   =>  true,
                    "heading"       =>  __( 'Number of Columns', 'better-studio' ),
                    "param_name"    =>  'columns',
                    "value"         =>  $this->defaults['columns'],
                    "options"       =>  array(
                        '1'     =>  __( '1 Column' , 'better-studio' ),
                        '2'     =>  __( '2 Column' , 'better-studio' ),
                        '3'     =>  __( '3 Column' , 'better-studio' ),
                        '4'     =>  __( '4 Column' , 'better-studio' ),
                        '5'     =>  __( '5 Column' , 'better-studio' ),
                        '6'     =>  __( '6 Column' , 'better-studio' ),
                        '7'     =>  __( '7 Column' , 'better-studio' ),
                        '8'     =>  __( '8 Column' , 'better-studio' ),
                        '9'     =>  __( '9 Column' , 'better-studio' ),
                        '10'    =>  __( '10 Column' , 'better-studio' ),
                    ),
                ),

                array(
                    "type"          =>  'bf_sorter_checkbox',
                    "admin_label"   =>  true,
                    "heading"       =>  __( 'Active and Sort Sites', 'better-studio' ),
                    "param_name"    =>  'order',
                    "value"         =>  '',
                    "options"       =>  Better_Social_Counter_Data_Manager::self()->get_widget_options_list(),
                ),

            )

        ) );

    }
}

class WPBakeryShortCode_better_social_counter extends BF_VC_Shortcode_Extender { }