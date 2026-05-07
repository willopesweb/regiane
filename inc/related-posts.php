<?php
$categories = wp_get_post_categories(get_the_ID());

$args = array(
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'posts_per_page' => 3,
  'post__not_in'   => array(get_the_ID()),
  'category__in'   => $categories,
  'orderby'        => 'date',
  'order'          => 'DESC',
);

$related_query = new WP_Query($args);

if ($related_query->have_posts()) : ?>
  <section class="l-page-single__related-posts">
    <h2 class="l-page-single__related-posts__title">Você também pode gostar</h2>
    <div class="l-page-single__related-posts__grid">
      <?php while ($related_query->have_posts()) : $related_query->the_post();
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'slide')[0];
      ?>
        <article class="c-post">
          <div class="c-post__image">
            <img class="lazy" height="400" data-src="<?= esc_url($image) ?>" alt="<?= esc_attr(get_the_title()) ?>" />
          </div>
          <a class="c-post__header" href="<?= esc_url(get_permalink()) ?>" title="<?= esc_attr(get_the_title()) ?>">
            <h3 class="c-post__title">
              <?= esc_html(get_the_title()) ?>
            </h3>
          </a>
        </article>
      <?php endwhile; ?>
    </div>
  </section>
<?php endif;
wp_reset_postdata();
