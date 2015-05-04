<?php

/**
 * Archives Page
 *
 * This page is used for all kind of archives from custom post types to blog to 'by date' archives.
 *
 * @link http://codex.wordpress.org/images/1/18/Template_Hierarchy.png
 */

get_header();

?>
<div class="row main-section">
    <?php if( Better_Mag::current_sidebar_layout() == 'left' ) Better_Mag::get_sidebar(); ?>
    <div class="<?php echo Better_Mag::current_sidebar_layout() ? 'col-lg-8 col-md-8 col-sm-8 col-xs-12 with-sidebar content-column' : 'col-lg-12 col-md-12 col-sm-12 col-xs-12 no-sidebar'; ?>"><?php

        if( have_posts() ){

            /*
             * Queue the first post, that way we know what author
             * we're dealing with (if that is the case).
             *
             * We reset this later so we can run the loop properly
             * with a call to rewind_posts().
             */
            the_post();

            Better_Mag::generator()->set_attr( 'block-class', 'bottom-line' );
            Better_Mag::generator()->set_attr( 'bio-excerpt', false );
            Better_Mag::generator()->blocks()->block_user_row();
            Better_Mag::generator()->unset_attr( 'block-class' );

            /*
             * Since we called the_post() above, we need to rewind
             * the loop back to the beginning that way we can run
             * the loop properly, in full.
             */
            rewind_posts();

            get_template_part( Better_Mag::get_page_listing_template() );

            Better_Mag::generator()->blocks()->get_pagination();

        }else{

            // User have not post, we get it from global variables

            $_user = isset( $_GET['author_name'] ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );

            Better_Mag::generator()->set_attr( 'user-object', $_user );
            Better_Mag::generator()->set_attr( 'block-class', 'bottom-line' );
            Better_Mag::generator()->set_attr( 'bio-excerpt', false );
            Better_Mag::generator()->blocks()->block_user_row();
            Better_Mag::generator()->unset_attr( 'block-class' );

        }

        ?></div>
    <?php if( Better_Mag::current_sidebar_layout() == 'right' ) Better_Mag::get_sidebar(); ?>
</div>
<?php get_footer(); ?>