<?php
// Template Name: Livros
get_header();
?>
<main class="l-page-about" id="content">
  <section class="l-page-single__content">
    <header class="l-page__header">
      <h1 class="l-page__title"><?= the_title(); ?></h1>
    </header>
    <?php {
      global $query_string;
      parse_str($query_string, $my_query_array);
      $paged = (isset($my_query_array['paged']) && !empty($my_query_array['paged'])) ? $my_query_array['paged'] : 1;

      $args = array(
        'post_type' => 'livro',
        'post_status' => 'publish',
        'posts_per_page' => 5,
        'paged' => $paged,
        'order' => 'DESC',
        'orderby' => 'post-date'
      );
      $query = new WP_Query($args);
      if ($query->have_posts()) {
        while ($query->have_posts()) {
          $query->the_post();
          $book = array(
            'titulo' => get_the_title(),
            'sinopse' => get_field("sinopse"),
            'arquivo' => get_field("arquivo"),
            'capa' => get_field("capa"),
            'gratuito' => get_field("gratuito"),
            'link' => get_field("link")
          );

          echo  '<article class="l-book">';
          echo  '<img loadind="lazy" width="270" height="400" class="l-book__image" src="' . $book["capa"] . '">';
          echo  '<div class="l-book__content">';
          echo  '<h1 class="l-book__title">' . $book["titulo"] . '</h1>';
          echo  '<div class="l-book__sinopse">' . $book["sinopse"] . '</div> ';
          echo  '<div class="l-book__actions">';
          if ($book["gratuito"] == "Não" && $book["link"]) {
            echo  '<a class="c-button c-button--outline" href="' . $book["link"] . '" target="_blank">Comprar</a>';
          }
          if ($book["gratuito"] == "Não" && $book["arquivo"]) {
            echo  '<a class="c-button c-button--outline" href="' . $book["arquivo"] . '" target="_blank">Ler Amostra</a>';
          }
          if ($book["gratuito"] == "Sim" && $book["arquivo"]) {
            echo  '<a class="c-button c-button--outline" href="' . $book["arquivo"] . '" target="_blank">Ler</a>';
          }

          if ($book["gratuito"] == "Sim" && $book["link"]) {
            echo  '<a class="c-button c-button--outline" href="' . $book["link"] . '" target="_blank">Ler</a>';
          }

          echo  '</div></div></article>';
        }
      }
    }


    ?>
    <div class="c-pagination">
      <?php
      theme_custom_pagination($query);
      ?>
    </div>
  </section>
</main>


<?php
get_footer();
?>