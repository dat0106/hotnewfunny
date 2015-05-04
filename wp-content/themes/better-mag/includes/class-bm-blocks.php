<?php

/**
 * Used for blocks and other html parts of BetterMag
 *
 * Developers note: For changing this blocks don't change this file!
 * Create a child theme and inside functions.php create a class  that inherits from the BM_Blocks class and then override blocks do you want and change the code.
 * For example how to change the get_block_title method in child theme
 *
 *
 * // Child class of BM_Blocks
 * class Custom_BM_Blocks extends BM_Blocks{
 *
 *      public static function get_block_title( $title = '', $link = false, $echo = true, $class = '' ){
 *          if( $link != false ){
 *              $title = '<a href="' . $link . '">' . $title . '</a>';
 *          }
 *
 *          $output = '<h4 class="section-heading ' . $class . '"><span class="h-title">1111' . $title . '</span></h4>';
 *
 *          if( $echo )
 *              echo $output;
 *          else
 *              return $output;
 *      }
 *
 * }
 *
 * add_filter( 'better_mag-blocks', 'filter_better_mag_blocks_generator' );
 *
 * function filter_better_mag_blocks_generator(){
 *      return 'Custom_BM_Blocks';
 * }
 *
 */
class BM_Blocks{


    /**
     * Used for showing logo
     */
    public static function site_logo(){ ?>
        <?php if( is_home() ){ ?>
            <h1 class="logo">
        <?php }else{ ?>
            <h2 class="logo">
        <?php } ?>
        <a href="<?php echo home_url(); ?>" rel="home">
            <?php if( Better_Mag::get_option( 'logo_image' ) != '' ){ ?>
            <img src="<?php echo esc_attr( Better_Mag::get_option( 'logo_image' ) ); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"
                 <?php if( Better_Mag::get_option( 'logo_image_retina' ) != '' ){ ?>data-at2x="<?php echo Better_Mag::get_option( 'logo_image_retina' ); ?>"<?php } ?> />
        <?php }else{
            echo Better_Mag::get_option( 'logo_text' );
        } ?>
        </a>
        <?php if( is_home() ){ ?>
            </h1>
        <?php }else{ ?>
            </h2>
        <?php }

        if( Better_Mag::get_option( 'show_site_description' ) ){
            ?><p class="site-description"><?php echo bloginfo('description'); ?></p><?php
        }

    }


    /**
     * Used for generating a block title
     *
     * @param   string  $title
     * @param   bool    $link
     * @param   bool    $echo
     * @param   string  $class
     * @return  string
     */
    public static function get_block_title( $title = '', $link = false, $echo = true, $class = '' ){
        if( $link != false ){
            $title = '<a href="' . $link . '">' . $title . '</a>';
        }

        $output = '<h4 class="section-heading ' . $class . '"><span class="h-title">' . $title . '</span></h4>';

        if( $echo )
            echo $output;
        else
            return $output;
    }


    /**
     * Used for generating a page title
     *
     * @param   string  $title
     * @param   bool    $link
     * @param   bool    $echo
     * @param   string  $heading
     * @param   string  $transform
     * @return  string
     */
    public static function get_page_title( $title = '', $link = false, $echo = true, $heading = 'h4', $transform = 'uppercase' ){
        if( $link != false ){
            $title = '<a href="' . $link . '">' . $title . '</a>';
        }

        $output = '<' . $heading . ' class="page-heading ' . $transform . '"><span class="h-title">' . $title . '</span></' . $heading . '>';

        if( $echo )
            echo $output;
        else
            return $output;
    }


    /**
     * Used for generating tab block title
     *
     * @param   array   $other_links
     * @param   bool    $echo
     * @return  string
     */
    public static function get_tab_block_title( $other_links = array(), $echo = true ){

        $output = '';

        if( count( $other_links ) ){

            $first = reset( $other_links );

            $output .= '<div class="section-heading extended tab-heading  active-term-' . $first['id'] . ' clearfix">';

            $output .= '<ul class="other-links nav nav-tabs">';

            foreach( $other_links as $link ){

                if( isset( $link['active'] ) && $link['active'] ){
                    $active = 'active';
                }else{
                    $active = '';
                }

                if( isset( $link['class'] ) && $link['class'] ){
                    $class = $link['class'];
                }else{
                    $class = '';
                }

                if( isset( $link['id'] ) ){
                    $class .= ' term-' . $link['id'] ;
                }

                $output .= "<li class='other-item {$class} {$active}'><a href='" . $link['href'] . "'  data-toggle='tab'>" . $link['title'] . "</a></li>";
            }
            $output .= '</ul>';

            $output .= '</div>';

        }

        if( $echo )
            echo $output;
        else
            return $output;
    }


    /**
     * Used for generating extended block title
     *
     * @param   string  $title
     * @param   bool    $link
     * @param   array   $other_links
     * @param   bool    $echo
     * @param   string  $class
     * @return  string
     */
    public static function get_extended_block_title( $title = '', $link = false, $other_links = array(), $echo = true, $class= '' ){
        if( $link != false ){
            $title = '<a href="' . $link . '">' . $title . '</a>';
        }

        $output = '<div class="section-heading extended clearfix ' . $class . '"><h4 class=""><span class="h-title">' . $title . '</span></h4>';

        if( count( $other_links ) ){

            $output .= '<ul class="other-links">';
            foreach( $other_links as $link ){

                if( isset( $link['active'] ) && $link['active'] ){
                    $active = 'active-item';
                }else{
                    $active = '';
                }

                if( isset( $link['class'] ) && $link['class'] ){
                    $class = $link['class'];
                }else{
                    $class = '';
                }

                $output .= "<li class='other-item {$class} {$active}'><a href='" . $link['href'] . "'>" . $link['title'] . "</a></li>";
            }
            $output .= '</ul>';
        }


        $output .= '</div>';
        if( $echo )
            echo $output;
        else
            return $output;
    }


    /**
     * Used for generating a page or block description title
     *
     * @param string $content
     * @param bool $echo
     * @return string
     */
    public static function get_block_desc( $content = '', $echo = true ){

        $output = '<div class="block-desc">' . $content . '</div>';

        if( $echo )
            echo $output;
        else
            return $output;
    }


