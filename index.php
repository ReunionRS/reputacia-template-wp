<?php get_header(); ?>

<section class="hero" id="top">
    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('full', array('class' => 'hero-bg', 'alt' => get_the_title())); ?>
    <?php else : ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-house.jpg" alt="Модульный дом" class="hero-bg">
    <?php endif; ?>
    
    <div class="hero-content container">
        <h1><?php echo get_theme_mod('hero_title', 'Репутация<br>Модульное строительство.'); ?></h1>
        <p><?php echo get_theme_mod('hero_description', 'Быстровозводимые бытовки, бани, дома в Ижевске и УР. Профессиональное строительство модульных зданий любой сложности.'); ?></p>
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
        
        <!-- Фильтр предложений -->
        <div class="projects-nav">
            <button class="active" data-filter="all">Все предложения</button>
            <button data-filter="house">Дома</button>
            <button data-filter="bath">Бани</button>
            <button data-filter="cabin">Бытовки</button>
            <button data-filter="commercial">Коммерческие</button>
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
                    $offer_type = get_post_meta(get_the_ID(), '_offer_type', true);
            ?>
            <article class="card" data-category="<?php echo esc_attr($offer_type ?: 'house'); ?>">
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
                    <div class="price"> <?php echo number_format($price, 0, '', ' '); ?> ₽</div>
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

<!-- Блок О нас -->
<section class="section about-section" id="about">
    <div class="container">
        <?php
        $about_query = new WP_Query(array(
            'post_type' => 'about_us',
            'posts_per_page' => 1,
            'post_status' => 'publish'
        ));
        
        if ($about_query->have_posts()) :
            while ($about_query->have_posts()) : $about_query->the_post();
                $about_image_id = get_post_meta(get_the_ID(), '_about_us_image', true);
                $about_image_url = $about_image_id ? wp_get_attachment_image_url($about_image_id, 'large') : '';
        ?>
        <div class="about-content-grid">
            <div class="about-map">
                <?php if ($about_image_url) : ?>
                    <img src="<?php echo esc_url($about_image_url); ?>" alt="<?php the_title(); ?>">
                <?php else : ?>
                    <div>Тут изображение</div>
                <?php endif; ?>
            </div>
            <div class="about-text">
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </div>
        </div>
        <?php 
            endwhile;
            wp_reset_postdata();
        else :
        ?>
        <div class="about-content-grid">
            <div class="about-text">
                <h2>О компании Репутация</h2>
                <p>Мы специализируемся на производстве и установке модульных зданий в Ижевске и Удмуртской Республике. Наша команда имеет многолетний опыт в строительстве быстровозводимых домов, бань и бытовок.</p>
                <p>Используем только качественные материалы и современные технологии. Каждый проект выполняется с гарантией качества и в кратчайшие сроки.</p>
            </div>
            <div class="about-map">
                <div>Тут изображение</div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Блок Технология строительства -->
