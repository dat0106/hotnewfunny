<?php

/**
 * Recent Tab Widget
 */
class BM_Recent_Tab_Widget extends BF_Widget{


    /**
     * Register widget with WordPress.
     */
    function __construct(){

        // Back end form fields
        $this->fields = array(

            array(
                'name'          =>  __( 'Number Of Posts', 'better-studio'),
                'attr_id'       =>  'tabs',
                'type'          =>  'repeater',
                'section_class' => 'widefat',
                'add_label'     => __( 'Add Tab', 'better-studio' ),
                'delete_label'  => __( 'Delete Tab', 'better-studio' ),
                'item_title'    => __( 'Delete Tab', 'better-studio' ),
                'options' => array(

                    array(
                        'name'          =>  __( 'Tab Title (Optional)', 'better-studio'),
                        'attr_id'       =>  'tab_title',
                        'id'            =>  'tab_title',
                        'type'          =>  'text',
                        'desc'          =>  __( 'Category name is default title', 'better-studio' ),
                        'section_class' => 'widefat',
                        'repeater_item' => 'true',
                    ),

                    array(
                        'name'          =>  __( 'Tab Icon', 'better-studio'),
                        'attr_id'       =>  'icon',
                        'id'            =>  'icon',
                        'std'           =>  '',
                        'type'          =>  'icon_select',
                        'section_class' => 'widefat',
                        'repeater_item' => 'true',
                    ),

                    array(
                        'name'          =>  __( 'Style', 'better-studio'),
                        'attr_id'       =>  'style',
                        'id'            =>  'style',
                        'type'          =>  'image_radio',
                        'std'           =>  'thumbnail',
                        'section_class' =>  'style-floated-left bordered',
                        'options'       =>  array(
                            'thumbnail'  =>  array(
                                'label'     =>  __( 'Thumbnail Style', 'better-studio' ),
                                'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . '/images/widget-post-listing-thumbnail.png'
                            ),
                            'modern'  =>  array(
                                'label'     =>  __( 'Modern Style', 'better-studio' ),
                                'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . '/images/widget-post-listing-modern.png'
                            ),
                            'highlight'  =>  array(
                                'label'     =>  __( 'Highlight Style', 'better-studio' ),
                                'img'       =>  BETTER_MAG_ADMIN_ASSETS_URI . '/images/widget-post-listing-highlight.png'
                            ),
                        ),
                        'repeater_item' => 'true',
                    ),

                    array(
                        'name'          =>  __( 'Category', 'better-studio'),
                        'attr_id'       =>  'category',
                        'id'            =>  'category',
                        'type'          =>  'select',
                        'std'           =>  'All Posts',
                        'section_class' =>  'widefat',
                        "options"       =>  array(
                            'recent'            =>  __( 'Recent Posts', 'better-studio' ),
                            'popular'           =>  __( 'Popular Posts', 'better-studio' ),
                            'bm-review-posts'   =>  __( 'Review Posts', 'better-studio' ),
                            'category'  =>  array(
                                'label'         =>  __( 'Category', 'better-studio' ),
                                'options'       =>  array(
                                    'category_walker'    => true,
                                ),
                            )
                        ),
                        'repeater_item' => 'true',
                    ),

                    array(
                        'name'          =>  __( 'Tag', 'better-studio'),
                        'attr_id'       =>  'tag',
                        'id'            =>  'tag',
                        'type'          =>  'ajax_select',
                        "callback"      =>  'BF_Ajax_Select_Callbacks::tags_callback' ,
                        "get_name"      =>  'BF_Ajax_Select_Callbacks::tag_name',
                        'placeholder'   =>  __( 'Select Tags...', 'better-studio' ),
                        'section_class' =>  'widefat',
                        'repeater_item' => 'true',
                    ),

                    array(
                        'name'          =>  __( 'Number Of Posts', 'better-studio'),
                        'attr_id'       =>  'count',
                        'id'            =>  'count',
                        'std'           =>  '5',
                        'type'          =>  'text',
                        'section_class' => 'widefat',
                        'repeater_item' => 'true',
                    ),

                    array(
                        'name'          =>  __( 'Show Read More Button?', 'better-studio' ),
                        'attr_id'       =>  'read_more',
                        'id'            =>  'read_more',
                        'type'          =>  'checkbox',
                    ),
                )
            ),

        );

        parent::__construct(
            'bm-recent-tab',
            __( 'BetterStudio - Recent Tab', 'better-studio' ),
            array( 'description' => __( 'Recent Tabbed Posts Listing', 'better-studio' ) )
        );
    }
}