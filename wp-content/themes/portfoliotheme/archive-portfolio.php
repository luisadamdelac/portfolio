<?php
/**
 * Portfolio archive
 */

global $wp_query;
get_header();
?>
<section class="section light-background py-5">
  <div class="container" data-aos="fade-up">
    <header class="mb-4">
      <h1 class="h2"><?php post_type_archive_title(); ?></h1>
    </header>

    <?php if (have_posts()) : ?>
      <div class="row gy-4">
        <?php while (have_posts()) : the_post(); ?>
          <div class="col-md-6 col-lg-4">
            <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 shadow-sm portfolio-card'); ?>>
              <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" class="card-img-top d-block overflow-hidden">
                  <?php the_post_thumbnail('portfolio-thumb', ['class' => 'img-fluid']); ?>
                </a>
              <?php endif; ?>
              <div class="card-body">
                <h2 class="card-title h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center">
                <span class="small text-muted"><?php echo get_the_date(); ?></span>
                <a class="small" href="<?php the_permalink(); ?>"><?php _e('Details', 'portfoliotheme'); ?> &raquo;</a>
              </div>
            </article>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="mt-4">
        <?php the_posts_pagination(); ?>
      </div>
    <?php else : ?>
      <p><?php _e('No portfolio items yet.', 'portfoliotheme'); ?></p>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
