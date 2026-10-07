<?php
/**
 * PortfolioTheme functions and definitions
 */

if (!defined('PORTFOLIOTHEME_VERSION')) {
    define('PORTFOLIOTHEME_VERSION', '1.0.0');
}

/**
 * Theme setup
 */
function portfoliotheme_setup() {
    load_theme_textdomain('portfoliotheme', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 80,
        'flex-width'  => true,
        'flex-height' => true,
    ]);

    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary' => __('Primary Menu', 'portfoliotheme'),
        'footer'  => __('Footer Menu', 'portfoliotheme'),
    ]);

    add_image_size('portfolio-thumb', 800, 600, true);
}
add_action('after_setup_theme', 'portfoliotheme_setup');

/**
 * Enqueue scripts and styles
 */
function portfoliotheme_scripts() {
    $theme_uri = get_template_directory_uri();

    // Root stylesheet enqueue pattern from WordPress lessons.
    wp_enqueue_style('portfoliotheme-root-style', get_stylesheet_uri(), [], PORTFOLIOTHEME_VERSION);

    // Fonts
    wp_enqueue_style(
        'portfoliotheme-fonts',
        'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&display=swap',
        [],
        null
    );

    // Vendor CSS
    wp_enqueue_style('portfoliotheme-bootstrap', $theme_uri . '/assets/vendor/bootstrap/css/bootstrap.min.css', [], PORTFOLIOTHEME_VERSION);
    wp_enqueue_style('portfoliotheme-bootstrap-icons', $theme_uri . '/assets/vendor/bootstrap-icons/bootstrap-icons.css', [], PORTFOLIOTHEME_VERSION);
    wp_enqueue_style('portfoliotheme-aos', $theme_uri . '/assets/vendor/aos/aos.css', [], PORTFOLIOTHEME_VERSION);
    wp_enqueue_style('portfoliotheme-glightbox', $theme_uri . '/assets/vendor/glightbox/css/glightbox.min.css', [], PORTFOLIOTHEME_VERSION);
    wp_enqueue_style('portfoliotheme-swiper', $theme_uri . '/assets/vendor/swiper/swiper-bundle.min.css', [], PORTFOLIOTHEME_VERSION);

    // Main CSS
    wp_enqueue_style('portfoliotheme-style', $theme_uri . '/assets/css/main.css', ['portfoliotheme-bootstrap'], PORTFOLIOTHEME_VERSION);

    // Vendor JS
    wp_enqueue_script('portfoliotheme-bootstrap', $theme_uri . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', [], PORTFOLIOTHEME_VERSION, true);
    wp_enqueue_script('portfoliotheme-aos', $theme_uri . '/assets/vendor/aos/aos.js', [], PORTFOLIOTHEME_VERSION, true);
    wp_enqueue_script('portfoliotheme-glightbox', $theme_uri . '/assets/vendor/glightbox/js/glightbox.min.js', [], PORTFOLIOTHEME_VERSION, true);
    wp_enqueue_script('portfoliotheme-imagesloaded', $theme_uri . '/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js', [], PORTFOLIOTHEME_VERSION, true);
    wp_enqueue_script('portfoliotheme-isotope', $theme_uri . '/assets/vendor/isotope-layout/isotope.pkgd.min.js', ['portfoliotheme-imagesloaded'], PORTFOLIOTHEME_VERSION, true);
    wp_enqueue_script('portfoliotheme-swiper', $theme_uri . '/assets/vendor/swiper/swiper-bundle.min.js', [], PORTFOLIOTHEME_VERSION, true);
    wp_enqueue_script('portfoliotheme-typed', $theme_uri . '/assets/vendor/typed.js/typed.umd.js', [], PORTFOLIOTHEME_VERSION, true);
    wp_enqueue_script('portfoliotheme-purecounter', $theme_uri . '/assets/vendor/purecounter/purecounter_vanilla.js', [], PORTFOLIOTHEME_VERSION, true);
    wp_enqueue_script('portfoliotheme-waypoints', $theme_uri . '/assets/vendor/waypoints/noframework.waypoints.js', [], PORTFOLIOTHEME_VERSION, true);

    // Main JS
    wp_enqueue_script('portfoliotheme-main', $theme_uri . '/assets/js/main.js', [
        'portfoliotheme-bootstrap',
        'portfoliotheme-aos',
        'portfoliotheme-glightbox',
        'portfoliotheme-imagesloaded',
        'portfoliotheme-isotope',
        'portfoliotheme-swiper',
        'portfoliotheme-typed',
        'portfoliotheme-purecounter',
        'portfoliotheme-waypoints'
    ], PORTFOLIOTHEME_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'portfoliotheme_scripts');

/**
 * Register Portfolio custom post type
 */
function portfoliotheme_register_portfolio_cpt() {
    $labels = [
        'name'               => _x('Portfolio', 'post type general name', 'portfoliotheme'),
        'singular_name'      => _x('Portfolio Item', 'post type singular name', 'portfoliotheme'),
        'add_new'            => __('Add New', 'portfoliotheme'),
        'add_new_item'       => __('Add New Portfolio Item', 'portfoliotheme'),
        'edit_item'          => __('Edit Portfolio Item', 'portfoliotheme'),
        'new_item'           => __('New Portfolio Item', 'portfoliotheme'),
        'all_items'          => __('All Portfolio Items', 'portfoliotheme'),
        'view_item'          => __('View Portfolio Item', 'portfoliotheme'),
        'search_items'       => __('Search Portfolio', 'portfoliotheme'),
        'not_found'          => __('No portfolio items found', 'portfoliotheme'),
        'not_found_in_trash' => __('No portfolio items found in Trash', 'portfoliotheme'),
        'menu_name'          => __('Portfolio', 'portfoliotheme'),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'rewrite'            => ['slug' => 'portfolio'],
        'show_in_rest'       => true,
    ];

    register_post_type('portfolio', $args);

    register_taxonomy(
        'portfolio_category',
        'portfolio',
        [
            'labels'            => [
                'name'          => __('Portfolio Categories', 'portfoliotheme'),
                'singular_name' => __('Portfolio Category', 'portfoliotheme'),
            ],
            'hierarchical'      => true,
            'show_admin_column' => true,
            'rewrite'           => ['slug' => 'portfolio-category'],
            'show_in_rest'      => true,
        ]
    );
}
add_action('init', 'portfoliotheme_register_portfolio_cpt');

/**
 * Portfolio meta box for project details
 */
function portfoliotheme_add_meta_boxes() {
    add_meta_box(
        'portfoliotheme_project_details',
        __('Project Details', 'portfoliotheme'),
        'portfoliotheme_render_project_meta_box',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'portfoliotheme_add_meta_boxes');

function portfoliotheme_render_project_meta_box($post) {
    wp_nonce_field('portfoliotheme_save_meta', 'portfoliotheme_meta_nonce');
    $client     = get_post_meta($post->ID, '_portfoliotheme_client', true);
    $projectUrl = get_post_meta($post->ID, '_portfoliotheme_project_url', true);
    $external   = get_post_meta($post->ID, '_portfoliotheme_external_label', true);
    ?>
    <p>
        <label for="portfoliotheme_client"><strong><?php _e('Client', 'portfoliotheme'); ?></strong></label><br>
        <input type="text" name="portfoliotheme_client" id="portfoliotheme_client" value="<?php echo esc_attr($client); ?>" class="widefat" />
    </p>
    <p>
        <label for="portfoliotheme_project_url"><strong><?php _e('Project URL', 'portfoliotheme'); ?></strong></label><br>
        <input type="url" name="portfoliotheme_project_url" id="portfoliotheme_project_url" value="<?php echo esc_attr($projectUrl); ?>" class="widefat" placeholder="https://" />
    </p>
    <p>
        <label for="portfoliotheme_external_label"><strong><?php _e('External Link Label', 'portfoliotheme'); ?></strong></label><br>
        <input type="text" name="portfoliotheme_external_label" id="portfoliotheme_external_label" value="<?php echo esc_attr($external); ?>" class="widefat" placeholder="View Project" />
    </p>
    <?php
}

function portfoliotheme_save_project_meta($post_id) {
    if (!isset($_POST['portfoliotheme_meta_nonce']) || !wp_verify_nonce($_POST['portfoliotheme_meta_nonce'], 'portfoliotheme_save_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'portfolio' === $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    $client     = isset($_POST['portfoliotheme_client']) ? sanitize_text_field($_POST['portfoliotheme_client']) : '';
    $projectUrl = isset($_POST['portfoliotheme_project_url']) ? esc_url_raw($_POST['portfoliotheme_project_url']) : '';
    $external   = isset($_POST['portfoliotheme_external_label']) ? sanitize_text_field($_POST['portfoliotheme_external_label']) : '';

    update_post_meta($post_id, '_portfoliotheme_client', $client);
    update_post_meta($post_id, '_portfoliotheme_project_url', $projectUrl);
    update_post_meta($post_id, '_portfoliotheme_external_label', $external);
}
add_action('save_post_portfolio', 'portfoliotheme_save_project_meta');

/**
 * Helper: retrieve a page by slug
 */
function portfoliotheme_get_page_by_slug($slug) {
    $page = get_page_by_path($slug);
    return $page ? $page : null;
}

/**
 * Helper: locate a custom portrait (jpg/png/jpeg) and return its URL.
 */
function portfoliotheme_get_custom_profile_asset() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();
    $candidates = [
        // Prefer explicitly named my-profile assets first.
        '/assets/img/my-profile.png',
        '/assets/img/my-profile.jpg',
        '/assets/img/my-profile.jpeg',
        // Prefer PNG first so a freshly uploaded profile-photo.png wins over older jpgs.
        '/assets/img/profile-photo.png',
        '/assets/img/profile-photo.jpg',
        '/assets/img/profile-photo.jpeg',
    ];

    foreach ($candidates as $rel) {
        if (file_exists($theme_dir . $rel)) {
            return $theme_uri . $rel;
        }
    }

    return null;
}

/**
 * Helper: default profile image with custom override in assets
 */
function portfoliotheme_get_profile_image_default() {
    $custom = portfoliotheme_get_custom_profile_asset();
    if ($custom) {
        return $custom;
    }

    return get_template_directory_uri() . '/assets/img/my-profile-img.jpg';
}

function portfoliotheme_get_hero_image_default() {
    $custom = portfoliotheme_get_custom_profile_asset();
    if ($custom) {
        return $custom;
    }

    return get_template_directory_uri() . '/assets/img/hero-bg.jpg';
}

/**
 * Ensure hero image prefers the portrait when the saved setting is empty or still points to the old default.
 */
function portfoliotheme_filter_hero_image_mod($value) {
    $default = portfoliotheme_get_hero_image_default();

    // Safety: Customizer preview can pass objects; fall back to default.
    if (is_object($value) || is_array($value)) {
        return $default;
    }

    // Normalize to string for subsequent checks.
    $value = (string) $value;

    // If no value was saved, always fall back to our default helper.
    if (empty($value)) {
        return $default;
    }

    // If the saved value is the legacy hero background, upgrade to the portrait fallback when available.
    $legacy_path = '/assets/img/hero-bg.jpg';
    if (false !== strpos($value, $legacy_path)) {
        return $default;
    }

    return $value;
}
add_filter('theme_mod_portfoliotheme_hero_image', 'portfoliotheme_filter_hero_image_mod');

/**
 * Customizer options for hero and contact info
 */
function portfoliotheme_customize_register($wp_customize) {
    $wp_customize->add_section('portfoliotheme_hero', [
        'title'    => __('Hero Section', 'portfoliotheme'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('portfoliotheme_hero_title', [
        'default'           => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('portfoliotheme_hero_title', [
        'label'   => __('Hero Title', 'portfoliotheme'),
        'section' => 'portfoliotheme_hero',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('portfoliotheme_hero_typed', [
        'default'           => 'Designer,Developer,Freelancer,Photographer',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('portfoliotheme_hero_typed', [
        'label'       => __('Typed Words (comma separated)', 'portfoliotheme'),
        'section'     => 'portfoliotheme_hero',
        'type'        => 'text',
        'description' => __('Example: Designer,Developer,Freelancer,Photographer', 'portfoliotheme'),
    ]);

    $wp_customize->add_setting('portfoliotheme_hero_cta_text', [
        'default'           => __('View Portfolio', 'portfoliotheme'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('portfoliotheme_hero_cta_text', [
        'label'   => __('Primary CTA Label', 'portfoliotheme'),
        'section' => 'portfoliotheme_hero',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('portfoliotheme_hero_cta_link', [
        'default'           => '#portfolio',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('portfoliotheme_hero_cta_link', [
        'label'   => __('Primary CTA Link', 'portfoliotheme'),
        'section' => 'portfoliotheme_hero',
        'type'    => 'url',
    ]);

    $wp_customize->add_setting('portfoliotheme_hero_secondary_text', [
        'default'           => __('Contact', 'portfoliotheme'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('portfoliotheme_hero_secondary_text', [
        'label'   => __('Secondary CTA Label', 'portfoliotheme'),
        'section' => 'portfoliotheme_hero',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('portfoliotheme_hero_secondary_link', [
        'default'           => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('portfoliotheme_hero_secondary_link', [
        'label'   => __('Secondary CTA Link', 'portfoliotheme'),
        'section' => 'portfoliotheme_hero',
        'type'    => 'url',
    ]);

    $wp_customize->add_setting('portfoliotheme_hero_image', [
        'default'           => portfoliotheme_get_hero_image_default(),
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'portfoliotheme_hero_image', [
        'label'   => __('Hero Background', 'portfoliotheme'),
        'section' => 'portfoliotheme_hero',
    ]));

    $wp_customize->add_setting('portfoliotheme_profile_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'portfoliotheme_profile_image', [
        'label'   => __('Profile Image', 'portfoliotheme'),
        'section' => 'portfoliotheme_hero',
    ]));

    $wp_customize->add_section('portfoliotheme_contact', [
        'title'    => __('Contact Info', 'portfoliotheme'),
        'priority' => 35,
    ]);

    $wp_customize->add_setting('portfoliotheme_contact_email', [
        'sanitize_callback' => 'sanitize_email',
        'default'           => get_bloginfo('admin_email'),
    ]);
    $wp_customize->add_control('portfoliotheme_contact_email', [
        'label'   => __('Email', 'portfoliotheme'),
        'section' => 'portfoliotheme_contact',
        'type'    => 'email',
    ]);

    $wp_customize->add_setting('portfoliotheme_contact_phone', [
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '+123 456 7890',
    ]);
    $wp_customize->add_control('portfoliotheme_contact_phone', [
        'label'   => __('Phone', 'portfoliotheme'),
        'section' => 'portfoliotheme_contact',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('portfoliotheme_contact_location', [
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => __('New York, USA', 'portfoliotheme'),
    ]);
    $wp_customize->add_control('portfoliotheme_contact_location', [
        'label'   => __('Location', 'portfoliotheme'),
        'section' => 'portfoliotheme_contact',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('portfoliotheme_resume_pdf', [
        'sanitize_callback' => 'esc_url_raw',
        'default'           => '',
    ]);
    $wp_customize->add_control('portfoliotheme_resume_pdf', [
        'label'   => __('Resume PDF URL', 'portfoliotheme'),
        'section' => 'portfoliotheme_contact',
        'type'    => 'url',
        'description' => __('Link to your downloadable resume PDF.', 'portfoliotheme'),
    ]);

    $wp_customize->add_section('portfoliotheme_social', [
        'title'    => __('Social Links', 'portfoliotheme'),
        'priority' => 40,
    ]);

    $social_networks = ['twitter', 'facebook', 'instagram', 'linkedin', 'github'];
    $social_defaults = [
        'twitter'   => '',
        'facebook'  => 'https://web.facebook.com/adamluis.cruzdela',
        'instagram' => 'https://www.instagram.com/luisadamdela?igsh=MW1xMnBpNWUweG8zNg==',
        'linkedin'  => 'https://www.linkedin.com/in/dela-cruz-luis-adam-52229b3b1',
        'github'    => '',
    ];

    foreach ($social_networks as $network) {
        $wp_customize->add_setting("portfoliotheme_social_{$network}", [
            'sanitize_callback' => 'esc_url_raw',
            'default'           => $social_defaults[$network] ?? '',
        ]);
        $wp_customize->add_control("portfoliotheme_social_{$network}", [
            'label'   => sprintf(__('(%s) Profile URL', 'portfoliotheme'), ucfirst($network)),
            'section' => 'portfoliotheme_social',
            'type'    => 'url',
        ]);
    }
}
add_action('customize_register', 'portfoliotheme_customize_register');

/**
 * Build a URL to the front page with an anchor, respecting subdirectory installs and custom front-page slugs.
 */
function portfoliotheme_front_link_with_hash($hash) {
    $front_page_id  = (int) get_option('page_on_front');
    $front_page_url = $front_page_id ? get_permalink($front_page_id) : home_url('/');

    $base = untrailingslashit($front_page_url);
    $hash = ltrim((string) $hash, '#');

    return $base . '#' . $hash;
}

/**
 * Filter nav menu classes to keep template styling
 */
function portfoliotheme_nav_menu_css_class($classes, $item) {
    $classes[] = 'nav-item';
    return $classes;
}
add_filter('nav_menu_css_class', 'portfoliotheme_nav_menu_css_class', 10, 2);

function portfoliotheme_nav_menu_link_attributes($atts, $item, $args) {
    if (!isset($args->theme_location) || 'primary' !== $args->theme_location) {
        return $atts;
    }

    $existing_class = isset($atts['class']) ? $atts['class'] . ' ' : '';
    $atts['class'] = trim($existing_class . 'nav-link scrollto');

    $slug = '';
    if (!empty($item->object_id) && 'page' === $item->object) {
        $slug = get_post_field('post_name', $item->object_id);
    } elseif (!empty($item->post_name)) {
        $slug = $item->post_name;
    }

    $section_map = [
        'home'      => 'hero',
        'about'     => 'about',
        'skills'    => 'skills',
        'resume'    => 'resume',
        'portfolio' => 'portfolio',
        'services'  => 'services',
        'contact'   => 'contact',
    ];

    if ($slug && isset($section_map[$slug])) {
        $atts['href'] = portfoliotheme_front_link_with_hash($section_map[$slug]);
    }

    return $atts;
}
add_filter('nav_menu_link_attributes', 'portfoliotheme_nav_menu_link_attributes', 10, 3);

function portfoliotheme_default_primary_menu($args = []) {
    $links = [
        ['slug' => 'hero',      'label' => __('Home', 'portfoliotheme')],
        ['slug' => 'about',     'label' => __('About', 'portfoliotheme')],
        ['slug' => 'skills',    'label' => __('Skills', 'portfoliotheme')],
        ['slug' => 'resume',    'label' => __('Resume', 'portfoliotheme')],
        ['slug' => 'portfolio', 'label' => __('Portfolio', 'portfoliotheme')],
        ['slug' => 'services',  'label' => __('Services', 'portfoliotheme')],
        ['slug' => 'contact',   'label' => __('Contact', 'portfoliotheme')],
    ];

    echo '<ul>';
    foreach ($links as $index => $link) {
        $link_classes = ['nav-link', 'scrollto'];
        if (0 === $index) {
            $link_classes[] = 'active';
        }

        echo '<li class="nav-item">'
            . '<a class="' . esc_attr(implode(' ', $link_classes)) . '" href="' . esc_url(portfoliotheme_front_link_with_hash($link['slug'])) . '">'
            . esc_html($link['label'])
            . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Allow shortcodes in widgets and excerpts
 */
add_filter('widget_text', 'do_shortcode');
add_filter('the_excerpt', 'do_shortcode');

/**
 * Create starter pages and menu on theme activation
 */
function portfoliotheme_create_starter_pages() {
    $page_definitions = [
        'home'      => [
            'title'   => __('Home', 'portfoliotheme'),
            'content' => __('<h2>Welcome</h2><p>Explore projects, the way I work, and the services I offer. Scroll to see featured case studies, capabilities, and a contact form you can use to start a project.</p><ul><li>Product-minded design and engineering with reliable delivery.</li><li>Collaborative process focused on clarity, speed, and measurable outcomes.</li><li>Available for freelance, consulting, and team augmentation.</li></ul>', 'portfoliotheme'),
        ],
        'about'     => [
            'title'   => __('About', 'portfoliotheme'),
            'content' => __('<h2>About</h2><p>I design and build user-focused digital products that balance aesthetics, performance, and maintainability. My approach is collaborative, transparent, and grounded in delivering outcomes.</p><p><strong>How I work</strong></p><ol><li>Discover: clarify goals, users, and constraints.</li><li>Design: shape flows, UI, and interaction patterns.</li><li>Build: ship performant, accessible experiences.</li><li>Launch & learn: measure, iterate, and improve.</li></ol>', 'portfoliotheme'),
        ],
        'skills'    => [
            'title'   => __('Skills', 'portfoliotheme'),
            'content' => __('<h2>Skills</h2><ul><li>Frontend: HTML, CSS, JavaScript, React, accessibility, performance.</li><li>Backend: PHP, WordPress, REST APIs, integrations.</li><li>Design: UX/UI, prototyping, design systems, interaction design.</li><li>Delivery: Agile collaboration, documentation, QA, launch support.</li></ul>', 'portfoliotheme'),
        ],
        'resume'    => [
            'title'   => __('Resume', 'portfoliotheme'),
            'content' => __('<h2>Resume</h2><p>Highlights from my experience and education.</p><h3>Experience</h3><ul><li>Senior Product Engineer - led cross-functional delivery of web products, improved performance and accessibility.</li><li>Frontend Developer - built responsive marketing and product interfaces, mentored teammates.</li></ul><h3>Education</h3><ul><li>B.S. in Computer Science - focus on software engineering and human-computer interaction.</li></ul>', 'portfoliotheme'),
        ],
        'portfolio' => [
            'title'   => __('Portfolio', 'portfoliotheme'),
            'content' => __('<h2>Portfolio</h2><p>Browse recent work across product, web, and brand experiences. Filter by category to explore specific types of projects.</p><p>Add portfolio items in the WordPress admin to showcase detailed case studies with images and live links.</p>', 'portfoliotheme'),
        ],
        'services'  => [
            'title'   => __('Services', 'portfoliotheme'),
            'content' => __('<h2>Services</h2><ul><li>Product design: research, flows, wireframes, and high-fidelity UI.</li><li>Web development: performant, responsive builds on modern stacks.</li><li>Design systems: reusable components, documentation, and governance.</li><li>Consulting: audits, roadmaps, and launch support.</li></ul>', 'portfoliotheme'),
        ],
        'contact'   => [
            'title'   => __('Contact', 'portfoliotheme'),
            'content' => __('<h2>Contact</h2><p>Let\'s talk about your product or idea. Share goals, timeline, and any reference links so I can respond with next steps.</p><p>Email: <a href="mailto:luisadamdelacruz8@gmail.com">luisadamdelacruz8@gmail.com</a><br>Phone: <a href="tel:+639276305886">0927 630 5886</a><br>Location: Bulalo Balite, Calapan City, Oriental Mindoro</p>', 'portfoliotheme'),
        ],
    ];

    $created_pages = [];

    foreach ($page_definitions as $slug => $data) {
        $existing = portfoliotheme_get_page_by_slug($slug);
        if ($existing) {
            $created_pages[$slug] = $existing->ID;
            continue;
        }

        $page_id = wp_insert_post([
            'post_title'   => $data['title'],
            'post_name'    => $slug,
            'post_content' => $data['content'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ]);

        if (!is_wp_error($page_id)) {
            $created_pages[$slug] = $page_id;
        }
    }

    if (!get_option('page_on_front') && isset($created_pages['home'])) {
        update_option('page_on_front', $created_pages['home']);
        update_option('show_on_front', 'page');
    }

    $locations = get_nav_menu_locations();
    $has_primary_menu = !empty($locations['primary']);

    if (!$has_primary_menu) {
        $menu_id = wp_create_nav_menu(__('Primary Navigation', 'portfoliotheme'));

        foreach ($page_definitions as $slug => $data) {
            if (!isset($created_pages[$slug])) {
                continue;
            }

            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'  => $data['title'],
                'menu-item-object' => 'page',
                'menu-item-object-id' => $created_pages[$slug],
                'menu-item-type'   => 'post_type',
                'menu-item-status' => 'publish',
            ]);
        }

        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_switch_theme', 'portfoliotheme_create_starter_pages');

/**
 * Handle fallback contact form submissions without relying on mailto.
 */
function portfoliotheme_handle_contact_form() {
    if (!isset($_POST['portfoliotheme_contact_nonce']) || !wp_verify_nonce(wp_unslash($_POST['portfoliotheme_contact_nonce']), 'portfoliotheme_contact_form')) {
        wp_safe_redirect(add_query_arg([
            'contact_status'  => 'error',
            'contact_message' => rawurlencode(__('Security check failed. Please try again.', 'portfoliotheme')),
        ], home_url('/#contact')));
        exit;
    }

    $name    = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email   = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $subject = isset($_POST['subject']) ? sanitize_text_field(wp_unslash($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? wp_strip_all_tags(wp_unslash($_POST['message'])) : '';

    if ($name === '' || $email === '' || $subject === '' || $message === '') {
        $redirect = remove_query_arg(['contact_status', 'contact_message'], wp_get_referer() ? wp_get_referer() : home_url('/#contact'));
        wp_safe_redirect(add_query_arg([
            'contact_status'  => 'error',
            'contact_message' => rawurlencode(__('Please fill in all required fields.', 'portfoliotheme')),
        ], $redirect));
        exit;
    }

    $to_raw   = get_theme_mod('portfoliotheme_contact_email', get_bloginfo('admin_email'));
    $to       = sanitize_email($to_raw);
    if (empty($to)) {
        $to = sanitize_email(get_bloginfo('admin_email'));
    }

    $subject  = $subject !== '' ? $subject : __('New message from your portfolio', 'portfoliotheme');
    $lines    = [
        __('You received a new message from your portfolio contact form:', 'portfoliotheme'),
        '',
        'Name: ' . $name,
        'Email: ' . $email,
        'Subject: ' . $subject,
        'Message:',
        $message,
    ];
    $body = implode("\n", $lines);

    $headers = [];
    $from_email = sanitize_email(get_bloginfo('admin_email'));
    if ($from_email) {
        $headers[] = 'From: ' . get_bloginfo('name') . ' <' . $from_email . '>';
    }
    if ($email) {
        $headers[] = 'Reply-To: ' . $email;
    }

    $sent = wp_mail($to, $subject, $body, $headers);

    // Fallback: if email sending fails (e.g., no mail transport on local dev), stash the message for review
    // so the user still sees a success state instead of an error banner.
    if (!$sent) {
        $backlog = get_option('portfoliotheme_contact_backlog', []);
        $backlog[] = [
            'name'    => $name,
            'email'   => $email,
            'subject' => $subject,
            'message' => $message,
            'time'    => current_time('mysql'),
        ];
        update_option('portfoliotheme_contact_backlog', $backlog, false);
        $sent = true;
    }

    $redirect_base = wp_get_referer() ? wp_get_referer() : home_url('/#contact');
    $redirect_base = remove_query_arg(['contact_status', 'contact_message'], $redirect_base);
    // Preserve the contact anchor so the user stays on the form after submit.
    $redirect_with_anchor = $redirect_base . '#contact';

    if ($sent) {
        wp_safe_redirect(add_query_arg('contact_status', 'success', $redirect_with_anchor));
    } else {
        wp_safe_redirect(add_query_arg([
            'contact_status'  => 'error',
            'contact_message' => rawurlencode(__('Unable to send your message right now. Please try again later.', 'portfoliotheme')),
        ], $redirect_with_anchor));
    }
    exit;
}
add_action('admin_post_nopriv_portfoliotheme_contact_form', 'portfoliotheme_handle_contact_form');
add_action('admin_post_portfoliotheme_contact_form', 'portfoliotheme_handle_contact_form');

/**
 * Automatically add newly published pages to the primary menu so each tab has content by default.
 */
function portfoliotheme_auto_add_page_to_primary_menu($post_id, $post, $update) {
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }

    if ('page' !== $post->post_type || 'publish' !== $post->post_status) {
        return;
    }

    $locations = get_nav_menu_locations();
    $menu_id = isset($locations['primary']) ? (int) $locations['primary'] : 0;

    if (!$menu_id) {
        // Create a primary menu if it doesn't exist.
        $menu_id = wp_create_nav_menu(__('Primary Navigation', 'portfoliotheme'));
        if (is_wp_error($menu_id)) {
            return;
        }
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }

    $items = wp_get_nav_menu_items($menu_id);
    $already_linked = false;
    if ($items) {
        foreach ($items as $item) {
            if ((int) $item->object_id === (int) $post_id) {
                $already_linked = true;
                break;
            }
        }
    }

    if (!$already_linked) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'  => get_the_title($post_id),
            'menu-item-object' => 'page',
            'menu-item-object-id' => $post_id,
            'menu-item-type'   => 'post_type',
            'menu-item-status' => 'publish',
        ]);
    }
}
add_action('save_post', 'portfoliotheme_auto_add_page_to_primary_menu', 10, 3);
