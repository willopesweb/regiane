<?php

// Retorna um array formatado com as informações de cada produto
function format_products($products, $img_size = 'medium')
{
  $products_final = [];
  foreach ($products as $product) :
    $promotion = (($product->price < $product->regular_price) ? true : false);
    $promotion_value = $promotion ? round((($product->regular_price - $product->price) / $product->regular_price) * 100) : 0;

    $products_final[] = [
      'name' => $product->get_name(),
      'price' => $product->get_price_html(),
      'img' => wp_get_attachment_image_src($product->get_image_id(), $img_size)[0],
      'link' => $product->get_permalink(),
      'promotion' => $promotion,
      'promotion_value' => $promotion_value
    ];
  endforeach;

  return $products_final;
}

// Recebe um array  com objetos do tipo produto e retorna html formatado
function theme_products_list($products)
{ ?>
  <ul class='products-list'>
    <?php foreach ($products as $product) :
      echo "<li>";
      theme_single_product($product);
      echo "</li>";
    endforeach ?>
  </ul>
<?php }

// Recebe um array  com objetos do tipo produto e retorna html formatado (Single pdt)
function theme_single_product($product)
{ ?>
  <a class='single-pdt' href="<?= $product['link'] ?>" title=<?= $product['name'] ?>>
    <div class='single-pdt__info'>
      <img class='single-pdt__image' src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>">
      <h2 class='single-pdt__title'><?= $product['name'] ?></h2>
      <div class="single-pdt__price">
        <?php
        if ($product['price']) :
          echo $product['price'];
          if ($product['promotion']) :
            echo "<span class='single-pdt__promotion'>" . $product['promotion_value'] .  "% <i>OFF</i></span>";
          endif;
        else :
          echo "<span class='only-quote'>Sob Consulta</span>";
        endif;

        ?>
      </div>
    </div>

    <div class='single-pdt__overlay'>
      <span class="btn">Ver Mais</span>
    </div>
  </a>
<?php }
