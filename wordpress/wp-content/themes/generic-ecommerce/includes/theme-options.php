<?php
/**
 * Opções do Tema para Generic E-commerce
 */

// Evitar acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// Adicionar customizer
function generic_customize_register($wp_customize) {
    
    // Seção de cores
    $wp_customize->add_section('generic_colors', array(
        'title'    => __('Cores do Tema', 'generic-ecommerce'),
        'priority' => 30,
    ));
    
    // Cor primária
    $wp_customize->add_setting('generic_primary_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'generic_primary_color', array(
        'label'    => __('Cor Primária', 'generic-ecommerce'),
        'section'  => 'generic_colors',
        'settings' => 'generic_primary_color',
    )));
    
    // Cor secundária
    $wp_customize->add_setting('generic_secondary_color', array(
        'default'           => '#8b7355',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'generic_secondary_color', array(
        'label'    => __('Cor Secundária', 'generic-ecommerce'),
        'section'  => 'generic_colors',
        'settings' => 'generic_secondary_color',
    )));
    
    // Cor de destaque
    $wp_customize->add_setting('generic_accent_color', array(
        'default'           => '#f5f5f5',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'generic_accent_color', array(
        'label'    => __('Cor de Destaque', 'generic-ecommerce'),
        'section'  => 'generic_colors',
        'settings' => 'generic_accent_color',
    )));
    
    // Seção de configurações da loja
    $wp_customize->add_section('generic_store', array(
        'title'    => __('Configurações da Loja', 'generic-ecommerce'),
        'priority' => 35,
    ));
    
    // Nome da loja
    $wp_customize->add_setting('generic_store_name', array(
        'default'           => 'Generic E-commerce',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('generic_store_name', array(
        'label'    => __('Nome da Loja', 'generic-ecommerce'),
        'section'  => 'generic_store',
        'settings' => 'generic_store_name',
        'type'     => 'text',
    ));
    
    // Email da loja
    $wp_customize->add_setting('generic_store_email', array(
        'default'           => 'contato@generic-ecommerce.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('generic_store_email', array(
        'label'    => __('Email da Loja', 'generic-ecommerce'),
        'section'  => 'generic_store',
        'settings' => 'generic_store_email',
        'type'     => 'email',
    ));
    
    // Telefone da loja
    $wp_customize->add_setting('generic_store_phone', array(
        'default'           => '(11) 99999-9999',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('generic_store_phone', array(
        'label'    => __('Telefone da Loja', 'generic-ecommerce'),
        'section'  => 'generic_store',
        'settings' => 'generic_store_phone',
        'type'     => 'text',
    ));
    
    // Endereço da loja
    $wp_customize->add_setting('generic_store_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('generic_store_address', array(
        'label'    => __('Endereço da Loja', 'generic-ecommerce'),
        'section'  => 'generic_store',
        'settings' => 'generic_store_address',
        'type'     => 'textarea',
    ));
    
    // Seção de redes sociais
    $wp_customize->add_section('generic_social', array(
        'title'    => __('Redes Sociais', 'generic-ecommerce'),
        'priority' => 40,
    ));
    
    // Facebook
    $wp_customize->add_setting('generic_facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('generic_facebook', array(
        'label'    => __('Facebook', 'generic-ecommerce'),
        'section'  => 'generic_social',
        'settings' => 'generic_facebook',
        'type'     => 'url',
    ));
    
    // Instagram
    $wp_customize->add_setting('generic_instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('generic_instagram', array(
        'label'    => __('Instagram', 'generic-ecommerce'),
        'section'  => 'generic_social',
        'settings' => 'generic_instagram',
        'type'     => 'url',
    ));
    
    // Twitter
    $wp_customize->add_setting('generic_twitter', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('generic_twitter', array(
        'label'    => __('Twitter', 'generic-ecommerce'),
        'section'  => 'generic_social',
        'settings' => 'generic_twitter',
        'type'     => 'url',
    ));
    
    // YouTube
    $wp_customize->add_setting('generic_youtube', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('generic_youtube', array(
        'label'    => __('YouTube', 'generic-ecommerce'),
        'section'  => 'generic_social',
        'settings' => 'generic_youtube',
        'type'     => 'url',
    ));
}
add_action('customize_register', 'generic_customize_register');

// Gerar CSS personalizado
function generic_customize_css() {
    $primary_color = get_theme_mod('generic_primary_color', '#000000');
    $secondary_color = get_theme_mod('generic_secondary_color', '#8b7355');
    $accent_color = get_theme_mod('generic_accent_color', '#f5f5f5');
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo $primary_color; ?>;
            --secondary-color: <?php echo $secondary_color; ?>;
            --accent-color: <?php echo $accent_color; ?>;
        }
        
        .logo {
            color: <?php echo $primary_color; ?>;
        }
        
        .logo:hover {
            color: <?php echo $secondary_color; ?>;
        }
        
        .nav-links li a:hover {
            color: <?php echo $secondary_color; ?>;
        }
        
        .nav-links li a::after {
            background: <?php echo $secondary_color; ?>;
        }
        
        .slide-button {
            background: <?php echo $primary_color; ?>;
        }
        
        .slide-button:hover {
            background: <?php echo $secondary_color; ?>;
        }
        
        .product-button {
            background: <?php echo $primary_color; ?>;
        }
        
        .product-button:hover {
            background: <?php echo $secondary_color; ?>;
        }
        
        .product-price {
            color: <?php echo $secondary_color; ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'generic_customize_css');

// Adicionar suporte a widgets
function generic_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar Principal', 'generic-ecommerce'),
        'id'            => 'sidebar-1',
        'description'   => __('Widgets da sidebar principal', 'generic-ecommerce'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer 1', 'generic-ecommerce'),
        'id'            => 'footer-1',
        'description'   => __('Widgets do footer coluna 1', 'generic-ecommerce'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer 2', 'generic-ecommerce'),
        'id'            => 'footer-2',
        'description'   => __('Widgets do footer coluna 2', 'generic-ecommerce'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer 3', 'generic-ecommerce'),
        'id'            => 'footer-3',
        'description'   => __('Widgets do footer coluna 3', 'generic-ecommerce'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer 4', 'generic-ecommerce'),
        'id'            => 'footer-4',
        'description'   => __('Widgets do footer coluna 4', 'generic-ecommerce'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'generic_widgets_init');

// Adicionar suporte a WooCommerce
function generic_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'generic_woocommerce_support');

// Personalizar WooCommerce
function generic_woocommerce_customizations() {
    // Remover breadcrumbs padrão
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    
    // Adicionar breadcrumbs personalizados
    add_action('woocommerce_before_main_content', 'generic_woocommerce_breadcrumb', 20);
    
    // Personalizar botões
    add_filter('woocommerce_loop_add_to_cart_args', 'generic_add_to_cart_args');
    
    // Personalizar preços
    add_filter('woocommerce_price_format', 'generic_price_format');
}
add_action('init', 'generic_woocommerce_customizations');

// Breadcrumbs personalizados
function generic_woocommerce_breadcrumb() {
    if (function_exists('woocommerce_breadcrumb')) {
        woocommerce_breadcrumb(array(
            'delimiter'   => ' / ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb">',
            'wrap_after'  => '</nav>',
        ));
    }
}

// Personalizar botões
function generic_add_to_cart_args($args) {
    $args['class'] = 'button product-button';
    return $args;
}

// Personalizar formato de preço
function generic_price_format($format) {
    return '%2$s %1$s';
}

// Adicionar suporte a thumbnails
function generic_add_thumbnail_support() {
    add_post_type_support('generic_product', 'thumbnail');
    add_post_type_support('generic_collection', 'thumbnail');
    add_post_type_support('generic_slider', 'thumbnail');
    add_post_type_support('generic_banner', 'thumbnail');
}
add_action('init', 'generic_add_thumbnail_support');

// Adicionar tamanhos de imagem personalizados
function generic_add_image_sizes() {
    add_image_size('generic-product-thumb', 300, 300, true);
    add_image_size('generic-product-large', 600, 600, true);
    add_image_size('generic-collection-thumb', 400, 300, true);
    add_image_size('generic-slider-large', 1200, 600, true);
    add_image_size('generic-banner-large', 1200, 400, true);
}
add_action('after_setup_theme', 'generic_add_image_sizes');

// Adicionar suporte a menus
function generic_register_menus() {
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'generic-ecommerce'),
        'footer'  => __('Menu Footer', 'generic-ecommerce'),
        'mobile'  => __('Menu Mobile', 'generic-ecommerce'),
    ));
}
add_action('init', 'generic_register_menus');

// Adicionar suporte a custom logo
function generic_custom_logo_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'generic_custom_logo_setup');

// Adicionar suporte a HTML5
function generic_html5_support() {
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'generic_html5_support');

// Adicionar suporte a título dinâmico
function generic_title_tag_support() {
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'generic_title_tag_support');

// Adicionar suporte a imagens destacadas
function generic_post_thumbnails_support() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'generic_post_thumbnails_support');