<section class="section technology-section" id="technology">
    <div class="container">
        <?php
        $tech_query = new WP_Query(array(
            'post_type' => 'technology',
            'posts_per_page' => 1,
            'post_status' => 'publish'
        ));
        
        if ($tech_query->have_posts()) :
            while ($tech_query->have_posts()) : $tech_query->the_post();
                $tech_image_id = get_post_meta(get_the_ID(), '_technology_image', true);
                $tech_image_url = $tech_image_id ? wp_get_attachment_image_url($tech_image_id, 'large') : '';
        ?>
        <div class="technology-content-grid">
            <div class="technology-text">
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </div>
            <div class="technology-image">
                <?php if ($tech_image_url) : ?>
                    <img src="<?php echo esc_url($tech_image_url); ?>" alt="<?php the_title(); ?>">
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/technology.jpg" alt="Технология строительства">
                <?php endif; ?>
            </div>
        </div>
        <?php 
            endwhile;
            wp_reset_postdata();
        else :
        ?>
        <div class="technology-content-grid">
            <div class="technology-text">
                <h2>Технология модульного строительства</h2>
                <p>Наша технология строительства основана на современных методах модульного строительства, обеспечивающих высокую скорость возведения и отличное качество.</p>
            </div>
            <div class="technology-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/technology.jpg" alt="Технология строительства">
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Блок Наши проекты -->
<section class="section" id="portfolio">
    <div class="container">
        <h2>Наши проекты</h2>
        <p class="sub">Готовые проекты модульных домов и бань с индивидуальной планировкой</p>
        
        <div class="projects-carousel-container">
            <div class="projects-carousel">
                <div class="projects-carousel-track">
                    <?php
                    $projects_query = new WP_Query(array(
                        'post_type' => 'project',
                        'posts_per_page' => -1,
                        'post_status' => 'publish'
                    ));
                    
                    if ($projects_query->have_posts()) :
                        while ($projects_query->have_posts()) : $projects_query->the_post();
                            $project_type = get_post_meta(get_the_ID(), '_project_type', true);
                            $project_series = get_post_meta(get_the_ID(), '_project_series', true);
                            $area = get_post_meta(get_the_ID(), '_project_area', true);
                            $price = get_post_meta(get_the_ID(), '_project_price', true);
                    ?>
                    <div class="project-carousel-slide">
                        <div class="project-carousel-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="project-carousel-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="project-carousel-body">
                                <?php if ($project_series) : ?>
                                    <div class="project-series-badge"><?php echo esc_html($project_series); ?></div>
                                <?php endif; ?>
                                
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                
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
                                                 <?php echo number_format($price, 0, '', ' '); ?> ₽
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <p class="project-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                
                                <div class="project-carousel-actions">
                                    <a href="<?php the_permalink(); ?>" class="button primary">Подробнее</a>
                                    <button class="button" data-open="callback">Заказать</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
            
            <!-- Навигация карусели -->
            <div class="projects-carousel-nav">
                <button class="carousel-btn carousel-prev" aria-label="Предыдущий проект">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.41 16.58L10.83 12L15.41 7.42L14 6L8 12L14 18L15.41 16.58Z" fill="currentColor"/>
                    </svg>
                </button>
                <button class="carousel-btn carousel-next" aria-label="Следующий проект">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.59 16.58L13.17 12L8.59 7.42L10 6L16 12L10 18L8.59 16.58Z" fill="currentColor"/>
                    </svg>
                </button>
            </div>
            
            <!-- Индикаторы -->
            <div class="projects-carousel-indicators">
            </div>
        </div>
    </div>
</section>

<!-- Блок отзывов -->
<section class="section reviews-section" id="reviews">
    <div class="container">
        <div class="reviews-header">
            <h2>Отзывы наших клиентов</h2>
            <p class="sub">Более 200 довольных клиентов уже получили дома своей мечты</p>
        </div>
        
        <div class="reviews-grid">
            <?php
            $reviews_query = new WP_Query(array(
                'post_type' => 'review',
                'posts_per_page' => 6,
                'post_status' => 'publish'
            ));
            
            if ($reviews_query->have_posts()) :
                while ($reviews_query->have_posts()) : $reviews_query->the_post();
                    $review_project = get_post_meta(get_the_ID(), '_review_project', true);
                    $review_location = get_post_meta(get_the_ID(), '_review_location', true);
            ?>
            <div class="review-card">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="review-image">
                        <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                    </div>
                <?php endif; ?>
                
                <div class="review-content">
                    <div class="review-header">
                        <h3><?php the_title(); ?></h3>
                        <?php if ($review_project) : ?>
                            <div class="review-project"><?php echo esc_html($review_project); ?></div>
                        <?php endif; ?>
                        <?php if ($review_location) : ?>
                            <div class="review-location"><?php echo esc_html($review_location); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="review-text">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            else :
            ?>
            <?php endif; ?>
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
                <h3>Наш офис</h3>
                <div class="contact-map-container">
                    <div style="position:relative;overflow:hidden;width:100%;height:400px;border-radius:16px;">
                        <iframe src="https://yandex.ru/map-widget/v1/?ll=53.351456%2C56.892370&mode=whatshere&whatshere%5Bpoint%5D=53.351457%2C56.892370&whatshere%5Bzoom%5D=17&z=17" 
                                width="100%" 
                                height="100%" 
                                frameborder="1" 
                                allowfullscreen="true" 
                                style="position:relative;border:none;border-radius:16px;">
                        </iframe>
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
                        • Монтаж и установка от 1 дня<br>
                        • Гарантия
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>