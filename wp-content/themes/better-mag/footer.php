</div> <!-- /container -->

<?php if( Better_Mag::get_option( 'footer_large_active' ) ){ ?>
<footer class="footer-larger-wrapper">
    <div class="container">
        <div class="row">
            <?php

            switch( Better_Mag::get_option( 'footer_large_columns' ) ){

                case 2: ?>
                    <aside class="col-lg-6 col-md-6 col-sm-6 col-xs-12 footer-aside footer-aside-1">
                        <?php dynamic_sidebar( 'footer-column-1' ); ?>
                    </aside>
                    <aside class="col-lg-6 col-md-6 col-sm-6 col-xs-12 footer-aside footer-aside-2">
                        <?php dynamic_sidebar( 'footer-column-2' ); ?>
                    </aside>
                <?php
                    break;

                case 3: ?>
                    <aside class="col-lg-4 col-md-4 col-sm-4 col-xs-12 footer-aside footer-aside-1">
                        <?php dynamic_sidebar( 'footer-column-1' ); ?>
                    </aside>
                    <aside class="col-lg-4 col-md-4 col-sm-4 col-xs-12 footer-aside footer-aside-2">
                        <?php dynamic_sidebar( 'footer-column-2' ); ?>
                    </aside>
                    <aside class="col-lg-4 col-md-4 col-sm-4 col-xs-12 footer-aside footer-aside-3">
                        <?php dynamic_sidebar( 'footer-column-3' ); ?>
                    </aside>
                <?php
                    break;

                case 4: ?>
                    <aside class="col-lg-3 col-md-3 col-sm-6 col-xs-12 footer-aside footer-aside-1">
                        <?php dynamic_sidebar( 'footer-column-1' ); ?>
                    </aside>
                    <aside class="col-lg-3 col-md-3 col-sm-6 col-xs-12 footer-aside footer-aside-2">
                        <?php dynamic_sidebar( 'footer-column-2' ); ?>
                    </aside>
                    <aside class="col-lg-3 col-md-3 col-sm-6 col-xs-12 footer-aside footer-aside-3">
                        <?php dynamic_sidebar( 'footer-column-3' ); ?>
                    </aside>
                    <aside class="col-lg-3 col-md-3 col-sm-6 col-xs-12 footer-aside footer-aside-4">
                        <?php dynamic_sidebar( 'footer-column-4' ); ?>
                    </aside>
                <?php
                    break;
            }

            ?>
        </div>
    </div>
</footer>
<?php }

if( Better_Mag::get_option( 'footer_lower_active' ) ){ ?>
<footer class="footer-lower-wrapper">
    <div class="container">
        <div class="row">
            <aside class="col-lg-6 col-md-6 col-sm-6 col-xs-12 lower-footer-aside lower-footer-aside-1">
                <?php dynamic_sidebar( 'footer-lower-left-column' ); ?>
            </aside>
            <aside class="col-lg-6 col-md-6 col-sm-6 col-xs-12 lower-footer-aside lower-footer-aside-2">
                <?php dynamic_sidebar( 'footer-lower-right-column' ); ?>
            </aside>
        </div>
    </div>
</footer>
<?php } ?>

</div> <!-- /main-wrap -->
<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer. ?>
</body>
</html>