<?php
/**
 * Front page template
 */

get_header();

$default_name    = 'Luis Adam Dela Cruz';
$hero_title      = get_theme_mod('portfoliotheme_hero_title', get_bloginfo('name'));
if (!is_string($hero_title) || trim($hero_title) === '' || trim($hero_title) === 'My Portfolio Website') {
  $hero_title = $default_name;
}
$hero_typed      = get_theme_mod('portfoliotheme_hero_typed', 'Designer,Developer,Freelancer,Photographer');
$typed_items     = array_filter(array_map('trim', explode(',', $hero_typed)));
$typed_first     = !empty($typed_items) ? $typed_items[array_key_first($typed_items)] : __('Creator', 'portfoliotheme');
$hero_cta_text   = get_theme_mod('portfoliotheme_hero_cta_text', __('View Portfolio', 'portfoliotheme'));
$hero_cta_link   = get_theme_mod('portfoliotheme_hero_cta_link', '#portfolio');
$hero_secondary  = get_theme_mod('portfoliotheme_hero_secondary_text', __('Contact', 'portfoliotheme'));
$hero_secondary_link = get_theme_mod('portfoliotheme_hero_secondary_link', '#contact');
$hero_image      = get_theme_mod('portfoliotheme_hero_image', portfoliotheme_get_hero_image_default());

$site_description = get_bloginfo('description');
if (!is_string($site_description)) {
  $site_description = '';
} else {
  $site_description = trim($site_description);
}

// About/hero bio: prefer the site description if set, otherwise use a clear default.
$about_bio = $site_description !== ''
  ? $site_description
  : __('I’m Luis Adam Dela Cruz, an aspiring web developer and designer from Bulalo Balite, Calapan City, Oriental Mindoro. I enjoy turning ideas into clean, responsive websites that are easy to use and visually consistent. My work focuses on building simple but effective interfaces, writing organized code, and making sure every section of a page has a clear purpose.', 'portfoliotheme');

$home_page       = portfoliotheme_get_page_by_slug('home');
$about_page      = portfoliotheme_get_page_by_slug('about');
$skills_page     = portfoliotheme_get_page_by_slug('skills');
$resume_page     = portfoliotheme_get_page_by_slug('resume');
$portfolio_page  = portfoliotheme_get_page_by_slug('portfolio');
$services_page   = portfoliotheme_get_page_by_slug('services');
$contact_page    = portfoliotheme_get_page_by_slug('contact');
$blog_page_id    = get_option('page_for_posts');
$contact_email   = get_theme_mod('portfoliotheme_contact_email', 'luisadamdelacruz8@gmail.com');
$contact_phone   = get_theme_mod('portfoliotheme_contact_phone', '0927 630 5886');
$contact_city    = get_theme_mod('portfoliotheme_contact_location', __('Bulalo Balite, Calapan City, Oriental Mindoro', 'portfoliotheme'));
$contact_status  = isset($_GET['contact_status']) ? sanitize_key(wp_unslash($_GET['contact_status'])) : '';
$contact_flash   = isset($_GET['contact_message']) ? sanitize_text_field(wp_unslash($_GET['contact_message'])) : '';

$stats = [
    ['icon' => 'bi-emoji-smile', 'label' => __('Happy Clients', 'portfoliotheme'), 'value' => 232, 'note' => __('projects delivered with care', 'portfoliotheme')],
    ['icon' => 'bi-journal-richtext', 'label' => __('Projects', 'portfoliotheme'), 'value' => 521, 'note' => __('completed milestones', 'portfoliotheme')],
    ['icon' => 'bi-headset', 'label' => __('Hours Of Support', 'portfoliotheme'), 'value' => 1453, 'note' => __('available for partners', 'portfoliotheme')],
    ['icon' => 'bi-people', 'label' => __('Hard Workers', 'portfoliotheme'), 'value' => 32, 'note' => __('collaborators and experts', 'portfoliotheme')],
];

$skills = [
    ['label' => 'HTML', 'value' => 100],
    ['label' => 'CSS', 'value' => 90],
    ['label' => 'JavaScript', 'value' => 85],
    ['label' => 'PHP', 'value' => 80],
    ['label' => 'WordPress', 'value' => 90],
    ['label' => 'UI/UX', 'value' => 80],
];

