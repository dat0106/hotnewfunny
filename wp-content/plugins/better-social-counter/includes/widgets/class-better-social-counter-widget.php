<?php

/**
 * Better Social Counter Widget
 */
class Better_Social_Counter_Widget extends BF_Widget{

    /**
     * Register widget with WordPress.
     */
    function __construct(){

        // haven't title in any location
        $this->with_title = true;

        // Back end form fields
        $this->fields = array(
            array(
                'name'          =>  __( 'Title', 'better-studio'),
                'attr_id'       =>  'title',
                'type'          =>  'text',
                'section_class' => 'widefat',
            ),

            array(
                'name'          =>  __( 'Style', 'better-studio'),
                'attr_id'       =>  'style',
                'type'          =>  'image_radio',
                'section_class' =>  'style-floated-left',
                'value'         =>  'clean',
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
                'name'          =>  __( 'Show in colored  style?', 'better-studio' ),
                'attr_id'       =>  'colored',
                'type'          =>  'checkbox',
            ),

            array(
                'name'          =>  __( 'Number of Columns', 'better-studio' ),
                'attr_id'       =>  'columns',
                'type'          =>  'select',
                'value'         =>  'all',
                'options'       =>  array(
                    '1'     =>  __( '1 Column' , 'better-studio' ),
                    '2'     =>  __( '2 Column' , 'better-studio' ),
                    '3'     =>  __( '3 Column' , 'better-studio' ),
                    '4'     =>  __( '4 Column' , 'better-studio' ),
                ),
            ),

            array(
                'name'          =>  __( 'Sort and Active Sites', 'better-studio' ),
                'attr_id'       =>  'order',
                'type'          =>  'sorter_checkbox',
                'options'       =>  Better_Social_Counter_Data_Manager::self()->get_widget_options_list(),
                'section_class' =>  'better-social-counter-sorter',
            ),

        );

        parent::__construct(
            'better-social-counter',
            __( 'Better Social Counter', 'better-studio' ),
            array( 'description' => __( 'Social Counter Widget', 'better-studio' ) )
        );

    }


    /**
     * Front-end display of widget.
     *
     * @see BF_Widget::widget()
     * @see WP_Widget::widget()
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance){

        $instance = $this->parse_args( $this->defaults , $instance  );

        if( ! BF_Widgets_Manager::is_top_bar_sidebar() )
            echo $args['before_widget'];

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        if( ! empty($title) && $this->with_title ){
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo BF_Shortcodes_Manager::factory( $this->id_base )->display( $instance , '' );

        if( ! BF_Widgets_Manager::is_top_bar_sidebar() )
            echo $args['after_widget'];
    }
}