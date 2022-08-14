<?php
// Template Name: Sobre
get_header();
?>
<main class="l-page" id="content">
  <section class="l-page-single__content">
    <header class="l-page__header">
      <h1 class="l-page__title"><?= the_title(); ?></h1>
    </header>
    <div class="l-page-single__post-content">
      <?= the_content(); ?>
    </div>
  </section>
  <aside class="l-page-single__content l-page-single__instagram">
    <p class="l-page-single__instagram__text">Você pode me seguir no Instagram para
      saber sobre meu dia a dia e meu processo de escrita.</p>
    <h1 class='c-instagram__name icon-instagram'>@regianecassiadasilva</h1>
    <div class="c-instagram__feed">
      <?= do_shortcode('[instagram-feed showbutton=false showfollow=false showheader=false followtext="Me Siga no Instagram"]'); ?>
      <a href="https://www.instagram.com/regianecassiadasilva/" class="c-button c-button--outline">Me Siga no Instagram</a>
    </div>
  </aside>
</main>


<?php
get_footer();
?>