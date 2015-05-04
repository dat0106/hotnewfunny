<?php

/**
 * Posts Listing Widget
 */
class BM_Posts_Listing_Widget extends BF_Widget{

    /**
     * Register widget with WordPress.
     */
    function __construct(){

        // Back end form fields
        $this->fields = array(

            array(
                'name'          =>  __( 'Title', 'better-studio'),
                'attr_id'       =>  'title',
                'type'          =>  'text',
                'section_class' => 'widefat',
            ),

            array(
                'name'          =>  __( 'Order', 'better-studio'),
                'attr_id'       =>  'order',
                'type'          =>  'select',
                'section_class' => 'widefat',
                "options"       =>  array(
                        'recent'    => __('Recent Posts','better-studio'),
                        'popular'   => __('Popular Posts','better-studio'),
                ) ,
            ),

            array(
                'name'          =>  __( 'Style', 'better-studio'),
                'attr_id'       =>  'style',
                'type'          =>  'image_radio',
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
                )
            ),

            array(
                'name'          =>  __( 'Category', 'better-studio'),
                'attr_id'       =>  'category',
                'type'          =>  'select',
                'section_class' => 'widefat',
                "options"       =>  array(
                    'All Posts'         =>  __( 'All Posts', 'better-studio' ),
                    'bm-review-posts'   =>  __( 'Review Posts', 'better-studio' ),
                    'category'  => array(
                        'label'     =>  __( 'Category', 'better-studio' ),
                        'options'     =>  array(
                            'category_walker'    => true,
                        ),
                    )
                ),
            ),

            array(
                'name'          =>  __( 'Tag', 'better-studio'),
                'attr_id'       =>  'tag',
                'type'          =>  'ajax_select',
                "callback"      =>  'BF_Ajax_Select_Callbacks::tags_callback' ,
                "get_name"      =>  'BF_Ajax_Select_Callbacks::tag_name',
                'placeholder'   =>  __( 'Select Tags...', 'better-studio' ),
                'section_class' =>  'widefat',
            ),

            array(
                'name'          =>  __( 'Number Of Posts', 'better-studio'),
                'attr_id'       =>  'count',
                'type'          =>  'text',
                'section_class' => 'widefat',
            ),

            array(
                'name'          =>  __( 'Show Read More Button?', 'better-studio' ),
                'attr_id'       =>  'read_more',
                'id'            =>  'read_more',
                'type'          =>  'checkbox',
            ),
        );

        parent::__construct(
            'bm-posts-listing',
            __( 'BetterStudio - Posts Listing', 'better-studio' ),
            array( 'description' => __( 'Recent and Popular Posts Listing', 'better-studio' ) )
        );
    }
}