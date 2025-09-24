<?php
/**
 * Funções para aplicar o estilo Miu Miu
 * Adiciona CSS personalizado e configurações do tema
 */

// Adicionar CSS personalizado
function add_miumiu_custom_css() {
    wp_enqueue_style('miumiu-custom-style', get_template_directory_uri() . '/custom-miumiu-style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'add_miumiu_custom_css');

// Configurar tema
function miumiu_theme_setup() {
    // Suporte a logo personalizada
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Suporte a imagens destacadas
    add_theme_support('post-thumbnails');
    
    // Suporte a menus
    register_nav_menus(array(
        'primary' => 'Menu Principal',
        'footer'  => 'Menu Footer',
    ));
    
    // Suporte a WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'miumiu_theme_setup');

// Configurar WooCommerce
function miumiu_woocommerce_setup() {
    // Remover estilos padrão do WooCommerce
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Configurar produtos por página
    add_filter('loop_shop_per_page', function() { return 12; });
    
    // Configurar colunas de produtos
    add_filter('loop_shop_columns', function() { return 3; });
    
    // Configurar ordem dos produtos
    add_filter('woocommerce_default_catalog_orderby', function() { return 'menu_order'; });
}
add_action('init', 'miumiu_woocommerce_setup');

// Adicionar classes CSS personalizadas
function miumiu_body_classes($classes) {
    $classes[] = 'miumiu-theme';
    return $classes;
}
add_filter('body_class', 'miumiu_body_classes');

// Configurar tamanhos de imagem
function miumiu_image_sizes() {
    add_image_size('product-thumbnail', 300, 300, true);
    add_image_size('product-large', 600, 600, true);
}
add_action('after_setup_theme', 'miumiu_image_sizes');

// Adicionar scripts personalizados
function add_miumiu_scripts() {
    wp_enqueue_script('miumiu-custom-js', get_template_directory_uri() . '/custom-miumiu.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'add_miumiu_scripts');

// Configurar sidebar
function miumiu_widgets_init() {
    register_sidebar(array(
        'name'          => 'Sidebar Principal',
        'id'            => 'sidebar-1',
        'description'   => 'Sidebar principal do site',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => 'Footer 1',
        'id'            => 'footer-1',
        'description'   => 'Primeira coluna do footer',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => 'Footer 2',
        'id'            => 'footer-2',
        'description'   => 'Segunda coluna do footer',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => 'Footer 3',
        'id'            => 'footer-3',
        'description'   => 'Terceira coluna do footer',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'miumiu_widgets_init');

// Configurar título da página
function miumiu_wp_title($title, $sep) {
    if (is_feed()) {
        return $title;
    }
    
    global $page, $paged;
    
    if (is_home() || is_front_page()) {
        $title = get_bloginfo('name') . ' - ' . get_bloginfo('description');
    } else {
        $title .= get_bloginfo('name');
    }
    
    if (($paged >= 2 || $page >= 2) && !is_404()) {
        $title .= " $sep " . sprintf('Página %s', max($paged, $page));
    }
    
    return $title;
}
add_filter('wp_title', 'miumiu_wp_title', 10, 2);

// Adicionar meta tags
function miumiu_meta_tags() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
    echo '<meta name="description" content="Loja online de moda elegante e sofisticada. Produtos de alta qualidade com design único.">' . "\n";
    echo '<meta name="keywords" content="moda, elegante, sofisticado, qualidade, design">' . "\n";
}
add_action('wp_head', 'miumiu_meta_tags');

// Configurar excerpt
function miumiu_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'miumiu_excerpt_length');

function miumiu_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'miumiu_excerpt_more');

// Adicionar suporte a HTML5
function miumiu_html5_support() {
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'miumiu_html5_support');

// Configurar WooCommerce
function miumiu_woocommerce_config() {
    // Remover breadcrumbs padrão
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    
    // Adicionar breadcrumbs personalizados
    add_action('woocommerce_before_main_content', 'miumiu_woocommerce_breadcrumb', 20);
    
    // Configurar botões
    add_filter('woocommerce_loop_add_to_cart_args', 'miumiu_add_to_cart_args');
    
    // Configurar preços
    add_filter('woocommerce_price_format', 'miumiu_price_format');
}
add_action('init', 'miumiu_woocommerce_config');

// Breadcrumbs personalizados
function miumiu_woocommerce_breadcrumb() {
    if (function_exists('woocommerce_breadcrumb')) {
        woocommerce_breadcrumb(array(
            'delimiter'   => ' / ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb">',
            'wrap_after'  => '</nav>',
        ));
    }
}

// Configurar botões
function miumiu_add_to_cart_args($args) {
    $args['class'] = 'button';
    return $args;
}

// Configurar formato de preço
function miumiu_price_format($format) {
    return '%2$s %1$s';
}

// Adicionar suporte a customizer
function miumiu_customize_register($wp_customize) {
    // Seção de cores
    $wp_customize->add_section('miumiu_colors', array(
        'title'    => 'Cores Miu Miu',
        'priority' => 30,
    ));
    
    // Cor primária
    $wp_customize->add_setting('miumiu_primary_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'miumiu_primary_color', array(
        'label'    => 'Cor Primária',
        'section'  => 'miumiu_colors',
        'settings' => 'miumiu_primary_color',
    )));
    
    // Cor secundária
    $wp_customize->add_setting('miumiu_secondary_color', array(
        'default'           => '#8b7355',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'miumiu_secondary_color', array(
        'label'    => 'Cor Secundária',
        'section'  => 'miumiu_colors',
        'settings' => 'miumiu_secondary_color',
    )));
}
add_action('customize_register', 'miumiu_customize_register');

// Adicionar CSS do customizer
function miumiu_customizer_css() {
    $primary_color = get_theme_mod('miumiu_primary_color', '#000000');
    $secondary_color = get_theme_mod('miumiu_secondary_color', '#8b7355');
    
    echo '<style type="text/css">';
    echo '.site-title, .main-navigation a, .woocommerce ul.products li.product h2 { color: ' . $primary_color . '; }';
    echo '.main-navigation a:hover, .woocommerce ul.products li.product .button:hover { color: ' . $secondary_color . '; }';
    echo '.woocommerce ul.products li.product .button, .button, .btn { background: ' . $primary_color . '; }';
    echo '.woocommerce ul.products li.product .button:hover, .button:hover, .btn:hover { background: ' . $secondary_color . '; }';
    echo '</style>';
}
add_action('wp_head', 'miumiu_customizer_css');
?>
