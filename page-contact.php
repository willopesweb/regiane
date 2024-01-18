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
          <input required aria-required="true" aria-invalid="false" value="" type="text" name="name"></span>
        </label>

        <label class="c-form__label">
          <span>E-mail</span>
          <input required aria-required="true" aria-invalid="false" value="" type="email" name="email"></span>
        </label>
        <label class="c-form__label">
          <span>Sua Mensagem</span>
          <textarea required cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false" name="message"></textarea>
        </label>
        <div class="c-form__actions">
          <input class="c-button c-button--outline" type="submit" value="Enviar">
          <div class="c-loading">
            <figure class="page"></figure>
            <figure class="page"></figure>
            <figure class="page"></figure>
          </div>
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