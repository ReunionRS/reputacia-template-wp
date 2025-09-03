<?php
// single-offer.php - улучшенный шаблон для отдельного предложения
get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
    $area = get_post_meta(get_the_ID(), '_offer_area', true);
    $price = get_post_meta(get_the_ID(), '_offer_price', true);
    $features = get_post_meta(get_the_ID(), '_offer_features', true);
    $project_description = get_post_meta(get_the_ID(), '_offer_project_description', true);
    $frame_spec = get_post_meta(get_the_ID(), '_offer_frame_spec', true);
    $windows_spec = get_post_meta(get_the_ID(), '_offer_windows_spec', true);
    $electrical_spec = get_post_meta(get_the_ID(), '_offer_electrical_spec', true);
    $interior_spec = get_post_meta(get_the_ID(), '_offer_interior_spec', true);
    $includes = get_post_meta(get_the_ID(), '_offer_includes', true);
?>

<section class="offer-hero">
    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('full', array('class' => 'offer-hero-bg', 'alt' => get_the_title())); ?>
    <?php else : ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-house.jpg" alt="<?php the_title(); ?>" class="offer-hero-bg">
    <?php endif; ?>
    
    <div class="offer-hero-content">
        <div class="container">
            <div class="offer-hero-inner">
                <div class="offer-hero-text">
                    <h1><?php the_title(); ?></h1>
                    <?php if (get_the_excerpt()) : ?>
                        <p class="offer-hero-description"><?php echo get_the_excerpt(); ?></p>
                    <?php endif; ?>
                    
                    <div class="offer-hero-features">
                        <?php if ($area) : ?>
                            <div class="feature-item">
                                <span class="feature-label">Площадь</span>
                                <span class="feature-value"><?php echo $area; ?> м²</span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($price) : ?>
                            <div class="feature-item price-feature">
                                <span class="feature-label">Цена</span>
                                <span class="feature-value price">от <?php echo number_format($price, 0, '', ' '); ?> ₽</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="offer-hero-actions">
                        <button class="cta" data-open="calculator">Рассчитать стоимость</button>
                        <button class="button" data-open="callback">Заказать консультацию</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($features) : ?>
<section class="offer-quick-info">
    <div class="container">
        <div class="quick-info-grid">
            <?php 
            $features_array = explode(',', $features);
            foreach (array_slice($features_array, 0, 4) as $feature) : 
            ?>
                <div class="quick-info-card">
                    <div class="quick-info-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 16.17L4.83 12L3.41 13.41L9 19L21 7L19.59 5.59L9 16.17Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <div class="quick-info-text"><?php echo trim($feature); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="offer-content">
    <div class="container">
        <div class="offer-content-grid">
            <div class="offer-main">
                <?php if ($project_description || get_the_content()) : ?>
                <div class="offer-description">
                    <h2>Описание проекта</h2>
                    <?php if ($project_description) : ?>
                        <?php echo wpautop(esc_html($project_description)); ?>
                    <?php else : ?>
                        <?php the_content(); ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <?php if ($frame_spec || $windows_spec || $electrical_spec || $interior_spec) : ?>
                <div class="offer-specs">
                    <h3>Технические характеристики</h3>
                    <div class="specs-grid">
                        <?php if ($frame_spec) : ?>
                        <div class="spec-item">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 20V14H14V20H19V12H22L12 3L2 12H5V20H10Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <h4>Силовой каркас</h4>
                                <p><?php echo esc_html($frame_spec); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($windows_spec) : ?>
                        <div class="spec-item">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 3H21V21H3V3ZM5 5V19H19V5H5ZM11 7V11H7V13H11V17H13V13H17V11H13V7H11Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <h4>Окна</h4>
                                <p><?php echo esc_html($windows_spec); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($electrical_spec) : ?>
                        <div class="spec-item">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 21H10L6.5 14H11L9.5 7L14 14H9.5L11 21ZM12.5 2L13 4H17V6H15L11.5 16H8.5L12 6H10V4H12.5L12.5 2Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <h4>Электропроводка</h4>
                                <p><?php echo esc_html($electrical_spec); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($interior_spec) : ?>
                        <div class="spec-item">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L13.09 6.26L18 5L16.74 9.91L22 11L17.74 12.09L19 17L14.09 15.74L13 20L11.91 15.74L7 17L8.26 12.09L3 11L7.26 9.91L6 5L10.91 6.26L12 2Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <h4>Внутренняя отделка</h4>
                                <p><?php echo esc_html($interior_spec); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="offer-sidebar">
                <div class="offer-card">
                    <div class="offer-card-header">
                        <h3><?php the_title(); ?></h3>
                        <?php if ($price) : ?>
                            <div class="offer-price">
                                <span class="price-from">от</span>
                                <span class="price-amount"><?php echo number_format($price, 0, '', ' '); ?></span>
                                <span class="price-currency">₽</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="offer-card-body">
                        <?php if ($includes) : ?>
                        <ul class="offer-includes">
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
                        <?php else : ?>
                        <ul class="offer-includes">
                            <li>Проект и чертежи</li>
                            <li>Производство модулей</li>
                            <li>Доставка на участок</li>
                            <li>Установка от 1 дня</li>
                            <li>Гарантия</li>
                        </ul>
                        <?php endif; ?>
                        
                        <div class="offer-actions">
                            <button class="cta full-width" data-open="callback">Заказать проект</button>
                            <button class="button full-width" data-open="calculator">Калькулятор стоимости</button>
                        </div>
                    </div>
                </div>
                
                <div class="contact-card">
                    <h4>Есть вопросы?</h4>
                    <p>Наш специалист ответит на все вопросы и поможет с выбором проекта</p>
                    <div class="contact-phone">
                        <a href="tel:<?php echo str_replace(array(' ', '(', ')', '-'), '', get_theme_mod('phone_number', '+7 (891) 200-74-33')); ?>">
                            <?php echo get_theme_mod('phone_number', '+7 (891) 200-74-33'); ?>
                        </a>
                    </div>
                    <div class="contact-hours">Ежедневно, без выходных</div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
$gallery = get_post_meta(get_the_ID(), '_offer_gallery', true);
if ($gallery && !empty(array_filter($gallery))) : 
    $gallery_images = array_filter($gallery); 
?>
<section class="offer-gallery">
    <div class="container">
        <h2>Галерея предложения</h2>
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

<section class="offer-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Получите готовый объект уже завтра!</h2>
            <p>Заполните форму ниже и получите персональное предложение с расчетом стоимости</p>
            <div class="cta-actions">
                <button class="cta large" data-open="callback">Получить предложение</button>
                <div class="cta-note">Бесплатная консультация и расчет стоимости</div>
            </div>
        </div>
    </div>
</section>
<?php endwhile; endif; ?>

<?php get_footer(); ?>