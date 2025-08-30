<?php
if (!defined('ABSPATH')) {
    exit;
}

function reputacia_theme_setup() {
    add_theme_support('title-tag');
    
    add_theme_support('post-thumbnails');
    
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ]);
    
    add_theme_support('custom-logo', [
        'height' => 36,
        'width' => 36,
        'flex-height' => true,
        'flex-width' => true
    ]);
    
    register_nav_menus([
        'primary' => __('Главное меню', 'reputacia')
    ]);
}
add_action('after_setup_theme', 'reputacia_theme_setup');

function reputacia_enqueue_assets() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
    wp_enqueue_style('reputacia-style', get_stylesheet_uri(), [], '1.0.0');
    wp_enqueue_script('reputacia-script', get_template_directory_uri() . '/assets/js/app.js', [], '1.0.0', true);
    wp_localize_script('reputacia-script', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('reputacia_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'reputacia_enqueue_assets');

function reputacia_register_post_types() {
    register_post_type('offer', [
        'labels' => [
            'name' => 'Предложения',
            'singular_name' => 'Предложение',
            'add_new' => 'Добавить предложение',
            'add_new_item' => 'Добавить новое предложение',
            'edit_item' => 'Редактировать предложение',
            'new_item' => 'Новое предложение',
            'view_item' => 'Посмотреть предложение',
            'search_items' => 'Искать предложения',
            'not_found' => 'Предложения не найдены',
            'not_found_in_trash' => 'В корзине предложений не найдено'
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
        'menu_icon' => 'dashicons-admin-home',
        'rewrite' => ['slug' => 'offers']
    ]);
    
    register_post_type('project', [
        'labels' => [
            'name' => 'Проекты',
            'singular_name' => 'Проект',
            'add_new' => 'Добавить проект',
            'add_new_item' => 'Добавить новый проект',
            'edit_item' => 'Редактировать проект',
            'new_item' => 'Новый проект',
            'view_item' => 'Посмотреть проект',
            'search_items' => 'Искать проекты',
            'not_found' => 'Проекты не найдены',
            'not_found_in_trash' => 'В корзине проектов не найдено'
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
        'menu_icon' => 'dashicons-building',
        'rewrite' => ['slug' => 'projects']
    ]);
}
add_action('init', 'reputacia_register_post_types');

function add_offer_meta_boxes() {
    add_meta_box(
        'offer_details',
        'Детали предложения',
        'offer_details_callback',
        'offer'
    );
}
add_action('add_meta_boxes', 'add_offer_meta_boxes');

function offer_details_callback($post) {
    wp_nonce_field('offer_meta_nonce', 'offer_meta_nonce');
    
    $area = get_post_meta($post->ID, '_offer_area', true);
    $price = get_post_meta($post->ID, '_offer_price', true);
    $features = get_post_meta($post->ID, '_offer_features', true);
    $project_description = get_post_meta($post->ID, '_offer_project_description', true);
    $frame_spec = get_post_meta($post->ID, '_offer_frame_spec', true);
    $windows_spec = get_post_meta($post->ID, '_offer_windows_spec', true);
    $electrical_spec = get_post_meta($post->ID, '_offer_electrical_spec', true);
    $interior_spec = get_post_meta($post->ID, '_offer_interior_spec', true);
    $includes = get_post_meta($post->ID, '_offer_includes', true);
    $gallery = get_post_meta($post->ID, '_offer_gallery', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="offer_area">Площадь (м²):</label></th><td><input type="number" id="offer_area" name="offer_area" value="' . esc_attr($area) . '" class="regular-text"></td></tr>';
    echo '<tr><th><label for="offer_price">Цена (₽):</label></th><td><input type="number" id="offer_price" name="offer_price" value="' . esc_attr($price) . '" class="regular-text"></td></tr>';
    echo '<tr><th><label for="offer_features">Особенности<br><small>(через запятую)</small>:</label></th><td><textarea id="offer_features" name="offer_features" rows="3" class="large-text">' . esc_textarea($features) . '</textarea></td></tr>';
    echo '<tr><th><label for="offer_project_description">Описание проекта:</label></th><td><textarea id="offer_project_description" name="offer_project_description" rows="5" class="large-text">' . esc_textarea($project_description) . '</textarea></td></tr>';
    echo '<tr><th colspan="2"><h3 style="margin: 20px 0 10px;">Технические характеристики</h3></th></tr>';
    echo '<tr><th><label for="offer_frame_spec">Силовой каркас:</label></th><td><textarea id="offer_frame_spec" name="offer_frame_spec" rows="3" class="large-text">' . esc_textarea($frame_spec) . '</textarea></td></tr>';
    echo '<tr><th><label for="offer_windows_spec">Окна:</label></th><td><textarea id="offer_windows_spec" name="offer_windows_spec" rows="3" class="large-text">' . esc_textarea($windows_spec) . '</textarea></td></tr>';
    echo '<tr><th><label for="offer_electrical_spec">Электропроводка:</label></th><td><textarea id="offer_electrical_spec" name="offer_electrical_spec" rows="3" class="large-text">' . esc_textarea($electrical_spec) . '</textarea></td></tr>';
    echo '<tr><th><label for="offer_interior_spec">Внутренняя отделка:</label></th><td><textarea id="offer_interior_spec" name="offer_interior_spec" rows="3" class="large-text">' . esc_textarea($interior_spec) . '</textarea></td></tr>';
    echo '<tr><th><label for="offer_includes">Что включено<br><small>(каждый пункт с новой строки)</small>:</label></th><td><textarea id="offer_includes" name="offer_includes" rows="5" class="large-text">' . esc_textarea($includes) . '</textarea></td></tr>';
    echo '<tr><th colspan="2"><h3 style="margin: 20px 0 10px;">Галерея проекта</h3></th></tr>';
    echo '<tr><th><label>Изображения галереи<br><small>(до 5 изображений)</small>:</label></th><td>';
    
    // Gallery uploader
    for ($i = 1; $i <= 5; $i++) {
        $image_id = isset($gallery["image_$i"]) ? $gallery["image_$i"] : '';
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
        
        echo '<div class="gallery-item" style="margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">';
        echo '<label style="font-weight: 600;">Изображение ' . $i . ':</label><br>';
        echo '<div class="image-preview" style="margin: 10px 0;">';
        if ($image_url) {
            echo '<img src="' . esc_url($image_url) . '" style="max-width: 150px; height: auto; display: block; margin-bottom: 10px;">';
        }
        echo '</div>';
        echo '<input type="hidden" id="gallery_image_' . $i . '" name="gallery_image_' . $i . '" value="' . esc_attr($image_id) . '">';
        echo '<button type="button" class="button gallery-upload" data-target="gallery_image_' . $i . '">Выбрать изображение</button> ';
        echo '<button type="button" class="button gallery-remove" data-target="gallery_image_' . $i . '" style="margin-left: 10px;">Удалить</button>';
        echo '</div>';
    }
    
    echo '</td></tr>';
    echo '</table>';
    
    // Add media uploader script
    echo '<script>
    jQuery(document).ready(function($) {
        
        $(".gallery-upload").click(function(e) {
            e.preventDefault();
            var target = $(this).data("target");
            var button = $(this);
            var preview = button.siblings(".image-preview");
            
            // Create new media uploader instance for each click
            var mediaUploader = wp.media({
                title: "Выберите изображение для галереи",
                button: { text: "Выбрать изображение" },
                multiple: false,
                library: { type: "image" }
            });
            
            // Remove any existing event listeners
            mediaUploader.off("select");
            
            mediaUploader.on("select", function() {
                var attachment = mediaUploader.state().get("selection").first().toJSON();
                $("#" + target).val(attachment.id);
                
                // Use different size fallbacks
                var imageUrl = attachment.url; // fallback to full size
                if (attachment.sizes) {
                    if (attachment.sizes.medium) {
                        imageUrl = attachment.sizes.medium.url;
                    } else if (attachment.sizes.thumbnail) {
                        imageUrl = attachment.sizes.thumbnail.url;
                    } else if (attachment.sizes.large) {
                        imageUrl = attachment.sizes.large.url;
                    }
                }
                
                preview.html("<img src=\"" + imageUrl + "\" style=\"max-width: 150px; height: auto; display: block; margin-bottom: 10px;\">");
            });
            
            mediaUploader.open();
        });
        
        $(".gallery-remove").click(function(e) {
            e.preventDefault();
            var target = $(this).data("target");
            var preview = $(this).siblings(".image-preview");
            $("#" + target).val("");
            preview.html("");
        });
    });
    </script>';
}

function save_offer_meta($post_id) {
    if (!isset($_POST['offer_meta_nonce']) || !wp_verify_nonce($_POST['offer_meta_nonce'], 'offer_meta_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    $fields = [
        'offer_area' => '_offer_area',
        'offer_price' => '_offer_price',
        'offer_features' => '_offer_features',
        'offer_project_description' => '_offer_project_description',
        'offer_frame_spec' => '_offer_frame_spec',
        'offer_windows_spec' => '_offer_windows_spec',
        'offer_electrical_spec' => '_offer_electrical_spec',
        'offer_interior_spec' => '_offer_interior_spec',
        'offer_includes' => '_offer_includes'
    ];
    
    foreach ($fields as $field_name => $meta_key) {
        if (isset($_POST[$field_name])) {
            if (in_array($field_name, ['offer_area', 'offer_price'])) {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field_name]));
            } else {
                update_post_meta($post_id, $meta_key, sanitize_textarea_field($_POST[$field_name]));
            }
        }
    }
    
    // Save gallery images
    $gallery = [];
    for ($i = 1; $i <= 5; $i++) {
        if (isset($_POST["gallery_image_$i"]) && !empty($_POST["gallery_image_$i"])) {
            $gallery["image_$i"] = intval($_POST["gallery_image_$i"]);
        }
    }
    update_post_meta($post_id, '_offer_gallery', $gallery);
}
add_action('save_post', 'save_offer_meta');

// Enqueue media uploader for admin
function enqueue_admin_media_uploader() {
    global $typenow;
    if (in_array($typenow, ['offer', 'project'])) {
        wp_enqueue_media();
        wp_enqueue_script('jquery');
    }
}
add_action('admin_enqueue_scripts', 'enqueue_admin_media_uploader');

function add_project_meta_boxes() {
    add_meta_box(
        'project_details',
        'Детали проекта',
        'project_details_callback',
        'project'
    );
    
    add_meta_box(
        'project_type',
        'Тип проекта',
        'project_type_callback',
        'project'
    );
}
add_action('add_meta_boxes', 'add_project_meta_boxes');

function project_details_callback($post) {
    wp_nonce_field('project_meta_nonce', 'project_meta_nonce');
    
    $area = get_post_meta($post->ID, '_project_area', true);
    $price = get_post_meta($post->ID, '_project_price', true);
    $features = get_post_meta($post->ID, '_project_features', true);
    $modules_count = get_post_meta($post->ID, '_project_modules_count', true);
    $dimensions = get_post_meta($post->ID, '_project_dimensions', true);
    $project_series = get_post_meta($post->ID, '_project_series', true);
    $frame_spec = get_post_meta($post->ID, '_project_frame_spec', true);
    $windows_spec = get_post_meta($post->ID, '_project_windows_spec', true);
    $electrical_spec = get_post_meta($post->ID, '_project_electrical_spec', true);
    $interior_spec = get_post_meta($post->ID, '_project_interior_spec', true);
    $exterior_spec = get_post_meta($post->ID, '_project_exterior_spec', true);
    $insulation_spec = get_post_meta($post->ID, '_project_insulation_spec', true);
    $includes = get_post_meta($post->ID, '_project_includes', true);
    $gallery = get_post_meta($post->ID, '_project_gallery', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="project_series">Серия проекта:</label></th><td><input type="text" id="project_series" name="project_series" value="' . esc_attr($project_series) . '" class="regular-text" placeholder="Скандинавия"></td></tr>';
    echo '<tr><th><label for="project_area">Площадь (м²):</label></th><td><input type="number" id="project_area" name="project_area" value="' . esc_attr($area) . '" class="regular-text"></td></tr>';
    echo '<tr><th><label for="project_price">Цена (₽):</label></th><td><input type="number" id="project_price" name="project_price" value="' . esc_attr($price) . '" class="regular-text"></td></tr>';
    echo '<tr><th><label for="project_modules_count">Количество модулей:</label></th><td><input type="number" id="project_modules_count" name="project_modules_count" value="' . esc_attr($modules_count) . '" class="regular-text"></td></tr>';
    echo '<tr><th><label for="project_dimensions">Размеры (LxWxH mm):</label></th><td><input type="text" id="project_dimensions" name="project_dimensions" value="' . esc_attr($dimensions) . '" class="regular-text" placeholder="4000x4000x2700"></td></tr>';
    echo '<tr><th><label for="project_features">Особенности:</label></th><td><textarea id="project_features" name="project_features" rows="3" class="large-text">' . esc_textarea($features) . '</textarea></td></tr>';
    echo '<tr><th colspan="2"><h3 style="margin: 20px 0 10px;">Технические характеристики</h3></th></tr>';
    echo '<tr><th><label for="project_frame_spec">Силовой каркас:</label></th><td><textarea id="project_frame_spec" name="project_frame_spec" rows="2" class="large-text">' . esc_textarea($frame_spec) . '</textarea></td></tr>';
    echo '<tr><th><label for="project_windows_spec">Окна и двери:</label></th><td><textarea id="project_windows_spec" name="project_windows_spec" rows="2" class="large-text">' . esc_textarea($windows_spec) . '</textarea></td></tr>';
    echo '<tr><th><label for="project_electrical_spec">Электропроводка:</label></th><td><textarea id="project_electrical_spec" name="project_electrical_spec" rows="2" class="large-text">' . esc_textarea($electrical_spec) . '</textarea></td></tr>';
    echo '<tr><th><label for="project_interior_spec">Внутренняя отделка:</label></th><td><textarea id="project_interior_spec" name="project_interior_spec" rows="2" class="large-text">' . esc_textarea($interior_spec) . '</textarea></td></tr>';
    echo '<tr><th><label for="project_exterior_spec">Внешняя отделка:</label></th><td><textarea id="project_exterior_spec" name="project_exterior_spec" rows="2" class="large-text">' . esc_textarea($exterior_spec) . '</textarea></td></tr>';
    echo '<tr><th><label for="project_insulation_spec">Утепление:</label></th><td><textarea id="project_insulation_spec" name="project_insulation_spec" rows="2" class="large-text">' . esc_textarea($insulation_spec) . '</textarea></td></tr>';
    echo '<tr><th><label for="project_includes">Что включено<br><small>(каждый пункт с новой строки)</small>:</label></th><td><textarea id="project_includes" name="project_includes" rows="5" class="large-text">' . esc_textarea($includes) . '</textarea></td></tr>';
    
    // Gallery for projects
    echo '<tr><th colspan="2"><h3 style="margin: 20px 0 10px;">Галерея проекта</h3></th></tr>';
    echo '<tr><th><label>Изображения галереи<br><small>(до 5 изображений)</small>:</label></th><td>';
    
    for ($i = 1; $i <= 5; $i++) {
        $image_id = isset($gallery["image_$i"]) ? $gallery["image_$i"] : '';
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
        
        echo '<div class="gallery-item" style="margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">';
        echo '<label style="font-weight: 600;">Изображение ' . $i . ':</label><br>';
        echo '<div class="image-preview" style="margin: 10px 0;">';
        if ($image_url) {
            echo '<img src="' . esc_url($image_url) . '" style="max-width: 150px; height: auto; display: block; margin-bottom: 10px;">';
        }
        echo '</div>';
        echo '<input type="hidden" id="project_gallery_image_' . $i . '" name="project_gallery_image_' . $i . '" value="' . esc_attr($image_id) . '">';
        echo '<button type="button" class="button project-gallery-upload" data-target="project_gallery_image_' . $i . '">Выбрать изображение</button> ';
        echo '<button type="button" class="button project-gallery-remove" data-target="project_gallery_image_' . $i . '" style="margin-left: 10px;">Удалить</button>';
        echo '</div>';
    }
    
    echo '</td></tr>';
    echo '</table>';
    
    // Add media uploader script for projects
    echo '<script>
    jQuery(document).ready(function($) {
        
        $(".project-gallery-upload").click(function(e) {
            e.preventDefault();
            var target = $(this).data("target");
            var button = $(this);
            var preview = button.siblings(".image-preview");
            
            var mediaUploader = wp.media({
                title: "Выберите изображение для галереи проекта",
                button: { text: "Выбрать изображение" },
                multiple: false,
                library: { type: "image" }
            });
            
            mediaUploader.off("select");
            
            mediaUploader.on("select", function() {
                var attachment = mediaUploader.state().get("selection").first().toJSON();
                $("#" + target).val(attachment.id);
                
                var imageUrl = attachment.url;
                if (attachment.sizes) {
                    if (attachment.sizes.medium) {
                        imageUrl = attachment.sizes.medium.url;
                    } else if (attachment.sizes.thumbnail) {
                        imageUrl = attachment.sizes.thumbnail.url;
                    } else if (attachment.sizes.large) {
                        imageUrl = attachment.sizes.large.url;
                    }
                }
                
                preview.html("<img src=\"" + imageUrl + "\" style=\"max-width: 150px; height: auto; display: block; margin-bottom: 10px;\">");
            });
            
            mediaUploader.open();
        });
        
        $(".project-gallery-remove").click(function(e) {
            e.preventDefault();
            var target = $(this).data("target");
            var preview = $(this).siblings(".image-preview");
            $("#" + target).val("");
            preview.html("");
        });
    });
    </script>';
}

function project_type_callback($post) {
    wp_nonce_field('project_type_nonce', 'project_type_nonce');
    
    $project_type = get_post_meta($post->ID, '_project_type', true);
    
    echo '<select name="project_type" class="regular-text">';
    echo '<option value="house"' . selected($project_type, 'house', false) . '>Дома</option>';
    echo '<option value="bath"' . selected($project_type, 'bath', false) . '>Бани</option>';
    echo '<option value="commercial"' . selected($project_type, 'commercial', false) . '>Коммерческие</option>';
    echo '</select>';
}

function save_project_meta($post_id) {
    if (isset($_POST['project_meta_nonce']) && wp_verify_nonce($_POST['project_meta_nonce'], 'project_meta_nonce')) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;
        
        $fields = [
            'project_area' => '_project_area',
            'project_price' => '_project_price',
            'project_features' => '_project_features',
            'project_modules_count' => '_project_modules_count',
            'project_dimensions' => '_project_dimensions',
            'project_series' => '_project_series',
            'project_frame_spec' => '_project_frame_spec',
            'project_windows_spec' => '_project_windows_spec',
            'project_electrical_spec' => '_project_electrical_spec',
            'project_interior_spec' => '_project_interior_spec',
            'project_exterior_spec' => '_project_exterior_spec',
            'project_insulation_spec' => '_project_insulation_spec',
            'project_includes' => '_project_includes'
        ];
        
        foreach ($fields as $field_name => $meta_key) {
            if (isset($_POST[$field_name])) {
                if (in_array($field_name, ['project_area', 'project_price', 'project_modules_count'])) {
                    update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field_name]));
                } else {
                    update_post_meta($post_id, $meta_key, sanitize_textarea_field($_POST[$field_name]));
                }
            }
        }
        
        // Save project gallery
        $gallery = [];
        for ($i = 1; $i <= 5; $i++) {
            if (isset($_POST["project_gallery_image_$i"]) && !empty($_POST["project_gallery_image_$i"])) {
                $gallery["image_$i"] = intval($_POST["project_gallery_image_$i"]);
            }
        }
        update_post_meta($post_id, '_project_gallery', $gallery);
    }
    
    if (isset($_POST['project_type_nonce']) && wp_verify_nonce($_POST['project_type_nonce'], 'project_type_nonce')) {
        if (isset($_POST['project_type'])) {
            update_post_meta($post_id, '_project_type', sanitize_text_field($_POST['project_type']));
        }
    }
}
add_action('save_post', 'save_project_meta');

