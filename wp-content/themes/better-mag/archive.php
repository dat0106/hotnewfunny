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

        // Categories Page
        if( is_category() ){
            Better_Mag::generator()->blocks()->get_page_title( sprintf( _x('Browsing: %s', 'category archives title', 'better-studio'), '<i>' . single_cat_title( '', false )  . '</i>' ), false, true, 'h1' );

            if (category_description()){
                echo Better_Mag::generator()->blocks()->get_block_desc( do_shortcode(category_description()) );
            }
        }

        // Tags Page
        elseif( is_tag() ){
            Better_Mag::generator()->blocks()->get_page_title( sprintf( _x('Browsing: %s', 'tag archives title', 'better-studio'), '<i>' . single_tag_title( '', false )  . '</i>' ), false, true, 'h1' );
        }

        // Custom Taxonomy Terms Page
        elseif( is_tax() ){
            Better_Mag::generator()->blocks()->get_page_title( sprintf( _x('Browsing: %s', 'custom taxonomies archives title', 'better-studio'), '<i>' . single_term_title( '', false )  . '</i>' ), false, true, 'h1' );

            if (term_description()){
                echo Better_Mag::generator()->blocks()->get_block_desc( do_shortcode(term_description()) );
            }
        }

        // Search Page
        elseif( is_search() ){
            Better_Mag::generator()->blocks()->get_page_title( sprintf( __('Search Results: %s (%s)', 'better-studio'), '<i>' . get_search_query() . '</i>', '<span class="result-count">' . $wp_query->found_posts . '</span>' ), false, true, 'h1' );
        }

        // Daily Archive
        elseif( is_day() ){
            Better_Mag::generator()->blocks()->get_page_title( sprintf( __('Daily Archives: %s', 'better-studio'), '<i>' . get_the_date() . '</i>' ), false, true, 'h1' );
        }

        // Monthly Archive
        elseif( is_month() ){
            Better_Mag::generator()->blocks()->get_page_title( sprintf( __('Monthly Archives: %s', 'better-studio'), '<i>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'better-studio' ) ) . '</i>' ), false, true, 'h1' );
        }

        // Yearly Archive
        elseif( is_year() ){
            Better_Mag::generator()->blocks()->get_page_title( sprintf( __('Yearly Archives: %s', 'better-studio'), '<i>' . get_the_date( _x( 'Y', 'yearly archives date format', 'better-studio' ) ) . '</i>' ), false, true, 'h1' );
        }

        if( have_posts() ){

            get_template_part( Better_Mag::get_page_listing_template() );

            Better_Mag::generator()->blocks()->get_pagination();

        }
        elseif( is_search() ){ ?>

            <article class="post-0">
                <h2 class="title"><?php _e( 'Nothing Found!', 'better-studio' ); ?></h2>
                <div class="the-content">
                    <p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'better-studio'); ?></p>
                </div>
            </article><?php

        }
        else{ ?>
            <article class="post-0">
                <h2 class="title"><?php _e( 'Nothing Found!', 'better-studio' ); ?></h2>
                <div class="the-content">
                    <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'better-studio'); ?></p>
                </div>
            </article><?php

        }

    ?></div>
    <?php if( Better_Mag::current_sidebar_layout() == 'right' ) Better_Mag::get_sidebar(); ?>
</div>
<?php get_footer(); ?>