<?php
/**
 * Generic E-commerce Theme Functions
 * Sistema genérico de e-commerce totalmente administrável
 */

// Evitar acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes do tema
define('GENERIC_ECOMMERCE_VERSION', '1.0.0');
define('GENERIC_ECOMMERCE_PATH', get_template_directory());
define('GENERIC_ECOMMERCE_URL', get_template_directory_uri());

// Carregar arquivos necessários
require_once GENERIC_ECOMMERCE_PATH . '/includes/custom-post-types.php';
require_once GENERIC_ECOMMERCE_PATH . '/includes/custom-fields.php';
require_once GENERIC_ECOMMERCE_PATH . '/includes/admin-functions.php';
require_once GENERIC_ECOMMERCE_PATH . '/includes/theme-options.php';

// Configuração do tema
function generic_ecommerce_setup() {
    // Suporte a título dinâmico
    add_theme_support('title-tag');
    
    // Suporte a imagens destacadas
    add_theme_support('post-thumbnails');
    
    // Suporte a HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Suporte a WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Suporte a custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Registrar menus
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'generic-ecommerce'),
        'footer'  => __('Menu Footer', 'generic-ecommerce'),
    ));
}
add_action('after_setup_theme', 'generic_ecommerce_setup');

// Enfileirar estilos e scripts
function generic_ecommerce_scripts() {
    // CSS
    wp_enqueue_style('generic-ecommerce-style', get_stylesheet_uri(), array(), GENERIC_ECOMMERCE_VERSION);
    wp_enqueue_style('generic-ecommerce-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap', array(), null);
    
    // JavaScript
    wp_enqueue_script('generic-ecommerce-main', GENERIC_ECOMMERCE_URL . '/assets/js/main.js', array('jquery'), GENERIC_ECOMMERCE_VERSION, true);
    
    // Localizar script para AJAX
    wp_localize_script('generic-ecommerce-main', 'generic_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('generic_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'generic_ecommerce_scripts');

// Enfileirar scripts do admin
function generic_ecommerce_admin_scripts($hook) {
    if (strpos($hook, 'generic-ecommerce') !== false) {
        wp_enqueue_media();
        wp_enqueue_script('generic-ecommerce-admin', GENERIC_ECOMMERCE_URL . '/assets/js/admin.js', array('jquery'), GENERIC_ECOMMERCE_VERSION, true);
        wp_enqueue_style('generic-ecommerce-admin', GENERIC_ECOMMERCE_URL . '/assets/css/admin.css', array(), GENERIC_ECOMMERCE_VERSION);
    }
}
add_action('admin_enqueue_scripts', 'generic_ecommerce_admin_scripts');

// Criar diretórios necessários
function generic_ecommerce_create_directories() {
    $upload_dir = wp_upload_dir();
    $directories = array(
        $upload_dir['basedir'] . '/generic-ecommerce',
        $upload_dir['basedir'] . '/generic-ecommerce/products',
        $upload_dir['basedir'] . '/generic-ecommerce/collections',
        $upload_dir['basedir'] . '/generic-ecommerce/sliders',
    );
    
    foreach ($directories as $dir) {
        if (!file_exists($dir)) {
            wp_mkdir_p($dir);
        }
    }
}
add_action('after_switch_theme', 'generic_ecommerce_create_directories');

// Função para obter opções do tema
function generic_get_option($option_name, $default = '') {
    $options = get_option('generic_ecommerce_options', array());
    return isset($options[$option_name]) ? $options[$option_name] : $default;
}

// Função para salvar opções do tema
function generic_save_option($option_name, $value) {
    $options = get_option('generic_ecommerce_options', array());
    $options[$option_name] = $value;
    update_option('generic_ecommerce_options', $options);
}

// Função para obter produtos em destaque
function generic_get_featured_products($limit = 8) {
    $args = array(
        'post_type'      => 'generic_product',
        'posts_per_page' => $limit,
        'meta_query'     => array(
            array(
                'key'     => 'featured_product',
                'value'   => '1',
                'compare' => '='
            )
        )
    );
    
    return get_posts($args);
}

// Função para obter categorias de produtos
function generic_get_product_categories() {
    return get_terms(array(
        'taxonomy'   => 'generic_category',
        'hide_empty' => false,
    ));
}

// Função para obter coleções
function generic_get_collections() {
    return get_posts(array(
        'post_type'      => 'generic_collection',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ));
}

// Função para obter sliders da homepage
function generic_get_homepage_sliders() {
    return get_posts(array(
        'post_type'      => 'generic_slider',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_key'       => 'slider_order',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
    ));
}

// Shortcode para exibir produtos
function generic_products_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit'    => 8,
        'category' => '',
        'featured' => 'false',
    ), $atts);
    
    $args = array(
        'post_type'      => 'generic_product',
        'posts_per_page' => intval($atts['limit']),
        'post_status'    => 'publish',
    );
    
    if ($atts['category']) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'generic_category',
                'field'    => 'slug',
                'terms'    => $atts['category'],
            ),
        );
    }
    
    if ($atts['featured'] === 'true') {
        $args['meta_query'] = array(
            array(
                'key'     => 'featured_product',
                'value'   => '1',
                'compare' => '='
            )
        );
    }
    
    $products = get_posts($args);
    
    ob_start();
    include GENERIC_ECOMMERCE_PATH . '/templates/products-grid.php';
    return ob_get_clean();
}
add_shortcode('generic_products', 'generic_products_shortcode');

// Shortcode para exibir slider
function generic_slider_shortcode($atts) {
    $atts = shortcode_atts(array(
        'slider_id' => '',
    ), $atts);
    
    $sliders = generic_get_homepage_sliders();
    
    ob_start();
    include GENERIC_ECOMMERCE_PATH . '/templates/hero-slider.php';
    return ob_get_clean();
}
add_shortcode('generic_slider', 'generic_slider_shortcode');

// AJAX para carregar mais produtos
function generic_load_more_products() {
    check_ajax_referer('generic_nonce', 'nonce');
    
    $page = intval($_POST['page']);
    $category = sanitize_text_field($_POST['category']);
    
    $args = array(
        'post_type'      => 'generic_product',
        'posts_per_page' => 8,
        'paged'          => $page,
        'post_status'    => 'publish',
    );
    
    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'generic_category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }
    
    $products = get_posts($args);
    
    ob_start();
    foreach ($products as $product) {
        include GENERIC_ECOMMERCE_PATH . '/templates/product-card.php';
    }
    $html = ob_get_clean();
    
    wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_generic_load_more_products', 'generic_load_more_products');
add_action('wp_ajax_nopriv_generic_load_more_products', 'generic_load_more_products');

// Limpar cache quando produtos são atualizados
function generic_clear_cache_on_update($post_id) {
    if (get_post_type($post_id) === 'generic_product') {
        wp_cache_flush();
    }
}
add_action('save_post', 'generic_clear_cache_on_update');

// Adicionar suporte a thumbnails para custom post types
function generic_add_thumbnail_support() {
    add_post_type_support('generic_product', 'thumbnail');
    add_post_type_support('generic_collection', 'thumbnail');
    add_post_type_support('generic_slider', 'thumbnail');
}
add_action('init', 'generic_add_thumbnail_support');
