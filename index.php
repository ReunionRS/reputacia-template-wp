<?php get_header(); ?>

<section class="hero" id="top">
    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('full', array('class' => 'hero-bg', 'alt' => get_the_title())); ?>
    <?php else : ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-house.jpg" alt="Модульный дом" class="hero-bg">
    <?php endif; ?>
    
    <div class="hero-content container">
        <h1><?php echo get_theme_mod('hero_title', 'Репутация<br>Модульное строительство.'); ?></h1>
        <p><?php echo get_theme_mod('hero_description', 'Быстровозводимые бани, дома в Ижевске и УР. Профессиональное строительство модульных зданий любой сложности.'); ?></p>
        <div class="hero-actions">
            <button class="cta" data-open="calculator">РАССЧИТАТЬ СТОИМОСТЬ</button>
            <button class="button" data-open="callback">ЗАКАЗАТЬ ЗВОНОК</button>
        </div>
    </div>
</section>

<section class="section" id="offers">
    <div class="container">
        <div class="offers-intro">
            <h2>Наши предложения</h2>
            <p>Выберите подходящий модульный дом из нашей коллекции или закажите индивидуальный проект</p>
        </div>
        <div class="cards">
            <?php
            $offers_query = new WP_Query(array(
                'post_type' => 'offer',
                'posts_per_page' => 6,
                'post_status' => 'publish'
            ));
            
            if ($offers_query->have_posts()) :
                while ($offers_query->have_posts()) : $offers_query->the_post();
                    $area = get_post_meta(get_the_ID(), '_offer_area', true);
                    $price = get_post_meta(get_the_ID(), '_offer_price', true);
                    $features = get_post_meta(get_the_ID(), '_offer_features', true);
            ?>
            <article class="card">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('medium_large', array('alt' => get_the_title())); ?>
                <?php endif; ?>
                <div class="card-body">
                    <h3><?php the_title(); ?></h3>
                    <p style="color:var(--muted);font-size:14px;margin:0 0 12px"><?php the_excerpt(); ?></p>
                    <?php if ($features) : ?>
                    <div class="features">
                        <?php 
                        $features_array = explode(',', $features);
                        foreach ($features_array as $feature) :
                        ?>
                        <span class="feature-tag"><?php echo trim($feature); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($price) : ?>
                    <div class="price">от <?php echo number_format($price, 0, '', ' '); ?> ₽</div>
                    <?php endif; ?>
                    <div class="btns">
                        <a href="<?php the_permalink(); ?>" class="button primary">Подробнее</a>
                    </div>
                </div>
            </article>
            <?php 
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<section class="section" id="projects">
    <div class="container">
        <h2>Реализованные проекты</h2>
        <p class="sub">Посмотрите на наши завершенные проекты и убедитесь в качестве нашей работы</p>
        <div class="projects-nav">
            <button class="active" data-filter="all">Все проекты</button>
            <button data-filter="house">Дома</button>
            <button data-filter="bath">Бани</button>
            <button data-filter="commercial">Коммерческие</button>
        </div>
