<?php

const ASSETS_DIR = 'assets/public';

// Setup Inicial do Tema
function theme_initial_setup()
{
  add_theme_support('woocommerce'); // Adiciona suporte ao WooCommerce
  add_theme_support('post-thumbnails'); // Adiciona suporte à post thumbnails

  // Tamanho personalizados para imagens
  add_image_size('slide', 1000, 800, ['center', 'top']);
  update_option('medium_crop', 1);

  // Adiciona Menu Principal
  if (function_exists('wp_nav_menu')) {
    add_theme_support('nav-menus');
    register_nav_menus(
      array(
        'primary' => 'Menu Principal'
      )
    );
  }
}

add_action('after_setup_theme', 'theme_initial_setup');


// Registra o arquivo CSS do tema
function theme_css()
{
  wp_register_style('theme-fonts', get_template_directory_uri() . '/' . ASSETS_DIR . '/fonts/fonts.css', [], '1.0.0', false);
  wp_register_style('theme-style', get_template_directory_uri() . '/' . ASSETS_DIR . '/css/main.css', [], '1.0.1', false);
  wp_register_style('theme-icons', get_template_directory_uri() . '/' . ASSETS_DIR . '/fonts/icons.css', [], '1.0.0', false);
  wp_enqueue_style('theme-fonts');
  wp_enqueue_style('theme-style');
  wp_enqueue_style('theme-icons');
}

add_action('wp_enqueue_scripts', 'theme_css');


// Tamanho do resumo dos posts
function theme_custom_excerpt_length($length)
{
  return 20;
}
add_filter('excerpt_length', 'theme_custom_excerpt_length', 999);

// Paginação
function theme_custom_pagination($query = null)
{
  global $wp_query;
  if ($query == null) {
    $query = $wp_query;
  }

  $current = get_query_var('page') ? get_query_var('page') : get_query_var('paged');


  echo paginate_links(array(
    'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
    'total'        => $query->max_num_pages,
    'current'      => max(1, $current),
    'format'       => '?page=%#%',
    'show_all'     => false,
    'type'         => 'plain',
    'end_size'     => 2,
    'mid_size'     => 1,
    'prev_next'    => true,
    'prev_text'    => sprintf('<i></i> %1$s', __('Anterior', 'text-domain')),
    'next_text'    => sprintf('%1$s <i></i>', __('Próximo', 'text-domain')),
    'add_args'     => false,
    'add_fragment' => '',
  ));
}

add_filter('redirect_canonical', 'custom_disable_redirect_canonical');
function custom_disable_redirect_canonical($redirect_url)
{
  if (is_paged() && is_singular()) $redirect_url = false;
  return $redirect_url;
}

// WOOCOMMERCE

// Define quantidade de produtos exibidos por página
add_filter('loop_shop_per_page', 'theme_loop_shop_per_page');

function theme_loop_shop_per_page()
{
  return 12;
}

// Filtro para remover algumas classes do body com estilos padrão do WooCommerce
function remove_some_body_class($class)
{
  $woo_class = array_search('woocommerce', $class);
  $woopage_class = array_search('woocommerce-page', $class);

  // Filtrar as classes apenas das páginas Product e Product Archive
  $search = in_array('archive', $class) || in_array('product-template-default', $class);
  if (($woo_class || $woopage_class) && $search); {
    unset($class[$woo_class]);
    unset($class[$woopage_class]);
  }
  return $class;
}

add_filter('body_class', 'remove_some_body_class');



// Retorna Categorias
function theme_list_product_categories($parent = null, $number = null, $orderby = null, $order = null, $hide_empty = false, $ids = null)
{
  $args = array(
    'taxonomy'   => "product_cat",
    'number'     => $number,
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
    'include'    => $ids,
    'parent'    => $parent
  );

  $product_category = get_terms($args);

  $categories = [];
  foreach ($product_category as $category) :
    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
    $image = wp_get_attachment_url($thumbnail_id);
    $categories[] = [
      'name' => $category->name,
      'link' => $category->slug,
      'img' => $image
    ];
  endforeach;
  return $categories;
}

