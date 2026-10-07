<?php
/**
 * Single event template
 */

get_header();
?>
<section class="section py-5">
  <div class="container" data-aos="fade-up">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php $event_date = function_exists('portfoliotheme_get_event_date') ? portfoliotheme_get_event_date(get_the_ID()) : null; ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
        <header class="mb-4">
          <p class="text-uppercase small text-muted mb-2"><?php esc_html_e('Event', 'portfoliotheme'); ?></p>
          <h1 class="mb-2"><?php the_title(); ?></h1>
          <?php if ($event_date instanceof DateTime) : ?>
            <div class="text-muted small"><?php echo esc_html($event_date->format(get_option('date_format'))); ?></div>
          <?php endif; ?>
        </header>

        <?php if (has_post_thumbnail()) : ?>
          <div class="mb-4">
            <?php the_post_thumbnail('large', ['class' => 'img-fluid rounded']); ?>
          </div>
        <?php endif; ?>

        <div class="content">
          <?php the_content(); ?>
        </div>

        <footer class="mt-4">
          <a class="btn btn-outline-primary" href="<?php echo esc_url(get_post_type_archive_link('event')); ?>">
            <?php esc_html_e('Events Home', 'portfoliotheme'); ?>
          </a>
        </footer>
      </article>
    <?php endwhile; endif; ?>
  </div>
</section>
<?php get_footer(); ?>
