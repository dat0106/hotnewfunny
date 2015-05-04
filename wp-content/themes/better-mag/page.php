<?php
get_header();

the_post();

?>
<div class="row main-section">
    <?php if( Better_Mag::current_sidebar_layout() == 'left' ) Better_Mag::get_sidebar(); ?>
    <div class="<?php echo Better_Mag::current_sidebar_layout() ? 'col-lg-8 col-md-8 col-sm-8 col-xs-12 with-sidebar content-column' : 'col-lg-12 col-md-12 col-sm-12 col-xs-12 no-sidebar'; ?>">
        <article <?php post_class( Better_Mag::generator()->get_attr_class( 'single-content' ) ); ?>><?php
            Better_Mag::posts()->the_title();
            Better_Mag::posts()->the_content(); ?>
        </article>
    </div>
    <?php if( Better_Mag::current_sidebar_layout() == 'right' ) Better_Mag::get_sidebar(); ?>
</div>
<?php get_footer(); ?>