<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php bloginfo('name'); ?></title>

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?> ./css/custom.css">

    <?php wp_head(); ?>
</head>

<body>
    <header>
        <h1><?php bloginfo('name'); ?></h1>
        <p><?php bloginfo('description'); ?></p>
        <?php wp_nav_menu(array('theme_location' => 'my-theme', 'menu_id' => 'nav')); ?>
    </header>