?>

<section id="hero" class="hero section dark-background">
  <img src="<?php echo esc_url($hero_image); ?>" alt="Hero background" data-aos="fade-in">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <h2><?php echo esc_html($hero_title); ?></h2>
    <div class="hero-badges">
      <span class="hero-badge"><i class="bi bi-broadcast-pin"></i><?php echo esc_html($contact_city); ?></span>
      <span class="hero-badge"><i class="bi bi-lightning-charge"></i><?php _e('Available for freelance and collaboration', 'portfoliotheme'); ?></span>
    </div>
    <p><?php esc_html_e("I'm", 'portfoliotheme'); ?> <span class="typed" data-typed-items="<?php echo esc_attr(implode(',', $typed_items)); ?>"><?php echo esc_html($typed_first); ?></span></p>
    <div class="hero-cta d-flex gap-2 mt-3">
      <a class="btn btn-primary" href="<?php echo esc_url($hero_cta_link); ?>"><?php echo esc_html($hero_cta_text); ?></a>
      <a class="btn btn-outline-light" href="<?php echo esc_url($hero_secondary_link); ?>"><?php echo esc_html($hero_secondary); ?></a>
    </div>
  </div>
</section>

<section id="about" class="about section">
  <div class="container section-title" data-aos="fade-up">
    <h2><?php _e('About', 'portfoliotheme'); ?></h2>
  </div>
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4 justify-content-center">
      <div class="col-lg-4">
        <?php
        $about_image = $about_page && has_post_thumbnail($about_page->ID)
          ? get_the_post_thumbnail_url($about_page->ID, 'large')
          : portfoliotheme_get_profile_image_default();
        ?>
        <img src="<?php echo esc_url($about_image); ?>" class="img-fluid" alt="About portrait">
      </div>
      <div class="col-lg-8 content" style="text-align: justify;">
        <h2><?php echo esc_html($hero_title); ?></h2>
        <div class="py-3">
          <?php
          if ($about_page && trim((string) $about_page->post_content) !== '') {
            echo apply_filters('the_content', $about_page->post_content);
          } else {
            echo '<p>' . esc_html($about_bio) . '</p>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="stats" class="stats section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
      <?php foreach ($stats as $stat) : ?>
        <div class="col-lg-3 col-md-6">
          <div class="stats-item">
            <i class="bi <?php echo esc_attr($stat['icon']); ?>"></i>
            <span data-purecounter-start="0" data-purecounter-end="<?php echo esc_attr($stat['value']); ?>" data-purecounter-duration="1" class="purecounter"></span>
            <p><strong><?php echo esc_html($stat['label']); ?></strong> <span><?php echo esc_html($stat['note']); ?></span></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="skills" class="skills section light-background">
  <div class="container section-title" data-aos="fade-up">
    <h2><?php _e('Skills', 'portfoliotheme'); ?></h2>
    <p><?php _e('Core capabilities tailored for modern products.', 'portfoliotheme'); ?></p>
  </div>
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <?php if ($skills_page && trim((string) $skills_page->post_content) !== '') : ?>
      <div class="row gy-4">
        <div class="col-12">
          <?php echo apply_filters('the_content', $skills_page->post_content); ?>
        </div>
      </div>
    <?php else : ?>
      <div class="row skills-content skills-animation">
        <?php foreach (array_chunk($skills, 3) as $chunk) : ?>
          <div class="col-lg-6">
            <?php foreach ($chunk as $skill) : ?>
              <div class="progress">
                <span class="skill"><span><?php echo esc_html($skill['label']); ?></span> <i class="val"><?php echo esc_html($skill['value']); ?>%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo esc_attr($skill['value']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<section id="resume" class="resume section">
  <div class="container section-title d-flex align-items-center justify-content-between gap-3 flex-wrap" data-aos="fade-up">
    <div>
      <h2><?php _e('Resume', 'portfoliotheme'); ?></h2>
        <p style="text-align: justify;"><?php _e('A snapshot of my experience and education, highlighting my academic background, professional journey, and developed skills. It reflects my growth as a designer and developer and my commitment to creating high-quality digital solutions while continuously adapting to evolving technologies.', 'portfoliotheme'); ?></p>
    </div>
    <?php
      $resume_pdf = get_theme_mod('portfoliotheme_resume_pdf', '');
      if (!empty($resume_pdf)) : ?>
        <a class="btn btn-primary" href="<?php echo esc_url($resume_pdf); ?>" target="_blank" rel="noopener">
          <?php _e('Download PDF', 'portfoliotheme'); ?>
        </a>
    <?php endif; ?>
  </div>
  <div class="container">
    <?php if ($resume_page && trim((string) $resume_page->post_content) !== '') : ?>
      <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
        <div class="col-12">
          <?php echo apply_filters('the_content', $resume_page->post_content); ?>
        </div>
      </div>
    <?php else : ?>
      <div class="row">
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
          <h3 class="resume-title"><?php _e('Summary', 'portfoliotheme'); ?></h3>
          <div class="resume-item pb-0">
            <h4><?php echo esc_html($hero_title); ?></h4>
            <p><em><?php _e('Creative technologist focused on building delightful interfaces and reliable systems.', 'portfoliotheme'); ?></em></p>
            <ul>
              <li><?php echo esc_html($contact_city); ?></li>
              <li><?php echo esc_html($contact_phone); ?></li>
              <li><?php echo esc_html($contact_email); ?></li>
            </ul>
          </div>
          <h3 class="resume-title"><?php _e('Education', 'portfoliotheme'); ?></h3>
          <div class="resume-item">
            <h4><?php _e('Bachelor of Science in Information System', 'portfoliotheme'); ?></h4>
            <h5>2024 - Present</h5>
            <p><em><?php _e('City College of Calapan', 'portfoliotheme'); ?></em></p>
            <p style="text-align: justify;"><?php _e('Focused on information systems, business process integration, product design, and human-computer interaction, with an emphasis on developing technology solutions that align with organizational needs and user experience.', 'portfoliotheme'); ?></p>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
          <h3 class="resume-title"><?php _e('Professional Experience', 'portfoliotheme'); ?></h3>
          <div class="resume-item">
            <h4><?php _e('Student Developer / Academic Project Experience', 'portfoliotheme'); ?></h4>
            <h5>2024 - Present</h5>
            <p><em><?php _e('City College of Calapan / Remote', 'portfoliotheme'); ?></em></p>
            <ul>
              <li><?php _e('Develop responsive and user-friendly web applications for academic and personal projects.', 'portfoliotheme'); ?></li>
              <li><?php _e('Apply design-to-code workflows to transform UI/UX concepts into functional systems.', 'portfoliotheme'); ?></li>
              <li><?php _e('Collaborate with classmates and project teams to gather requirements and deliver structured outputs.', 'portfoliotheme'); ?></li>
              <li><?php _e('Build system-based projects aligned with information systems, business processes, and user needs.', 'portfoliotheme'); ?></li>
              <li><?php _e('Implement frontend and basic backend functionalities using HTML, CSS, JavaScript, PHP, and WordPress.', 'portfoliotheme'); ?></li>
              <li><?php _e('Ensure applications are accessible, optimized, and aligned with modern web standards.', 'portfoliotheme'); ?></li>
            </ul>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<section id="portfolio" class="portfolio section light-background">
  <div class="container section-title" data-aos="fade-up">
    <h2><?php _e('Portfolio', 'portfoliotheme'); ?></h2>
    <p><?php _e('Selected work delivered across apps, products, and systems.', 'portfoliotheme'); ?></p>
  </div>
  <div class="container">
    <?php if ($portfolio_page && trim((string) $portfolio_page->post_content) !== '') : ?>
      <div class="mb-4" data-aos="fade-up" data-aos-delay="80">
        <?php echo apply_filters('the_content', $portfolio_page->post_content); ?>
      </div>
    <?php else : ?>
      <div class="portfolio-fallback" data-aos="fade-up" data-aos-delay="80">
        <div class="fallback-lead">
          <p class="eyebrow"><?php _e('Selected work', 'portfoliotheme'); ?></p>
          <h3><?php _e('Shipped across apps, products, and systems.', 'portfoliotheme'); ?></h3>
          <p class="body"><?php _e('A snapshot of academic and personal builds highlighting web, systems, and UI/UX skills.', 'portfoliotheme'); ?></p>
        </div>
        <div class="row g-4">
          <?php
          $fallback_items = [
            [
              'title'   => __('Library Management System', 'portfoliotheme'),
              'excerpt' => __('Desktop app for cataloging, borrowing, returns, and inventory controls.', 'portfoliotheme'),
              'tag'     => __('Desktop', 'portfoliotheme'),
            ],
            [
              'title'   => __('E-Benta (Dropshipping)', 'portfoliotheme'),
              'excerpt' => __('Multi-role web platform for orders and inventory tracking.', 'portfoliotheme'),
              'tag'     => __('Web Platform', 'portfoliotheme'),
            ],
            [
              'title'   => __('Portfolio Website', 'portfoliotheme'),
              'excerpt' => __('Responsive WordPress build to showcase work and case studies.', 'portfoliotheme'),
              'tag'     => __('WordPress', 'portfoliotheme'),
            ],
            [
              'title'   => __('Student Management (Concept)', 'portfoliotheme'),
              'excerpt' => __('Practice project for enrollment, records, and reporting flows.', 'portfoliotheme'),
              'tag'     => __('Concept', 'portfoliotheme'),
            ],
          ];

          foreach ($fallback_items as $item) : ?>
            <div class="col-lg-6">
              <div class="portfolio-fallback-card h-100">
                <div class="card-top">
                  <span class="pill"><?php echo esc_html($item['tag']); ?></span>
                  <h4><?php echo esc_html($item['title']); ?></h4>
                </div>
                <p><?php echo esc_html($item['excerpt']); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <p class="coming-soon"><?php _e('More coming soon.', 'portfoliotheme'); ?></p>
      </div>
    <?php endif; ?>
    <?php
    $terms = get_terms([
        'taxonomy'   => 'portfolio_category',
        'hide_empty' => true,
    ]);
    ?>
    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
      <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
        <li data-filter="*" class="filter-active"><?php _e('All', 'portfoliotheme'); ?></li>
        <?php if (!is_wp_error($terms)) : foreach ($terms as $term) : ?>
          <li data-filter=".filter-<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></li>
        <?php endforeach; endif; ?>
      </ul>

      <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
        <?php
        $portfolio_query = new WP_Query([
            'post_type'      => 'portfolio',
            'posts_per_page' => 12,
        ]);

        if ($portfolio_query->have_posts()) :
            while ($portfolio_query->have_posts()) :
                $portfolio_query->the_post();
                $classes = '';
                $item_terms = get_the_terms(get_the_ID(), 'portfolio_category');
                if ($item_terms && !is_wp_error($item_terms)) {
                    $classes = implode(' ', array_map(function ($term) {
                        return 'filter-' . $term->slug;
                    }, $item_terms));
                }
                $post_slug = get_post_field('post_name', get_the_ID());
                $thumb_fallback = get_template_directory_uri() . '/assets/img/portfolio/stickman.png';
                if (strpos($post_slug, 'ebenta') !== false) {
                  $thumb_fallback = get_template_directory_uri() . '/assets/img/portfolio/ebenta.png';
                } elseif (strpos($post_slug, 'library') !== false) {
                  $thumb_fallback = get_template_directory_uri() . '/assets/img/portfolio/library.png';
                } elseif (strpos($post_slug, 'stickman') !== false) {
                  $thumb_fallback = get_template_directory_uri() . '/assets/img/portfolio/stickman.png';
                }

                $thumb = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'portfolio-thumb') : $thumb_fallback;
                $project_url = get_post_meta(get_the_ID(), '_portfoliotheme_project_url', true);
                $external_label = get_post_meta(get_the_ID(), '_portfoliotheme_external_label', true);
                ?>
                <div class="col-lg-4 col-md-6 portfolio-item isotope-item <?php echo esc_attr($classes); ?>">
                  <div class="portfolio-content h-100">
                    <img src="<?php echo esc_url($thumb); ?>" class="img-fluid" alt="<?php the_title_attribute(); ?>">
                    <div class="portfolio-info">
                      <h4><?php the_title(); ?></h4>
                      <p><?php echo esc_html(get_the_excerpt()); ?></p>
                      <div class="portfolio-actions">
                        <a href="<?php echo esc_url($thumb); ?>" title="<?php esc_attr_e('Preview Image', 'portfoliotheme'); ?>" aria-label="<?php esc_attr_e('Preview Image', 'portfoliotheme'); ?>" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-plus-circle"></i></a>
                        <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e('More Details', 'portfoliotheme'); ?>" aria-label="<?php esc_attr_e('More Details', 'portfoliotheme'); ?>" class="details-link"><i class="bi bi-link-45deg"></i></a>
                        <?php if (!empty($project_url)) : ?>
                          <a href="<?php echo esc_url($project_url); ?>" class="portfolio-live-link" target="_blank" rel="noopener" title="<?php echo esc_attr($external_label ?: __('Live Project', 'portfoliotheme')); ?>" aria-label="<?php echo esc_attr($external_label ?: __('Live Project', 'portfoliotheme')); ?>"><i class="bi bi-box-arrow-up-right"></i> <?php echo esc_html($external_label ?: __('Live', 'portfoliotheme')); ?></a>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
          $fallback_items = [
            [
              'title'   => __('Library Management System', 'portfoliotheme'),
              'excerpt' => __('Desktop app for catalog, borrowing, returns, and member management.', 'portfoliotheme'),
              'image'   => get_template_directory_uri() . '/assets/img/portfolio/library.png',
              'class'   => 'filter-systems',
            ],
            [
              'title'   => __('E-Benta System (Dropshipping Platform)', 'portfoliotheme'),
              'excerpt' => __('Multi-role web platform for orders, inventory tracking, and transactions.', 'portfoliotheme'),
              'image'   => get_template_directory_uri() . '/assets/img/portfolio/ebenta.png',
              'class'   => 'filter-web',
            ],
            [
              'title'   => __('Stickman Game Project', 'portfoliotheme'),
              'excerpt' => __('Interactive concept project showcasing gameplay mechanics and UI flow.', 'portfoliotheme'),
              'image'   => get_template_directory_uri() . '/assets/img/portfolio/stickman.png',
              'class'   => 'filter-web',
            ],
          ];

          foreach ($fallback_items as $item) : ?>
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item <?php echo esc_attr($item['class']); ?>">
              <div class="portfolio-content h-100">
                <img src="<?php echo esc_url($item['image']); ?>" class="img-fluid" alt="<?php echo esc_attr($item['title']); ?>">
                <div class="portfolio-info">
                  <h4><?php echo esc_html($item['title']); ?></h4>
                  <p><?php echo esc_html($item['excerpt']); ?></p>
                  <div class="portfolio-actions">
                    <a href="<?php echo esc_url($item['image']); ?>" title="<?php esc_attr_e('Preview Image', 'portfoliotheme'); ?>" aria-label="<?php esc_attr_e('Preview Image', 'portfoliotheme'); ?>" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-plus-circle"></i></a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach;
        endif;
        ?>
      </div>
    </div>
  </div>
</section>

<section id="services" class="services section">
  <div class="container section-title" data-aos="fade-up">
    <h2><?php _e('Services', 'portfoliotheme'); ?></h2>
  </div>
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
      <?php
      if ($services_page && trim((string) $services_page->post_content) !== '') {
          echo apply_filters('the_content', $services_page->post_content);
      } else {
            $default_services = [
              [
                'icon'  => 'bi-laptop',
                'title' => __('Web Development', 'portfoliotheme'),
                'desc'  => __('Building clean and responsive websites using HTML, CSS, JavaScript, PHP, and WordPress.', 'portfoliotheme'),
              ],
              [
                'icon'  => 'bi-brush',
                'title' => __('UI/UX & Visual Design', 'portfoliotheme'),
                'desc'  => __('Designing organized layouts, clear sections, and user-friendly interfaces for portfolio and system projects.', 'portfoliotheme'),
              ],
              [
                'icon'  => 'bi-lightbulb',
                'title' => __('Academic & System Projects', 'portfoliotheme'),
                'desc'  => __('Translating school and concept requirements into working prototypes and real-world-style applications.', 'portfoliotheme'),
              ],
            ];
          foreach ($default_services as $service) : ?>
            <div class="col-lg-4 col-md-6">
              <div class="service-item position-relative">
                <div class="icon"><i class="bi <?php echo esc_attr($service['icon']); ?>"></i></div>
                <h3><?php echo esc_html($service['title']); ?></h3>
                <p><?php echo esc_html($service['desc']); ?></p>
              </div>
            </div>
          <?php endforeach;
      }
      ?>
    </div>
  </div>
</section>

<section id="contact" class="contact section light-background">
  <div class="container section-title" data-aos="fade-up">
    <h2><?php _e('Contact', 'portfoliotheme'); ?></h2>
    <p><?php _e('Let’s discuss your next project.', 'portfoliotheme'); ?></p>
  </div>
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div id="contact-form-success" class="alert alert-success<?php echo $contact_status === 'success' ? '' : ' d-none'; ?>" role="status"><?php _e('Thanks, your message was sent. I will get back to you soon.', 'portfoliotheme'); ?></div>
    <?php if ($contact_status === 'error') : ?>
      <div class="alert alert-danger" role="status"><?php echo esc_html($contact_flash !== '' ? $contact_flash : __('Sorry, something went wrong. Please try again.', 'portfoliotheme')); ?></div>
    <?php endif; ?>
    <?php if ($contact_page && trim((string) $contact_page->post_content) !== '') : ?>
      <div class="row gy-4 mb-4">
        <div class="col-12">
          <?php echo apply_filters('the_content', $contact_page->post_content); ?>
        </div>
      </div>
    <?php endif; ?>
    <div class="row gy-4">
      <div class="col-lg-5">
        <div class="info-wrap">
          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
            <i class="bi bi-geo-alt flex-shrink-0"></i>
            <div>
              <h3><?php _e('Location', 'portfoliotheme'); ?></h3>
              <p><?php echo esc_html($contact_city); ?></p>
            </div>
          </div>
          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-envelope flex-shrink-0"></i>
            <div>
              <h3><?php _e('Email', 'portfoliotheme'); ?></h3>
              <p><a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_html($contact_email); ?></a></p>
            </div>
          </div>
          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
            <i class="bi bi-phone flex-shrink-0"></i>
            <div>
              <h3><?php _e('Call', 'portfoliotheme'); ?></h3>
              <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $contact_phone)); ?>"><?php echo esc_html($contact_phone); ?></a></p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="form-wrapper" data-aos="fade-up" data-aos-delay="200">
          <?php
          if (shortcode_exists('contact-form-7')) {
              echo do_shortcode('[contact-form-7 id="1" title="Contact form 1"]');
          } else {
              ?>
              <form class="php-email-form" action="<?php echo esc_url('https://formsubmit.co/' . $contact_email); ?>" method="post">
                <input type="hidden" name="_subject" value="New portfolio contact message">
                <input type="hidden" name="_next" value="https://luisadamdelac.github.io/portfolio/?contact_status=success#contact-form-success">
                <input type="hidden" name="_template" value="table">
                <input type="text" name="_honey" tabindex="-1" autocomplete="off" aria-hidden="true" style="display:none">
                <div class="row gy-4">
                  <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="<?php esc_attr_e('Your Name', 'portfoliotheme'); ?>" required>
                  </div>
                  <div class="col-md-6">
                    <input type="email" class="form-control" name="email" placeholder="<?php esc_attr_e('Your Email', 'portfoliotheme'); ?>" required>
                  </div>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="subject" placeholder="<?php esc_attr_e('Subject', 'portfoliotheme'); ?>" required>
                  </div>
                  <div class="col-md-12">
                    <textarea class="form-control" name="message" rows="6" placeholder="<?php esc_attr_e('Message', 'portfoliotheme'); ?>" required></textarea>
                  </div>
                  <div class="col-md-12 text-center">
                    <button type="submit"><?php esc_html_e('Send Message', 'portfoliotheme'); ?></button>
                  </div>
                </div>
                <div class="loading" role="status" aria-live="polite"><?php esc_html_e('Sending message...', 'portfoliotheme'); ?></div>
                <div class="error-message" role="alert"></div>
                <div class="sent-message" role="status" aria-live="polite"><?php esc_html_e('Thanks, your message was sent. I will get back to you soon.', 'portfoliotheme'); ?></div>
              </form>
              <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
