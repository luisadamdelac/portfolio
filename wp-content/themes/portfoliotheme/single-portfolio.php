<?php
/**
 * Single portfolio item
 */

global $post;
get_header();

$client       = get_post_meta(get_the_ID(), '_portfoliotheme_client', true);
$project_url  = get_post_meta(get_the_ID(), '_portfoliotheme_project_url', true);
$external_txt = get_post_meta(get_the_ID(), '_portfoliotheme_external_label', true);
$post_slug    = get_post_field('post_name', get_the_ID());
$hero_fallback = get_template_directory_uri() . '/assets/img/portfolio/stickman.png';

if (strpos($post_slug, 'ebenta') !== false) {
  $hero_fallback = get_template_directory_uri() . '/assets/img/portfolio/ebenta.png';
} elseif (strpos($post_slug, 'library') !== false) {
  $hero_fallback = get_template_directory_uri() . '/assets/img/portfolio/library.png';
} elseif (strpos($post_slug, 'stickman') !== false) {
  $hero_fallback = get_template_directory_uri() . '/assets/img/portfolio/stickman.png';
}
?>
<section class="portfolio-details section">
  <div class="container" data-aos="fade-up">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-details-layout'); ?>>
        <header class="portfolio-header" data-aos="fade-up" data-aos-delay="80">
          <p class="eyebrow"><?php _e('Portfolio Project', 'portfoliotheme'); ?></p>
          <h1><?php the_title(); ?></h1>
          <div class="portfolio-meta">
            <?php
            $terms = get_the_terms(get_the_ID(), 'portfolio_category');
            if ($terms && !is_wp_error($terms)) {
                $names = wp_list_pluck($terms, 'name');
                echo esc_html(implode(' · ', $names));
            }
            ?>
          </div>
        </header>

        <div class="portfolio-hero-image" data-aos="fade-up" data-aos-delay="120">
          <?php
          $featured_image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : $hero_fallback;
          ?>
          <a href="<?php echo esc_url($featured_image); ?>" class="glightbox single-portfolio-lightbox" data-gallery="single-portfolio-gallery" title="<?php the_title_attribute(); ?>">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('large', ['class' => 'img-fluid rounded']); ?>
            <?php else : ?>
              <img src="<?php echo esc_url($featured_image); ?>" class="img-fluid rounded" alt="<?php the_title_attribute(); ?>">
            <?php endif; ?>
          </a>
        </div>

        <div class="row gy-4 align-items-start">
          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="140">
            <div class="portfolio-description single-portfolio-content">
              <?php the_content(); ?>
            </div>
          </div>
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="180">
            <aside class="portfolio-info sticky-card">
              <h3><?php _e('Project Details', 'portfoliotheme'); ?></h3>
              <ul class="list-unstyled">
                <?php if ($client) : ?>
                  <li><strong><?php _e('Client:', 'portfoliotheme'); ?></strong> <?php echo esc_html($client); ?></li>
                <?php endif; ?>
                <li><strong><?php _e('Published:', 'portfoliotheme'); ?></strong> <?php echo esc_html(get_the_date()); ?></li>
              </ul>
              <?php if ($project_url) : ?>
                <a class="btn btn-primary w-100" href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($external_txt ?: __('View Project', 'portfoliotheme')); ?></a>
              <?php endif; ?>
            </aside>
          </div>
        </div>

        <nav class="portfolio-post-nav mt-5 d-flex justify-content-between">
          <div><?php previous_post_link('%link', __('&laquo; Previous', 'portfoliotheme')); ?></div>
          <div><?php next_post_link('%link', __('Next &raquo;', 'portfoliotheme')); ?></div>
        </nav>
      </article>
    <?php endwhile; endif; ?>
  </div>
</section>
<?php get_footer(); ?>
