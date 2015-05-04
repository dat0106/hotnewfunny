<?php
/*
	Template Name: Archive
*/

get_header();

the_post();

?>
    <div class="row main-section">
        <?php if( Better_Mag::current_sidebar_layout() == 'left' ) Better_Mag::get_sidebar(); ?>
        <div class="<?php echo Better_Mag::current_sidebar_layout() ? 'col-lg-8 col-md-8 col-sm-8 col-xs-12 with-sidebar content-column' : 'col-lg-12 col-md-12 col-sm-12 col-xs-12 no-sidebar'; ?>">
            <article <?php post_class( Better_Mag::generator()->get_attr_class( 'single-content' ) ); ?>><?php
                Better_Mag::posts()->the_title();
                Better_Mag::posts()->the_content(); ?>

                <div class="archive-section clearfix">
                    <div class="column-1">
                        <div class="ordered-list">
                            <h3><?php _e( 'Latest posts', 'better-studio' ); ?></h3>
                            <ol>
                                <?php $posts_list = new WP_Query( array( 'post_type'=> 'post' , 'posts_per_page'  => -1 ) );
                                while( $posts_list->have_posts()){ $posts_list->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php } wp_reset_query(); ?>
                            </ol>
                        </div>
                    </div>

                    <div class="column-2">
                        <div class="ordered-list">
                            <h3><?php _e( 'Posts by month', 'better-studio' ); ?></h3>
                            <ol>
                                <?php wp_get_archives('type=monthly'); ?>
                            </ol>
                        </div>

                        <div class="ordered-list">
                            <h3><?php _e( 'Posts by year', 'better-studio' ); ?></h3>
                            <ul>
                                <?php wp_get_archives('type=yearly'); ?>
                            </ul>
                        </div>
                    </div>

                    <div class="column-3">
                        <div class="ordered-list">
                            <h3><?php _e( 'Categories', 'better-studio' ); ?></h3>
                            <ul>
                                <?php
                                $cats = get_categories();
                                foreach($cats as $cat){
                                    echo '<li><a href="'. get_category_link( $cat ).'">'. $cat->name.'</a></li>';
                                }?>
                            </ul>
                        </div>

                        <div class="ordered-list">
                            <h3><?php _e( 'Writers', 'better-studio' ); ?></h3>
                            <ul>
                                <?php wp_list_authors('exclude_admin=0&show_fullname=1&hide_empty=1'); ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </article>
        </div>
        <?php if( Better_Mag::current_sidebar_layout() == 'right' ) Better_Mag::get_sidebar(); ?>
    </div>
<?php get_footer(); ?>