<?php
get_header();
?>

<main class="l-page-single" id="content">
  <section class="l-page-single__content">
    <header class="l-page-single__header">
      <h1 class='l-page-single__title'><?= the_title() ?></h1>
      <p class='l-page-single__subtitle'><?= get_the_date() . ' - Regiane Silva' ?></p>
    </header>
    <div class="l-page-single__post-content">
      <?= the_content(); ?>
    </div>
    <article class="l-page-single__share">
      <h1 class="l-page-single__share__title">Compartilhe essa postagem</h1>
      <ul class="c-social">
        <li><a target='_blank' class='icon-whatsapp' href="https://api.whatsapp.com/send?text=<?= get_permalink() ?>"></a></li>
        <li><a target='_blank' class='icon-twitter' href="https://twitter.com/intent/tweet?text=<?= get_permalink() ?>"></a></li>
        <li><a target='_blank' class='icon-facebook' href="https://www.facebook.com/sharer/sharer.php?u=<?= get_permalink() ?>"></a></li>
      </ul>
    </article>
    <article class="l-page-single__author">
      <h1 class="l-page-single__author__title">Postagem feita por:</h1>
      <div class="l-page-single__author__content">
        <img class="l-page-single__author__image" loading="lazy" width="100px" height="125px" src="<?= the_field('foto', 10) ?>" alt="Foto Regiane Silva" title="Regiane Silva" />
        <span><?php $author =  (get_the_author() == '' ? 'Regiane Silva' : get_the_author());
              echo $author;
              ?>
        </span>
      </div>
    </article>
  </section>
  <div class="l-page-single__comments">
    <?php
    if (comments_open()) { ?>
      <div class="l-page__content" style="justify-content:center">
        <form action="" method="post" class="c-form js-form" aria-label="Formulário de comentário" id="comment">
          <input type="hidden" name="PostId" value="<?= get_the_ID() ?>" />
          <label class="c-form__label">
            <span>Nome</span>
            <input required aria-required="true" aria-invalid="false" value="" type="text" name="Nome"></span>
          </label>
          <label class="c-form__label">
            <span>Comentário</span>
            <textarea required cols="40" rows="10" aria-invalid="false" name="Comentario"></textarea>
          </label>
          <label class="c-form__label c-form__captcha">
            <span>Digite os caracteres da imagem abaixo</span>
            <?php $random =  rand(1, 13) ?>
            <input required aria-required="true" aria-invalid="false" value="" type="text" name="Captcha">
            <input type="hidden" name="CaptchaCode" value="<?= $random ?>" />
            <img loading="lazy" width="200" height="50" src="<?= get_template_directory_uri() . '/' . ASSETS_DIR . '/img/captchas/' . $random . '.png' ?>" alt="">
          </label>
          <div class="c-form__actions">
            <input class="c-button c-button--outline" type="submit" value="Enviar">
            <?= themeLoadingSpinner() ?>
          </div>
        </form>
      </div>
    <?php }
    ?>
  </div>
</main>
<?php
get_footer();