// AJAX обработчики для форм
// AJAX обработчики для форм
function handle_contact_form() {
    // Проверяем nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'reputacia_nonce')) {
        wp_send_json_error('Ошибка безопасности');
        wp_die();
    }

    // Получаем и очищаем данные
    $name = sanitize_text_field($_POST['name']);
    $phone = sanitize_text_field($_POST['phone']);
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $form_type = isset($_POST['form_type']) ? sanitize_text_field($_POST['form_type']) : 'contact';
    
    // Дополнительные поля для калькулятора
    $area = isset($_POST['area']) ? sanitize_text_field($_POST['area']) : '';
    $finish = isset($_POST['finish']) ? sanitize_text_field($_POST['finish']) : '';
    $windows = isset($_POST['windows']) ? sanitize_text_field($_POST['windows']) : '';
    $calculated_price = isset($_POST['calculated_price']) ? sanitize_text_field($_POST['calculated_price']) : '';

    // Подготовка данных для email
    $to = get_option('admin_email');
    $subject = ($form_type === 'callback') ? 'Заказ обратного звонка' : 'Новая заявка с сайта';
    $subject .= ' - ' . get_bloginfo('name');

    $body = "Новая заявка:\n\n";
    $body .= "Имя: $name\n";
    $body .= "Телефон: $phone\n";
    
    if ($message) {
        $body .= "Сообщение: $message\n";
    }
    
    if ($area || $finish || $windows || $calculated_price) {
        $body .= "\nДанные из калькулятора:\n";
        if ($area) $body .= "Площадь: $area м²\n";
        if ($finish) $body .= "Отделка: $finish\n";
        if ($windows) $body .= "Окна: $windows шт\n";
        if ($calculated_price) $body .= "Рассчитанная стоимость: $calculated_price ₽\n";
    }
    
    $body .= "Тип формы: $form_type\n";
    $body .= "Дата: " . current_time('d.m.Y H:i') . "\n";
    $body .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";

    $headers = ['Content-Type: text/plain; charset=UTF-8'];

    // Отправляем email
    $email_sent = wp_mail($to, $subject, $body, $headers);

    // Создаем запись в кастомном типе записи
    $post_data = [
        'post_title' => ($form_type === 'callback') ? "Обратный звонок - $name" : "Заявка от $name",
        'post_content' => $message,
        'post_status' => 'private',
        'post_type' => 'contact_form',
        'meta_input' => [
            'contact_name' => $name,
            'contact_phone' => $phone,
            'contact_message' => $message,
            'form_type' => $form_type,
            'contact_area' => $area,
            'contact_finish' => $finish,
            'contact_windows' => $windows,
            'contact_calculated_price' => $calculated_price,
            'contact_date' => current_time('Y-m-d H:i:s'),
            'contact_ip' => $_SERVER['REMOTE_ADDR']
        ]
    ];
    
    $post_id = wp_insert_post($post_data);

