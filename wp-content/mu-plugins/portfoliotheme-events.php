<?php

if (!defined('ABSPATH')) {
    exit;
}

function portfoliotheme_register_event_post_type() {
    $labels = array(
        'name'               => __('Events', 'portfoliotheme'),
        'singular_name'      => __('Event', 'portfoliotheme'),
        'add_new_item'       => __('Add New Event', 'portfoliotheme'),
        'edit_item'          => __('Edit Event', 'portfoliotheme'),
        'all_items'          => __('All Events', 'portfoliotheme'),
        'menu_name'          => __('Events', 'portfoliotheme'),
        'search_items'       => __('Search Events', 'portfoliotheme'),
        'not_found'          => __('No events found', 'portfoliotheme'),
        'not_found_in_trash' => __('No events found in Trash', 'portfoliotheme'),
    );

    register_post_type('event', array(
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-calendar',
        'rewrite'       => array('slug' => 'events'),
        'show_in_rest'  => true,
        'supports'      => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
    ));
}
add_action('init', 'portfoliotheme_register_event_post_type');

function portfoliotheme_add_event_meta_box() {
    add_meta_box(
        'portfoliotheme_event_details',
        __('Event Date', 'portfoliotheme'),
        'portfoliotheme_render_event_meta_box',
        'event',
        'side',
        'default'
    );
}
add_action('add_meta_boxes_event', 'portfoliotheme_add_event_meta_box');

function portfoliotheme_render_event_meta_box($post) {
    wp_nonce_field('portfoliotheme_save_event_meta', 'portfoliotheme_event_nonce');
    $event_date = get_post_meta($post->ID, '_portfoliotheme_event_date', true);
    ?>
    <p>
        <label for="portfoliotheme_event_date"><strong><?php esc_html_e('Event Date', 'portfoliotheme'); ?></strong></label><br>
        <input type="date" id="portfoliotheme_event_date" name="portfoliotheme_event_date" value="<?php echo esc_attr($event_date); ?>" class="widefat">
    </p>
    <?php
}

function portfoliotheme_save_event_meta($post_id) {
    if (!isset($_POST['portfoliotheme_event_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['portfoliotheme_event_nonce'])), 'portfoliotheme_save_event_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $event_date = isset($_POST['portfoliotheme_event_date']) ? sanitize_text_field(wp_unslash($_POST['portfoliotheme_event_date'])) : '';
    if ($event_date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $event_date)) {
        $event_date = '';
    }

    update_post_meta($post_id, '_portfoliotheme_event_date', $event_date);
}
add_action('save_post_event', 'portfoliotheme_save_event_meta');

function portfoliotheme_get_event_date($post_id = null) {
    $post_id = $post_id ? (int) $post_id : get_the_ID();
    $event_date = get_post_meta($post_id, '_portfoliotheme_event_date', true);

    if (empty($event_date)) {
        return null;
    }

    try {
        return new DateTime($event_date);
    } catch (Exception $exception) {
        return null;
    }
}

function portfoliotheme_sort_events_by_date($query) {
    if (is_admin() || !$query->is_main_query() || !$query->is_post_type_archive('event')) {
        return;
    }

    $query->set('meta_key', '_portfoliotheme_event_date');
    $query->set('orderby', 'meta_value');
    $query->set('order', 'ASC');
    $query->set('meta_type', 'DATE');
}
add_action('pre_get_posts', 'portfoliotheme_sort_events_by_date');

function portfoliotheme_create_core_pages() {
    if (get_option('portfoliotheme_core_pages_created')) {
        return;
    }

    $pages = array(
        'home'      => 'Home',
        'about'     => 'About',
        'skills'    => 'Skills',
        'resume'    => 'Resume',
        'portfolio' => 'Portfolio',
        'services'  => 'Services',
        'contact'   => 'Contact',
    );

    $created_home_id = 0;

    foreach ($pages as $slug => $title) {
        $existing_page = get_page_by_path($slug);

        if ($existing_page instanceof WP_Post) {
            if ('home' === $slug) {
                $created_home_id = (int) $existing_page->ID;
            }
            continue;
        }

        $page_id = wp_insert_post(
            array(
                'post_title'   => $title,
                'post_name'    => $slug,
                'post_type'    => 'page',
                'post_status'  => 'publish',
                'post_content' => '',
            )
        );

        if (!is_wp_error($page_id) && 'home' === $slug) {
            $created_home_id = (int) $page_id;
        }
    }

    if ($created_home_id > 0 && !get_option('page_on_front')) {
        update_option('page_on_front', $created_home_id);
        update_option('show_on_front', 'page');
    }

    update_option('portfoliotheme_core_pages_created', 1);
}
add_action('init', 'portfoliotheme_create_core_pages');
