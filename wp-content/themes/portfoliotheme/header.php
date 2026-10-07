<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  $meta_description = get_bloginfo('description');
  if (is_singular() && get_option('blog_public')) {
      $excerpt = wp_strip_all_tags(get_the_excerpt());
      if (!empty($excerpt)) {
          $meta_description = $excerpt;
      }
  }
  ?>
  <meta name="description" content="<?php echo esc_attr($meta_description); ?>">
  
  <!-- WordPress Hook: Loads theme styles, scripts, and admin bar CSS -->
  <?php wp_head(); ?>
</head>
<body <?php body_class('index-page'); ?>>
<?php wp_body_open(); ?>
<div id="preloader"></div>
<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<header id="header" class="header dark-background d-flex flex-column">
  <button class="header-toggle d-xl-none bi bi-list" aria-label="Toggle navigation"></button>

  <div class="profile-img">
    <?php if (has_custom_logo()) : ?>
      <?php the_custom_logo(); ?>
    <?php elseif (get_theme_mod('portfoliotheme_profile_image')) : ?>
      <img src="<?php echo esc_url( get_theme_mod('portfoliotheme_profile_image') ); ?>" alt="<?php bloginfo('name'); ?>" class="img-fluid rounded-circle">
    <?php else : ?>
      <img src="<?php echo esc_url( portfoliotheme_get_profile_image_default() ); ?>" alt="<?php bloginfo('name'); ?>" class="img-fluid rounded-circle">
    <?php endif; ?>
  </div>

  <?php
  $site_title_default = 'Luis Adam Dela Cruz';
  $site_title_source  = get_theme_mod('portfoliotheme_hero_title', get_bloginfo('name'));
  $site_title_trimmed = is_string($site_title_source) ? trim($site_title_source) : '';
  if ($site_title_trimmed === '' || $site_title_trimmed === 'My Portfolio Website') {
      $site_title_trimmed = $site_title_default;
  }
  ?>

  <a href="<?php echo esc_url( portfoliotheme_front_link_with_hash('hero') ); ?>" class="logo d-flex align-items-center justify-content-center">
    <h1 class="sitename"><?php echo esc_html($site_title_trimmed); ?></h1>
  </a>

  <div class="social-links text-center">
    <?php
    $social_networks = [
        'twitter'   => 'twitter-x',
        'facebook'  => 'facebook',
        'instagram' => 'instagram',
        'linkedin'  => 'linkedin',
        'github'    => 'github',
    ];

    $social_defaults = [
        'twitter'   => '',
        'facebook'  => 'https://web.facebook.com/adamluis.cruzdela',
        'instagram' => 'https://www.instagram.com/luisadamdela?igsh=MW1xMnBpNWUweG8zNg==',
        'linkedin'  => 'https://www.linkedin.com/in/dela-cruz-luis-adam-52229b3b1',
        'github'    => '',
    ];

    foreach ($social_networks as $network => $icon) {
        $fallback_url = $social_defaults[$network] ?? '';
        $url = get_theme_mod('portfoliotheme_social_' . $network, $fallback_url);
        if (empty($url)) {
            continue;
        }

        echo '<a href="' . esc_url($url) . '" class="' . esc_attr($network) . '" target="_blank" rel="noopener"><i class="bi bi-' . esc_attr($icon) . '"></i></a>';
    }
    ?>
  </div>

  <nav id="navmenu" class="navmenu" aria-label="Primary Menu">
    <?php
    wp_nav_menu([
      'theme_location'  => 'primary',
      'container'       => false,
      'menu_class'      => '',
      'fallback_cb'     => 'portfoliotheme_default_primary_menu',
      'walker'          => new Walker_Nav_Menu(),
    ]);
    ?>
  </nav>
</header>

<main class="main">
