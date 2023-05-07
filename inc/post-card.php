<?php
$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID(), 'single-post-thumbnail'), 'slide')[0];

apply_filters('excerpt_length', 10); // Diminui o tamanho do resumo
?>
<article class="c-post">
  <div class="c-post__image">
    <img class="lazy" height="400" data-src="<?= $image ?>" alt="" />
  </div>

  <a class="c-post__header" href="<?= the_permalink() ?>" title="<?= the_title(); ?>">
    <h1 class="c-post__title">
      <?php echo the_title(); ?>
    </h1>
  </a>
</article>