<?php
// Template Name: Contato
get_header();
?>
<main class="l-page" id="content">
  <section class="l-page-contact__content">
    <header class="l-page__header">
      <h1 class="l-page__title">Fale Comigo</h1>
    </header>
    <div class="l-page-contact__form">
      <?= do_shortcode('[contact-form-7 id="69" title="Formulário de Contato"]') ?>
    </div>
    <div class="l-page-contact__image">
      <?php include ASSETS_DIR . '/img/contato.svg' ?>
    </div>
  </section>
</main>


<?php
get_footer();
?>