// Products List
include(get_template_directory() . '/inc/products-list.php');

// Prepara os dados para exibir na página do Produto (Single Product)
function format_single_product($id, $img_size = 'medium')
{
  $product = wc_get_product($id);

  $gallery_ids = $product->get_gallery_attachment_ids();
  $gallery = [];

  if ($gallery_ids) :
    foreach ($gallery_ids as $img_id) :
      $gallery[] = wp_get_attachment_image_src($img_id, $img_size)[0];
    endforeach;
  endif;


  return [
    'id' => $id,
    'name' => $product->get_name(),
    'price' => $product->get_price_html(),
    'link' => $product->get_permalink(),
    'sku' => $product->get_sku(),
    'description' => $product->get_description(),
    'img' => wp_get_attachment_image_src($product->get_image_id(), $img_size)[0],
    'gallery' => $gallery
  ];
}


/** CUSTOM LOGIN PAGE */
/*Função que altera a URL na página de Login, trocando pelo endereço do seu site*/
function my_login_logo_url()
{
  return get_bloginfo('url');
}
add_filter('login_headerurl', 'my_login_logo_url');

/*Função que adiciona o nome do seu site, no momento que o mouse passa por cima da logo*/
function my_login_logo_url_title()
{
  return 'Voltar para Home';
}
add_filter('login_headertext', 'my_login_logo_url_title');

/* Estiliza a página de login */
function theme_custom_login_logo()
{
  echo '<style type="text/css">
h1 a { 
  background-image:url(' .  get_stylesheet_directory_uri() . '/' . ASSETS_DIR . '/img/logo.png) !important; 
  background-size:contain !important; 
  height:72px !important; 
  width:320px !important; 
  margin-bottom:20px !important; 
  padding-bottom:0 !important; 
}
.login form { margin-top: 10px !important; }
body.login{
  background-color:  #efc7ad;
}
</style>';
}

add_action('login_head', 'theme_custom_login_logo');

/** CUSTOM POST TYPES */
function register_cpt_books()
{
  $labels = array(
    'name' => _x('Livros', 'post type general name'),
    'singular_name' => _x('Livro', 'post type singular name'),
    'add_new' => __('Adicionar Novo'),
    'add_new_item' => __('Adicionar Novo Livro'),
    'edit_item' => __('Editar Livro'),
    'new_item' => __('Novo Livro'),
    'view_item' => __('Ver Livro'),
    'search_items' => __('Pequisar Livros'),
    'not_found' =>  __('Nenhum livro encontrado'),
    'not_found_in_trash' => __('Nenhum livro na Lixeira'),
    'parent_item_colon' => ''
  );

  $args = array(
    'labels' => $labels,
    'description' => 'Cadastre os seus livros',
    'public' => true,
    'menu_position' => 5, // Abaixo de 'Posts'
    'menu_icon' => 'dashicons-book-alt', // https://developer.wordpress.org/resource/dashicons/
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'livro', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicy_queryable' => true
  );

  register_post_type('livro', $args);
}

add_action('init', 'register_cpt_books');

function books_shortcode()
{
  $args = array(
    'post_type' => 'livro',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'order' => 'ASC',
  );
  $html = '';
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

      $html .= '<article class="l-book">';
      $html .= '<img loadind="lazy" width="270" height="400" class="l-book__image" src="' . $book["capa"] . '">';
      $html .= '<div class="l-book__content">';
      $html .= '<h1 class="l-book__title">' . $book["titulo"] . '</h1>';
      $html .= '<div class="l-book__sinopse">' . $book["sinopse"] . '</div> ';
      $html .= '<div class="l-book__actions">';
      if ($book["gratuito"] == "Não" && $book["link"]) {
        $html .= '<a class="c-button c-button--outline" href="' . $book["link"] . '" target="_blank">Comprar</a>';
      }
      if ($book["gratuito"] == "Não" && $book["arquivo"]) {
        $html .= '<a class="c-button c-button--outline" href="' . $book["arquivo"] . '" target="_blank">Ler Amostra</a>';
      }
      if ($book["gratuito"] == "Sim" && $book["arquivo"]) {
        $html .= '<a class="c-button c-button--outline" href="' . $book["arquivo"] . '" target="_blank">Ler</a>';
      }

      if ($book["gratuito"] == "Sim" && $book["link"]) {
        $html .= '<a class="c-button c-button--outline" href="' . $book["link"] . '" target="_blank">Ler</a>';
      }

      $html .= '</div></div></article>';
    }
  }
  wp_reset_postdata();
  return $html;
}

