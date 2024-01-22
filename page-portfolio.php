<?php
// Template Name: Portfólio
get_header();
?>
<main class="l-page" id="content">
  <section class="l-page-single__content">
    <header class="l-page__header">
      <h1 class="l-page__title">
        <?= the_title(); ?>
      </h1>
    </header>
    <div class="l-page-single__post-content">
      <?= the_content(); ?>

      <section class="c-carousel splide js-portfolio-carousel" aria-label="Meus últimos trabalhos de revisão">
        <h1 class="screen-readers-only">Meus últimos trabalhos de revisão</h1>
        <div class="splide__track">
          <ul class="splide__list">
            <?php {
              global $query_string;
              parse_str($query_string, $my_query_array);
              $paged = (isset($my_query_array['paged']) && !empty($my_query_array['paged'])) ? $my_query_array['paged'] : 1;

              $args = array(
                'post_type' => 'portfolio',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'ASC'
              );

              $query = new WP_Query($args);
              if ($query->have_posts()) {
                while ($query->have_posts()) {
                  $query->the_post();
                  $book = array(
                    'titulo' => get_the_title(),
                    'autor' => get_field("autor"),
                    'capa' => get_field("capa"),
                    'link' => get_field("link")
                  );

                  echo '<li class="splide__slide c-carousel__item">';
                  echo '<a href="' . $book["link"] . '" target="_blank" title="' . $book["titulo"] . ', de ' . $book["autor"] . '">';
                  echo '<img loadind="lazy" width="270" height="400" src="' . $book["capa"] . '" alt="' . $book["titulo"] . ', de ' . $book["autor"] . '">';
                  echo '</a></li>';
                }
              }
            }
            ?>
          </ul>
        </div>
      </section>
      <p style="margin-top:10px">Para mais informações a respeito do meu trabalho, entre em contato por meio deste e-mail: <a href="mailto:contato@regianesilva.com.br" title="Contato por email"> contato@regianesilva.com.br</a> ou <b> preencha o formulário abaixo</b></p>
    </div>
    <div class="l-page-single__form">
      <form id="revisao" action="" method="post" class="c-form js-form" aria-label="Formulário de revisão">
        <div class="c-form__group">
          <div>
            <label class="c-form__label">
              <span>Nome</span>
              <input required aria-required="true" aria-invalid="false" value="" type="text" name="Nome"></span>
            </label>
            <label class="c-form__label">
              <span>E-mail</span>
              <input required aria-required="true" aria-invalid="false" value="" type="email" name="Email"></span>
            </label>
            <label>
              <span>Orçamento para:</span>
              <select aria-invalid="false" name="Orçamento">
                <option value="">—Escolha uma opção—</option>
                <option value="Revisão gramatical e ortográfica">Revisão gramatical e ortográfica</option>
                <option value="Crítica literária">Crítica literária</option>
                <option value="Revisão gramatical e ortográfica + Crítica literária">Revisão gramatical e ortográfica + Crítica literária</option>
              </select>
            </label>
          </div>
          <div>
            <label class="c-form__label">
              <span>Gênero literário</span>
              <input required aria-required="true" aria-invalid="false" value="" type="text" name="Gênero"></span>
            </label>
            <label class="c-form__label">
              <span>Páginas</span>
              <input required aria-required="true" aria-invalid="false" value="" type="number" name="Páginas"></span>
            </label>
            <label class="c-form__label">
              <span>Palavras</span>
              <input required aria-required="true" aria-invalid="false" value="" type="number" name="Palavras"></span>
            </label>
          </div>
        </div>
        <label class="c-form__label">
          <span>Detalhes</span>
          <textarea cols="40" rows="10" aria-invalid="false" name="Detalhes"></textarea>
        </label>
        <div class="c-form__actions">
          <input class="c-button c-button--outline" type="submit" value="Enviar">
          <?= themeLoadingSpinner() ?>
        </div>
      </form>
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