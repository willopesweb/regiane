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
      <form action="" method="post" class="c-form js-form" aria-label="Formulário de contato">
        <label class="c-form__label">
          <span>Nome</span>
          <input required aria-required="true" aria-invalid="false" value="" type="text" name="Nome"></span>
        </label>

        <label class="c-form__label">
          <span>E-mail</span>
          <input required aria-required="true" aria-invalid="false" value="" type="email" name="Email"></span>
        </label>
        <label class="c-form__label">
          <span>Sua Mensagem</span>
          <textarea required cols="40" rows="10" aria-invalid="false" name="Mensagem"></textarea>
        </label>
        <div class="c-form__actions">
          <input class="c-button c-button--outline" type="submit" value="Enviar">
          <?= themeLoadingSpinner() ?>
        </div>
      </form>
    </div>
    <div class="l-page-contact__image">
      <?php include ASSETS_DIR . '/img/contato.svg' ?>
    </div>
  </section>
</main>


<?php
get_footer();
?>