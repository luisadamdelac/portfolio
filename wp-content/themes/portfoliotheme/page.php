<?php
/**
 * Default page template
 */

get_header();
?>
<section class="page-hero section dark-background">
  <div class="container" data-aos="fade-up">
    <h1 class="text-white mb-3"><?php the_title(); ?></h1>
  </div>
</section>

<section class="section light-background py-5">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <?php
    while (have_posts()) {
        the_post();

        $parent_id = wp_get_post_parent_id(get_the_ID());

        $child_pages = get_pages(array(
            'child_of' => $parent_id ? $parent_id : get_the_ID(),
        ));

        if ($parent_id || !empty($child_pages)) :
    ?>
      <div class="page-links mb-4 pb-4 border-bottom">
        <?php if ($parent_id) : ?>
          <p>
            <a class="metabox_blog-home-link" href="<?php echo esc_url(get_permalink($parent_id)); ?>">
              <i class="fa fa-home" aria-hidden="true"></i> <?php echo esc_html(sprintf(__('Back to %s', 'portfoliotheme'), get_the_title($parent_id))); ?>
            </a>
            <span class="metabox_main"><?php the_title(); ?></span>
          </p>
        <?php endif; ?>

        <?php if (!empty($child_pages)) : ?>
          <div class="mt-3">
            <h2 class="page-links_title"><?php echo esc_html($parent_id ? get_the_title($parent_id) : get_the_title()); ?></h2>
            <ul class="min-list">
              <?php
              wp_list_pages(array(
                  'title_li'    => null,
                  'child_of'    => $parent_id ? $parent_id : get_the_ID(),
                  'sort_column' => 'menu_order',
              ));
              ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    <?php
        endif;

        the_content();
    }
    ?>
  </div>
</section>
<?php get_footer(); ?>
