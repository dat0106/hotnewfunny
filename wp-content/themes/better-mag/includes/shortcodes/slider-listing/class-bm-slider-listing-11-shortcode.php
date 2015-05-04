<?php

class BM_Slider_Listing_11_Shortcode extends BM_Listing_Shortcode{

    function __construct( $id, $options ){

        $id = 'bm_slider_listing_11';

        $this->name = __( 'Slider Listing 11', 'better-studio' );

        $this->description = __( 'Carousel slider listing with 2 and 3 column', 'better-studio' );

        $this->icon = ( BETTER_MAG_ADMIN_ASSETS_URI . 'images/vc-' . $id . '.png' );

        $_options = array(
            'defaults' => array(
                'title'     =>  __( 'Latest Posts', 'better-studio' ),
                'hide_title'        =>  0,
                'icon'              =>  '',
                'category'          =>  '',
                'tag'               =>  '',
                'count'             =>  9,
                'columns'           =>  3,
                'show_read_more'    =>  0,
                'show_excerpt'      =>  0,
                'order_by'          =>  'date',
                'order'             =>  'DESC',
                'format'            =>  'all',
            ),

            'have_widget'       => false,
            'have_vc_add_on'    => true,
        );

        $_options = wp_parse_args( $_options, $options );

        parent::__construct( $id, $_options );

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

        switch( $atts['columns'] ){

            case '3':
                $class = 'column-3';
                break;

            case '2':
                $class = 'column-2';
                break;

            default:
                $class = 'column-3';
                break;
        }

        ?>
        <div class="row gallery-listing gallery-listing-11 block-listing <?php echo $class; ?>">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php

                if( empty( $atts['count'] ) || intval( $atts['count'] ) < 1 )
                    $atts['count'] = get_option('posts_per_page');

                $args = array(
                    'post_type'         => array('post'),
                    'posts_per_page'    => $atts['count'],
                    'order'             =>  $atts['order'],
                    'orderby'           =>  $atts['order_by'],
                );

                if( $atts['order_by'] == 'reviews' ){
                    $args['orderby'] = 'date';
                    $args['meta_key'] = '_bs_review_enabled';
                    $args['meta_value'] = '1';
                }

                if( $atts['category'] != __( 'All Posts', 'better-studio' ) && ! empty( $atts['category'] ) ){
                    $args['category_name'] = $atts['category'];
                }

                if( $atts['tag'] ){
                    $args['tag_slug__and'] = explode(',', $atts['tag']);
                }

                if( $atts['format'] != 'all' ){
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => 'post-format-' . $atts['format'],
                        )
                    );
                    Better_Mag::generator()->set_attr( 'hide-post-format', true );
                }

                if( is_front_page() ){
                    $args = Better_Mag::posts()->update_query_for_duplicate_posts( $args );
                }

                $this->decision_showing_of_term_banner( $atts );

                Better_Mag::posts()->set_query( new WP_Query( apply_filters( 'better-mag/slider-listing-11/args', $args ) ) );

                $this->the_block_title( $atts );

                if( ! $atts['show_excerpt'] ){
                    Better_Mag::generator()->set_attr( 'hide-summary', true );
                }
                Better_Mag::generator()->set_attr( 'hide-meta-review', true );
                Better_Mag::generator()->set_attr( 'hide-meta-author', true );

                ?>
                <div class="flexslider">
                    <ul class="slides"><?php

                        while( Better_Mag::posts()->have_posts() ){
                            Better_Mag::posts()->the_post();
                            echo '<li>';
                            Better_Mag::generator()->blocks()->block_modern();
                            echo '</li>';
                        }

                        ?>
                    </ul>
                </div>
            </div>
        </div><?php

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
                    "type"      =>  'bf_select',
                    "admin_label" => true,
                    "heading"   =>  __( 'Post Formats', 'better-studio' ),
                    "param_name"=>  'format',
                    "value"     =>  $this->defaults['format'],
                    "options"   =>  array(
                        'all'       =>  __( 'All Post Formats', 'better-studio') ,
                        'video'     =>  __( 'Videos', 'better-studio'),
                        'audio'     =>  __( 'Audios', 'better-studio'),
                        'gallery'   =>  __( 'Gallery', 'better-studio'),
                    ) ,
                ),

                array(
                    "type"      =>  'bf_select',
                    "admin_label" => true,
                    "heading"   =>  __( 'Category', 'better-studio' ),
                    "param_name"=>  'category',
                    "value"     =>  $this->defaults['category'],
                    "options"   =>  array( __('All Posts','better-studio') => __('All Posts','better-studio') ) + BF_Query::get_categories_by_slug(),
                ),

                array(
                    "type"      =>  'bf_ajax_select',
                    "admin_label" => true,
                    "heading"   =>  __( 'Tags', 'better-studio' ),
                    "param_name"=>  'tag',
                    "value"     =>  $this->defaults['tag'],
                    "callback"  =>  'BF_Ajax_Select_Callbacks::tags_slug_callback' ,
                    "get_name"  =>  'BF_Ajax_Select_Callbacks::tag_by_slug_name',
                    'placeholder'   => __( "Search tag...", 'better-studio' ),
                    'description'   => __( "Search and select tags. You can use combination of Category and Tags!", 'better-studio' )
                ),

                array(
                    "type"          =>  'bf_switchery',
                    "heading"       =>  __( 'Show post excerpt in slider?', 'better-studio' ),
                    "param_name"    =>  'show_excerpt',
                    "value"         =>  $this->defaults['show_excerpt'],
                ),

                array(
                    "type"          =>  'bf_switchery',
                    "heading"       =>  __( 'Show read more button?', 'better-studio' ),
                    "param_name"    =>  'show_read_more',
                    "value"         =>  $this->defaults['show_read_more'],
                ),

                array(
                    "type"          => 'bf_select',
                    "admin_label"   => true,
                    "heading"       => __( 'Columns', 'better-studio' ),
                    "param_name"    => 'columns',
                    "value"         => $this->defaults['columns'],
                    "options"       => array(
                        '2'   =>  __('2 Column', 'better-studio'),
                        '3'   =>  __('3 Column', 'better-studio'),
                    ),
                ),

                array(
                    "type"      =>  'textfield',
                    "admin_label" => true,
                    "heading"   =>  __( 'Number of Posts', 'better-studio' ),
                    "param_name"=>  'count',
                    "value"     =>  $this->defaults['count'],
                    "description"=> __( 'Configures posts to show. Leave empty to use theme default number of posts.', 'better-studio' )
                ),

                array(
                    "type"          =>  'bf_select',
                    "heading"       =>  __( 'Order By', 'better-studio' ),
                    "param_name"    =>  'order_by',
                    "admin_label" => true,
                    "value"         =>  $this->defaults['order_by'],
                    "options"   =>  array(
                        'date'      =>  __( 'Published Date', 'better-studio' ),
                        'modified'  =>  __( 'Modified Date', 'better-studio' ),
                        'rand'      =>  __( 'Random', 'better-studio' ),
                        'comment_count' =>  __( 'Number of Comments', 'better-studio' ),
                        'reviews'   =>  __( 'Reviews', 'better-studio' ),
                    )
                ),

                array(
                    "type"          =>  'bf_select',
                    "heading"       =>  __( 'Order', 'better-studio' ),
                    "param_name"    =>  'order',
                    "admin_label" => true,
                    "value"         =>  $this->defaults['order'],
                    "options"   =>  array(
                        'DESC'       =>  __( 'Latest First - Descending', 'better-studio' ),
                        'ASC'      =>  __( 'Oldest First - Ascending', 'better-studio' ),
                    )
                ),

                array(
                    "type"      =>  'textfield',
                    "admin_label" => true,
                    "heading"   =>  __( 'Custom Heading (Optional)', 'better-studio' ),
                    "param_name"=>  'title',
                    "value"     =>  $this->defaults['title'],
                ),

                array(
                    "type"      =>  'bf_icon_select',
                    "heading"   =>  __( 'Custom Heading Icon (Optional)', 'better-studio' ),
                    "param_name"=>  'icon',
                    "admin_label" => true,
                    "value"     =>  $this->defaults['icon'],
                    "description"=> __( 'Select custom icon for listing.', 'better-studio' ),
                ),

                array(
                    "type"      =>  'bf_switchery',
                    "heading"   =>  __( 'Hide listing Heading?', 'better-studio'),
                    "param_name"=>  'hide_title',
                    "value"     =>  $this->defaults['hide_title'],
                    'section_class' =>  'style-floated-left bordered',
                    "description"   => __( 'You can hide listing heading with turning on this field.', 'better-studio'),
                ),



            )
        ));

    }

}

class WPBakeryShortCode_bm_slider_listing_11 extends BM_VC_Shortcode_Extender { }
