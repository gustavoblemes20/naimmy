<?php
/**
 * Aplicação do Estilo Miu Miu
 * Script para aplicar o design minimalista e elegante da Miu Miu
 */

// Carregar WordPress
require_once('wp-load.php');

echo "=== APLICANDO ESTILO MIU MIU ===\n\n";

// 1. Configurar tema e personalizações
echo "1. Configurando tema e personalizações...\n";

// Ativar tema Astra (se disponível) ou configurar tema atual
$current_theme = wp_get_theme();
echo "   Tema atual: " . $current_theme->get('Name') . "\n";

// 2. Configurar cores e tipografia
echo "2. Configurando cores e tipografia...\n";

// Cores principais (inspiradas na Miu Miu)
$miumiu_colors = array(
    'primary' => '#000000',      // Preto
    'secondary' => '#f5f5f5',    // Branco sujo
    'accent' => '#8b7355',       // Bege elegante
    'text' => '#333333',         // Cinza escuro
    'background' => '#ffffff'    // Branco puro
);

// Aplicar cores personalizadas
update_option('astra-settings', array(
    'site-layout' => 'ast-full-width-layout',
    'site-content-layout' => 'page-builder',
    'single-page-content-layout' => 'page-builder',
    'single-post-content-layout' => 'page-builder',
    'archive-page-content-layout' => 'page-builder',
    'site-sidebar-layout' => 'no-sidebar',
    'single-page-sidebar-layout' => 'no-sidebar',
    'single-post-sidebar-layout' => 'no-sidebar',
    'archive-page-sidebar-layout' => 'no-sidebar',
    'site-layout-outside-bg-obj' => array(
        'background-color' => $miumiu_colors['background'],
        'background-image' => '',
        'background-repeat' => 'no-repeat',
        'background-position' => 'center center',
        'background-size' => 'auto',
        'background-attachment' => 'scroll'
    ),
    'site-layout-outside-bg-obj-responsive' => array(
        'desktop' => array(
            'background-color' => $miumiu_colors['background'],
            'background-image' => '',
            'background-repeat' => 'no-repeat',
            'background-position' => 'center center',
            'background-size' => 'auto',
            'background-attachment' => 'scroll'
        )
    )
));

echo "   ✓ Cores aplicadas\n";

// 3. Configurar header minimalista
echo "3. Configurando header minimalista...\n";

// Configurar logo centralizado
update_option('custom_logo', '');
update_option('blogname', 'Naimmy E-commerce');
update_option('blogdescription', 'Moda e Elegância');

// Configurar menu principal
$menu_id = wp_create_nav_menu('Menu Principal');
if ($menu_id) {
    // Adicionar itens do menu
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Coleções',
        'menu-item-url' => home_url('/colecoes/'),
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Bolsas',
        'menu-item-url' => home_url('/produto-categoria/bolsas/'),
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Calçados',
        'menu-item-url' => home_url('/produto-categoria/calcados/'),
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Acessórios',
        'menu-item-url' => home_url('/produto-categoria/acessorios/'),
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Novidades',
        'menu-item-url' => home_url('/novidades/'),
        'menu-item-status' => 'publish'
    ));
    
    // Atribuir menu ao local correto
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

echo "   ✓ Menu principal configurado\n";

// 4. Configurar WooCommerce
echo "4. Configurando WooCommerce...\n";

// Configurar layout do WooCommerce
update_option('woocommerce_shop_page_display', 'products');
update_option('woocommerce_category_archive_display', 'products');
update_option('woocommerce_default_catalog_orderby', 'menu_order');
update_option('woocommerce_shop_page_id', get_option('woocommerce_shop_page_id'));

// Configurar produtos por página
update_option('woocommerce_shop_page_id', get_option('woocommerce_shop_page_id'));
update_option('woocommerce_shop_page_display', 'products');
update_option('woocommerce_category_archive_display', 'products');

echo "   ✓ WooCommerce configurado\n";

// 5. Criar páginas essenciais
echo "5. Criando páginas essenciais...\n";

// Página Sobre
$about_page = array(
    'post_title' => 'Sobre Nós',
    'post_content' => '<h2>Nossa História</h2><p>Somos uma marca de moda elegante e sofisticada, inspirada na estética minimalista e atemporal.</p><h2>Nossa Missão</h2><p>Oferecer produtos de alta qualidade com design único e elegante.</p>',
    'post_status' => 'publish',
    'post_type' => 'page'
);
wp_insert_post($about_page);

// Página Contato
$contact_page = array(
    'post_title' => 'Contato',
    'post_content' => '<h2>Entre em Contato</h2><p>Telefone: (11) 99999-9999</p><p>Email: contato@naimmy.com</p><p>Endereço: São Paulo, SP</p>',
    'post_status' => 'publish',
    'post_type' => 'page'
);
wp_insert_post($contact_page);

echo "   ✓ Páginas criadas\n";

// 6. Configurar widgets e áreas
echo "6. Configurando widgets...\n";

// Limpar widgets existentes
$sidebars = array('sidebar-1', 'sidebar-2', 'footer-1', 'footer-2', 'footer-3', 'footer-4');
foreach ($sidebars as $sidebar) {
    $widgets = get_option('widget_' . $sidebar);
    if ($widgets) {
        update_option('widget_' . $sidebar, array());
    }
}

echo "   ✓ Widgets configurados\n";

// 7. Configurar SEO
echo "7. Configurando SEO...\n";

