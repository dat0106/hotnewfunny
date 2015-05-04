<?php
get_header();

the_post();

?><div class="row main-section">
    <?php if( Better_Mag::current_sidebar_layout() == 'left' ) Better_Mag::get_sidebar(); ?>
    <div class="<?php echo Better_Mag::current_sidebar_layout() ?  'col-lg-8 col-md-8 col-sm-8 col-xs-12 with-sidebar content-column' : 'col-lg-12 col-md-12 col-sm-12 col-xs-12 no-sidebar'; ?>"><?php

        ?>
        <article <?php post_class( Better_Mag::generator()->get_attr_class( 'single-content clearfix' ) ); ?>>
            <?php
            if( ! Better_Mag::get_meta( 'bm_disable_post_featured' ) ): ?>
                <div class="featured"><?php

                // Gallery Post Format
                if( get_post_format() == 'gallery' ){
                    Better_Mag::generator()->blocks()->partial_gallery_slider();
                }

                // Video Post Format
                elseif( get_post_format() == 'video' ){
                    echo do_shortcode( apply_filters( 'better-framework/content/video-embed', Better_Mag::posts()->get_meta( 'featured_video_code' ) ) );
                }

                // Featured Image
                else{

                    $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                    $img = $img[0];

                    // featured image for layouts width sidebar
                    if( Better_Mag::current_sidebar_layout() ){
                        echo '<a href="'. $img .'" rel="prettyPhoto" title="' . the_title_attribute( 'echo=0' ) .'">';
                        the_post_thumbnail( 'main-post', array( 'title' => get_the_title(), 'class' => 'img-responsive' ));
                        echo '</a>';
                    }
                    // full width layout style
                    else{
                        echo '<a href="'. $img .'" rel="prettyPhoto" title="' . the_title_attribute( 'echo=0' ) .'">';
                        the_post_thumbnail( 'main-full', array( 'title' => get_the_title(), 'class' => 'img-responsive' ));
                        echo '</a>';
                    }
                }
                ?>
                </div><?php
            endif;

            Better_Mag::posts()->the_title();

            Better_Mag::posts()->the_post_meta();

            if( Better_Mag::get_option( 'content_show_share_box' )  && ( Better_Mag::get_option( 'bm_share_box_location' ) == 'top' || Better_Mag::get_option( 'bm_share_box_location' ) == 'bottom-top' ) ){

                Better_Mag::generator()->blocks()->partial_share_box( true, array( 'class' => 'top-location' ) );

            }

            Better_Mag::posts()->the_content();

            // Shows post categories
            if( Better_Mag::get_option( 'content_show_categories' ) && has_category() ){
                echo "<div class='the-content'><p class='terms-list'>";
                echo '<span class="fa fa-folder-open"></span> ' . __( "Categories: ", 'better-studio' );
                the_category( "<span class='sep'>,</span>" );
                echo "</p></div>";
            }

            // Shows post tags
            if( Better_Mag::get_option( 'content_show_tags' ) && has_tag() ){
                echo "<div class='the-content'><p class='terms-list'>";
                echo '<span class="fa fa-tag"></span> ' . __( "Tags: ", 'better-studio' );
                the_tags( "", "<span class='sep'>,</span>", "" );
                echo "</p></div>";
            }

            ?>
        </article>
        <?php

        if( Better_Mag::get_option( 'content_show_share_box' ) && ( Better_Mag::get_option( 'bm_share_box_location' ) == 'bottom' || Better_Mag::get_option( 'bm_share_box_location' ) == 'bottom-top' ) )
            Better_Mag::generator()->blocks()->partial_share_box();

        if( Better_Mag::get_option( 'content_show_author_box' ) ){
            Better_Mag::generator()->set_attr( 'bio-excerpt', false );
            Better_Mag::generator()->set_attr_class( 'single-post-author' );
            Better_Mag::generator()->blocks()->block_user_row();
            Better_Mag::generator()->clear_atts();
        }

        if( Better_Mag::get_option( 'bm_content_show_post_navigation' ) ){
            Better_Mag::generator()->blocks()->partial_navigate_posts();
        }

        if( Better_Mag::get_option( 'content_show_related_posts' ) )
            Better_Mag::generator()->blocks()->partial_related_posts();

        ?>
        <div class="comments">
            <?php comments_template('', true); ?>
        </div>
    </div>
    <?php if( Better_Mag::current_sidebar_layout() == 'right' ) Better_Mag::get_sidebar(); ?>
</div>
<?php get_footer(); ?>