if ($email_sent || $post_id) {
    $success_message = ($form_type === 'callback') ? 
        'Заявка принята! Мы перезвоним вам в ближайшее время.' : 
        'Заявка отправлена! Мы свяжемся с вами в течение 15 минут.';
        
    wp_send_json_success($success_message);
} else {
    wp_send_json_error('Ошибка отправки. Пожалуйста, попробуйте еще раз или позвоните нам напрямую.');
}
    
    wp_die();
}
add_action('wp_ajax_contact_form', 'handle_contact_form');
add_action('wp_ajax_nopriv_contact_form', 'handle_contact_form');

function register_contact_forms_post_type() {
    register_post_type('contact_form', [
        'labels' => [
            'name' => 'Заявки',
            'singular_name' => 'Заявка',
            'menu_name' => 'Заявки',
            'all_items' => 'Все заявки',
            'view_item' => 'Посмотреть заявку',
            'search_items' => 'Искать заявки',
            'not_found' => 'Заявки не найдены',
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'supports' => ['title', 'editor'],
        'menu_icon' => 'dashicons-email-alt',
        'capabilities' => [
            'create_posts' => false,
        ],
        'map_meta_cap' => true,
    ]);
}
add_action('init', 'register_contact_forms_post_type');

function add_contact_form_meta_boxes() {
    add_meta_box(
        'contact_form_details',
        'Детали заявки',
        'contact_form_meta_box_callback',
        'contact_form',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_contact_form_meta_boxes');

function contact_form_meta_box_callback($post) {
    $name = get_post_meta($post->ID, 'contact_name', true);
    $phone = get_post_meta($post->ID, 'contact_phone', true);
    $message = get_post_meta($post->ID, 'contact_message', true);
    $form_type = get_post_meta($post->ID, 'form_type', true);
    $date = get_post_meta($post->ID, 'contact_date', true);
    $ip = get_post_meta($post->ID, 'contact_ip', true);
    
    // Данные из калькулятора
    $area = get_post_meta($post->ID, 'contact_area', true);
    $finish = get_post_meta($post->ID, 'contact_finish', true);
    $windows = get_post_meta($post->ID, 'contact_windows', true);
    $calculated_price = get_post_meta($post->ID, 'contact_calculated_price', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label>Имя:</label></th><td>' . esc_html($name) . '</td></tr>';
    echo '<tr><th><label>Телефон:</label></th><td><a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a></td></tr>';
    
    if ($message) {
        echo '<tr><th><label>Сообщение:</label></th><td>' . esc_html($message) . '</td></tr>';
    }
    
    echo '<tr><th><label>Тип формы:</label></th><td>' . esc_html($form_type === 'callback' ? 'Обратный звонок' : ($form_type === 'calculator' ? 'Калькулятор' : 'Обычная заявка')) . '</td></tr>';
    
    // Показываем данные калькулятора если есть
    if ($area || $finish || $windows || $calculated_price) {
        echo '<tr><th colspan="2"><h3>Данные из калькулятора</h3></th></tr>';
        if ($area) echo '<tr><th><label>Площадь:</label></th><td>' . esc_html($area) . ' м²</td></tr>';
        if ($finish) echo '<tr><th><label>Отделка:</label></th><td>' . esc_html($finish) . '</td></tr>';
        if ($windows) echo '<tr><th><label>Окна:</label></th><td>' . esc_html($windows) . ' шт</td></tr>';
        if ($calculated_price) echo '<tr><th><label>Рассчитанная стоимость:</label></th><td>' . esc_html($calculated_price) . '</td></tr>';
    }
    
    echo '<tr><th><label>Дата:</label></th><td>' . esc_html($date ?: get_the_date('d.m.Y H:i', $post->ID)) . '</td></tr>';
    if ($ip) echo '<tr><th><label>IP адрес:</label></th><td>' . esc_html($ip) . '</td></tr>';
    echo '</table>';
}

function reputacia_image_sizes() {
    add_image_size('project-thumb', 400, 240, true);
    add_image_size('offer-thumb', 400, 280, true);
    add_image_size('hero-bg', 1920, 1080, true);
}
add_action('after_setup_theme', 'reputacia_image_sizes');

function reputacia_cleanup_head() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'reputacia_cleanup_head');

function disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if(post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('init', 'disable_comments_post_types_support');

function add_contact_form_columns($columns) {
    $new_columns = [];
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['contact_name'] = 'Имя';
    $new_columns['contact_phone'] = 'Телефон';
    $new_columns['form_type'] = 'Тип';
    $new_columns['date'] = 'Дата';
    return $new_columns;
}
add_filter('manage_contact_form_posts_columns', 'add_contact_form_columns');

function fill_contact_form_columns($column, $post_id) {
    switch ($column) {
        case 'contact_name':
            echo esc_html(get_post_meta($post_id, 'contact_name', true));
            break;
        case 'contact_phone':
            $phone = get_post_meta($post_id, 'contact_phone', true);
            echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
            break;
        case 'form_type':
            $type = get_post_meta($post_id, 'form_type', true);
            $type_labels = [
                'callback' => 'Обратный звонок',
                'calculator' => 'Калькулятор',
                'contact' => 'Заявка'
            ];
            echo esc_html($type_labels[$type] ?? $type);
            break;
        case 'contact_date':
            $date = get_post_meta($post_id, 'contact_date', true);
            echo esc_html($date ? date('d.m.Y H:i', strtotime($date)) : get_the_date('d.m.Y H:i', $post_id));
            break;
    }
}
add_action('manage_contact_form_posts_custom_column', 'fill_contact_form_columns', 10, 2);

function calculator_shortcode($atts) {
    $atts = shortcode_atts([
        'text' => 'Рассчитать стоимость',
        'class' => 'cta'
    ], $atts);
    
    return '<button class="' . esc_attr($atts['class']) . '" data-open="calculator">' . esc_html($atts['text']) . '</button>';
}
add_shortcode('calculator', 'calculator_shortcode');

function callback_shortcode($atts) {
    $atts = shortcode_atts([
        'text' => 'Заказать звонок',
        'class' => 'cta'
    ], $atts);
    
    return '<button class="' . esc_attr($atts['class']) . '" data-open="callback">' . esc_html($atts['text']) . '</button>';
}
add_shortcode('callback', 'callback_shortcode');

?>