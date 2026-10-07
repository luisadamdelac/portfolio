<?php
/**
 * Main blog template file
 */

get_header();
?>
<section class="section light-background py-5">
  <div class="container" data-aos="fade-up">
    <!-- Blog Banner Section -->
    <header class="mb-4" data-aos="fade-up">
      <h1 class="h2"><?php echo is_home() && !is_front_page() ? esc_html(get_the_title(get_option('page_for_posts', true))) : esc_html__('Latest Posts', 'portfoliotheme'); ?></h1>
      <p class="text-muted"><?php esc_html_e('Keep up with our latest news and articles.', 'portfoliotheme'); ?></p>
    </header>

    <!-- Blog Posts Container -->
    <div class="row gy-4">
      <?php
      while (have_posts()) {
          the_post();
      ?>
        <!-- Post Item -->
        <div class="col-md-6 col-lg-4">
          <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 shadow-sm'); ?> data-aos="fade-up" data-aos-delay="100">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="card-img-top d-block overflow-hidden">
                <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid']); ?>
              </a>
            <?php endif; ?>

            <div class="card-body">
              <!-- Post Title (Linked) -->
              <h2 class="card-title h5">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>

              <!-- Post Meta: Author, Date, Category -->
              <div class="metabox small text-muted mb-2">
                <p>
                  Posted by <?php the_author_posts_link(); ?> on
                  <?php the_time('n.j.y'); ?> in
                  <?php echo wp_kses_post(get_the_category_list(', ')); ?>
                </p>
              </div>

              <!-- Post Excerpt & Continue Reading -->
              <div class="generic-content">
                <p><?php the_excerpt(); ?></p>
                <p><a class="btn btn-primary btn-sm" href="<?php the_permalink(); ?>"><?php esc_html_e('Continue Reading', 'portfoliotheme'); ?></a></p>
              </div>
            </div>
          </article>
        </div>
      <?php
      }
      ?>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4"><?php echo wp_kses_post(paginate_links()); ?></div>
  </div>
</section>
<?php get_footer(); ?>
