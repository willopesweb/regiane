<?php

function themeLoadingSpinner()
{
  echo '<div class="c-loading">';
  echo '<figure class="page"></figure>';
  echo '<figure class="page"></figure>';
  echo '<figure class="page"></figure>';
  echo '</div>';
}

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

//Comentário
function theme_custom_comment($id, $avatar, $date, $author, $content, $parent = true)
{
  echo '<div class="l-comments__card ' . (($parent === true) ? 'parent' : '') . '" id="comment-' . $id  . '">';
  echo '<div class="l-comments__avatar">' . $avatar  . '</div>';
  echo '<div class="l-comments__card-main">';
  echo '<div class="l-comments__card-header">';
  echo '<span class="l-comments__card-date">' . $date  . '</span>';
  echo '<span class="l-comments__card-author"><cite>' . $author  . '</cite> disse:</span>';
  echo '</div>';
  echo '<div class="l-comments__card-content">';
  echo '<p>' . $content  . '</p>';
  if ($parent === true) {
    echo '<a href="#comment" data-id="' . $id  . '" class="c-button--outline js-reply-comment">Responder</a>';
  }
  echo '</div>';
  echo '</div>';
  echo '</div>';
}
