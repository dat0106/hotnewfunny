<?php
get_header();
?>
<div class="row main-section">
    <div class="col-lg-8 col-lg-offset-2  col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 no-sidebar content-column">

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <span class="text-404">404</span>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 desc-section">
                <h1><?php _e( 'Page Not Found!', 'better-studio'); ?></h1>
                <p><?php _e( "We're sorry, but we can't find the page you were looking for. It's probably some thing we've done wrong but now we know about it and we'll try to fix it. In the meantime, try one of these options:", 'better-studio' ); ?></p>
                <div class="row action-links">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <a href="javascript: history.go(-1);"><i class="fa fa-angle-double-right"></i> <?php _e( 'Go to Previous Page', 'better-studio' ); ?></a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <a href="<?php echo site_url(); ?>"><i class="fa fa-angle-double-right"></i> <?php _e( 'Go to Homepage', 'better-studio' ); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 100px;">
            <div class="col-lg-12">
                <div class="top-line">
                    <?php
                    Better_Mag::generator()->set_attr( 'submit-label', __( 'Search', 'better-studio' ) );
                    Better_Mag::generator()->blocks()->partial_search_form(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>