add_shortcode('books', 'books_shortcode');

// Categoria Livros
/* function books_custom_tax()
{
  register_taxonomy(
    'livros-categoria',
    'livros',
    array(
      'label' => __('Categoria'),
      'rewrite' => array('slug' => 'livros-categoria'),
      'hierarchical' => true,
    )
  );
}
add_action('init', 'books_custom_tax'); */


/** PERFORMANCE */
function theme_remove_unnecessary_css_js()
{

  wp_dequeue_style('wp-block-library'); // Remove o CSS WP Block, usado para estilizar os blocos do Gutenberg
  wp_deregister_script('wp-embed'); // Remove o JS para embedar Vídeos no Wordpress

  // Remove CSS e JS do plugin Contact Form 7 nas páginas onde não existir formulários
  $load_scripts_wcp7 = false;
  $post = get_post();
  if (is_singular()) {
    if (has_shortcode($post->post_content, 'contact-form-7') || $post->post_title == 'Contato') {
      $load_scripts_wcp7 = true;
    }
  }

  if (!$load_scripts_wcp7) {
    wp_dequeue_script('contact-form-7');
    wp_dequeue_style('contact-form-7');
  }

  // Remove CSS e JS do plugin Instagram nas páginas onde não existir formulários
  $load_scripts_instagram = false;

  if (is_singular()) {
    $post = get_post();
    if (has_shortcode($post->post_content, 'instagram-feed') || $post->post_title == 'Home' || $post->post_title == 'Sobre') {
      $load_scripts_instagram = true;
    }
  }

  if (!$load_scripts_instagram) {
    wp_dequeue_script('sb_instagram');
    wp_dequeue_style('sb_instagram');
  }
}

add_action('wp_enqueue_scripts', 'theme_remove_unnecessary_css_js');

// Desativa WP Emojis
function disable_emoji_feature()
{

  // Prevent Emoji from loading on the front-end
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');

  // Remove from admin area also
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('admin_print_styles', 'print_emoji_styles');

  // Remove from RSS feeds also
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');

  // Remove from Embeds
  remove_filter('embed_head', 'print_emoji_detection_script');

  // Remove from emails
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

  // Disable from TinyMCE editor. Currently disabled in block editor by default
  add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');

  /** Finally, prevent character conversion too
   ** without this, emojis still work 
   ** if it is available on the user's device
   */

  add_filter('option_use_smilies', '__return_false');
}

function disable_emojis_tinymce($plugins)
{
  if (is_array($plugins)) {
    $plugins = array_diff($plugins, array('wpemoji'));
  }
  return $plugins;
}

add_action('init', 'disable_emoji_feature');
add_filter('option_use_smilies', '__return_false');


function crunchify_print_scripts_styles()
{

  $result = [];
  $result['scripts'] = [];
  $result['styles'] = [];

  // Print all loaded Scripts
  global $wp_scripts;
  foreach ($wp_scripts->queue as $script) :
    $result['scripts'][] =  $wp_scripts->registered[$script]->src . ";";
  endforeach;

  // Print all loaded Styles (CSS)
  global $wp_styles;
  foreach ($wp_styles->queue as $style) :
    $result['styles'][] =  $wp_styles->registered[$style]->src . ";";
  endforeach;

  return $result;
}

add_action('wp_enqueue_scripts', 'crunchify_print_scripts_styles');
