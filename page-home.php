<?php
// Template Name: Home
get_header();
?>

<main class="l-page-home" id='content'>
  <div class="l-page-home__slides">
    <section class="c-carousel splide js-main-carousel" aria-label="Meus Livros">
      <div class="splide__track">
        <ul class="splide__list">
          <?php
          $args = array(
            'post_type' => 'livro',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'post-date',
            'posts_per_page' => -1
          );
          $query = new WP_Query($args);
          if ($query->have_posts()) {
            while ($query->have_posts()) {
              $query->the_post();
              $book = array(
                'titulo' => get_the_title(),
                'capa' => get_field("capa"),
                'link' => get_field("link")
              );
              echo '<li class="splide__slide c-carousel__item">';
              echo '<a title="' . esc_attr($book["titulo"]) . '" target="_blank" href="' . esc_url($book["link"]) . '">';
              echo '<img alt="' . esc_attr($book["titulo"]) . '" title="' . esc_attr($book["titulo"]) . '" width="270" height="400" class="l-book__image" src="' . esc_url($book["capa"]) . '">';
              echo '</a></li>';
            }
          }
          wp_reset_postdata();
          ?>
        </ul>
      </div>
    </section>

  </div>
  <div class="l-page-home__content">
    <section class="l-page-home__posts">
      <h1 class="screen-readers-only">Posts</h1>
      <?php
      wp_reset_query();
      $paged = get_query_var('page', 1);

      $args = array(
        'posts_per_page' => '10',
        'order' => 'DESC',
        'paged' => $paged,
        'order' => 'DESC',
        'orderby' => 'post-date',
        'category__not_in' => 77
      );

      $the_query = new WP_Query($args); //Create our new custom query
      if ($the_query->have_posts()) :
        while ($the_query->have_posts()) :
          $the_query->the_post();
          require 'inc/post-card.php';
        endwhile;
      ?>



        <div class="c-pagination">
          <?php
          theme_custom_pagination($the_query);
          ?>
        </div>

      <?php
      else : ?>
        <div class="c-notification">
          <p>Desculpe, nenhum post foi encontrado.</p>
        </div>
      <?php endif; ?>
    </section>

    <?php require 'inc/sidebar.php' ?>
  </div>
</main>


<?php
get_footer();