    /**
     * Blog block.
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function block_blog( $echo = true ){

        if( ! $echo )
            ob_start();

        $term = Better_Mag::generator()->get_post_main_category();
        if( $term ){
            $class = 'main-term-' . $term->cat_ID;
        }else{
            $class = 'main-term-none';
        }

        ?><article <?php post_class( Better_Mag::generator()->get_attr_class( 'blog-block ' . $class ) ); ?>>
        <div class="row">
            <?php if( Better_Mag::posts()->has_post_thumbnail() ){ ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <a class="image-link" href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( Better_Mag::generator()->get_attr_thumbnail_size( 'main-block' ), array( 'class' => 'img-responsive' ) );
                    Better_Mag::generator()->blocks()->get_post_format_icon();
                    ?>
                </a>
                <?php Better_Mag::generator()->blocks()->get_term_title_banner(); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?php } else { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php } ?>
                    <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php Better_Mag::generator()->blocks()->partial_meta(); ?>
                    <div class="summary the-content"><?php Better_Mag::posts()->excerpt( Better_Mag::generator()->get_attr( 'excerpt-length', Better_Mag::get_option( 'blog_listing_excerpt_length' ) ) ); ?></div>
                    <?php Better_Mag::generator()->excerpt_read_more(); ?>
                </div>
            </div>
        </article>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Block Highlight.
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function block_highlight( $echo = true ){

        if( ! $echo )
            ob_start();

        $term = Better_Mag::generator()->get_post_main_category();
        if( $term ){
            $class = 'main-term-' . $term->cat_ID;
        }else{
            $class = 'main-term-none';
        }

        ?><article <?php post_class( Better_Mag::generator()->get_attr_class( 'block-highlight ' . $class ) ); ?>>
        <a class="image-link" href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( Better_Mag::generator()->get_attr_thumbnail_size( 'main-block' ), array( 'class' => 'img-responsive' ) ); ?>
            <?php
            Better_Mag::generator()->blocks()->get_post_format_icon();
            ?>
        </a>
        <?php
        Better_Mag::generator()->blocks()->get_term_title_banner();
        ?>
        <div class="content">
            <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php
            if( ! Better_Mag::generator()->get_attr( "hide-meta", false ) ){
                Better_Mag::generator()->blocks()->partial_meta();
            }
            ?>
        </div>
        </article>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Block Modern.
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function block_modern( $echo = true ){

        if( ! $echo )
            ob_start();

        $term = Better_Mag::generator()->get_post_main_category();
        if( $term ){
            $class = 'main-term-' . $term->cat_ID;
        }else{
            $class = 'main-term-none';
        }

        ?><article <?php post_class( Better_Mag::generator()->get_attr_class( 'block-modern ' . $class ) ); ?>>
        <?php if( Better_Mag::posts()->has_post_thumbnail() ) {?>
            <a class="image-link" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( Better_Mag::generator()->get_attr_thumbnail_size( 'main-block' ), array( 'class' => 'img-responsive' ) );
                Better_Mag::generator()->blocks()->get_post_format_icon();
                ?></a>
            <?php
            Better_Mag::generator()->blocks()->get_term_title_banner();

            Better_Mag::generator()->blocks()->partial_meta();
        }

        ?>
        <h2 class="title <?php echo Better_Mag::generator()->get_attr( 'hide-summary' ) ? 'highlight-line' : ''; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if( ! Better_Mag::generator()->get_attr( 'hide-summary' ) ): ?>
            <div class="summary highlight-line"><?php Better_Mag::posts()->excerpt( Better_Mag::generator()->get_attr( 'excerpt-length', Better_Mag::get_option( 'modern_listing_excerpt_length' ) ) ); ?></div>
        <?php endif; ?>
        </article>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Block user modern.
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function block_user_modern( $echo = true ){

        if( ! $echo )
            ob_start();

        ?><section class="block-user-modern clearfix <?php echo Better_Mag::generator()->get_attr( 'block-class', '' ); ?>"><?php

        // Custom User Object, used in shortcode and user listings
        $_author = Better_Mag::generator()->get_attr( 'user-object', false );

        // If user object not defined then use global $authordata
        if( $_author == false ){

            global $authordata;
            $_author = $authordata;

        }

        $links = array();

        if(  $github_url = get_the_author_meta( 'github_url', $_author->ID ) ){
            $links[] = array(
                'title'     =>  '<i class="fa fa-github"></i>',
                'href'      =>  $github_url,
                'class'     =>  'github',
            );
        }

        if(  $linkedin_url = get_the_author_meta( 'linkedin_url', $_author->ID ) ){
            $links[] = array(
                'title'     =>  '<i class="fa fa-linkedin"></i>',
                'href'      =>  $linkedin_url,
                'class'     =>  'linkedin',
            );
        }

        if(  $gplus_url = get_the_author_meta( 'gplus_url', $_author->ID ) ){
            $links[] = array(
                'title'     =>  '<i class="fa fa-google-plus"></i>',
                'href'      =>  $gplus_url,
                'class'     =>  'gplus',
            );
        }

        if(  $twitter_url = get_the_author_meta( 'twitter_url', $_author->ID ) ){
            $links[] = array(
                'title'     =>  '<i class="fa fa-twitter"></i>',
                'href'      =>  $twitter_url,
                'class'     =>  'twitter',
            );
        }

        if(  $facebook_url = get_the_author_meta( 'facebook_url', $_author->ID ) ){
            $links[] = array(
                'title'     =>  '<i class="fa fa-facebook"></i>',
                'href'      =>  $facebook_url,
                'class'     =>  'facebook',
            );
        }

        $user_archive_link = false;

        if( ! is_author( $_author->ID ) ){

            $links[] = array(
                'title'     =>  '<i class="fa fa-home"></i>',
                'href'     =>  esc_url( get_author_posts_url( $_author->ID, $_author->user_nicename ) ),
                'class'     =>  'profile',
            );
            $user_archive_link = esc_url( get_author_posts_url( $_author->ID, $_author->user_nicename ) );

        }

        if( $user_archive_link )
            echo '<a href="' . $user_archive_link . '">';

        echo get_avatar( get_the_author_meta( 'user_email', $_author->ID ), Better_Mag::generator()->get_attr_thumbnail_size( 100 ) );

        if( $user_archive_link )
            echo '</a>';

        ?>
        <h4 class="user-title">
            <?php

            if( $user_archive_link ){
                echo '<a href="' . $user_archive_link . '">' . get_the_author_meta( 'display_name', $_author->ID ) .'</a>';
            }else{
                echo get_the_author_meta( 'display_name', $_author->ID );
            }



            ?>
        </h4>
        <div class="the-content"><?php echo wpautop( wp_trim_words( get_the_author_meta( 'description', $_author->ID ), 12 ) ); ?></div>
        <?php

        if( Better_Mag::generator()->get_attr( 'user-show-post-count', false ) ){
            echo  '<span class="posts-count"><a href="'. $user_archive_link .'" title="'. esc_attr( __( 'Browse Author Articles', 'better-studio') ) .'">'
                . sprintf( __( '%s Articles', 'better-studio' ), count_user_posts( $_author->ID ) ) . '</a></span>';

        }


        if( count( $links ) ){

            echo '<ul class="user-links">';

            foreach( $links as $link ){

                echo '<li class="' . $link['class'] . '">';
                echo '<a href="' . $link['href'] . '">' . $link['title'] . '</a>';
                echo '</li>';

            }

            echo '</ul>';

        }


        ?>
        </section>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }



    /**
     * Block user row
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function block_user_row( $echo = true ){

        if( ! $echo )
            ob_start();

        ?>
        <section class="block-user-row clearfix <?php echo Better_Mag::generator()->get_attr( 'block-class', '' ); ?>"><?php

            // Custom User Object, used in shortcode and user listings
            $_author = Better_Mag::generator()->get_attr( 'user-object', false );

            // If user object not defined then use global $authordata
            if( $_author == false ){

                global $authordata;
                $_author = $authordata;

            }

            $links = array();

            if(  $github_url = get_the_author_meta( 'github_url', $_author->ID ) ){
                $links[] = array(
                    'title'     =>  '<i class="fa fa-github"></i>',
                    'href'      =>  $github_url,
                );
            }

            if(  $linkedin_url = get_the_author_meta( 'linkedin_url', $_author->ID ) ){
                $links[] = array(
                    'title'     =>  '<i class="fa fa-linkedin"></i>',
                    'href'      =>  $linkedin_url,
                );
            }

            if(  $gplus_url = get_the_author_meta( 'gplus_url', $_author->ID ) ){
                $links[] = array(
                    'title'     =>  '<i class="fa fa-google-plus"></i>',
                    'href'      =>  $gplus_url,
                );
            }

            if(  $twitter_url = get_the_author_meta( 'twitter_url', $_author->ID ) ){
                $links[] = array(
                    'title'     =>  '<i class="fa fa-twitter"></i>',
                    'href'      =>  $twitter_url,
                );
            }

            if(  $facebook_url = get_the_author_meta( 'facebook_url', $_author->ID ) ){
                $links[] = array(
                    'title'     =>  '<i class="fa fa-facebook"></i>',
                    'href'      =>  $facebook_url,
                );
            }

            $user_archive_link = false;

            if( ! is_author( $_author->ID ) ){

                $links[] = array(
                    'title'     =>  '<i class="fa fa-home"></i>',
                    'href'     =>  esc_url( get_author_posts_url( $_author->ID, $_author->user_nicename ) ),
                );
                $user_archive_link = esc_url( get_author_posts_url( $_author->ID, $_author->user_nicename ) );

            }


            Better_Mag::generator()->blocks()->get_extended_block_title( get_the_author_meta( 'display_name', $_author->ID ) , $user_archive_link, $links );

            echo get_avatar( get_the_author_meta( 'user_email', $_author->ID ), Better_Mag::generator()->get_attr_thumbnail_size( 80 ) );


            ?><div class="the-content"><?php

                if( Better_Mag::generator()->get_attr( 'bio-excerpt', true ) ){
                    echo wpautop( wp_trim_words( get_the_author_meta( 'description', $_author->ID ), 12 ) );
                }else{
                    echo wpautop( get_the_author_meta( 'description', $_author->ID ) );
                }

                ?></div>
            <?php

            if( Better_Mag::generator()->get_attr( 'user-show-post-count', false ) ){
                echo  '<span class="posts-count"><a href="'. $user_archive_link .'" title="'. esc_attr( __( 'Browse Author Articles', 'better-studio') ) .'">'
                    . sprintf( __( '%s Articles', 'better-studio' ), count_user_posts( $_author->ID ) ) . '</a></span>';

            }

            ?>
        </section>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Bigger Thumbnail Listing
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function listing_bigger_thumbnail( $echo = true ){

        if( ! $echo )
            ob_start();

        ?>
        <ol class="listing-thumbnail">
            <?php

            while( Better_Mag::posts()->have_posts() ){

                Better_Mag::posts()->the_post();

                $term = Better_Mag::generator()->get_post_main_category();
                $class = 'main-term-' . $term->cat_ID;

                ?>
                <li class="<?php echo Better_Mag::generator()->get_attr_class( 'clearfix ' . $class ); ?>">
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( Better_Mag::generator()->get_attr_thumbnail_size( 'bigger-thumbnail' ) ); ?></a>
                    <h3 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                    <?php Better_Mag::generator()->blocks()->partial_meta(); ?>
                </li>
                <?php
            }

            ?>
        </ol>

        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Listing Thumbnail
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function listing_thumbnail( $echo = true ){

        if( ! $echo )
            ob_start();

        ?>
        <ol class="listing-thumbnail">
            <?php

            while( Better_Mag::posts()->have_posts() ){

                Better_Mag::posts()->the_post();

                $term = Better_Mag::generator()->get_post_main_category();
                $class = 'main-term-' . $term->cat_ID;

                ?>
                <li class="<?php echo Better_Mag::generator()->get_attr_class( 'clearfix ' . $class ); ?>">
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( Better_Mag::generator()->get_attr_thumbnail_size( 'post-thumbnail' ) ); ?></a>
                    <h3 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                    <?php Better_Mag::generator()->blocks()->partial_meta(); ?>
                </li>
                <?php
            }

            ?>
        </ol>



        <?php

        if( ! $echo )
            return ob_get_clean();
    }



    /**
     * Simple Listing
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function listing_simple( $echo = true ){

        if( ! $echo )
            ob_start();

        ?>
        <ol class="listing-simple">
            <?php

            while( Better_Mag::posts()->have_posts() ){

                Better_Mag::posts()->the_post();

                ?>
                <li class="<?php echo Better_Mag::generator()->get_attr_class( 'clearfix' ); ?>">
                    <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </li>
                <?php
            }

            ?>
        </ol>


        <?php

        if( ! $echo )
            return ob_get_clean();
    }



    /**
     * Partial block for for gallery posts
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function partial_gallery_slider( $echo = true ){

        if( ! $echo )
            ob_start();

        $gallery_images_ids = Better_Mag::posts()->get_first_gallery_ids();

        if( ! $gallery_images_ids ){
            return;
        }

        $gallery_images = new WP_Query( array(
            'post_type'     => 'attachment',
            'post_status'   => 'inherit',
            'post__in'      => $gallery_images_ids,
            'orderby'       => 'post__in',
            'posts_per_page'=> -1
        ));

        // Gallery Images as Background Slide Show!
        if( Better_Mag::posts()->get_meta( 'gallery_images_bg_slides' ) && is_singular() ){
            $gallery_bg_slide_show = 'gallery-as-background-slide-show';
        }else{
            $gallery_bg_slide_show = '';
        }

        ?>

        <div class="gallery-slider slider-arrows <?php echo $gallery_bg_slide_show; ?>">
            <div class="flexslider">
                <ul class="slides">
                    <?php foreach( $gallery_images->posts as $attachment ){ ?>

                        <li>
                            <a href="<?php echo wp_get_attachment_url($attachment->ID); ?>" title="<?php echo $attachment->post_excerpt ? $attachment->post_excerpt : ''; ?>" rel="prettyPhoto[featured-gallery]">
                                <?php
                                if( Better_Mag::posts()->get_meta( 'gallery_images_bg_slides' ) && is_singular() ){
                                    $_img_src = wp_get_attachment_image_src( $attachment->ID, 'full' );
                                    $image_attr = array(
                                        'data-img'  =>   $_img_src[0]
                                    );
                                }else{
                                    $image_attr = array();
                                }

                                if( is_singular() && ! Better_Mag::current_sidebar_layout() ){
                                    echo wp_get_attachment_image( $attachment->ID, 'main-full', false, $image_attr );
                                }else{
                                    echo wp_get_attachment_image( $attachment->ID, 'main-post', false, $image_attr );
                                }

                                // caption
                                if ($attachment->post_excerpt){?>
                                    <p class="caption"><?php echo $attachment->post_excerpt; ?></p><?php
                                } ?>
                            </a>
                        </li>

                    <?php } // No Reset Query Needed; We Used WP_Query->posts result directly as object ?>
                </ul>
            </div>
        </div>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }



    /**
     * Partial block for related posts.
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function partial_related_posts( $echo = true ){

        if( ! $echo )
            ob_start();

        ?>
        <section class="related-posts clearfix"><?php

            Better_Mag::generator()->blocks()->get_block_title( __( 'Related Posts', 'better-studio') );

            $related_q = Better_Mag::posts()->get_related( 3, Better_Mag::get_option( 'content_show_related_posts_type' ) );

            Better_Mag::posts()->set_query( $related_q );

            Better_Mag::generator()->set_attr( 'hide-summary', true );
            Better_Mag::generator()->set_attr( 'hide-meta-author', true );
            Better_Mag::generator()->set_attr_thumbnail_size( 'main-block' );
            Better_Mag::generator()->set_attr( 'show-term-banner', true );


            ?><div class="row"><?php

                while( Better_Mag::posts()->have_posts() ){

                    Better_Mag::posts()->the_post();

                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><?php

                    Better_Mag::generator()->blocks()->block_modern();

                    ?></div><?php

                }

                Better_Mag::posts()->clear_query();
                Better_Mag::generator()->clear_atts();

                ?></div>
        </section>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }




    /**
     * Partial search form
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function partial_search_form( $echo = true ){

        if( ! $echo )
            ob_start();

        ?>
        <form role="search" method="get" class="search-form" action="<?php echo home_url(); ?>">
            <label>
                <input type="search" class="search-field" placeholder="<?php _e( 'Search...', 'better-studio' ); ?>" value="<?php echo isset($s) ? $s : ''; ?>" name="s" title="<?php _e( 'Search for:', 'better-studio' ); ?>">
            </label>
            <input type="submit" class="search-submit" value="<?php echo Better_Mag::generator()->get_attr( 'submit-label', '&#xf002;' ); ?>">
        </form>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Partial Share box
     *
     * @param   bool $echo
     * @param array $atts
     * @return  string
     */
    public static function partial_share_box( $echo = true, $atts = array() ){

        if( ! $echo )
            ob_start();

        if( ! isset($atts['class']) ){
            $atts['class'] = '';
        }

        ?>
        <section class="share-box clearfix  <?php echo $atts['class']; ?>">
            <span class="share-text"><?php Better_Mag::echo_option( 'content_show_share_title' ); ?></span>
            <?php


            $atts['show_title'] = 0;
            $atts['sites'] = Better_Mag::get_option( 'social_share_list' );

            echo Better_Framework::shortcodes()->factory( 'social_share' )->display(
                Better_Framework::shortcodes()->factory( 'social_share' )->get_atts( $atts ),
                ''
            );

            ?></section>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Partial Meta
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function partial_meta(  $echo = true  ){

        if( ! $echo )
            ob_start();

        // TODO sua ko cho hien thi meta
        ?><div class="meta <?php echo Better_Mag::generator()->get_attr( 'meta-class', '' ); ?>">
<!--        <span class="time"><i class="fa fa-clock-o"></i> <time datetime="--><?php //echo get_the_date(__('Y-m-d\TH:i:sP', 'better-studio')); ?><!--">--><?php //the_time( Better_Mag::get_option( 'meta_date_format' ) ); ?><!--</time></span>-->
        <?php

        if( Better_Mag::get_option( 'meta_show_comment' ) && ! Better_Mag::generator()->get_attr( 'hide-meta-comment' ) ){
            if( comments_open() ){
                ?>
                <span class="comments"><?php comments_popup_link( __( '<i class="fa fa-comment-o"></i> 0', 'better-studio'), __( '<i class="fa fa-comment"></i> 1', 'better-studio'), __( '<i class="fa fa-comments-o"></i> %', 'better-studio') ); ?></span>
                <?php
            }
        }

        if( ! Better_Mag::generator()->get_attr( 'hide-meta-review' ) ){

            if( Better_Mag::review()->generator()->is_review_enabled() ){

                $atts = Better_Mag::review()->generator()->prepare_rate_atts();
//                echo Better_Mag::review()->generator()->get_rating( Better_Mag::review()->generator()->calculate_overall_rate( $atts ), $atts['type'] );

            }

        }

        if( Better_Mag::get_option( 'meta_show_author' ) && ! Better_Mag::generator()->get_attr( 'hide-meta-author' ) ){
            if( Better_Mag::generator()->get_attr( 'hide-meta-author-if-review' ) && Better_Mag::review()->generator()->is_review_enabled() ){

            }else{
                ?>
<!--                <span class="author"><a href="--><?php //echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?><!--" rel="author"><i class="fa fa-user"></i> --><?php //the_author(); ?><!--</a></span>-->
            <?php }
        }

        ?>
        </div>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Mega Menu: Right side category
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function mega_menu_category_right(  $echo = true  ){

        if( ! $echo )
            ob_start();

        // Sub menu
        $sub_menu           =   Better_Mag::generator()->get_attr( 'mega-menu-sub-menu' );

        // Mega menu item object
        $mega_menu_item     =   Better_Mag::generator()->get_attr( 'mega-menu-item' );

        ?>
        <div class="mega-menu style-category links-right-side">
            <div class="row">

                <div class="col-lg-9 col-md-9 col-sm-9 mega-menu-listing-container">
                    <div class="row mega-menu-listing"><?php

                        $_exclude = array();

                        Better_Mag::posts()->set_query( new WP_Query(
                            array(
                                'cat'                   =>  $mega_menu_item->object_id,
                                'meta_key'              =>  '_bm_featured_post',
                                'meta_value'            =>  1,
                                'order'                 =>  'date',
                                'posts_per_page'        =>  1,
                                'ignore_sticky_posts'   =>  1
                            )
                        ));

                        ?>
                        <div class="col-lg-7 col-md-7 col-sm-7"><?php

                            Better_Mag::generator()->blocks()->get_block_title( __('Featured', 'better-studio') );

                            Better_Mag::generator()->set_attr( 'hide-summary', true );

                            while( Better_Mag::posts()->get_query()->have_posts() ){

                                Better_Mag::posts()->the_post();

                                $_exclude[] = get_the_ID();

                                Better_Mag::generator()->blocks()->block_modern();

                            }

                            Better_Mag::posts()->clear_query();
                            Better_Mag::generator()->clear_atts();

                            ?></div><?php

                        Better_Mag::posts()->set_query( new WP_Query(
                            array(
                                'cat'                   =>  $mega_menu_item->object_id,
                                'posts_per_page'        =>  4,
                                'ignore_sticky_posts'   =>  1,
                                'post__not_in'          => $_exclude
                            )
                        ));

                        Better_Mag::generator()->set_attr( 'hide-meta-author', true );

                        ?>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <?php

                            Better_Mag::generator()->blocks()->get_block_title( __('Recent', 'better-studio') );

                            Better_Mag::generator()->blocks()->listing_thumbnail();

                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3">
                    <ul class="sub-menu mega-menu-links"><?php echo $sub_menu; ?></ul>
                </div>

            </div>
        </div>
        <?php

        Better_Mag::generator()->clear_atts();

        Better_Mag::posts()->clear_query();

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Mega Menu: Left side category
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function mega_menu_category_left(  $echo = true  ){

        if( ! $echo )
            ob_start();

        // Sub menu
        $sub_menu           =   Better_Mag::generator()->get_attr( 'mega-menu-sub-menu' );

        // Mega menu item object
        $mega_menu_item     =   Better_Mag::generator()->get_attr( 'mega-menu-item' );

        ?>
        <div class="mega-menu style-category">
            <div class="row">

                <div class="col-lg-3 col-md-3 col-sm-3">
                    <ul class="sub-menu mega-menu-links"><?php echo $sub_menu; ?></ul>
                </div>

                <div class="col-lg-9 col-md-9 col-sm-9 mega-menu-listing-container">
                    <div class="row mega-menu-listing"><?php

                        $_exclude = array();

                        Better_Mag::posts()->set_query( new WP_Query(
                            array(
                                'cat'                   =>  $mega_menu_item->object_id,
                                'meta_key'              =>  '_bm_featured_post',
                                'meta_value'            =>  1,
                                'order'                 =>  'date',
                                'posts_per_page'        =>  1,
                                'ignore_sticky_posts'   =>  1
                            )
                        ));

                        Better_Mag::generator()->set_attr( 'show-term-banner', true );

                        ?>
                        <div class="col-lg-7 col-md-7 col-sm-7"><?php

                            Better_Mag::generator()->blocks()->get_block_title( __('Featured', 'better-studio') );

                            Better_Mag::generator()->set_attr( 'hide-summary', true );

                            while( Better_Mag::posts()->have_posts() ){

                                Better_Mag::posts()->the_post();

                                $_exclude[] = get_the_ID();

                                Better_Mag::generator()->blocks()->block_modern();

                            }

                            Better_Mag::posts()->clear_query();
                            Better_Mag::generator()->clear_atts();

                            ?></div><?php

                        Better_Mag::posts()->set_query( new WP_Query(
                            array(
                                'cat'                   =>  $mega_menu_item->object_id,
                                'posts_per_page'        =>  4,
                                'ignore_sticky_posts'   =>  1,
                                'post__not_in'          => $_exclude
                            )
                        ));

                        Better_Mag::generator()->set_attr( 'hide-meta-author', true )

                        ?>
                        <div class="col-lg-5 col-md-5 col-sm-5"><?php

                            Better_Mag::generator()->blocks()->get_block_title( __('Recent', 'better-studio') );
                            Better_Mag::generator()->blocks()->listing_thumbnail();

                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php

        Better_Mag::generator()->clear_atts();

        Better_Mag::posts()->clear_query();

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Mega Menu: Left side category left
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function mega_menu_category_recent_left(  $echo = true  ){

        if( ! $echo )
            ob_start();

        // Sub menu
        $sub_menu           =   Better_Mag::generator()->get_attr( 'mega-menu-sub-menu' );

        // Mega menu item object
        $mega_menu_item     =   Better_Mag::generator()->get_attr( 'mega-menu-item' );

        ?>
        <div class="mega-menu style-category"><?php

            Better_Mag::posts()->set_query( new WP_Query(
                array(
                    'post_type'             =>  array( 'post' ),
                    'posts_per_page'        =>  3,
                    'cat'                   => $mega_menu_item->object_id,
                    'ignore_sticky_posts'   => 1
                )
            ));

            Better_Mag::generator()->set_attr( 'hide-meta-author', true );
            Better_Mag::generator()->set_attr( 'hide-summary', true );

            ?><div class="row">

                <div class="col-lg-3 col-md-3 col-sm-12">
                    <ul class="sub-menu mega-menu-links"><?php echo $sub_menu; ?></ul>
                </div>

                <div class="col-lg-9 col-md-9 col-sm-12 mega-menu-listing-container">
                    <div class="row mega-menu-listing"><?php

                        while( Better_Mag::posts()->have_posts() ) {

                            Better_Mag::posts()->the_post();

                            ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <?php Better_Mag::generator()->blocks()->block_modern(); ?>
                            </div>
                            <?php

                        }

                        ?>
                    </div>
                </div>

            </div>
        </div>
        <?php

        Better_Mag::generator()->clear_atts();

        Better_Mag::posts()->clear_query();

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Mega Menu: right side category recent
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function mega_menu_category_recent_right(  $echo = true  ){

        if( ! $echo )
            ob_start();

        // Sub menu
        $sub_menu           =   Better_Mag::generator()->get_attr( 'mega-menu-sub-menu' );

        // Mega menu item object
        $mega_menu_item     =   Better_Mag::generator()->get_attr( 'mega-menu-item' );

        ?>
        <div class="mega-menu style-category links-right-side"><?php

            Better_Mag::posts()->set_query( new WP_Query(
                array(
                    'post_type'                 =>  array( 'post' ),
                    'posts_per_page'            =>  3,
                    'cat'                       =>  $mega_menu_item->object_id,
                    'ignore_sticky_posts'       =>  1
                )
            ));

            Better_Mag::generator()->set_attr( 'hide-meta-author', true );
            Better_Mag::generator()->set_attr( 'hide-summary', true );

            ?><div class="row">

                <div class="col-lg-9 col-md-9 col-sm-9 mega-menu-listing-container">
                    <div class="row mega-menu-listing"><?php

                        while( Better_Mag::posts()->have_posts() ) {

                            Better_Mag::posts()->the_post();

                            ?>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <?php Better_Mag::generator()->blocks()->block_modern(); ?>
                            </div>
                            <?php

                        }

                        ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3">
                    <ul class="sub-menu mega-menu-links"><?php echo $sub_menu; ?></ul>
                </div>

            </div>
        </div>
        <?php

        Better_Mag::generator()->clear_atts();

        Better_Mag::posts()->clear_query();

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Mega Menu: Left side category ( simple )
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function mega_menu_simple_left(  $echo = true  ){

        if( ! $echo )
            ob_start();

        // Sub menu
        $sub_menu           =   Better_Mag::generator()->get_attr( 'mega-menu-sub-menu' );

        // Mega menu item object
        $mega_menu_item     =   Better_Mag::generator()->get_attr( 'mega-menu-item' );

        ?>
        <div class="mega-menu style-category">
            <div class="row">

                <div class="col-lg-3 col-md-3 col-sm-3">
                    <ul class="sub-menu mega-menu-links"><?php echo $sub_menu; ?></ul>
                </div>

                <div class="col-lg-9 col-md-9 col-sm-9 mega-menu-listing-container">
                    <div class="row mega-menu-listing"><?php

                        Better_Mag::posts()->set_query( new WP_Query(
                            array(
                                'cat'                   =>  $mega_menu_item->object_id,
                                'meta_key'              =>  '_bm_featured_post',
                                'meta_value'            =>  1,
                                'order'                 =>  'date',
                                'posts_per_page'        =>  1,
                                'ignore_sticky_posts'   =>  1
                            )
                        ));


                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <?php

                            Better_Mag::generator()->blocks()->get_block_title( __('Featured', 'better-studio') );

                            Better_Mag::generator()->set_attr( 'hide-summary', true );

                            $_exclude = array();

                            if( Better_Mag::posts()->have_posts() ){

                                Better_Mag::posts()->the_post();

                                $_exclude[] = get_the_ID();

                                Better_Mag::generator()->blocks()->block_modern();

                            }

                            Better_Mag::posts()->clear_query(); ?>
                        </div><?php

                        Better_Mag::posts()->set_query( new WP_Query(
                            array(
                                'cat'                   => $mega_menu_item->object_id,
                                'posts_per_page'        => 6,
                                'ignore_sticky_posts'   => 1,
                                'post__not_in'          => $_exclude
                            )
                        ));

                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <?php

                            Better_Mag::generator()->blocks()->get_block_title( __('Recent', 'better-studio') );

                            Better_Mag::generator()->blocks()->listing_simple();

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

        Better_Mag::generator()->clear_atts();

        Better_Mag::posts()->clear_query();

        if( ! $echo )
            return ob_get_clean();
    }



    /**
     * Mega Menu: Right side category ( simple )
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function mega_menu_simple_right(  $echo = true  ){

        if( ! $echo )
            ob_start();

        // Sub menu
        $sub_menu           =   Better_Mag::generator()->get_attr( 'mega-menu-sub-menu' );

        // Mega menu item object
        $mega_menu_item     =   Better_Mag::generator()->get_attr( 'mega-menu-item' );

        ?>
        <div class="mega-menu style-category links-right-side">
            <div class="row">

                <div class="col-lg-9 col-md-9 col-sm-9 mega-menu-listing-container">
                    <div class="row mega-menu-listing"><?php

                        Better_Mag::posts()->set_query( new WP_Query(
                            array(
                                'cat'                   =>  $mega_menu_item->object_id,
                                'meta_key'              =>  '_bm_featured_post',
                                'meta_value'            =>  1,
                                'order'                 =>  'date',
                                'posts_per_page'        =>  1,
                                'ignore_sticky_posts'   =>  1
                            )
                        ));

                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-6"><?php

                            Better_Mag::generator()->blocks()->get_block_title( __('Featured', 'better-studio') );

                            Better_Mag::generator()->set_attr( 'hide-summary', true );

                            $_exclude = array();

                            if( Better_Mag::posts()->have_posts() ){

                                Better_Mag::posts()->the_post();

                                $_exclude[] = get_the_ID();

                                Better_Mag::generator()->blocks()->block_modern();

                            }

                            Better_Mag::posts()->clear_query();

                            ?></div><?php


                        Better_Mag::posts()->set_query( new WP_Query(
                            array(
                                'cat'                   => $mega_menu_item->object_id,
                                'posts_per_page'        => 6,
                                'ignore_sticky_posts'   => 1,
                                'post__not_in'          => $_exclude
                            )
                        ));

                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-6"><?php

                            Better_Mag::generator()->blocks()->get_block_title( __('Recent', 'better-studio') );

                            Better_Mag::generator()->blocks()->listing_simple();

                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3">
                    <ul class="sub-menu mega-menu-links">
                        <?php echo $sub_menu; ?>
                    </ul>
                </div>

            </div>
        </div>
        <?php

        Better_Mag::generator()->clear_atts();

        Better_Mag::posts()->clear_query();

        if( ! $echo )
            return ob_get_clean();
    }



    /**
     * Mega Menu: Link mega menu
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function mega_menu_link(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <ul class="mega-menu style-link <?php echo Better_Mag::generator()->get_attr( 'mega-menu-columns', '' ); ?>">
            <?php echo Better_Mag::generator()->get_attr( 'mega-menu-sub-menu' ); ?>
        </ul>
        <?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }



    /**
     * Main menu block
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function menu_main_menu(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <?php echo Better_Mag::get_option( 'main_menu_sticky' ) ? '<div class="main-menu-sticky-wrapper">' : ''; ?>
        <div class="main-menu <?php echo Better_Mag::get_option( 'main_menu_layout' ) == 'boxed' ? 'boxed' : ''; ?> <?php echo Better_Mag::get_option( 'main_menu_sticky' ) ? ' sticky-menu' : ''; ?>">
            <div class="container">
                <nav class="main-menu-container">
                    <ul id="main-menu" class="menu">
                        <?php
                        if( has_nav_menu( 'main-menu' ) ){

                            wp_nav_menu(
                                array(
                                    'theme_location'    => 'main-menu',
                                    'container'         => false,
                                    'items_wrap'        => '%3$s',
                                    'fallback_cb'       => 'BF_Menu_Walker',
                                )
                            );
                        }else{?>
                            <li><?php _e( 'Select a menu for "Main Navigation"', 'better-studio' ); ?></li>
                        <?php }

                        if( Better_Mag::get_option( 'show_shopping_cart_in_menu' ) && function_exists('is_woocommerce')){

                            Better_Mag::wooCommerce()->get_menu_icon();

                        }

                        if( Better_Mag::get_option( 'show_random_post_link' ) ){ ?>
                            <li class="random-post menu-title-hide  alignright">
                                <a href="<?php BF_Query::get_random_post_link(); ?>"><i class="fa fa-random"></i> <span class="hidden"><?php _e( 'Random Post', 'better-studio' ); ?></span></a>
                            </li>
                        <?php }


                        // Login/Register Button and Modal
                        if( Better_Mag::get_option( 'main_navigation_show_user_login' ) ){ ?>
                            <li class="random-post user-info-item menu-title-hide alignright"><?php

                                // User Logged in: Links to profile and logout
                                if( is_user_logged_in() ){

                                    $current_user = wp_get_current_user();

                                    // Links to bbPress profile if bbPress is active
                                    if( class_exists('bbpress') ){ ?>
                                        <a href="<?php bbp_user_profile_url( bbp_get_current_user_id() ); ?>" title="<?php echo esc_attr( __( 'Profile', 'better-studio' )); ?>"><i class="fa fa-user"></i> <span class="hidden"><?php echo $current_user->display_name; ?></span></a>
                                        <ul class="sub-menu">
                                            <li class=""><a href="<?php bbp_user_profile_url( bbp_get_current_user_id() ); ?>" title="<?php echo esc_attr( __( 'Profile', 'better-studio' )); ?>"><?php _e( 'Profile', 'better-studio' ); ?></a></li>
                                            <li class=""><a href="<?php echo wp_logout_url(); ?>" title="<?php echo esc_attr( __( 'Logout', 'better-studio' )); ?>"><?php _e( 'Logout', 'better-studio' ); ?></a></li>
                                        </ul>
                                        <?php
                                        // Normal Links
                                    }else{?>
                                        <a href="<?php echo get_edit_user_link(); ?>" title="<?php echo esc_attr( __( 'Profile', 'better-studio' )); ?>"><i class="fa fa-user"></i> <span class="hidden"><?php echo $current_user->display_name; ?></span></a>
                                        <ul class="sub-menu">
                                            <li class=""><a href="<?php echo get_edit_user_link(); ?>" title="<?php echo esc_attr( __( 'Profile', 'better-studio' )); ?>"><?php _e( 'Profile', 'better-studio' ); ?></a></li>
                                            <li class=""><a href="<?php echo wp_logout_url(); ?>" title="<?php echo esc_attr( __( 'Logout', 'better-studio' )); ?>"><?php _e( 'Logout', 'better-studio' ); ?></a></li>
                                        </ul>
                                    <?php }

                                }
                                // Login/ Register Modal
                                else{ ?>
                                    <a href="<?php wp_login_url(); ?>" title="<?php echo esc_attr( __( 'Login', 'better-studio' ) ); ?>" data-toggle="modal" data-target="#login-modal"><i class="fa fa-user"></i> <span class="hidden"><?php _e( 'Login', 'better-studio' ); ?></span></a>

                                <?php } ?>
                            </li>
                            <?php
                        }

                        if( Better_Mag::get_option( 'show_search_in_main_navigation' ) ){ ?>
                            <li class="search-item alignright">
                                <?php if( is_search() ){

                                    global $wp_query;
                                    ?>
                                    <span class="better-custom-badge "><?php echo $wp_query->found_posts;?></span>
                                <?php }

                                Better_Mag::generator()->blocks()->partial_search_form();

                                ?>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>

        <?php
        // Add modal
        if( Better_Mag::get_option( 'main_navigation_show_user_login' ) && ! is_user_logged_in()){

            ?>
            <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content"><?php

                    // If register form is active and user registration is allowed
                    if(  get_option('users_can_register') && Better_Mag::get_option( 'main_navigation_show_user_register_in_modal' ) ){

                    ?>
                    <div class="modal-header">
                        <div class="bs-tab-shortcode">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#login-tab" role="tab" data-toggle="tab"><?php _e( 'Login', 'better-studio' ); ?></a></li>
                                <li ><a href="#register-tab" role="tab" data-toggle="tab"><?php _e( 'Register', 'better-studio' ); ?></a></li>
                            </ul>
                            <button type="button" class="close tabbed-close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php __( 'Close', 'better-studio'); ?></span></button>
                            <div class="tab-content">
                                <div class="tab-pane active" id="login-tab"><?php wp_login_form(); ?></div>
                                <div class="tab-pane" id="register-tab">
                                    <div id="register-form">
                                        <div class="title">
                                            <h5><?php _e( 'Register your Account', 'better-studio' ); ?></h5>
                                            <span><?php _e( 'Sign Up with us and Enjoy!', 'better-studio' ); ?></span>
                                        </div>
                                        <form action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" method="post">
                                            <input type="text" name="user_login" placeholder="<?php _e( 'Username', 'better-studio' ); ?>" id="user_login" class="input" />
                                            <input type="text" name="user_email" placeholder="<?php _e( 'E-Mail', 'better-studio' ); ?>" id="user_email" class="input"  />
                                            <?php do_action('register_form'); ?>
                                            <input type="submit" value="<?php _e( 'Register', 'better-studio' ); ?>" id="register" />
                                            <hr />
                                            <p class="statement"><?php _e( 'A password will be e-mailed to you.', 'better-studio' ); ?></p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }

                        else{ ?>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php __( 'Close', 'better-studio'); ?></span></button>
                            <h4 class="modal-title" id="login-modal-label"><?php _e( 'Login', 'better-studio' ); echo ( get_option('users_can_register') && Better_Mag::get_option( 'main_navigation_show_user_register_in_modal' ) ) ? '/' . __( 'Register', 'better-studio') : ''; ?></h4>
                        </div>
                        <div class="modal-body">
                            <?php
                            wp_login_form();
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php }

        echo Better_Mag::get_option( 'main_menu_sticky' ) ? '</div>' : ''; ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }



    /**
     * Used for printing main slider
     *
     * @param string $slider_id
     */
    public static function print_main_slider( $slider_id = 'style-1' ){
        ?>
        </div>
        <section class="main-slider-wrapper">
            <div class="container">
                <?php
                switch( $slider_id ){

                    case 'style-1':
                        Better_Mag::generator()->blocks()->slider_style_1();
                        break;

                    case 'style-2':
                        Better_Mag::generator()->blocks()->slider_style_2();
                        break;

                    case 'style-3':
                        Better_Mag::generator()->blocks()->slider_style_3();
                        break;

                    case 'style-4':
                        Better_Mag::generator()->blocks()->slider_style_4();
                        break;

                    case 'style-5':
                        Better_Mag::generator()->blocks()->slider_style_5();
                        break;

                    case 'style-6':
                        Better_Mag::generator()->blocks()->slider_style_6();
                        break;

                    case 'style-7':
                        Better_Mag::generator()->blocks()->slider_style_7();
                        break;

                    case 'style-8':
                        Better_Mag::generator()->blocks()->slider_style_8();
                        break;

                    case 'style-9':
                        Better_Mag::generator()->blocks()->slider_style_9();
                        break;

                    case 'style-10':
                        Better_Mag::generator()->blocks()->slider_style_10();
                        break;
                }
                ?>
            </div>
        </section>
        <div class="container"><?php
    }


    /**
     * Slider: Style 1
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function slider_style_1(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><?php

            Better_Mag::generator()->set_attr_count( 7 );
            Better_Mag::generator()->set_attr( "show-term-banner", true );

            $first = '';
            $second = '';
            $third = '';


            if( Better_Mag::posts()->have_posts() ){ ?>
                <div class="main-slider slider-arrows">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php

                            while( Better_Mag::posts()->have_posts() ){
                                Better_Mag::posts()->the_post();

                                if( ! $first ){
                                    $first = true;
                                }
                                elseif( ! $second ){
                                    Better_Mag::generator()->set_attr( "hide-meta", true );
                                    Better_Mag::generator()->set_attr_thumbnail_size( 'slider-1' );

                                    $second = Better_Mag::generator()->blocks()->block_highlight( false );
                                    continue;
                                }
                                elseif( ! $third ){
                                    Better_Mag::generator()->set_attr( "hide-meta", true );
                                    Better_Mag::generator()->set_attr_thumbnail_size( 'slider-1' );

                                    $third = Better_Mag::generator()->blocks()->block_highlight( false );
                                    continue;
                                }

                                Better_Mag::generator()->set_attr( "hide-meta", false );
                                Better_Mag::generator()->set_attr_thumbnail_size( "main-post" );

                                echo '<li>';
                                Better_Mag::generator()->blocks()->block_highlight();
                                echo '</li>';

                            }

                            ?>
                        </ul>
                    </div>
                </div>
                <?php

            }

            Better_Mag::generator()->unset_attr( "count" );

            ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
            <div class="large">
                <?php

                echo $second;

                ?>
            </div>
            <?php

            echo $third;

            ?>
        </div>
        </div><?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Slider: Style 2
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function slider_style_2(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <?php
            Better_Mag::generator()->set_attr_count( 8 );
            Better_Mag::generator()->set_attr( "show-term-banner", true );

            $first = '';
            $second = '';
            $third = '';
            $fourth = '';

            if( Better_Mag::posts()->have_posts() ){ ?>
                <div class="main-slider slider-arrows">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php

                            while( Better_Mag::posts()->have_posts() ){
                                Better_Mag::posts()->the_post();

                                if( ! $first ){
                                    $first = true;
                                }
                                elseif( ! $second ){
                                    Better_Mag::generator()->set_attr( "hide-meta", true );
                                    Better_Mag::generator()->set_attr_thumbnail_size( 'slider-2' );

                                    $second = Better_Mag::generator()->blocks()->block_highlight( false );;
                                    continue;
                                }
                                elseif( ! $third ){
                                    Better_Mag::generator()->set_attr( "show-term-banner", false );
                                    Better_Mag::generator()->set_attr_thumbnail_size( 'slider-3' );

                                    $third = Better_Mag::generator()->blocks()->block_highlight( false );;
                                    continue;
                                }
                                elseif( ! $fourth ){
                                    Better_Mag::generator()->set_attr( "show-term-banner", false );
                                    Better_Mag::generator()->set_attr_thumbnail_size( 'slider-3' );
                                    $fourth = Better_Mag::generator()->blocks()->block_highlight( false );;
                                    continue;
                                }

                                Better_Mag::generator()->set_attr( "hide-meta", false );
                                Better_Mag::generator()->set_attr_thumbnail_size( "main-post" );
                                echo '<li>';
                                Better_Mag::generator()->blocks()->block_highlight();
                                echo '</li>';

                            }

                            ?>
                        </ul>
                    </div>
                </div>
                <?php

            }

            ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
            <div class="large">
                <?php

                echo $second;

                ?>
            </div>
            <div class="row hidden-sm">
                <div class="col-lg-6 col-md-6">
                    <?php

                    echo $third;

                    ?>
                </div>
                <div class="col-lg-6 col-md-6 ">
                    <?php

                    echo $fourth;

                    ?>
                </div>

            </div>
        </div>
        </div><?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Slider: Style 3
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function slider_style_3(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <div class="row slider-style-3">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 slider-part-1">
            <?php
            Better_Mag::generator()->set_attr_count( 6 );
            Better_Mag::generator()->set_attr( "show-term-banner", true );

            $first = '';
            $second = '';

            if( Better_Mag::posts()->have_posts() ){ ?>
                <div class="main-slider slider-arrows">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php
                            Better_Mag::generator()->set_attr( "hide-meta-author", true );
                            Better_Mag::generator()->set_attr_thumbnail_size( "slider-5" );

                            while( Better_Mag::posts()->have_posts() ){
                                Better_Mag::posts()->the_post();


                                if( ! $first ){
                                    $first = true;
                                }
                                elseif( ! $second ){
                                    $second = '<li>';
                                    $second .= Better_Mag::generator()->blocks()->block_highlight( false );
                                    $second .= '</li>';
                                    continue;
                                }

                                echo '<li>';
                                Better_Mag::generator()->blocks()->block_highlight();
                                echo '</li>';
                            }

                            ?>
                        </ul>
                    </div>
                </div>
                <?php

            }

            ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 slider-part-2">
            <?php
            Better_Mag::generator()->set_attr_count( 5 );
            Better_Mag::generator()->set_attr( "counter", 0 );

            ?>
            <div class="main-slider slider-arrows">
                <div class="flexslider">
                    <ul class="slides">
                        <?php

                        echo $second;

                        if( Better_Mag::posts()->have_posts() ){

                            while( Better_Mag::posts()->have_posts() ){
                                Better_Mag::posts()->the_post();
                                echo '<li>';
                                Better_Mag::generator()->blocks()->block_highlight();
                                echo '</li>';
                            }

                        }

                        ?>
                    </ul>
                </div>
            </div>
            <?php


            ?>
        </div>
        </div><?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Slider: Style 4
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function slider_style_4(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <div class="row slider-style-4">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 slider-part-1">
            <?php
            Better_Mag::generator()->set_attr_count( 7 );
            Better_Mag::generator()->set_attr( "show-term-banner", true );

            $first = '';
            $second = '';
            $third = '';

            if( Better_Mag::posts()->have_posts() ){ ?>
                <div class="main-slider slider-arrows">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php
                            Better_Mag::generator()->set_attr( "hide-meta-author", true );
                            Better_Mag::generator()->set_attr_thumbnail_size( "slider-5" );

                            while( Better_Mag::posts()->have_posts() ){
                                Better_Mag::posts()->the_post();

                                if( ! $first ){
                                    $first = true;
                                }
                                elseif( ! $second ){
                                    Better_Mag::generator()->set_attr( "show-term-banner", true );
                                    Better_Mag::generator()->set_attr( "hide-meta-author", true );
                                    Better_Mag::generator()->set_attr_thumbnail_size( "slider-4" );

                                    $second = Better_Mag::generator()->blocks()->block_highlight( false );
                                    continue;
                                }
                                elseif( ! $third ){
                                    Better_Mag::generator()->set_attr( "show-term-banner", true );
                                    Better_Mag::generator()->set_attr( "hide-meta-author", true );
                                    Better_Mag::generator()->set_attr_thumbnail_size( "slider-4" );

                                    $third = Better_Mag::generator()->blocks()->block_highlight( false );
                                    continue;
                                }

                                Better_Mag::generator()->set_attr( "hide-meta-author", true );
                                Better_Mag::generator()->set_attr_thumbnail_size( "slider-5" );
                                Better_Mag::generator()->set_attr( "hide-meta-author", false );

                                echo '<li>';
                                Better_Mag::generator()->blocks()->block_highlight();
                                echo '</li>';
                            }

                            ?>
                        </ul>
                    </div>
                </div>
                <?php

            }

            ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs slider-part-2">
            <?php

            echo $second;

            ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs slider-part-3">
            <?php

            echo $third;

            ?>
        </div>
        </div><?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Slider: Style 5
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function slider_style_5(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <div class="row slider-style-5">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 slider-part-1">
                <?php
                Better_Mag::generator()->set_attr( "show-term-banner", true );
                Better_Mag::generator()->set_attr( "hide-meta-author", true );
                Better_Mag::generator()->set_attr_thumbnail_size( "slider-4" );

                if( Better_Mag::posts()->have_posts() ){

                    Better_Mag::posts()->the_post();
                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 slider-part-2">
                <?php

                if( Better_Mag::posts()->have_posts() ){

                    Better_Mag::posts()->the_post();
                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 hidden-xs slider-part-3">
                <?php

                if( Better_Mag::posts()->have_posts() ){

                    Better_Mag::posts()->the_post();
                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
            <div class="col-lg-3 col-md-3 hidden-sm hidden-xs slider-part-4">
                <?php

                if( Better_Mag::posts()->have_posts() ){

                    Better_Mag::posts()->the_post();
                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
        </div>
        <?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Slider: Style 6
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function slider_style_6(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <div class="row slider-style-6">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
            Better_Mag::generator()->set_attr( "show-term-banner", true );
            Better_Mag::generator()->set_attr_count( 5 );
            Better_Mag::generator()->set_attr_thumbnail_size( "slider-6" );

            if( Better_Mag::posts()->have_posts() ){ ?>
                <div class="main-slider slider-arrows">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php

                            while( Better_Mag::posts()->have_posts() ){
                                Better_Mag::posts()->the_post();
                                echo '<li>';
                                Better_Mag::generator()->blocks()->block_highlight();
                                echo '</li>';
                            }

                            ?>
                        </ul>
                    </div>
                </div>
                <?php

            }

            ?>
        </div>
        </div><?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Slider: Style 7
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function slider_style_7(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <div class="row slider-style-7">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 slider-part-1">
                <div class="large">
                    <?php
                    Better_Mag::generator()->set_attr( "show-term-banner", true );
                    Better_Mag::generator()->set_attr_count( 8 );

                    $first = '';
                    $second = '';
                    $third = '';
                    $fourth = '';

                    if( Better_Mag::posts()->have_posts() ){ ?>
                        <div class="main-slider slider-arrows">
                            <div class="flexslider">
                                <ul class="slides">
                                    <?php

                                    while( Better_Mag::posts()->have_posts() ){
                                        Better_Mag::posts()->the_post();

                                        if( ! $first ){
                                            $first = true;
                                        }
                                        elseif( ! $second ){
                                            Better_Mag::generator()->set_attr( "hide-meta", true );
                                            Better_Mag::generator()->set_attr_thumbnail_size( 'slider-1' );

                                            $second = Better_Mag::generator()->blocks()->block_highlight( false );
                                            continue;
                                        }
                                        elseif( ! $third ){
                                            Better_Mag::generator()->set_attr( "hide-meta", true );
                                            Better_Mag::generator()->set_attr_thumbnail_size( 'slider-1' );

                                            $third = Better_Mag::generator()->blocks()->block_highlight( false );
                                            continue;
                                        }
                                        elseif( ! $fourth ){
                                            Better_Mag::generator()->set_attr( "hide-meta", true );
                                            Better_Mag::generator()->set_attr_thumbnail_size( 'slider-1' );

                                            $fourth = Better_Mag::generator()->blocks()->block_highlight( false );
                                            continue;
                                        }

                                        Better_Mag::generator()->set_attr_thumbnail_size( "slider-6" );
                                        Better_Mag::generator()->set_attr( "hide-meta", false );

                                        echo '<li>';
                                        Better_Mag::generator()->blocks()->block_highlight();
                                        echo '</li>';
                                    }

                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php

                    }

                    ?>
                </div>
            </div>
        </div>
        <div class="row hidden-xs">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <?php

            echo $second;

            ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <?php

            echo $third;

            ?>
        </div>
        <div class="col-lg-4 col-md-4 hidden-sm">
            <?php

            echo $fourth;

            ?>
        </div>
        </div><?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Slider: Style 8
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function slider_style_8(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <div class="row slider-style-8">
        <div class="col-lg-4 col-md-4 col-sm-6 col-sx-12 slider-part-1">
            <div class="large">
                <?php

                Better_Mag::generator()->set_attr( "hide-meta", true );
                Better_Mag::generator()->set_attr_thumbnail_size( 'slider-1' );

                if( Better_Mag::posts()->have_posts() ){
                    Better_Mag::posts()->the_post();

                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div><?php

            if( Better_Mag::posts()->have_posts() ){
                Better_Mag::posts()->the_post();

                Better_Mag::generator()->blocks()->block_highlight();

            }

            ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 hidden-xs slider-part-2">
            <div class="large">
                <?php

                if( Better_Mag::posts()->have_posts() ){
                    Better_Mag::posts()->the_post();

                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div><?php

            if( Better_Mag::posts()->have_posts() ){
                Better_Mag::posts()->the_post();

                Better_Mag::generator()->blocks()->block_highlight();

            }

            ?>
        </div>
        <div class="col-lg-4 col-md-4 hidden-sm hidden-xs slider-part-3">
            <div class="large">
                <?php

                if( Better_Mag::posts()->have_posts() ){
                    Better_Mag::posts()->the_post();

                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div><?php

            if( Better_Mag::posts()->have_posts() ){
                Better_Mag::posts()->the_post();

                Better_Mag::generator()->blocks()->block_highlight();

            }

            ?>
        </div>

        </div><?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Slider: Style 9
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function slider_style_9(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <div class="row slider-style-9">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 slider-part1">
            <div class="large">
                <?php

                Better_Mag::generator()->set_attr( "hide-meta", true );
                Better_Mag::generator()->set_attr( "show-term-banner", true );
                Better_Mag::generator()->set_attr_thumbnail_size( 'slider-1' );

                if( Better_Mag::posts()->have_posts() ){
                    Better_Mag::posts()->the_post();

                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 slider-part-1-1">
                    <?php

                    Better_Mag::generator()->set_attr( "show-term-banner", false );
                    Better_Mag::generator()->set_attr_thumbnail_size( 'slider-3' );

                    if( Better_Mag::posts()->have_posts() ){
                        Better_Mag::posts()->the_post();

                        Better_Mag::generator()->blocks()->block_highlight();

                    }

                    ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 slider-part-1-2">
                    <?php

                    if( Better_Mag::posts()->have_posts() ){
                        Better_Mag::posts()->the_post();

                        Better_Mag::generator()->blocks()->block_highlight();

                    }

                    ?>
                </div>

            </div>

        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 hidden-xs slider-part2">
            <div class="large">
                <?php

                Better_Mag::generator()->set_attr( "hide-meta", true );
                Better_Mag::generator()->set_attr( "show-term-banner", true );
                Better_Mag::generator()->set_attr_thumbnail_size( 'slider-1' );

                if( Better_Mag::posts()->have_posts() ){
                    Better_Mag::posts()->the_post();

                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 slider-part-2-1">
                    <?php

                    Better_Mag::generator()->set_attr( "show-term-banner", false );
                    Better_Mag::generator()->set_attr_thumbnail_size( 'slider-3' );

                    if( Better_Mag::posts()->have_posts() ){
                        Better_Mag::posts()->the_post();

                        Better_Mag::generator()->blocks()->block_highlight();

                    }

                    ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 slider-part-2-2">
                    <?php

                    if( Better_Mag::posts()->have_posts() ){
                        Better_Mag::posts()->the_post();

                        Better_Mag::generator()->blocks()->block_highlight();

                    }

                    ?>
                </div>

            </div>
        </div>
        <div class="col-lg-4 col-md-4 hidden-sm hidden-xs slider-part1">
            <div class="large">
                <?php
                Better_Mag::generator()->set_attr( "show-term-banner", true );
                Better_Mag::generator()->set_attr( "hide-meta", true );
                Better_Mag::generator()->set_attr_thumbnail_size( 'slider-1' );

                if( Better_Mag::posts()->have_posts() ){
                    Better_Mag::posts()->the_post();

                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 slider-part-3-1">
                    <?php

                    Better_Mag::generator()->set_attr( "show-term-banner", false );
                    Better_Mag::generator()->set_attr_thumbnail_size( 'slider-3' );

                    if( Better_Mag::posts()->have_posts() ){
                        Better_Mag::posts()->the_post();

                        Better_Mag::generator()->blocks()->block_highlight();

                    }

                    ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 slider-part-3-3">
                    <?php

                    if( Better_Mag::posts()->have_posts() ){
                        Better_Mag::posts()->the_post();

                        Better_Mag::generator()->blocks()->block_highlight();

                    }

                    ?>
                </div>

            </div>
        </div>

        </div><?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Slider: Style 10
     *
     * @param   bool    $echo
     * @return  string
     */
    public static function slider_style_10(  $echo = true  ){

        if( ! $echo )
            ob_start();

        ?>
        <div class="row large slider-style-10">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 slider-part-1">
                <?php
                Better_Mag::generator()->set_attr( "show-term-banner", true );
                Better_Mag::generator()->set_attr( "hide-meta-author", true );
                Better_Mag::generator()->set_attr_thumbnail_size( "slider-4" );

                if( Better_Mag::posts()->have_posts() ){

                    Better_Mag::posts()->the_post();
                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 slider-part-2">
                <?php

                if( Better_Mag::posts()->have_posts() ){

                    Better_Mag::posts()->the_post();
                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 hidden-xs slider-part-3">
                <?php

                if( Better_Mag::posts()->have_posts() ){

                    Better_Mag::posts()->the_post();
                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
            <div class="col-lg-3 col-md-3 hidden-sm hidden-xs slider-part-4">
                <?php

                if( Better_Mag::posts()->have_posts() ){

                    Better_Mag::posts()->the_post();
                    Better_Mag::generator()->blocks()->block_highlight();

                }

                ?>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 slider-part-5">
            <?php

            Better_Mag::generator()->set_attr( "hide-meta", true );
            Better_Mag::generator()->set_attr( "thumbnail-size", 'slider-1' );

            if( Better_Mag::posts()->have_posts() ){
                Better_Mag::posts()->the_post();

                Better_Mag::generator()->blocks()->block_highlight();

            }

            ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 hidden-xs slider-part-6">
            <?php

            if( Better_Mag::posts()->have_posts() ){
                Better_Mag::posts()->the_post();

                Better_Mag::generator()->blocks()->block_highlight();

            }

            ?>
        </div>
        <div class="col-lg-4 col-md-4 hidden-sm hidden-xs slider-part-6">
            <?php

            if( Better_Mag::posts()->have_posts() ){
                Better_Mag::posts()->the_post();

                Better_Mag::generator()->blocks()->block_highlight();
            }

            ?>
        </div>
        </div><?php

        Better_Mag::generator()->clear_atts();

        ?>
        <?php

        if( ! $echo )
            return ob_get_clean();
    }


    /**
     * Generates bread crumb with BF Breadcrumb
     *
     * @param   bool        $echo
     * @return  bool|string
     */
    public static function breadcrumb( $echo = true ){

        $output = false;

        if( Better_Mag::get_option( 'show_breadcrumb' ) ){

            if( is_home() || is_front_page() ){
                if( Better_Mag::get_option( 'show_breadcrumb_homepage' ) ){
                    $output = Better_Framework::breadcrumb()->generate( false );
                }
            }else{
                $output = Better_Framework::breadcrumb()->generate( false );
            }

        }

        if( $output ){
            $output = '<div class="bf-breadcrumb-wrapper ' . ( Better_Mag::get_option( 'main_menu_layout' ) == 'boxed' ? 'boxed' : '' ) . '"><div class="container bf-breadcrumb-container">' . $output . '</div></div>';
        }

        if( $echo ){
            echo $output;
        }else{
            return $output;
        }

    }


    /**
     * Callback For Displaying a Comment
     *
     * @param mixed   $comment
     * @param array   $args
     * @param integer $depth
     */
    function partial_comment( $comment, $args, $depth ){

        $GLOBALS['comment'] = $comment;

        switch ($comment->comment_type):

            case 'pingback':
            case 'trackback':
                ?>

                <li class="post pingback">
                <p><span><?php _e( 'Pingback:', 'better-studio' ); ?></span> <?php comment_author_link(); ?><?php edit_comment_link( ' <i class="fa fa-edit"></i> ' . __( 'Edit', 'better-studio' ), '', '' ); ?></p>
                <?php
                break;


            default:
                ?>

                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment">
                    <div class="comment-avatar"><?php echo get_avatar( $comment, 60 ); ?></div>

                    <div class="comment-meta">
                        <p class="comment-author"><?php comment_author_link(); ?></p>
                        <a href="<?php comment_link(); ?>" class="comment-time" title="<?php comment_date(); _e(' at ', 'better-studio'); comment_time(); ?>">
                            <time datetime="<?php comment_time('c'); ?>"><i class="fa  fa-calendar"></i> <?php comment_date( get_option( 'date_format' ) ); ?> <i class="fa fa-clock-o"></i> <?php comment_time( get_option( 'time_format' ) ); ?></time>
                        </a>
                    </div>

                    <div class="comment-content">
                        <div class="the-content"><?php comment_text(); ?></div>
                        <?php if ($comment->comment_approved == '0'): ?>
                            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'better-studio' ); ?></em>
                        <?php endif; ?>
                    </div>

                    <?php
                    comment_reply_link( array_merge( $args, array(
                        'reply_text' => '<i class="fa fa-reply"></i> ' . __( 'Reply', 'better-studio'),
                        'depth'      => $depth,
                        'max_depth'  => $args['max_depth']
                    ) ) );

                    edit_comment_link( ' <i class="fa fa-edit"></i> ' . __( 'Edit', 'better-studio' ), '', '' );
                    ?>
                </article>
                <?php
                break;
        endswitch;

    }


    /**
     * Custom pagination
     *
     * @param array $options extend options for paginate_links()
     * @param null $query
     * @param bool $echo
     * @return array|mixed|string
     * @see paginate_links()
     */
    public static function get_pagination( $options = array(), $query = null, $echo = true ){

        global $wp_rewrite;

        if( ! $query ){
            if( Better_Mag::posts()->get_query() ){
                $query = Better_Mag::posts()->get_query();
            }else{
                global $wp_query;
                $query = $wp_query;
            }
        }

        // WP-PageNavi Plugin
        if( Better_Mag::get_option( 'use_wp_pagenavi' ) && function_exists( 'wp_pagenavi' )){

            ob_start();

            wp_pagenavi( array( 'query' => $query ) );

            $pagination = ob_get_clean();

        }
        // Custom Pagination With WP Functionality
        else{

            $total_pages = $query->max_num_pages;

            if( $total_pages <= 1 ){
                return '';
            }

            $paged = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');

            $args = array(
                'base'    => add_query_arg('paged', '%#%'),
                //    'format'  => '',
                'current' => max( 1, $paged ),
                'total'   => $total_pages,
                'next_text' => __( 'Next', 'better-studio' ) . '<i class="fa fa-angle-right"></i>',
                'prev_text' => '<i class="fa fa-angle-left"></i>' . __( 'Previous', 'better-studio' )
            );

            if( $wp_rewrite->using_permalinks() ){
                $big = 999999999;
                $args['base'] = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
            }

            if( is_search() ){
                $args['add_args'] = array( 's' => urlencode( get_query_var('s') ) );
            }

            $pagination = paginate_links( array_merge( $args, $options ) );

            $pagination = preg_replace( '/&#038;paged=1(\'|")/', '\\1', trim( $pagination ) );

        }

        $pagination = '<div class="pagination">' . $pagination .'</div>';

        if( $echo )
            echo $pagination;
        else
            return $pagination;
    }


    /**
     * Generates Terms Banner ( Category )
     *
     * @param bool $force_show
     * @param bool $echo
     * @return string
     */
    public static function get_term_title_banner( $force_show = false, $echo = true ){

        if( Better_Mag::generator()->get_attr( 'show-term-banner', '' ) || $force_show ){

            $category = Better_Mag::generator()->get_post_main_category();

            $output = '<span class="term-title term-' . $category->cat_ID . '"><a href="' . esc_url(get_category_link($category)) . '">' . esc_html($category->name) . '</a></span>';

            if( $echo ){
                echo $output;
            }else{
                return $output;
            }
        }

    }


    /**
     * Generates Post Format Icon
     *
     * @param bool $force_hide
     * @param bool $echo
     * @return string
     */
    public static function get_post_format_icon( $force_hide = false, $echo = true ){

        if( ! Better_Mag::generator()->get_attr( 'hide-post-format', false ) || $force_hide ){

            $format = get_post_format();
            $output = '';
            if( !empty( $format ) ){
                $output = '<span class="bm-post-format format-gallery">';

                if( $format == 'gallery' ){
                    $output .= '<i class="fa fa-image"></i>';
                }
                elseif( $format == 'audio' ){
                    $output .= '<i class="fa fa-music"></i>';
                }
                elseif( $format == 'video' ){
                    $output .= '<i class="fa fa-film"></i>';
                }

                $output .= '</span>';

            }


            if( $echo ){
                echo $output;
            }else{
                return $output;
            }
        }

    }


    /**
     * Generates Post Format Icon
     *
     * @param bool $echo
     * @return string
     */
    public static function partial_navigate_posts( $echo = true ){

        if( ! $echo )
            ob_start();

        ?>
    <div class="row block-listing navigate-posts <?php echo Better_Mag::get_option( 'bm_content_post_navigation_style' ); ?>">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 previous-box">
            <div class="previous"><?php
                previous_post_link( '<span class="main-color title"><i class="fa fa-chevron-left"></i> ' . __('Previous Article', 'better-studio' ) .'</span><span class="link">%link</span>' ); ?>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="next"><?php
                next_post_link( '<span class="main-color title">'. __( 'Next Article', 'better-studio' ) .' <i class="fa fa-chevron-right"></i></span><span class="link">%link</span>' ); ?>
            </div>
        </div>
        </div><?php

        if( ! $echo )
            return ob_get_clean();

    }



} // /BM_Blocks


if( ! function_exists( 'better_mag_comment' ) ):

    /**
     * Callback For Displaying a Comment
     *
     * @param mixed   $comment
     * @param array   $args
     * @param integer $depth
     */
    function better_mag_comment( $comment, $args, $depth ){

        $GLOBALS['comment'] = $comment;

        switch ($comment->comment_type):

            case 'pingback':
            case 'trackback':
                ?>

                <li class="post pingback">
                <p><span><?php _e( 'Pingback:', 'better-studio' ); ?></span> <?php comment_author_link(); ?><?php edit_comment_link( ' <i class="fa fa-edit"></i> ' . __( 'Edit', 'better-studio' ), '', '' ); ?></p>
                <?php
                break;


            default:
                ?>

                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment">
                        <div class="comment-avatar"><?php echo get_avatar( $comment, 60 ); ?></div>

                        <div class="comment-meta">
                            <p class="comment-author"><?php comment_author_link(); ?></p>
                            <a href="<?php comment_link(); ?>" class="comment-time" title="<?php comment_date(); _e(' at ', 'better-studio'); comment_time(); ?>">
                                <time datetime="<?php comment_time('c'); ?>"><i class="fa  fa-calendar"></i> <?php comment_date( get_option( 'date_format' ) ); ?> <i class="fa fa-clock-o"></i> <?php comment_time( get_option( 'time_format' ) ); ?></time>
                            </a>
                        </div>

                        <div class="comment-content">
                            <div class="the-content"><?php comment_text(); ?></div>
                            <?php if ($comment->comment_approved == '0'): ?>
                <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'better-studio' ); ?></em>
            <?php endif; ?>
                        </div>

                        <?php
                comment_reply_link( array_merge( $args, array(
                    'reply_text' => '<i class="fa fa-reply"></i> ' . __( 'Reply', 'better-studio'),
                    'depth'      => $depth,
                    'max_depth'  => $args['max_depth']
                ) ) );

                edit_comment_link( ' <i class="fa fa-edit"></i> ' . __( 'Edit', 'better-studio' ), '', '' );
                ?>
                    </article>
                <?php
                break;
        endswitch;

    }

endif;

