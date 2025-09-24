<?php
/**
 * Tema Miu Miu - WordPress Theme
 * Aplica o estilo minimalista e elegante da Miu Miu
 */

// Incluir funções personalizadas
require_once get_template_directory() . '/functions-miumiu.php';

// Adicionar CSS personalizado
function enqueue_miumiu_styles() {
    wp_enqueue_style('miumiu-custom-css', get_template_directory_uri() . '/custom-miumiu-style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_miumiu_styles');

// Adicionar JavaScript personalizado
function enqueue_miumiu_scripts() {
    wp_enqueue_script('miumiu-custom-js', get_template_directory_uri() . '/custom-miumiu.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_miumiu_scripts');

// Adicionar CSS inline para garantir que seja carregado
function add_miumiu_inline_css() {
    echo '<style type="text/css">
        /* CSS inline para garantir carregamento */
        body { font-family: "Helvetica Neue", Arial, sans-serif; }
        .site-header { background: #fff; border-bottom: 1px solid #f0f0f0; }
        .site-title { font-size: 32px; font-weight: 300; letter-spacing: 2px; }
        .main-navigation { text-align: center; }
        .main-navigation ul { list-style: none; margin: 0; padding: 0; display: flex; justify-content: center; }
        .main-navigation li { margin: 0 30px; }
        .main-navigation a { color: #000; text-decoration: none; font-size: 14px; letter-spacing: 1px; text-transform: uppercase; }
        .main-navigation a:hover { color: #8b7355; }
        .woocommerce ul.products { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 40px; }
        .woocommerce ul.products li.product { background: #fff; border: 1px solid #f0f0f0; padding: 20px; text-align: center; }
        .woocommerce ul.products li.product:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .woocommerce ul.products li.product .button { background: #000; color: #fff; border: none; padding: 12px 30px; }
        .woocommerce ul.products li.product .button:hover { background: #8b7355; }
        .site-footer { background: #f8f8f8; padding: 60px 0; text-align: center; }
        @media (max-width: 768px) {
            .main-navigation ul { flex-direction: column; gap: 20px; }
            .woocommerce ul.products { grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        }
    </style>';
}
add_action('wp_head', 'add_miumiu_inline_css');
?>
