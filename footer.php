<footer class="footer">
    <div class="container">
        ©<?php echo date('Y'); ?> Репутация - модульные здания, ИП Лекомцев Алексей Павлович ИНН: <?php echo get_theme_mod('company_inn', '180904423155'); ?>
    </div>
</footer>

<button class="fab" data-open="callback">Связаться</button>

<!-- Callback Modal -->
<div class="modal" id="modal-callback">
    <div class="modal-dialog" role="dialog" aria-modal="true">
        <div class="modal-header">
            <h3>Перезвоните мне</h3>
            <button class="close" data-close>&times;</button>
        </div>
        <form id="callback-form" method="post">
            <label for="cb-name">Имя *</label>
            <input id="cb-name" name="name" required>
            <label for="cb-phone">Телефон *</label>
            <input id="cb-phone" name="phone" required>
            <input type="hidden" name="action" value="contact_form">
            <input type="hidden" name="form_type" value="callback">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('reputacia_nonce'); ?>">
            <button class="cta submit" type="submit">Жду звонка</button>
        </form>
    </div>
</div>

<!-- Cost Calculator Modal -->
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