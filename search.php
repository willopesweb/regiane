<?php
get_header();

global $wp_query;

?>

<main class="l-page-home" id='content'>
  <header class="l-page-single__header">
      <?php
      if ($wp_query->found_posts == 0) {
        echo '<h1 class="l-page-single____title"> Nenhum resultado encontrado para "' . get_search_query() . '"</h1>';
        echo '<p class=s"l-page-single__subtitle">Tente refazer a pesquisa usando outros termos</p>';
      } else {
        echo '<h1 class="l-page-single____title">' . $wp_query->found_posts . ' resultados para "' . get_search_query() . '"</h1>';
        echo '<p class="l-page-single__subtitle">Espero que encontre o que está procurando! :)</p>';
      }
      ?>
  </header>

  <div class="l-page-home__content">
    <section class="l-page-home__posts">
      <h1 class="screen-readers-only">Posts</h1>
      <?php
      wp_reset_query();
      $paged = get_query_var('paged', 1);
      $s = get_search_query();

      $args = array(
        's' => $s,
        'post_type' => 'post',
        'posts_per_page' => '10',
        'paged' => $paged,
        'order' => 'DESC',
        'orderby' => 'post-date'
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
        <div class="c-trigger">
          <p>Desculpe, nenhum post foi encontrado.</p>
        </div>
      <?php endif; ?>
    </section>

    <?php require 'inc/sidebar.php' ?>
  </div>
</main>

<?php
get_footer();
