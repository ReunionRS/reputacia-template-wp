<?php
// single-project.php - шаблон для отдельного готового проекта
get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
    $area = get_post_meta(get_the_ID(), '_project_area', true);
    $price = get_post_meta(get_the_ID(), '_project_price', true);
    $features = get_post_meta(get_the_ID(), '_project_features', true);
    $modules_count = get_post_meta(get_the_ID(), '_project_modules_count', true);
    $dimensions = get_post_meta(get_the_ID(), '_project_dimensions', true);
    $project_series = get_post_meta(get_the_ID(), '_project_series', true);
    $frame_spec = get_post_meta(get_the_ID(), '_project_frame_spec', true);
    $windows_spec = get_post_meta(get_the_ID(), '_project_windows_spec', true);
    $electrical_spec = get_post_meta(get_the_ID(), '_project_electrical_spec', true);
    $interior_spec = get_post_meta(get_the_ID(), '_project_interior_spec', true);
    $exterior_spec = get_post_meta(get_the_ID(), '_project_exterior_spec', true);
    $insulation_spec = get_post_meta(get_the_ID(), '_project_insulation_spec', true);
    $includes = get_post_meta(get_the_ID(), '_project_includes', true);
    $gallery = get_post_meta(get_the_ID(), '_project_gallery', true);
?>

<section class="project-hero">
    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('full', array('class' => 'project-hero-bg', 'alt' => get_the_title())); ?>
    <?php else : ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-house.jpg" alt="<?php the_title(); ?>" class="project-hero-bg">
    <?php endif; ?>
    
    <div class="project-hero-content">
        <div class="container">
            <div class="project-hero-inner">
                <div class="project-hero-badge">
                    <?php if ($project_series) : ?>
                        <span class="project-series">Проект: <?php echo esc_html($project_series); ?></span>
                    <?php endif; ?>
                    <span class="project-type">
                        <?php 
                        $project_type = get_post_meta(get_the_ID(), '_project_type', true);
                        echo $project_type === 'house' ? 'Дом' : ($project_type === 'bath' ? 'Баня' : 'Коммерческое');
                        ?>
                    </span>
                </div>
                
                <h1><?php the_title(); ?></h1>
                
                <div class="project-quick-specs">
                    <?php if ($area) : ?>
                        <div class="quick-spec">
                            <span class="spec-label">Площадь</span>
                            <span class="spec-value"><?php echo $area; ?>м²</span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($modules_count) : ?>
                        <div class="quick-spec">
                            <span class="spec-label">Количество модулей</span>
                            <span class="spec-value"><?php echo $modules_count; ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($dimensions) : ?>
                        <div class="quick-spec">
                            <span class="spec-label">Размеры</span>
                            <span class="spec-value"><?php echo esc_html($dimensions); ?> mm</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($price) : ?>
                    <div class="project-price-hero">
                        <span class="price-label">Готовый проект "под ключ"</span>
                        <span class="price-amount"><?php echo number_format($price, 0, '', ' '); ?> ₽</span>
                    </div>
                <?php endif; ?>
                
                <div class="project-hero-actions">
                    <button class="cta large" data-open="callback">Заказать такой же</button>
                    <button class="button large" data-open="calculator">Рассчитать стоимость</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
if ($gallery && !empty(array_filter($gallery))) : 
    $gallery_images = array_filter($gallery);
