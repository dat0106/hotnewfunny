<!DOCTYPE html>
<!--[if IE 8]> <html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]> <html class="ie ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <title><?php wp_title(''); // Compatible with SEO plugins ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <?php wp_head(); ?>

    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
    <![endif]-->
</head>
<body  <?php body_class(); ?>>
<div class="main-wrap">

    <div class="container">
        <div class="container back-top-wrapper">
        <span class="back-top"><i class="fa fa-chevron-up"></i></span>
        </div>
    </div>

    <?php if( ! Better_Mag::get_option( 'disable_top_bar' ) ){ // if topbar is active ?>
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12 top-bar-left clearfix">
                    <?php dynamic_sidebar('top-bar-left'); ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12 top-bar-right clearfix">
                    <?php dynamic_sidebar('top-bar-right'); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<header class="header">
    <div class="container">
        <div class="row">
            <?php if( Better_Mag::get_option( 'logo_position' )  == 'left' ){ ?>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left-align-logo logo-container">
                    <?php Better_Mag::generator()->blocks()->site_logo(); ?>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 <?php echo Better_Mag::get_option( 'show_aside_logo_on_small' )  ? 'col-xs-12' : 'hidden-xs' ; ?> left-align-logo aside-logo-sidebar">
                    <?php dynamic_sidebar('aside-logo'); ?>
                </div>
            <?php } elseif( Better_Mag::get_option( 'logo_position'  ) == 'center' ){ ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-align-logo logo-container">
                    <?php Better_Mag::generator()->blocks()->site_logo(); ?>
                </div>
            <?php }elseif( Better_Mag::get_option( 'logo_position' ) == 'right' ){ ?>
                <div class="col-lg-8 col-md-8 col-sm-8 hidden-xs right-align-logo aside-logo-sidebar">
                    <?php dynamic_sidebar('aside-logo'); ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right-align-logo logo-container">
                    <?php Better_Mag::generator()->blocks()->site_logo(); ?>
                </div>
            <?php } ?>

        </div>
    </div>
</header><?php

Better_Mag::generator()->blocks()->menu_main_menu();

Better_Mag::generator()->blocks()->breadcrumb(); ?>

<div class="container"><?php

Better_Mag::generator()->get_main_slider();

?>