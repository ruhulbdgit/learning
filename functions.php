<?php
function my_theme_setup()
{
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    //Allow users to set custom header images and background colors or images.
    add_theme_support('custom-header');
    add_theme_support('custom-background');




    // Register navigation menu
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'my-theme'),
    ));
}
add_action('after_setup_theme', 'my_theme_setup');
//Test wp style 

wp_enqueue_style('custom', get_template_directory_uri() . '/css/custom.css');


// Enque style & js
function my_theme_scripts()
{
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');


//Custom post types allow you to create content types beyond the default posts and pages. For example, if you're creating a site for a portfolio, you might want a "Project" post type.
function my_custom_post_types()
{
    register_post_type(
        'project',
        array(
            'labels' => array(
                'name' => __('Projects'),
                'singular_name' => __('Project')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
        )
    );
}
add_action('init', 'my_custom_post_types');

//Similar to categories and tags, custom taxonomies can be used to organize your custom post types.
function my_custom_taxonomies()
{
    register_taxonomy(
        'genre',
        'project',
        array(
            'label' => __('Genre'),
            'rewrite' => array('slug' => 'genre'),
            'hierarchical' => true,
        )
    );
}
add_action('init', 'my_custom_taxonomies');

//Adding custom widgets can provide more interactive elements.
function my_custom_widgets_init()
{
    register_sidebar(array(
        'name' => 'Custom Widget Area',
        'id' => 'custom_widget_area',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'my_custom_widgets_init');

//Shortcodes allow users to add complex content easily from the WordPress editor.
function my_custom_shortcode($atts, $content = null)
{
    return '<div class="custom-shortcode">' . $content . '</div>';
}
add_shortcode('custom', 'my_custom_shortcode');


//Using the Theme Customizer API, users can change the appearance and settings of the theme in real-time.

function my_customizer_settings($wp_customize)
{
    $wp_customize->add_setting('header_color', array(
        'default' => '#000000',
        'transport' => 'refresh',
    ));

    $wp_customize->add_section('header_section', array(
        'title' => __('Header Settings', 'my-theme'),
        'priority' => 30,
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_color_control', array(
        'label' => __('Header Color', 'my-theme'),
        'section' => 'header_section',
        'settings' => 'header_color',
    )));
}
add_action('customize_register', 'my_customizer_settings');




//Meta boxes allow you to add custom fields to post edit screens for capturing additional information.

function my_custom_meta_box()
{
    add_meta_box(
        'my_meta_box', // ID
        'My Meta Box', // Title
        'my_meta_box_callback', // Callback
        'post', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'my_custom_meta_box');

function my_meta_box_callback($post)
{
    $value = get_post_meta($post->ID, '_my_meta_value_key', true);
    echo '<label for="my_meta_box">Meta Box: </label>';
    echo '<input type="text" id="my_meta_box" name="my_meta_box" value="' . esc_attr($value) . '">';
}

function save_my_meta_box_data($post_id)
{
    if (array_key_exists('my_meta_box', $_POST)) {
        update_post_meta(
            $post_id,
            '_my_meta_value_key',
            sanitize_text_field($_POST['my_meta_box'])
        );
    }
}
add_action('save_post', 'save_my_meta_box_data');


//AJAX can be used to create dynamic, interactive experiences without page reloads.
function my_ajax_script()
{
    wp_enqueue_script('my-ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery'), null, true);
    wp_localize_script('my-ajax-script', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'my_ajax_script');

function my_ajax_handler()
{
    $response = array('message' => 'Hello, AJAX!');
    wp_send_json_success($response);
}
add_action('wp_ajax_my_ajax_action', 'my_ajax_handler');
add_action('wp_ajax_nopriv_my_ajax_action', 'my_ajax_handler');

//Creating custom REST API endpoints can be useful for custom applications and integrations
function my_custom_api_endpoint()
{
    register_rest_route('myplugin/v1', '/data/', array(
        'methods' => 'GET',
        'callback' => 'my_custom_api_handler',
    ));
}
add_action('rest_api_init', 'my_custom_api_endpoint');

function my_custom_api_handler($data)
{
    return array('message' => 'Hello, REST API!');
}


//Create custom user roles for better control over site access and capabilities.
function my_custom_user_roles()
{
    add_role(
        'custom_role',
        __('Custom Role'),
        array(
            'read' => true,
            'edit_posts' => true,
        )
    );
}
add_action('init', 'my_custom_user_roles');

//Scheduled Tasks (WP-Cron)
//Scheduling tasks to run at intervals can automate repetitive tasks.
function my_custom_cron_schedule($schedules)
{
    $schedules['five_minutes'] = array(
        'interval' => 300,
        'display' => __('Every Five Minutes'),
    );
    return $schedules;
}
add_filter('cron_schedules', 'my_custom_cron_schedule');

if (!wp_next_scheduled('my_custom_cron_event')) {
    wp_schedule_event(time(), 'five_minutes', 'my_custom_cron_event');
}

function my_custom_cron_function()
{
    // Your custom task
}
add_action('my_custom_cron_event', 'my_custom_cron_function');

//Creating custom Gutenberg blocks allows for more flexible content creation.
function my_gutenberg_block()
{
    wp_register_script(
        'my-block',
        get_template_directory_uri() . '/js/my-block.js',
        array('wp-blocks', 'wp-element', 'wp-editor'),
        true
    );

    register_block_type('myplugin/my-block', array(
        'editor_script' => 'my-block',
    ));
}
add_action('init', 'my_gutenberg_block');
