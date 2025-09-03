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

    register_post_type('about_us', [
        'labels' => [
            'name' => 'О компании',
            'singular_name' => 'О компании',
            'add_new' => 'Добавить блок',
            'add_new_item' => 'Добавить новый блок',
            'edit_item' => 'Редактировать блок',
            'new_item' => 'Новый блок',
            'view_item' => 'Посмотреть блок',
            'search_items' => 'Искать блоки',
            'not_found' => 'Блоки не найдены',
            'not_found_in_trash' => 'В корзине блоков не найдено'
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'menu_icon' => 'dashicons-info-outline',
    ]);

    register_post_type('technology', [
        'labels' => [
            'name' => 'Технология строительства',
            'singular_name' => 'Технология',
            'add_new' => 'Добавить технологию',
            'add_new_item' => 'Добавить новую технологию',
            'edit_item' => 'Редактировать технологию',
            'new_item' => 'Новая технологию',
            'view_item' => 'Посмотреть технологию',
            'search_items' => 'Искать технологии',
            'not_found' => 'Технологии не найдены',
            'not_found_in_trash' => 'В корзине технологий не найдено'
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'menu_icon' => 'dashicons-hammer',
    ]);
}
add_action('init', 'reputacia_register_post_types');

function add_about_us_meta_boxes() {
    add_meta_box(
        'about_us_image',
        'Изображение для блока "О компании"',
        'about_us_image_callback',
        'about_us',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_about_us_meta_boxes');

function reputacia_register_review_post_type() {
    register_post_type('review', [
        'labels' => [
            'name' => 'Отзывы',
            'singular_name' => 'Отзыв',
            'add_new' => 'Добавить отзыв',
            'add_new_item' => 'Добавить новый отзыв',
            'edit_item' => 'Редактировать отзыв',
            'new_item' => 'Новый отзыв',
            'view_item' => 'Посмотреть отзыв',
            'search_items' => 'Искать отзывы',
            'not_found' => 'Отзывы не найдены',
            'not_found_in_trash' => 'В корзине отзывов не найдено'
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'menu_icon' => 'dashicons-star-filled',
        'capabilities' => [
            'edit_post' => 'manage_options',
            'read_post' => 'manage_options', 
            'delete_post' => 'manage_options',
            'edit_posts' => 'manage_options',
            'edit_others_posts' => 'manage_options',
            'delete_posts' => 'manage_options',
            'publish_posts' => 'manage_options',
            'read_private_posts' => 'manage_options',
            'create_posts' => 'manage_options',
        ],
    ]);
}

remove_action('init', 'reputacia_register_review_post_type');
add_action('init', 'reputacia_register_review_post_type');

function add_review_meta_boxes() {
    add_meta_box(
        'review_details',
        'Детали отзыва',
        'review_details_callback',
        'review',
        'normal',
        'high'
    );
}

function review_details_callback($post) {
    wp_nonce_field('review_meta_nonce', 'review_meta_nonce');
    
    $review_project = get_post_meta($post->ID, '_review_project', true);
    $review_location = get_post_meta($post->ID, '_review_location', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="review_project">Проект:</label></th><td><input type="text" id="review_project" name="review_project" value="' . esc_attr($review_project) . '" class="regular-text" placeholder="Модульный дом «Модерн» 40м²"></td></tr>';
    echo '<tr><th><label for="review_location">Местоположение:</label></th><td><input type="text" id="review_location" name="review_location" value="' . esc_attr($review_location) . '" class="regular-text" placeholder="г. Ижевск"></td></tr>';
    echo '</table>';
}

function save_review_meta($post_id) {
    if (!isset($_POST['review_meta_nonce']) || !wp_verify_nonce($_POST['review_meta_nonce'], 'review_meta_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('manage_options')) return;
    
    if (isset($_POST['review_project'])) {
        update_post_meta($post_id, '_review_project', sanitize_text_field($_POST['review_project']));
    }
    
    if (isset($_POST['review_location'])) {
        update_post_meta($post_id, '_review_location', sanitize_text_field($_POST['review_location']));
    }
    
    delete_post_meta($post_id, '_review_rating');
}

remove_action('add_meta_boxes', 'add_review_meta_boxes');
remove_action('save_post_review', 'save_review_meta');
add_action('add_meta_boxes', 'add_review_meta_boxes');
add_action('save_post_review', 'save_review_meta');

function get_reviews($limit = -1) {
    $reviews_query = new WP_Query(array(
        'post_type' => 'review',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ));
    
    return $reviews_query;
}

function reviews_shortcode($atts) {
    $atts = shortcode_atts([
        'limit' => 6,
        'columns' => 3
    ], $atts);
    
    $reviews_query = get_reviews($atts['limit']);
    
    if (!$reviews_query->have_posts()) {
        return '<p>Отзывы пока не добавлены.</p>';
    }
    
    $output = '<div class="reviews-shortcode-grid" style="display: grid; grid-template-columns: repeat(' . $atts['columns'] . ', 1fr); gap: 20px;">';
    
    while ($reviews_query->have_posts()) : $reviews_query->the_post();
        $review_project = get_post_meta(get_the_ID(), '_review_project', true);
        $review_location = get_post_meta(get_the_ID(), '_review_location', true);
        
        $output .= '<div class="review-shortcode-item" style="background: var(--bg-soft); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">';
        
        if (has_post_thumbnail()) {
            $output .= '<div style="margin-bottom: 15px;">' . get_the_post_thumbnail('medium') . '</div>';
        }
        
        $output .= '<h4 style="margin: 0 0 10px; color: var(--text);">' . get_the_title() . '</h4>';
        
        if ($review_project) {
            $output .= '<div style="font-weight: bold; color: var(--accent); margin-bottom: 5px;">' . esc_html($review_project) . '</div>';
        }
        
        if ($review_location) {
            $output .= '<div style="font-size: 14px; color: var(--muted); margin-bottom: 15px;">' . esc_html($review_location) . '</div>';
        }
        
        $output .= '<div style="color: var(--muted); line-height: 1.6;">' . get_the_content() . '</div>';
        $output .= '</div>';
        
    endwhile;
    wp_reset_postdata();
    
    $output .= '</div>';
    
    return $output;
}

remove_shortcode('reviews');
add_shortcode('reviews', 'reviews_shortcode');

function add_review_columns($columns) {
    $new_columns = [];
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumbnail'] = 'Фото';
    $new_columns['title'] = $columns['title'];
    $new_columns['review_project'] = 'Проект';
    $new_columns['review_location'] = 'Место';
    $new_columns['date'] = 'Дата';
    return $new_columns;
}

function fill_review_columns($column, $post_id) {
    switch ($column) {
        case 'thumbnail':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(50, 50));
            } else {
                echo '—';
            }
            break;
        case 'review_project':
            echo esc_html(get_post_meta($post_id, '_review_project', true) ?: '—');
            break;
        case 'review_location':
            echo esc_html(get_post_meta($post_id, '_review_location', true) ?: '—');
            break;
    }
}

remove_filter('manage_review_posts_columns', 'add_review_columns');
remove_action('manage_review_posts_custom_column', 'fill_review_columns');
add_filter('manage_review_posts_columns', 'add_review_columns');
add_action('manage_review_posts_custom_column', 'fill_review_columns', 10, 2);

function review_admin_styles() {
    global $typenow;
    if ($typenow === 'review') {
        echo '<style>
            .column-thumbnail { width: 60px; }
            .column-review_location { width: 120px; }
            .column-review_project { width: 200px; }
        </style>';
    }
}

remove_action('admin_head', 'review_admin_styles');
add_action('admin_head', 'review_admin_styles');

function about_us_image_callback($post) {
    wp_nonce_field('about_us_image_nonce', 'about_us_image_nonce');
    
    $image_id = get_post_meta($post->ID, '_about_us_image', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    
    echo '<div class="image-upload">';
    echo '<div class="image-preview" style="margin: 10px 0;">';
    if ($image_url) {
        echo '<img src="' . esc_url($image_url) . '" style="max-width: 300px; height: auto; display: block; margin-bottom: 10px;">';
    }
    echo '</div>';
    echo '<input type="hidden" id="about_us_image" name="about_us_image" value="' . esc_attr($image_id) . '">';
    echo '<button type="button" class="button about-us-upload">Выбрать изображение</button> ';
    echo '<button type="button" class="button about-us-remove" style="margin-left: 10px;">Удалить</button>';
    echo '</div>';
}

function save_about_us_meta($post_id) {
    if (!isset($_POST['about_us_image_nonce']) || !wp_verify_nonce($_POST['about_us_image_nonce'], 'about_us_image_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['about_us_image'])) {
        update_post_meta($post_id, '_about_us_image', sanitize_text_field($_POST['about_us_image']));
    } else {
        delete_post_meta($post_id, '_about_us_image');
    }
}
add_action('save_post_about_us', 'save_about_us_meta');

function add_project_delivery_meta_boxes() {
    add_meta_box(
        'project_delivery_info',
        'Доставка и установка',
        'project_delivery_info_callback',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_project_delivery_meta_boxes');

function project_delivery_info_callback($post) {
    wp_nonce_field('project_delivery_nonce', 'project_delivery_nonce');
    
    $delivery_info = get_post_meta($post->ID, '_project_delivery_info', true);
    $delivery_items = $delivery_info ? explode("\n", $delivery_info) : [];
    
    echo '<div class="delivery-info-editor">';
    echo '<p><strong>Укажите пункты доставки и установки (каждый пункт с новой строки):</strong></p>';
    echo '<textarea id="project_delivery_info" name="project_delivery_info" rows="6" class="large-text" placeholder="✓ Доставка по всей России&#10;✓ Установка за 1 день&#10;✓ Готовый дом &quot;под ключ&quot;&#10;✓ Гарантия 5 лет">';
    
    if (!empty($delivery_items)) {
        foreach ($delivery_items as $item) {
            echo esc_textarea(trim($item)) . "\n";
        }
    } else {
        echo "✓ Доставка по всей России\n✓ Установка за 1 день\n✓ Готовый дом \"под ключ\"\n✓ Гарантия 5 лет";
    }
    
    echo '</textarea>';
    echo '<p class="description">Каждый пункт должен начинаться с символа ✓ (галочка)</p>';
    echo '</div>';
}

function save_project_delivery_meta($post_id) {
    if (!isset($_POST['project_delivery_nonce']) || !wp_verify_nonce($_POST['project_delivery_nonce'], 'project_delivery_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['project_delivery_info'])) {
        $delivery_info = sanitize_textarea_field($_POST['project_delivery_info']);
        update_post_meta($post_id, '_project_delivery_info', $delivery_info);
    }
}
add_action('save_post_project', 'save_project_delivery_meta');

function add_technology_meta_boxes() {
    add_meta_box(
        'technology_image',
        'Изображение для блока "Технологии строительства"',
        'technology_image_callback',
        'technology',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_technology_meta_boxes');

function technology_image_callback($post) {
    wp_nonce_field('technology_image_nonce', 'technology_image_nonce');
    
    $image_id = get_post_meta($post->ID, '_technology_image', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    
    echo '<div class="image-upload">';
    echo '<div class="image-preview" style="margin: 10px 0;">';
    if ($image_url) {
        echo '<img src="' . esc_url($image_url) . '" style="max-width: 300px; height: auto; display: block; margin-bottom: 10px;">';
    }
    echo '</div>';
    echo '<input type="hidden" id="technology_image" name="technology_image" value="' . esc_attr($image_id) . '">';
    echo '<button type="button" class="button technology-upload">Выбрать изображение</button> ';
    echo '<button type="button" class="button technology-remove" style="margin-left: 10px;">Удалить</button>';
    echo '</div>';
}

function save_technology_meta($post_id) {
    if (!isset($_POST['technology_image_nonce']) || !wp_verify_nonce($_POST['technology_image_nonce'], 'technology_image_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['technology_image'])) {
        update_post_meta($post_id, '_technology_image', sanitize_text_field($_POST['technology_image']));
    } else {
        delete_post_meta($post_id, '_technology_image');
    }
}
add_action('save_post_technology', 'save_technology_meta');

function admin_media_uploader_scripts() {
    global $typenow;
    
    if (in_array($typenow, ['about_us', 'technology'])) {
        wp_enqueue_media();
        
        wp_add_inline_script('jquery', '
            jQuery(document).ready(function($) {
                $(".about-us-upload").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var preview = button.siblings(".image-preview");
                    var input = button.siblings("input[type=\'hidden\']");
                    
                    var mediaUploader = wp.media({
                        title: "Выберите изображение для блока О компании",
                        button: { text: "Выбрать изображение" },
                        multiple: false,
                        library: { type: "image" }
                    });
                    
                    mediaUploader.on("select", function() {
                        var attachment = mediaUploader.state().get("selection").first().toJSON();
                        input.val(attachment.id);
                        
                        var imageUrl = attachment.url;
                        if (attachment.sizes && attachment.sizes.medium) {
                            imageUrl = attachment.sizes.medium.url;
                        }
                        
                        preview.html("<img src=\"" + imageUrl + "\" style=\"max-width: 300px; height: auto; display: block; margin-bottom: 10px;\">");
                    });
                    
                    mediaUploader.open();
                });
                
                $(".about-us-remove").click(function(e) {
                    e.preventDefault();
                    var preview = $(this).siblings(".image-preview");
                    var input = $(this).siblings("input[type=\'hidden\']");
                    input.val("");
                    preview.html("");
                });
                
                // Для блока "Технологии строительства"
                $(".technology-upload").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var preview = button.siblings(".image-preview");
                    var input = button.siblings("input[type=\'hidden\']");
                    
                    var mediaUploader = wp.media({
                        title: "Выберите изображение для блока Технологии",
                        button: { text: "Выбрать изображение" },
                        multiple: false,
                        library: { type: "image" }
                    });
                    
                    mediaUploader.on("select", function() {
                        var attachment = mediaUploader.state().get("selection").first().toJSON();
                        input.val(attachment.id);
                        
                        var imageUrl = attachment.url;
                        if (attachment.sizes && attachment.sizes.medium) {
                            imageUrl = attachment.sizes.medium.url;
                        }
                        
                        preview.html("<img src=\"" + imageUrl + "\" style=\"max-width: 300px; height: auto; display: block; margin-bottom: 10px;\">");
                    });
                    
                    mediaUploader.open();
                });
                
                $(".technology-remove").click(function(e) {
                    e.preventDefault();
                    var preview = $(this).siblings(".image-preview");
                    var input = $(this).siblings("input[type=\'hidden\']");
                    input.val("");
                    preview.html("");
                });
            });
        ');
    }
}
add_action('admin_enqueue_scripts', 'admin_media_uploader_scripts');

function add_offer_meta_boxes() {
    add_meta_box(
        'offer_details',
        'Детали предложения',
        'offer_details_callback',
        'offer'
    );
    
    add_meta_box(
        'offer_type',
        'Тип предложения',
        'offer_type_callback',
        'offer'
    );
}
add_action('add_meta_boxes', 'add_offer_meta_boxes');


function offer_type_callback($post) {
    wp_nonce_field('offer_type_nonce', 'offer_type_nonce');
    
    $offer_type = get_post_meta($post->ID, '_offer_type', true);
    
    echo '<select name="offer_type" class="regular-text">';
    echo '<option value="house"' . selected($offer_type, 'house', false) . '>Дома</option>';
    echo '<option value="bath"' . selected($offer_type, 'bath', false) . '>Бани</option>';
    echo '<option value="cabin"' . selected($offer_type, 'cabin', false) . '>Бытовки</option>';
    echo '<option value="commercial"' . selected($offer_type, 'commercial', false) . '>Коммерческие</option>';
    echo '</select>';
    echo '<p class="description">Выберите категорию для фильтрации на сайте</p>';
}

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
    
    if (isset($_POST['offer_type_nonce']) && wp_verify_nonce($_POST['offer_type_nonce'], 'offer_type_nonce')) {
        if (isset($_POST['offer_type'])) {
            update_post_meta($post_id, '_offer_type', sanitize_text_field($_POST['offer_type']));
        }
    }
    
    $gallery = [];
    for ($i = 1; $i <= 5; $i++) {
        if (isset($_POST["gallery_image_$i"]) && !empty($_POST["gallery_image_$i"])) {
            $gallery["image_$i"] = intval($_POST["gallery_image_$i"]);
        }
    }
    update_post_meta($post_id, '_offer_gallery', $gallery);
}
add_action('save_post', 'save_offer_meta');

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
    echo '<option value="cabin"' . selected($project_type, 'cabin', false) . '>Бытовки</option>';
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

function handle_contact_form() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'reputacia_nonce')) {
        wp_send_json_error('Ошибка безопасности');
        wp_die();
    }

    $name = sanitize_text_field($_POST['name']);
    $phone = sanitize_text_field($_POST['phone']);
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $form_type = isset($_POST['form_type']) ? sanitize_text_field($_POST['form_type']) : 'contact';
    
    $area = isset($_POST['area']) ? sanitize_text_field($_POST['area']) : '';
    $finish = isset($_POST['finish']) ? sanitize_text_field($_POST['finish']) : '';
    $windows = isset($_POST['windows']) ? sanitize_text_field($_POST['windows']) : '';
    $calculated_price = isset($_POST['calculated_price']) ? sanitize_text_field($_POST['calculated_price']) : '';

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

    $email_sent = wp_mail($to, $subject, $body, $headers);

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

function reputacia_customizer_settings($wp_customize) {
    $wp_customize->add_section('company_info', [
        'title' => 'Информация о компании',
        'priority' => 30
    ]);

    $wp_customize->add_setting('phone_number', [
        'default' => '+7 (891) 200-74-33',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('phone_number', [
        'label' => 'Номер телефона',
        'section' => 'company_info',
        'type' => 'text'
    ]);

    $wp_customize->add_setting('email_address', [
        'default' => 'info@reputacia-dom.ru',
        'sanitize_callback' => 'sanitize_email'
    ]);
    $wp_customize->add_control('email_address', [
        'label' => 'Email адрес',
        'section' => 'company_info',
        'type' => 'email'
    ]);

    $wp_customize->add_setting('company_address', [
        'default' => 'г. Ижевск, Удмуртская Республика',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('company_address', [
        'label' => 'Адрес компании',
        'section' => 'company_info',
        'type' => 'text'
    ]);

    $wp_customize->add_setting('company_inn', [
        'default' => '180904423155',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('company_inn', [
        'label' => 'ИНН',
        'section' => 'company_info',
        'type' => 'text'
    ]);

    $wp_customize->add_setting('company_bank', [
        'default' => 'Филиал «Нижегородский» АО «Альфа-Банк»',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('company_bank', [
        'label' => 'Банк',
        'section' => 'company_info',
        'type' => 'text'
    ]);

    $wp_customize->add_setting('vk_group', [
        'default' => 'https://vk.com/reputacia_doma',
        'sanitize_callback' => 'esc_url_raw'
    ]);
    $wp_customize->add_control('vk_group', [
        'label' => 'Группа ВКонтакте',
        'section' => 'company_info',
        'type' => 'url'
    ]);

    $wp_customize->add_setting('telegram_handle', [
        'default' => '@izh_module',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('telegram_handle', [
        'label' => 'Telegram',
        'section' => 'company_info',
        'type' => 'text'
    ]);

    $wp_customize->add_section('hero_section', [
        'title' => 'Главная секция',
        'priority' => 35
    ]);

    $wp_customize->add_setting('hero_title', [
        'default' => 'Репутация<br>Модульное строительство.',
        'sanitize_callback' => 'wp_kses_post'
    ]);
    $wp_customize->add_control('hero_title', [
        'label' => 'Заголовок Hero секции',
        'section' => 'hero_section',
        'type' => 'textarea'
    ]);

    $wp_customize->add_setting('hero_description', [
        'default' => 'Быстровозводимые бытовки, бани, дома в Ижевске и УР. Профессиональное строительство модульных зданий любой сложности.',
        'sanitize_callback' => 'sanitize_textarea_field'
    ]);
    $wp_customize->add_control('hero_description', [
        'label' => 'Описание Hero секции',
        'section' => 'hero_section',
        'type' => 'textarea'
    ]);

    $wp_customize->add_setting('logo_text', [
        'default' => 'РЕПУТАЦИЯ',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('logo_text', [
        'label' => 'Текст логотипа',
        'section' => 'title_tagline',
        'type' => 'text'
    ]);

    $wp_customize->add_setting('logo_subtitle', [
        'default' => 'СТРОИТЕЛЬНАЯ КОМПАНИЯ',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('logo_subtitle', [
        'label' => 'Подпись логотипа',
        'section' => 'title_tagline',
        'type' => 'text'
    ]);
}
add_action('customize_register', 'reputacia_customizer_settings');

function reputacia_widgets_init() {
    register_sidebar([
        'name' => 'Футер - Социальные сети',
        'id' => 'footer-social',
        'description' => 'Виджеты для социальных сетей в футере',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ]);
}
add_action('widgets_init', 'reputacia_widgets_init');

?>