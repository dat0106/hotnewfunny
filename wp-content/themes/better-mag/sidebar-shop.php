<aside class="col-lg-4 col-md-4 col-sm-4 col-xs-12 main-sidebar <?php echo Better_Mag::wooCommerce()->is_sidebar_layout( 'right' ) == 'right' ? 'vertical-left-line' : 'vertical-right-line'; ?> ">
    <?php if ( ! dynamic_sidebar('woocommerce-sidebar') ) : ?>
        <div class="primary-sidebar-widget widget">
            <?php Better_Mag::generator()->blocks()->get_block_title( __( "Sample Widget Title", 'better-studio' ) ); ?>
            <p><?php _e( 'Nothing yet.', 'better-studio' ); ?></p>
        </div>
    <?php endif; ?>
</aside>