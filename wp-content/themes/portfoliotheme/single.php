<?php
/**
 * Single post template
 */

get_header();
?>
<section class="section py-5">
  <div class="container" data-aos="fade-up">
    <?php
    while (have_posts()) {
        the_post();
    ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
        <header class="mb-4">
          <h1><?php the_title(); ?></h1>
          <div class="text-muted small">
            <?php printf(
                esc_html__('By %1$s on %2$s', 'portfoliotheme'),
                esc_html(get_the_author()),
                esc_html(get_the_date())
            ); ?>
          </div>
        </header>

        <?php if (has_post_thumbnail()) : ?>
          <div class="mb-4">
            <?php the_post_thumbnail('large', ['class' => 'img-fluid rounded']); ?>
          </div>
        <?php endif; ?>

        <!-- Meta Box -->
        <div class="metabox mb-4">
          <p>
            <a class="metabox_blog-home-link" href="<?php echo esc_url(get_option('page_for_posts') ? get_permalink(get_option('page_for_posts')) : home_url('/blog')); ?>">
              <i class="bi bi-house-fill"></i> <?php esc_html_e('Blog Home', 'portfoliotheme'); ?>
            </a>
            <span class="metabox_main"><?php the_title(); ?></span>
          </p>
        </div>

        <div class="content">
          <?php the_content(); ?>
        </div>

        <footer class="mt-4">
          <div class="metabox mb-3">
            <p>
              Posted by <?php the_author_posts_link(); ?> on
              <?php the_time('n.j.y'); ?> in
              <?php echo wp_kses_post(get_the_category_list(', ')); ?>
            </p>
          </div>

          <?php the_tags('<span class="badge bg-primary me-2">', '</span><span class="badge bg-primary me-2">', '</span>'); ?>
        </footer>

        <nav class="post-nav mt-5 pt-4 border-top">
          <div class="row">
            <div class="col-md-6">
              <?php previous_post_link('%link', esc_html__('&laquo; Previous', 'portfoliotheme')); ?>
            </div>
            <div class="col-md-6 text-end">
              <?php next_post_link('%link', esc_html__('Next &raquo;', 'portfoliotheme')); ?>
            </div>
          </div>
        </nav>
      </article>

      <?php if (comments_open() || get_comments_number()) : ?>
        <div class="mt-5">
          <?php comments_template(); ?>
        </div>
      <?php endif; ?>
    <?php
    }
    ?>
  </div>
</section>
<?php get_footer(); ?>
