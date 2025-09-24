<?php
/**
 * Aplicar Página Inicial Miu Miu
 * Script para criar e configurar a página inicial inspirada na Miu Miu
 */

// Carregar WordPress
require_once('wp-load.php');

echo "=== APLICANDO PÁGINA INICIAL MIU MIU ===\n\n";

// 1. Criar página inicial
echo "1. Criando página inicial...\n";

$homepage = array(
    'post_title' => 'Home Miu Miu',
    'post_content' => 'Página inicial inspirada no estilo minimalista da Miu Miu',
    'post_status' => 'publish',
    'post_type' => 'page',
    'post_name' => 'home-miumiu'
);

$homepage_id = wp_insert_post($homepage);

if ($homepage_id) {
    // Definir como página inicial
    update_option('show_on_front', 'page');
    update_option('page_on_front', $homepage_id);
    
    // Adicionar template personalizado
    update_post_meta($homepage_id, '_wp_page_template', 'miumiu-home.php');
    
    echo "   ✓ Página inicial criada (ID: {$homepage_id})\n";
} else {
    echo "   ❌ Erro ao criar página inicial\n";
}

// 2. Criar post type para slides
echo "2. Criando post type para slides...\n";

// Registrar post type para slides
add_action('init', function() {
    register_post_type('slide', array(
        'labels' => array(
            'name' => 'Slides',
            'singular_name' => 'Slide',
            'add_new' => 'Adicionar Novo',
            'add_new_item' => 'Adicionar Novo Slide',
            'edit_item' => 'Editar Slide',
            'new_item' => 'Novo Slide',
            'view_item' => 'Ver Slide',
            'search_items' => 'Buscar Slides',
            'not_found' => 'Nenhum slide encontrado',
            'not_found_in_trash' => 'Nenhum slide encontrado na lixeira'
        ),
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-images-alt2',
        'show_in_menu' => true,
        'menu_position' => 20
    ));
});

// Registrar campos personalizados para slides
add_action('add_meta_boxes', function() {
    add_meta_box(
        'slide_fields',
        'Configurações do Slide',
        'slide_fields_callback',
        'slide',
        'normal',
        'high'
    );
});

