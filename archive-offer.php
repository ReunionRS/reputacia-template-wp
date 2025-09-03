<?php get_header(); ?>

<section class="hero" style="min-height: 50vh; background: var(--bg-soft);">
    <div class="hero-content container">
        <h1>Все наши предложения</h1>
        <p>Выберите подходящий модульный дом из полной коллекции или закажите индивидуальный проект</p>
        <div class="hero-actions">
            <button class="cta" data-open="calculator">РАССЧИТАТЬ СТОИМОСТЬ</button>
            <button class="button" data-open="callback">ЗАКАЗАТЬ ЗВОНОК</button>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="cards">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('offer-card'); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/default-house.jpg" alt="<?php the_title(); ?>">
                            </a>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p style="color:var(--muted);font-size:14px;margin:0 0 12px">
                                <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                            </p>
                            
                            <?php
                            $features = get_field('features');
                            if ($features) :
                            ?>
                            <div class="features">
                                <?php foreach ($features as $feature) : ?>
                                    <span class="feature-tag"><?php echo esc_html($feature['feature']); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php $price = get_field('price'); if ($price) : ?>
                            <div class="price">от <?php echo number_format($price, 0, '', ' '); ?> ₽</div>
                            <?php endif; ?>
                            
                            <div class="btns">
                                <a href="<?php the_permalink(); ?>" class="button primary">Подробнее</a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php
            $pagination = paginate_links([
                'total' => $wp_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
                'format' => '?paged=%#%',
                'show_all' => false,
                'prev_next' => true,
                'prev_text' => '← Предыдущая',
                'next_text' => 'Следующая →'
            ]);
            
            if ($pagination) :
            ?>
            <div class="pagination-wrapper" style="margin-top: 60px; text-align: center;">
                <div class="pagination" style="display: inline-flex; gap: 8px; align-items: center;">
                    <?php echo $pagination; ?>
                </div>
            </div>
            <?php endif; ?>
            
        <?php else : ?>
            <div style="text-align: center; padding: 60px 0;">
                <h2>Предложения пока не добавлены</h2>
                <p style="color: var(--muted);">Скоро здесь появятся наши предложения модульных домов</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Модальные окна -->
<div class="modal" id="modal-callback">
    <div class="modal-dialog" role="dialog" aria-modal="true">
        <div class="modal-header">
            <h3>Перезвоните мне</h3>
            <button class="close" data-close>&times;</button>
        </div>
        <form id="callback-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
            <?php wp_nonce_field('callback_form_nonce', 'callback_nonce'); ?>
            <input type="hidden" name="action" value="submit_callback_form">
            
            <label for="cb-name">Имя *</label>
            <input id="cb-name" name="name" required>
            
            <label for="cb-phone">Телефон *</label>
            <input id="cb-phone" name="phone" required>
            
            <button type="submit" class="cta submit">Жду звонка</button>
        </form>
    </div>
</div>

<div class="modal" id="modal-calculator">
    <div class="modal-dialog" role="dialog" aria-modal="true">
        <div class="modal-header">
            <h3>Калькулятор стоимости</h3>
            <button class="close" data-close>&times;</button>
        </div>
        <form id="calc-form">
            <label for="area">Площадь, м²</label>
            <input id="area" name="area" type="number" min="10" step="1" value="36">
            
            <label for="finish">Отделка</label>
            <select id="finish" name="finish">
                <option value="0">Базовая</option>
                <option value="1">Комфорт</option>
                <option value="2">Премиум</option>
            </select>
            
            <label for="windows">Панорамные окна (шт)</label>
            <input id="windows" name="windows" type="number" min="0" step="1" value="2">
            
            <p><strong>Итого: <span id="calc-result">—</span></strong></p>
            
            <button type="button" class="cta submit" data-open="callback">Оставить заявку</button>
        </form>
    </div>
</div>

<button class="fab" data-open="callback">Связаться</button>

<?php get_footer(); ?>