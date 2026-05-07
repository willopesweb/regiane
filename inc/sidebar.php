<aside class="l-sidebar">
  <h1 class="screen-readers-only">Mais Informações</h1>

  <form role="search" method="get" id="searchform" class="c-search" action="<?php echo home_url(); ?>">
    <label class="screen-reader-text" for="s">Pesquisar por:</label>
    <input type="text" value="" name="s" id="s" class="c-search__input">
    <button id="searchsubmit" class="c-search__button icon-search"></button>
  </form>

  <?php


  $args = array(
    'post_type' => 'livro',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_key' => 'destaque',
    'meta_value' => 'Sim',
    'order' => 'ASC',
  );
  $html = '';
  $query = new WP_Query($args);
  if ($query->have_posts()) {
    $book = array(
      'titulo' => $query->posts[0]->post_title,
      'capa' => get_field("capa", $query->posts[0]->ID),
      'link' => $query->posts[0]->post_name
    );
  ?>
    <section class="l-sidebar__book">
      <h2 class="l-sidebar__title">Confira meu último lançamento</h2>
      <a href="<?= $book['link'] ?>" title="<?= $book['titulo'] ?>">
        <img class="l-sidebar__cover lazy" height="400" width="200" data-src="<?= $book['capa'] ?>" alt="<?= $book['titulo'] ?>">
      </a>
    </section>
  <?php
  } ?>

  <section class="l-sidebar__about">
    <h1 class="screen-readers-only">Sobre a Autora</h1>
    <img loading='lazy' width='150px' height='140px' class="l-sidebar__avatar" src="<?= the_field('foto', 10) ?>" alt="Foto Regiane Silva" title="Regiane Silva">

    <div class="l-sidebar__biography">
      <?= the_field('sobre', 10) ?>
    </div>
  </section>
  <section class="c-instagram">
    <h2 class="l-sidebar__title icon-instagram">Instagram</h2>
    <div class="c-instagram__feed">
      <?= do_shortcode('[instagram-feed showbutton=false showfollow=false showheader=false followtext="Me Siga no Instagram"]'); ?>
    </div>
    <a href="https://www.instagram.com/regianecassiadasilva/" class="c-button c-button--outline" style="margin-top:10px">Me Siga no Instagram</a>

  </section>

  <?php
  $youtube_video_id = theme_get_youtube_latest_video();
  if ($youtube_video_id) : ?>
    <section class="l-sidebar__youtube">
      <h2 class="l-sidebar__title"><span class="icon-youtube"></span> YouTube</h2>
      <div class="l-sidebar__youtube__player">
        <iframe
          src="https://www.youtube-nocookie.com/embed/<?= esc_attr($youtube_video_id) ?>?rel=0"
          title="Último vídeo do canal Regiane Silva"
          loading="lazy"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen>
        </iframe>
      </div>
      <a href="https://www.youtube.com/@regianecassiadasilva" target="_blank" rel="noopener noreferrer" class="c-button c-button--outline" style="margin-top:10px">Me Siga no YouTube</a>
    </section>
  <?php endif; ?>


</aside>