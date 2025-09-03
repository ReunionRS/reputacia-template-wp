<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-company">
                <div class="footer-logo">
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
                </div>
                <div class="footer-description">
                    <p>©<?php echo date('Y'); ?> Репутация - модульные здания<br>
                    ИП Лекомцев Алексей Павлович<br>
                    ИНН: <?php echo get_theme_mod('company_inn', '180904423155'); ?></p>
                </div>
            </div>

            <div class="footer-contacts">
                <h4>Контакты</h4>
                <div class="footer-contact-items">
                    <div class="footer-contact-item">
                        <strong>Телефон:</strong>
                        <a href="tel:<?php echo str_replace(array(' ', '(', ')', '-'), '', get_theme_mod('phone_number', '+7 (891) 200-74-33')); ?>">
                            <?php echo get_theme_mod('phone_number', '+7 (891) 200-74-33'); ?>
                        </a>
                    </div>
                    <div class="footer-contact-item">
                        <strong>Email:</strong>
                        <a href="mailto:<?php echo get_theme_mod('email_address', 'info@reputacia-dom.ru'); ?>">
                            <?php echo get_theme_mod('email_address', 'info@reputacia-dom.ru'); ?>
                        </a>
                    </div>
                    <div class="footer-contact-item">
                        <strong>Адрес:</strong>
                        <?php echo get_theme_mod('company_address', 'г. Ижевск, Удмуртская Республика'); ?>
                    </div>
                    <div class="footer-contact-item">
                        <strong>Режим работы:</strong>
                        Ежедневно, без выходных
                    </div>
                </div>
            </div>

            <div class="footer-social">
                <h4>Социальные сети</h4>
                <div class="social-links">
                    <a href="<?php echo get_theme_mod('vk_group', 'https://vk.com/reputacia_doma'); ?>" target="_blank" rel="noopener" class="social-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0zM19.5 16.5c0 1.38-.62 2-2 2h-1.5c-1.38 0-2-.62-2-2v-1.5h-2v1.5c0 1.38-.62 2-2 2H8.5c-1.38 0-2-.62-2-2V8.5c0-1.38.62-2 2-2h11c1.38 0 2 .62 2 2v8z"/>
                        </svg>
                        ВКонтакте
                    </a>
                    <a href="https://t.me/<?php echo str_replace('@', '', get_theme_mod('telegram_handle', '@izh_module')); ?>" target="_blank" rel="noopener" class="social-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.568 8.16l-1.58 7.44c-.12.539-.432.672-.864.42l-2.388-1.764-1.152 1.116c-.128.128-.236.236-.48.236l.168-2.388 4.32-3.9c.192-.168-.036-.264-.3-.096L9.816 12.82l-2.364-.744c-.516-.156-.528-.516.108-.768L19.044 7.68c.432-.156.804.108.66.48l-.136.003z"/>
                        </svg>
                        Telegram
                    </a>
                </div>
                
                <?php if (is_active_sidebar('footer-social')) : ?>
                    <div class="footer-widgets">
                        <?php dynamic_sidebar('footer-social'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<button class="fab" data-open="callback">Связаться</button>

<div class="modal" id="modal-callback">
    <div class="modal-dialog" role="dialog" aria-modal="true">
        <div class="modal-header">
            <h3>Перезвоните мне</h3>
            <button class="close" data-close>&times;</button>
        </div>
        <form id="callback-form" method="post">
            <label for="cb-name">Имя</label>
            <input id="cb-name" name="name" required>
            <label for="cb-phone">Телефон</label>
            <input id="cb-phone" name="phone" required>
            <input type="hidden" name="action" value="contact_form">
            <input type="hidden" name="form_type" value="callback">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('reputacia_nonce'); ?>">
            <button class="cta submit" type="submit">Отправить запрос на звонок</button>
        </form>
    </div>
</div>

<div class="modal" id="modal-calculator">
    <div class="modal-dialog" role="dialog" aria-modal="true">
        <div class="modal-header">
            <h3>Калькулятор стоимости</h3>
            <button class="close" data-close>&times;</button>
        </div>
        <form id="calc-form" method="post">
            <label for="area">Площадь, м²</label>
            <input id="area" name="area" type="number" min="10" step="1" value="36" required>
            
            <label for="finish">Отделка</label>
            <select id="finish" name="finish" required>
                <option value="Базовая">Базовая</option>
                <option value="Комфорт">Комфорт</option>
                <option value="Премиум">Премиум</option>
            </select>
            
            <label for="windows">Панорамные окна (шт)</label>
            <input id="windows" name="windows" type="number" min="0" step="1" value="2" required>
            
            <p><strong>Итого: <span id="calc-result">—</span></strong></p>
            
            <input type="hidden" name="calculated_price" id="calculated-price">
            <input type="hidden" name="action" value="contact_form">
            <input type="hidden" name="form_type" value="calculator">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('reputacia_nonce'); ?>">
            
            <button type="submit" class="cta submit">Оставить заявку</button>
        </form>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>