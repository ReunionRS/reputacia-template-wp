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
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="offer_area">Площадь (м²):</label></th><td><input type="number" id="offer_area" name="offer_area" value="' . esc_attr($area) . '" class="regular-text"></td></tr>';
    echo '<tr><th><label for="offer_price">Цена (₽):</label></th><td><input type="number" id="offer_price" name="offer_price" value="' . esc_attr($price) . '" class="regular-text"></td></tr>';
    echo '<tr><th><label for="offer_features">Особенности<br><small>(через запятую)</small>:</label></th><td><textarea id="offer_features" name="offer_features" rows="3" class="large-text">' . esc_textarea($features) . '</textarea></td></tr>';
    echo '</table>';
}

function save_offer_meta($post_id) {
    if (!isset($_POST['offer_meta_nonce']) || !wp_verify_nonce($_POST['offer_meta_nonce'], 'offer_meta_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['offer_area'])) {
        update_post_meta($post_id, '_offer_area', sanitize_text_field($_POST['offer_area']));
    }
    if (isset($_POST['offer_price'])) {
        update_post_meta($post_id, '_offer_price', sanitize_text_field($_POST['offer_price']));
    }
    if (isset($_POST['offer_features'])) {
        update_post_meta($post_id, '_offer_features', sanitize_textarea_field($_POST['offer_features']));
    }
}
add_action('save_post', 'save_offer_meta');

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
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="project_area">Площадь (м²):</label></th><td><input type="number" id="project_area" name="project_area" value="' . esc_attr($area) . '" class="regular-text"></td></tr>';
    echo '<tr><th><label for="project_price">Цена (₽):</label></th><td><input type="number" id="project_price" name="project_price" value="' . esc_attr($price) . '" class="regular-text"></td></tr>';
    echo '<tr><th><label for="project_features">Особенности:</label></th><td><textarea id="project_features" name="project_features" rows="3" class="large-text">' . esc_textarea($features) . '</textarea></td></tr>';
    echo '</table>';
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
        
        if (isset($_POST['project_area'])) {
            update_post_meta($post_id, '_project_area', sanitize_text_field($_POST['project_area']));
        }
        if (isset($_POST['project_price'])) {
            update_post_meta($post_id, '_project_price', sanitize_text_field($_POST['project_price']));
        }
        if (isset($_POST['project_features'])) {
            update_post_meta($post_id, '_project_features', sanitize_textarea_field($_POST['project_features']));
        }
    }
    
    if (isset($_POST['project_type_nonce']) && wp_verify_nonce($_POST['project_type_nonce'], 'project_type_nonce')) {
        if (isset($_POST['project_type'])) {
            update_post_meta($post_id, '_project_type', sanitize_text_field($_POST['project_type']));
        }
    }
}
add_action('save_post', 'save_project_meta');

// AJAX обработчики для форм
function handle_contact_form() {
    if (!wp_verify_nonce($_POST['nonce'], 'reputacia_nonce')) {
        wp_send_json_error('Ошибка безопасности');
    }
    
    $name = sanitize_text_field($_POST['name']);
    $phone = sanitize_text_field($_POST['phone']);
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $form_type = isset($_POST['form_type']) ? sanitize_text_field($_POST['form_type']) : 'contact';
    
    $to = get_option('admin_email');
    $subject = ($form_type === 'callback') ? 'Заказ обратного звонка' : 'Новая заявка с сайта';
    $subject .= ' - ' . get_bloginfo('name');
    
    $body = "Новая заявка:\n\n";
    $body .= "Имя: $name\n";
    $body .= "Телефон: $phone\n";
    if ($message) {
        $body .= "Сообщение: $message\n";
    }
    $body .= "Тип формы: $form_type\n";
    $body .= "Дата: " . current_time('d.m.Y H:i') . "\n";
    
    $headers = ['Content-Type: text/plain; charset=UTF-8'];
    
    if (wp_mail($to, $subject, $body, $headers)) {
        $post_data = [
            'post_title' => ($form_type === 'callback') ? "Обратный звонок - $name" : "Заявка от $name",
            'post_content' => $message,
            'post_status' => 'private',
            'post_type' => 'contact_form',
            'meta_input' => [
                'contact_name' => $name,
                'contact_phone' => $phone,
                'form_type' => $form_type,
                'contact_date' => current_time('Y-m-d H:i:s')
            ]
        ];
        
        wp_insert_post($post_data);
        
        $success_message = ($form_type === 'callback') ? 
            'Заявка принята! Мы перезвоним вам в ближайшее время.' : 
            'Заявка отправлена! Мы свяжемся с вами.';
            
        wp_send_json_success($success_message);
    } else {
        wp_send_json_error('Ошибка отправки. Попробуйте еще раз.');
    }
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
    $form_type = get_post_meta($post->ID, 'form_type', true);
    $date = get_post_meta($post->ID, 'contact_date', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label>Имя:</label></th><td>' . esc_html($name) . '</td></tr>';
    echo '<tr><th><label>Телефон:</label></th><td><a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a></td></tr>';
    echo '<tr><th><label>Тип формы:</label></th><td>' . esc_html($form_type === 'callback' ? 'Обратный звонок' : 'Обычная заявка') . '</td></tr>';
    echo '<tr><th><label>Дата:</label></th><td>' . esc_html($date ?: get_the_date('d.m.Y H:i', $post->ID)) . '</td></tr>';
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
            echo esc_html($type === 'callback' ? 'Обратный звонок' : 'Заявка');
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