?>
<section class="project-gallery-section">
    <div class="container">
        <h2>Галерея проекта</h2>
        <div class="gallery-slider">
            <div class="gallery-track">
                <?php foreach ($gallery_images as $key => $image_id) : 
                    $image_url = wp_get_attachment_image_url($image_id, 'large');
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: get_the_title();
                    if ($image_url) :
                ?>
                    <div class="gallery-slide">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
            
            <?php if (count($gallery_images) > 1) : ?>
            <button class="gallery-btn gallery-prev">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.41 16.58L10.83 12L15.41 7.42L14 6L8 12L14 18L15.41 16.58Z" fill="currentColor"/>
                </svg>
            </button>
            <button class="gallery-btn gallery-next">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.59 16.58L13.17 12L8.59 7.42L10 6L16 12L10 18L8.59 16.58Z" fill="currentColor"/>
                </svg>
            </button>
            
            <div class="gallery-dots">
                <?php foreach (array_keys($gallery_images) as $index => $key) : ?>
                    <button class="gallery-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>"></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="project-content">
    <div class="container">
        <div class="project-content-grid">
            <div class="project-main">
                <?php if (get_the_content()) : ?>
                <div class="project-description">
                    <h2>О проекте</h2>
                    <?php the_content(); ?>
                </div>
                <?php endif; ?>
                
                <div class="project-specifications">
                    <h2>Комплектация</h2>
                    
                    <div class="specs-grid">
                        <?php if ($frame_spec) : ?>
                        <div class="spec-card">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 20V14H14V20H19V12H22L12 3L2 12H5V20H10Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <h3>Силовой каркас</h3>
                                <p><?php echo esc_html($frame_spec); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($windows_spec) : ?>
                        <div class="spec-card">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 3H21V21H3V3ZM5 5V19H19V5H5ZM11 7V11H7V13H11V17H13V13H17V11H13V7H11Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <h3>Окна и двери</h3>
                                <p><?php echo esc_html($windows_spec); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($electrical_spec) : ?>
                        <div class="spec-card">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 21H10L6.5 14H11L9.5 7L14 14H9.5L11 21ZM12.5 2L13 4H17V6H15L11.5 16H8.5L12 6H10V4H12.5L12.5 2Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <h3>Электропроводка</h3>
                                <p><?php echo esc_html($electrical_spec); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($interior_spec) : ?>
                        <div class="spec-card">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L13.09 6.26L18 5L16.74 9.91L22 11L17.74 12.09L19 17L14.09 15.74L13 20L11.91 15.74L7 17L8.26 12.09L3 11L7.26 9.91L6 5L10.91 6.26L12 2Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <h3>Внутренняя отделка</h3>
                                <p><?php echo esc_html($interior_spec); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($exterior_spec) : ?>
                        <div class="spec-card">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <h3>Внешняя отделка</h3>
                                <p><?php echo esc_html($exterior_spec); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($insulation_spec) : ?>
                        <div class="spec-card">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12S6.48 22 12 22 22 17.52 22 12 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <h3>Утепление</h3>
                                <p><?php echo esc_html($insulation_spec); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="project-sidebar">
                <div class="project-order-card">
                    <h3>Заказать проект</h3>
                    
                    <?php if ($price) : ?>
                        <div class="order-price">
                            <span class="price-label">Стоимость под ключ</span>
                            <span class="price-amount"><?php echo number_format($price, 0, '', ' '); ?> ₽</span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($includes) : ?>
                    <div class="order-includes">
                        <h4>В стоимость входит:</h4>
                        <ul class="includes-list">
                            <?php 
                            $includes_array = explode("\n", $includes);
                            foreach ($includes_array as $include) : 
                                $include = trim($include);
                                if (!empty($include)) :
                            ?>
                                <li><?php echo esc_html($include); ?></li>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <div class="order-actions">
                        <button class="cta full-width" data-open="callback">Заказать проект</button>
                        <button class="button full-width" data-open="calculator">Рассчитать стоимость</button>
                    </div>
                    
                        <?php
                        $delivery_info = get_post_meta(get_the_ID(), '_project_delivery_info', true);
                        $delivery_items = $delivery_info ? explode("\n", $delivery_info) : [
                            '✓ Доставка по всей России',
                            '✓ Установка за 1 день',
                            '✓ Готовый дом "под ключ"',
                            '✓ Гарантия 5 лет'
                        ];
                        ?>

                        <?php if (!empty($delivery_items)) : ?>
                        <div class="delivery-info">
                            <h4>Доставка и установка</h4>
                            <ul class="delivery-list">
                                <?php foreach ($delivery_items as $item) : 
                                    $item = trim($item);
                                    if (!empty($item)) : ?>
                                        <li><?php echo esc_html($item); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                </div>
                
                <div class="project-contact-card">
                    <h4>Нужна консультация?</h4>
                    <p>Ответим на все вопросы и поможем с выбором проекта</p>
                    <div class="contact-phone">
                        <a href="tel:<?php echo str_replace(array(' ', '(', ')', '-'), '', get_theme_mod('phone_number', '+7 (891) 200-74-33')); ?>">
                            <?php echo get_theme_mod('phone_number', '+7 (891) 200-74-33'); ?>
                        </a>
                    </div>
                    <div class="contact-hours">Ежедневно,, без выходных</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="project-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Понравился проект?</h2>
            <p>Заполните форму ниже и получите готовый дом уже на следующий день после подписания договора!</p>
            <div class="cta-actions">
                <button class="cta large" data-open="callback">Получить предложение</button>
                <div class="cta-note">Бесплатная консультация и расчет стоимости</div>
            </div>
        </div>
    </div>
</section>
<?php endwhile; endif; ?>

<?php get_footer();