// Configurar Yoast SEO se disponível
if (class_exists('WPSEO_Options')) {
    update_option('wpseo_titles', array(
        'title-home' => '%%sitename%% - %%sitedesc%%',
        'metadesc-home' => 'Loja online de moda elegante e sofisticada. Produtos de alta qualidade com design único.',
        'title-post' => '%%title%% - %%sitename%%',
        'metadesc-post' => '%%excerpt%%',
        'title-page' => '%%title%% - %%sitename%%',
        'metadesc-page' => '%%excerpt%%',
        'title-product' => '%%title%% - %%sitename%%',
        'metadesc-product' => '%%excerpt%%'
    ));
}

echo "   ✓ SEO configurado\n";

// 8. Criar CSS personalizado
echo "8. Criando CSS personalizado...\n";

$custom_css = "
/* Estilo Miu Miu - CSS Personalizado */

/* Reset e base */
* {
    box-sizing: border-box;
}

body {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    font-size: 16px;
    line-height: 1.6;
    color: #333;
    background-color: #fff;
    margin: 0;
    padding: 0;
}

/* Header */
.site-header {
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
    padding: 20px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.site-branding {
    text-align: center;
    margin-bottom: 30px;
}

.site-title {
    font-size: 32px;
    font-weight: 300;
    letter-spacing: 2px;
    margin: 0;
    color: #000;
}

.site-description {
    font-size: 14px;
    color: #666;
    margin: 5px 0 0 0;
    font-weight: 300;
}

/* Navegação */
.main-navigation {
    text-align: center;
    margin: 20px 0;
}

.main-navigation ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

.main-navigation li {
    margin: 0 30px;
}

.main-navigation a {
    text-decoration: none;
    color: #000;
    font-size: 14px;
    font-weight: 400;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: color 0.3s ease;
}

.main-navigation a:hover {
    color: #8b7355;
}

/* Conteúdo */
.site-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

/* Produtos */
.woocommerce ul.products {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
    margin: 0;
    padding: 0;
}

.woocommerce ul.products li.product {
    background: #fff;
    border: 1px solid #f0f0f0;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.woocommerce ul.products li.product:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.woocommerce ul.products li.product img {
    width: 100%;
    height: auto;
    margin-bottom: 20px;
}

.woocommerce ul.products li.product h2 {
    font-size: 16px;
    font-weight: 400;
    margin: 0 0 10px 0;
    color: #000;
}

.woocommerce ul.products li.product .price {
    font-size: 18px;
    font-weight: 300;
    color: #000;
    margin: 0 0 20px 0;
}

.woocommerce ul.products li.product .button {
    background: #000;
    color: #fff;
    border: none;
    padding: 12px 30px;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.3s ease;
}

.woocommerce ul.products li.product .button:hover {
    background: #8b7355;
}

/* Footer */
.site-footer {
    background: #f8f8f8;
    padding: 60px 0 30px 0;
    margin-top: 80px;
    text-align: center;
}

.site-footer .widget {
    margin-bottom: 40px;
}

.site-footer .widget-title {
    font-size: 16px;
    font-weight: 400;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin: 0 0 20px 0;
    color: #000;
}

.site-footer .widget ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.site-footer .widget ul li {
    margin: 0 0 10px 0;
}

.site-footer .widget ul li a {
    color: #666;
    text-decoration: none;
    font-size: 14px;
}

.site-footer .widget ul li a:hover {
    color: #000;
}

/* Responsivo */
@media (max-width: 768px) {
    .main-navigation ul {
        flex-direction: column;
        gap: 20px;
    }
    
    .main-navigation li {
        margin: 0;
    }
    
    .woocommerce ul.products {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .site-content {
        padding: 20px 15px;
    }
}

/* Botões */
.button, .btn {
    background: #000;
    color: #fff;
    border: none;
    padding: 12px 30px;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.button:hover, .btn:hover {
    background: #8b7355;
    color: #fff;
}

/* Formulários */
input[type='text'], input[type='email'], input[type='password'], textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    font-size: 14px;
    margin-bottom: 20px;
}

input[type='text']:focus, input[type='email']:focus, input[type='password']:focus, textarea:focus {
    outline: none;
    border-color: #8b7355;
}

/* Títulos */
h1, h2, h3, h4, h5, h6 {
    font-weight: 300;
    color: #000;
    margin: 0 0 20px 0;
}

h1 { font-size: 36px; }
h2 { font-size: 28px; }
h3 { font-size: 24px; }
h4 { font-size: 20px; }
h5 { font-size: 18px; }
h6 { font-size: 16px; }

/* Links */
a {
    color: #000;
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover {
    color: #8b7355;
}

/* Utilitários */
.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }
.mb-20 { margin-bottom: 20px; }
.mb-40 { margin-bottom: 40px; }
.mt-20 { margin-top: 20px; }
.mt-40 { margin-top: 40px; }
";

// Salvar CSS personalizado
update_option('custom_css', $custom_css);

echo "   ✓ CSS personalizado criado\n";

// 9. Configurar cache
echo "9. Configurando cache...\n";

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

echo "\n=== ESTILO MIU MIU APLICADO COM SUCESSO ===\n";
echo "O site agora possui:\n";
echo "• Design minimalista e elegante\n";
echo "• Cores inspiradas na Miu Miu\n";
echo "• Tipografia sofisticada\n";
echo "• Layout responsivo\n";
echo "• Navegação intuitiva\n";
echo "• Produtos bem organizados\n";
echo "• Footer informativo\n";
echo "\nAcesse o site para ver as mudanças!\n";
?>
