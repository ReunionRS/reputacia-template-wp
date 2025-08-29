<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
    <div class="container header-inner">
        <a href="<?php echo home_url(); ?>" class="logo">
            <?php 
            $custom_logo_id = get_theme_mod('custom_logo');
            if ($custom_logo_id) :
                $logo_image = wp_get_attachment_image_src($custom_logo_id, 'full');
            ?>
                <img src="<?php echo $logo_image[0]; ?>" alt="<?php bloginfo('name'); ?>">
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Лого">
            <?php endif; ?>
            <div class="logo-text">
                <div class="logo-main"><?php echo get_theme_mod('logo_text', 'РЕПУТАЦИЯ'); ?></div>
                <div class="logo-subtitle"><?php echo get_theme_mod('logo_subtitle', 'СТРОИТЕЛЬНАЯ КОМПАНИЯ'); ?></div>
            </div>
        </a>
        
        <nav id="nav" class="nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => '',
                'container' => false,
                'fallback_cb' => function() {
                    echo '<a href="#about">О нас</a>';
                    echo '<a href="#projects">Проекты и цены</a>';
                    echo '<a href="#portfolio">Наши работы</a>';
                    echo '<a href="#contacts">Контакты</a>';
                }
            ));
            ?>
            <div class="phone">
                <?php echo get_theme_mod('phone_number', '+7 (891) 200-74-33'); ?>
                <div class="phone-hours">с 9:00 до 21:00, без выходных</div>
            </div>
            <button class="cta" data-open="callback">ЗАКАЗАТЬ ЗВОНОК</button>
        </nav>
        <button id="burger" class="burger">Меню</button>
    </div>
</header>