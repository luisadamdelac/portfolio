<?php
/**
 * Event archive template
 */

get_header();
?>
<section class="section light-background py-5">
  <div class="container" data-aos="fade-up">
    <header class="mb-4">
      <h1 class="h2"><?php esc_html_e('All Events', 'portfoliotheme'); ?></h1>
      <p class="text-muted mb-0"><?php esc_html_e('A list of upcoming and published events.', 'portfoliotheme'); ?></p>
    </header>

    <?php if (have_posts()) : ?>
      <div class="row gy-4">
        <?php while (have_posts()) : the_post(); ?>
          <?php $event_date = function_exists('portfoliotheme_get_event_date') ? portfoliotheme_get_event_date(get_the_ID()) : null; ?>
          <div class="col-md-6 col-lg-4">
            <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 shadow-sm'); ?> data-aos="fade-up" data-aos-delay="100">
              <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" class="card-img-top d-block overflow-hidden">
                  <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid']); ?>
                </a>
              <?php endif; ?>
              <div class="card-body">
                <h2 class="card-title h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php if ($event_date instanceof DateTime) : ?>
                  <p class="text-muted small mb-2"><?php echo esc_html($event_date->format('M d, Y')); ?></p>
                <?php endif; ?>
                <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center">
                <span class="small text-muted"><?php echo esc_html(get_the_date()); ?></span>
                <a class="small" href="<?php the_permalink(); ?>"><?php esc_html_e('Details', 'portfoliotheme'); ?> &raquo;</a>
              </div>
            </article>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="mt-4">
        <?php the_posts_pagination(); ?>
      </div>
    <?php else : ?>
      <p><?php esc_html_e('No events found.', 'portfoliotheme'); ?></p>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
