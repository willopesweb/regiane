<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php bloginfo('name'); ?><?php wp_title('|'); ?></title>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <script>
    if (localStorage.getItem("dark-mode") === 'enabled') {
      document.body.classList.add('dark-theme');
    }
  </script>
  <div id="skip"><a href="#content">Pular para o Conteúdo</a></div>

  <header class="l-header" role="banner">
    <div class="l-header__content">
      <h1 class="screen-readers-only">Regiane Silva</h1>
      <div class='toggle-switch'>
        <label>
          <input type='checkbox' class='js-toggle-dark-mode'>
          <span class='slider'></span>
        </label>
      </div>
      <div class="l-header__logo">
        <?php include ASSETS_DIR . '/img/books.svg' ?>
        <?php include ASSETS_DIR . '/img/logo.svg' ?>
        <?php include ASSETS_DIR . '/img/coffee.svg' ?>
      </div>
    </div>
    <nav id="nav" class="c-nav" role="navigation">
      <h1 class="screen-readers-only">Menu Principal</h1>
      <?php
      wp_nav_menu([
        'menu' => 'Menu Principal',
        'container' => 'ul',
        'menu_class' => 'c-nav__menu',
        'menu_id' => 'menu',
        'container_aria_label' => 'main navigation'
      ]);
      ?>
      <!-- MENU TOGGLE BUTTON -->
      <a href="#nav" class="c-nav__toggle" role="button" aria-expanded="false" aria-controls="menu">
        <svg class="menuicon" width="50" height="50" viewBox="0 0 50 50">
          <title>Toggle Menu</title>
          <g>
            <line class="menuicon__bar" x1="13" y1="16.5" x2="37" y2="16.5" />
            <line class="menuicon__bar" x1="13" y1="24.5" x2="37" y2="24.5" />
            <line class="menuicon__bar" x1="13" y1="24.5" x2="37" y2="24.5" />
            <line class="menuicon__bar" x1="13" y1="32.5" x2="37" y2="32.5" />
            <circle class="menuicon__circle" r="23" cx="25" cy="25" />
          </g>
        </svg>
      </a>

      <!-- ANIMATED BACKGROUND ELEMENT -->
      <div class="splash"></div>

    </nav>
  </header>

  <script async>
    const nav = document.querySelector('#nav');
    const menu = document.querySelector('#menu');
    const menuToggle = document.querySelector('.c-nav__toggle');

    let isMenuOpen = false;

    //TOGGLE DARK MODE
    const darkToggle = document.querySelector('.js-toggle-dark-mode');

    const enableDarkMode = () => {
      document.body.classList.add('dark-theme');
      localStorage.setItem("dark-mode", "enabled");
    }

    const disableDarkMode = () => {
      document.body.classList.remove('dark-theme');
      localStorage.setItem("dark-mode", "disabled");
    }

    document.addEventListener('DOMContentLoaded', () => {
      darkMode = localStorage.getItem("dark-mode");
      if (darkMode === 'enabled') {
        darkToggle.checked = true;
      }
    });

    darkToggle.addEventListener('click', () => {
      darkMode = localStorage.getItem("dark-mode");
      if (darkMode === 'disabled') {
        enableDarkMode();
      } else {
        disableDarkMode();
      }
    })


    // TOGGLE MENU ACTIVE STATE
    menuToggle.addEventListener('click', e => {
      e.preventDefault();
      isMenuOpen = !isMenuOpen;

      let bodyOverflow = document.body.style.overflow;
      document.body.style.overflow = bodyOverflow === 'hidden' ? 'initial' : 'hidden';

      // toggle a11y attributes and active class
      menuToggle.setAttribute('aria-expanded', String(isMenuOpen));
      menu.hidden = !isMenuOpen;
      nav.classList.toggle('c-nav--open');
    });


    // TRAP TAB INSIDE NAV WHEN OPEN
    nav.addEventListener('keydown', e => {
      // abort if menu isn't open or modifier keys are pressed
      if (!isMenuOpen || e.ctrlKey || e.metaKey || e.altKey) {
        return;
      }

      // listen for tab press and move focus
      // if we're on either end of the navigation
      const menuLinks = menu.querySelectorAll('.menu-item');
      if (e.keyCode === 9) {
        if (e.shiftKey) {
          if (document.activeElement === menuLinks[0]) {
            menuToggle.focus();
            e.preventDefault();
          }
        } else if (document.activeElement === menuToggle) {
          menuLinks[0].focus();
          e.preventDefault();
        }
      }
    });
  </script>

  <?php
  /*   $to = 'willianlopes25@outlook.com';
  $subject = 'Assunto do Email';
  $message = 'Conteúdo do Email';
  $headers = array('Content-Type: text/html; charset=UTF-8');

  // Envie o email
  $result = wp_mail($to, $subject, $message, $headers);

  // Verifique se o email foi enviado com sucesso
  if ($result) {
    echo 'Email enviado com sucesso!';
  } else {
    echo 'Erro ao enviar o email.';
  } */
  ?>