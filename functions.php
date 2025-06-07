<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

function tc_enqueue_styles() {
    wp_enqueue_style('tc-post-styles', get_stylesheet_directory_uri() . '/tc-post.css');
}
add_action('wp_enqueue_scripts', 'tc_enqueue_styles');

// Add Customizer Settings
function tc_customize_register($wp_customize) {
    // Add section
    $wp_customize->add_section('tc_post_options', array(
        'title' => __('TechCrunch Post Options', 'generatepress-child'),
        'priority' => 120,
    ));

    // Add setting
    $wp_customize->add_setting('tc_post_template_enabled', array(
        'default' => false,
        'sanitize_callback' => 'tc_sanitize_checkbox',
    ));

    // Add control
    $wp_customize->add_control('tc_post_template_enabled', array(
        'label' => __('Enable TechCrunch Post Template', 'generatepress-child'),
        'section' => 'tc_post_options',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'tc_customize_register');

// Sanitize checkbox
function tc_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

// Include the post template file only if enabled
function tc_maybe_include_post_template() {
    if (get_theme_mod('tc_post_template_enabled', false)) {
        require_once get_stylesheet_directory() . '/inc/post-templates/tc-post.php';
    }
}
add_action('init', 'tc_maybe_include_post_template');

// Remove default GeneratePress single post elements when TC template is enabled
function tc_remove_generatepress_elements() {
    if (get_theme_mod('tc_post_template_enabled', false) && is_single() && get_post_type() === 'post') {
        remove_action('generate_before_content', 'generate_featured_page_header_inside_single');
        remove_action('generate_after_entry_header', 'generate_post_image');
        remove_action('generate_after_entry_title', 'generate_post_meta');
        remove_action('generate_before_content', 'generate_featured_page_header');
        remove_action('generate_after_header', 'generate_featured_page_header');
        remove_action('generate_before_content', 'generate_featured_page_header_inside');
        remove_action('generate_after_entry_content', 'generate_footer_meta');
        remove_action('generate_before_main_content', 'generate_page_header');
    }
}
add_action('wp', 'tc_remove_generatepress_elements');

// Override single post template
function tc_override_single_template($template) {
    if (get_theme_mod('tc_post_template_enabled', false) && is_single() && get_post_type() === 'post') {
        // Remove GeneratePress Elements content filter
        remove_filter('the_content', array('GeneratePress_Elements_Helper', 'generate_elements_content'));
        
        // Add our custom hero after site-content opens
        add_action('generate_after_header', 'tc_render_article_hero', 5);
        
        // Remove entry header
        add_filter('generate_show_entry_header', '__return_false');
    }
    return $template;
}
add_action('template_include', 'tc_override_single_template');

// Disable Comments
function tc_disable_comments() {
    // Remove comment support from posts and pages
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
    
    // Close comments on existing posts
    global $wpdb;
    $wpdb->update($wpdb->posts, array('comment_status' => 'closed'), array('comment_status' => 'open'));
    
    // Hide existing comments
    add_filter('comments_array', '__return_empty_array');
    
    // Remove comments from admin menu
    add_action('admin_menu', function() {
        remove_menu_page('edit-comments.php');
    });
    
    // Remove comments from admin bar
    add_action('wp_before_admin_bar_render', function() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
    });
    
    // Disable comments REST API endpoint
    add_filter('rest_endpoints', function($endpoints) {
        if (isset($endpoints['/wp/v2/comments'])) {
            unset($endpoints['/wp/v2/comments']);
        }
        return $endpoints;
    });
}
add_action('init', 'tc_disable_comments');
?>