function slide_fields_callback($post) {
    wp_nonce_field('slide_fields_nonce', 'slide_fields_nonce_field');
    
    $slide_title = get_post_meta($post->ID, 'slide_title', true);
    $slide_subtitle = get_post_meta($post->ID, 'slide_subtitle', true);
    $slide_button_text = get_post_meta($post->ID, 'slide_button_text', true);
    $slide_button_link = get_post_meta($post->ID, 'slide_button_link', true);
    $slide_background = get_post_meta($post->ID, 'slide_background', true);
    $slide_order = get_post_meta($post->ID, 'slide_order', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="slide_title">Título do Slide</label></th>';
    echo '<td><input type="text" id="slide_title" name="slide_title" value="' . esc_attr($slide_title) . '" style="width: 100%;" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="slide_subtitle">Subtítulo</label></th>';
    echo '<td><input type="text" id="slide_subtitle" name="slide_subtitle" value="' . esc_attr($slide_subtitle) . '" style="width: 100%;" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="slide_button_text">Texto do Botão</label></th>';
    echo '<td><input type="text" id="slide_button_text" name="slide_button_text" value="' . esc_attr($slide_button_text) . '" style="width: 100%;" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="slide_button_link">Link do Botão</label></th>';
    echo '<td><input type="url" id="slide_button_link" name="slide_button_link" value="' . esc_attr($slide_button_link) . '" style="width: 100%;" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="slide_background">URL da Imagem de Fundo</label></th>';
    echo '<td><input type="url" id="slide_background" name="slide_background" value="' . esc_attr($slide_background) . '" style="width: 100%;" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="slide_order">Ordem do Slide</label></th>';
    echo '<td><input type="number" id="slide_order" name="slide_order" value="' . esc_attr($slide_order) . '" min="1" style="width: 100px;" /></td>';
    echo '</tr>';
    echo '</table>';
}

// Salvar campos personalizados
add_action('save_post', function($post_id) {
    if (!isset($_POST['slide_fields_nonce_field']) || !wp_verify_nonce($_POST['slide_fields_nonce_field'], 'slide_fields_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array('slide_title', 'slide_subtitle', 'slide_button_text', 'slide_button_link', 'slide_background', 'slide_order');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
});

echo "   ✓ Post type para slides criado\n";

// 3. Criar slides de exemplo
echo "3. Criando slides de exemplo...\n";

$example_slides = array(
    array(
        'title' => 'Coleção FW25',
        'subtitle' => 'Individualidade feminina em cada peça',
        'button_text' => 'Explorar Coleção',
        'button_link' => '#colecao',
        'background' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
        'order' => 1
    ),
    array(
        'title' => 'Bolsas Icônicas',
        'subtitle' => 'Design versátil e atemporal',
        'button_text' => 'Ver Bolsas',
        'button_link' => '#bolsas',
        'background' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
        'order' => 2
    ),
    array(
        'title' => 'Calçados Elegantes',
        'subtitle' => 'Conforto e sofisticação',
        'button_text' => 'Descobrir',
        'button_link' => '#calcados',
        'background' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
        'order' => 3
    )
);

foreach ($example_slides as $slide_data) {
    $slide_post = array(
        'post_title' => $slide_data['title'],
        'post_content' => $slide_data['subtitle'],
        'post_status' => 'publish',
        'post_type' => 'slide'
    );
    
    $slide_id = wp_insert_post($slide_post);
    
    if ($slide_id) {
        update_post_meta($slide_id, 'slide_title', $slide_data['title']);
        update_post_meta($slide_id, 'slide_subtitle', $slide_data['subtitle']);
        update_post_meta($slide_id, 'slide_button_text', $slide_data['button_text']);
        update_post_meta($slide_id, 'slide_button_link', $slide_data['button_link']);
        update_post_meta($slide_id, 'slide_background', $slide_data['background']);
        update_post_meta($slide_id, 'slide_order', $slide_data['order']);
        
        echo "   ✓ Slide '{$slide_data['title']}' criado\n";
    }
}

// 4. Configurar menu
echo "4. Configurando menu...\n";

$menu_id = wp_create_nav_menu('Menu Principal Miu Miu');
if ($menu_id) {
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Destaques',
        'menu-item-url' => '#destaques',
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Categorias',
        'menu-item-url' => '#categorias',
        'menu-item-status' => 'publish'
    ));
    
    // Atribuir menu ao local correto
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    
    echo "   ✓ Menu configurado\n";
}

// 5. Configurar WooCommerce
echo "5. Configurando WooCommerce...\n";

// Configurar layout do WooCommerce
update_option('woocommerce_shop_page_display', 'products');
update_option('woocommerce_category_archive_display', 'products');
update_option('woocommerce_default_catalog_orderby', 'menu_order');

// Configurar produtos por página
add_filter('loop_shop_per_page', function() { return 12; });
add_filter('loop_shop_columns', function() { return 3; });

echo "   ✓ WooCommerce configurado\n";

// 6. Adicionar CSS personalizado
echo "6. Adicionando CSS personalizado...\n";

$custom_css = "
/* Estilo Miu Miu - Página Inicial */

/* Reset e base */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-weight: 300;
    line-height: 1.6;
    color: #000;
    background: #fff;
    overflow-x: hidden;
}

/* Navbar */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding: 20px 0;
    transition: all 0.3s ease;
}

.navbar.scrolled {
    background: rgba(255, 255, 255, 0.98);
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
}

.navbar-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.navbar-left {
    display: flex;
    align-items: center;
    gap: 40px;
}

.logo {
    font-size: 24px;
    font-weight: 300;
    letter-spacing: 2px;
    color: #000;
    text-decoration: none;
    transition: color 0.3s ease;
}

.logo:hover {
    color: #8b7355;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 30px;
    list-style: none;
}

.nav-links li a {
    color: #000;
    text-decoration: none;
    font-size: 14px;
    font-weight: 400;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: color 0.3s ease;
    position: relative;
}

.nav-links li a:hover {
    color: #8b7355;
}

.nav-links li a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 1px;
    background: #8b7355;
    transition: width 0.3s ease;
}