<div class="projects-grid">
    <?php
    $projects_query = new WP_Query(array(
        'post_type' => 'project',
        'posts_per_page' => 6,
        'post_status' => 'publish'
    ));
    
    if ($projects_query->have_posts()) :
        while ($projects_query->have_posts()) : $projects_query->the_post();
            $project_type = get_post_meta(get_the_ID(), '_project_type', true);
            $project_series = get_post_meta(get_the_ID(), '_project_series', true);
            $area = get_post_meta(get_the_ID(), '_project_area', true);
            $price = get_post_meta(get_the_ID(), '_project_price', true);
    ?>
    <div class="project-card" data-category="<?php echo esc_attr($project_type); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <div class="project-card-image">
                <?php the_post_thumbnail('medium_large', array('alt' => get_the_title())); ?>
            </div>
        <?php endif; ?>
        
        <div class="project-card-body">
            <?php if ($project_series) : ?>
                <div class="project-series-badge"><?php echo esc_html($project_series); ?></div>
            <?php endif; ?>
            
            <h3><?php the_title(); ?></h3>
            
            <?php if ($area || $price) : ?>
                <div class="project-specs">
                    <?php if ($area) : ?>
                        <span class="spec-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3H21V21H3V3ZM5 5V19H19V5H5Z" fill="currentColor"/>
                            </svg>
                            <?php echo $area; ?>м²
                        </span>
                    <?php endif; ?>
                    
                    <?php if ($price) : ?>
                        <span class="spec-item price-spec">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12S6.48 22 12 22 22 17.52 22 12 17.52 2 12 2ZM13.5 6V7.5C14.61 7.5 15.5 8.39 15.5 9.5S14.61 11.5 13.5 11.5V13H10.5V11.5C9.39 11.5 8.5 10.61 8.5 9.5S9.39 7.5 10.5 7.5V6H13.5ZM10.5 9.5C10.5 9.22 10.72 9 11 9H13C13.28 9 13.5 9.22 13.5 9.5S13.28 10 13 10H11C10.72 10 10.5 9.78 10.5 9.5Z" fill="currentColor"/>
                            </svg>
                            от <?php echo number_format($price, 0, '', ' '); ?> ₽
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <p class="project-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
        </div>
        
        <div class="project-card-footer">
            <div class="project-type-badge">
                <?php 
                echo $project_type === 'house' ? 'Дом' : 
                    ($project_type === 'bath' ? 'Баня' : 'Коммерческое');
                ?>
            </div>
            
            <a href="<?php the_permalink(); ?>" class="project-view-link">
                Подробнее
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.59 16.58L13.17 12L8.59 7.42L10 6L16 12L10 18L8.59 16.58Z" fill="currentColor"/>
                </svg>
            </a>
        </div>
    </div>
    <?php 
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</div>
    </div>
</section>

<section class="section" id="contacts">
    <div class="container">
        <div class="contact-hero">
            <h2>Свяжитесь с нами для консультации и расчета стоимости вашего проекта</h2>
        </div>
        
        <div class="contact-grid">
            <div class="contact-form">
                <h3>Оставить заявку</h3>
                <form id="contact-form" method="post">
                    <label for="name">Имя</label>
                    <input id="name" name="name" required placeholder="Ваше имя">
                    <label for="phone">Телефон</label>
                    <input id="phone" name="phone" required placeholder="+7 (___) ___-__-__">
                    <label for="message">Сообщение</label>
                    <textarea id="message" name="message" placeholder="Расскажите о вашем проекте..."></textarea>
                    <input type="hidden" name="action" value="contact_form">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('reputacia_nonce'); ?>">
                    <button class="cta submit" type="submit">Отправить заявку</button>
                </form>
            </div>

            <div class="contact-info">
                <h3>ИП Лекомцев Алексей Павлович</h3>
                <div class="contact-item">
                    <div class="contact-item-title">Телефон производства</div>
                    <div class="contact-item-value">
                        <a href="tel:<?php echo str_replace(array(' ', '(', ')', '-'), '', get_theme_mod('phone_number', '+7 (891) 200-74-33')); ?>">
                            <?php echo get_theme_mod('phone_number', '+7 (891) 200-74-33'); ?>
                        </a>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-item-title">Email</div>
                    <div class="contact-item-value">
                        <a href="mailto:<?php echo get_theme_mod('email_address', 'info@reputacia-dom.ru'); ?>">
                            <?php echo get_theme_mod('email_address', 'info@reputacia-dom.ru'); ?>
                        </a>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-item-title">Адрес</div>
                    <div class="contact-item-value"><?php echo get_theme_mod('company_address', 'г. Ижевск, Удмуртская Республика'); ?></div>
                </div>
                <div class="contact-item">
                    <div class="contact-item-title">Режим работы</div>
                    <div class="contact-item-value">
                        Пн-Пт: 9:00-18:00<br>
                        Сб-Вс: по договоренности
                    </div>
                </div>
            </div>
        </div>

        <div class="company-details">
            <div class="company-grid">
                <div>
                    <h3>Реквизиты</h3>
                    <p><strong>ИНН:</strong> <?php echo get_theme_mod('company_inn', '180904423155'); ?></p>
                    <p><strong>Банк:</strong> <?php echo get_theme_mod('company_bank', 'Филиал «Нижегородский» АО «Альфа-Банк»'); ?></p>
                </div>
                <div class="services-section">
                    <h3>Наши услуги</h3>
                    <div class="services-list">
                        • Проектирование модульных зданий<br>
                        • Производство и поставка<br>
                        • Монтаж и установка<br>
                        • Гарантийное обслуживание
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>