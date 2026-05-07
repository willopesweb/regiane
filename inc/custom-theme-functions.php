<?php

function theme_get_youtube_channel_id()
{
  $channel_id = get_transient('theme_youtube_channel_id');
  if ($channel_id !== false) {
    return $channel_id;
  }

  $response = wp_remote_get('https://www.youtube.com/@regianecassiadasilva', array(
    'timeout'    => 10,
    'user-agent' => 'Mozilla/5.0 (compatible; WordPress/' . get_bloginfo('version') . '; +' . home_url() . ')',
  ));

  if (is_wp_error($response)) return null;

  $body = wp_remote_retrieve_body($response);

  // YouTube usa "externalId" no HTML para identificar o canal
  preg_match('/"externalId":"(UC[^"]+)"/', $body, $matches);
  if (empty($matches[1])) {
    preg_match('/channel_id=(UC[^&"]+)/', $body, $matches);
  }
  if (empty($matches[1])) return null;

  set_transient('theme_youtube_channel_id', $matches[1], 30 * DAY_IN_SECONDS);
  return $matches[1];
}

function theme_get_youtube_latest_video()
{
  $video_id = get_transient('theme_youtube_latest_video');
  if ($video_id !== false) {
    return $video_id;
  }

  $channel_id = theme_get_youtube_channel_id();
  if (!$channel_id) return null;

  $response = wp_remote_get('https://www.youtube.com/feeds/videos.xml?channel_id=' . $channel_id, array(
    'timeout' => 10,
  ));

  if (is_wp_error($response)) return null;

  $xml = simplexml_load_string(wp_remote_retrieve_body($response));
  if (!$xml || empty($xml->entry)) return null;

  // Ignora YouTube Shorts (link contém /shorts/)
  $video_id = null;
  foreach ($xml->entry as $entry) {
    $link = (string) $entry->link->attributes()->href;
    if (strpos($link, '/shorts/') !== false) continue;
    $yt = $entry->children('yt', true);
    $video_id = (string) $yt->videoId;
    break;
  }

  if ($video_id) {
    set_transient('theme_youtube_latest_video', $video_id, 6 * HOUR_IN_SECONDS);
  }

  return $video_id ?: null;
}

function theme_custom_loading()
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
