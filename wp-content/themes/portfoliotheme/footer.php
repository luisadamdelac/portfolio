</main>

<footer id="footer" class="footer light-background">
  <div class="container">
    <div class="copyright text-center">
      <p>&copy; <span><?php echo esc_html(date('Y')); ?></span> <span class="sitename"><?php bloginfo('name'); ?></span>. All Rights Reserved</p>
    </div>
    <div class="credits text-center">
      <p><?php bloginfo('description'); ?></p>
    </div>
  </div>
</footer>

<!-- WordPress Hook: Loads admin bar JS and any scripts enqueued in footer -->
<?php wp_footer(); ?>
</body>
</html>