.nav-links li a:hover::after {
    width: 100%;
}

.categories-dropdown {
    position: relative;
}

.categories-dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1001;
}

.dropdown-menu li {
    padding: 0;
}

.dropdown-menu li a {
    display: block;
    padding: 15px 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    text-transform: none;
    font-size: 13px;
}

.dropdown-menu li:last-child a {
    border-bottom: none;
}

/* Slide principal */
.hero-slider {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
}

.slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: translateY(100%);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide.active {
    opacity: 1;
    transform: translateY(0);
}

.slide.prev {
    transform: translateY(-100%);
}

.slide-content {
    text-align: center;
    color: #fff;
    max-width: 600px;
    padding: 0 20px;
}

.slide-title {
    font-size: 48px;
    font-weight: 300;
    letter-spacing: 2px;
    margin-bottom: 20px;
    opacity: 0;
    transform: translateY(30px);
    animation: slideInUp 0.8s ease 0.3s forwards;
}

.slide-subtitle {
    font-size: 18px;
    font-weight: 300;
    margin-bottom: 40px;
    opacity: 0;
    transform: translateY(30px);
    animation: slideInUp 0.8s ease 0.5s forwards;
}

.slide-button {
    display: inline-block;
    padding: 15px 40px;
    background: #000;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 400;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateY(30px);
    animation: slideInUp 0.8s ease 0.7s forwards;
}

.slide-button:hover {
    background: #8b7355;
    color: #fff;
    transform: translateY(-2px);
}

/* Controles do slide */
.slide-controls {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 15px;
    z-index: 100;
}

.slide-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slide-dot.active {
    background: #fff;
    transform: scale(1.2);
}

.slide-dot:hover {
    background: rgba(255, 255, 255, 0.8);
}

/* Animações */
@keyframes slideInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsivo */
@media (max-width: 768px) {
    .navbar-container {
        padding: 0 15px;
    }

    .navbar-left {
        gap: 20px;
    }

    .nav-links {
        gap: 20px;
    }

    .nav-links li a {
        font-size: 12px;
    }

    .slide-title {
        font-size: 32px;
    }

    .slide-subtitle {
        font-size: 16px;
    }

    .slide-button {
        padding: 12px 30px;
        font-size: 12px;
    }

    .slide-controls {
        bottom: 20px;
    }
}

@media (max-width: 480px) {
    .navbar-left {
        flex-direction: column;
        gap: 10px;
    }

    .nav-links {
        gap: 15px;
    }

    .slide-title {
        font-size: 24px;
    }

    .slide-subtitle {
        font-size: 14px;
    }
}

/* Loading */
.loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity 0.5s ease;
}

.loading.hidden {
    opacity: 0;
    pointer-events: none;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #000;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
";

// Salvar CSS personalizado
update_option('custom_css', $custom_css);

echo "   ✓ CSS personalizado adicionado\n";

// 7. Limpar cache
echo "7. Limpando cache...\n";

// Limpar cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}

// Limpar cache do WooCommerce
if (class_exists('WC_Cache_Helper')) {
    WC_Cache_Helper::invalidate_cache_group('product_cat');
    WC_Cache_Helper::invalidate_cache_group('product_tag');
    WC_Cache_Helper::invalidate_cache_group('product_shipping_class');
    WC_Cache_Helper::invalidate_cache_group('product_visibility');
    WC_Cache_Helper::invalidate_cache_group('product_data');
    WC_Cache_Helper::invalidate_cache_group('cart_fragments');
}

echo "   ✓ Cache limpo\n";

echo "\n=== PÁGINA INICIAL MIU MIU APLICADA COM SUCESSO ===\n";
echo "A página inicial agora possui:\n";
echo "• Navbar minimalista com logo e categorias\n";
echo "• Slide principal fullscreen com transição vertical\n";
echo "• Design inspirado na Miu Miu\n";
echo "• Layout responsivo\n";
echo "• Integração com WooCommerce\n";
echo "• Sistema de slides personalizável\n";
echo "\nAcesse o site para ver a nova página inicial!\n";
echo "URL: " . home_url() . "\n";
?>
