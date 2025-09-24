<?php
// Script para instalar tema Astra e plugins essenciais
require_once('wp-config.php');

echo "🎨 Instalando tema Astra e plugins essenciais...\n\n";

// 1. Instalar tema Astra
echo "📦 Baixando tema Astra...\n";
$astra_url = 'https://downloads.wordpress.org/theme/astra.latest-stable.zip';
$astra_zip = 'astra.zip';

$astra_content = file_get_contents($astra_url);
if ($astra_content === false) {
    echo "❌ Erro ao baixar tema Astra\n";
    exit;
}

file_put_contents($astra_zip, $astra_content);

echo "📦 Extraindo tema Astra...\n";
$zip = new ZipArchive();
if ($zip->open($astra_zip) === TRUE) {
    $zip->extractTo('wp-content/themes/');
    $zip->close();
    unlink($astra_zip);
    echo "✅ Tema Astra extraído com sucesso!\n";
} else {
    echo "❌ Erro ao extrair tema Astra\n";
    exit;
}

// 2. Ativar tema Astra
echo "🔌 Ativando tema Astra...\n";
switch_theme('astra');
echo "✅ Tema Astra ativado!\n";

// 3. Instalar plugins essenciais
echo "\n📦 Instalando plugins essenciais...\n";

$plugins = [
    'wordpress-seo' => 'https://downloads.wordpress.org/plugin/wordpress-seo.latest-stable.zip',
    'wp-super-cache' => 'https://downloads.wordpress.org/plugin/wp-super-cache.latest-stable.zip',
    'smush' => 'https://downloads.wordpress.org/plugin/wp-smushit.latest-stable.zip',
    'wordfence' => 'https://downloads.wordpress.org/plugin/wordfence.latest-stable.zip',
    'woocommerce-extra-checkout-fields-for-brazil' => 'https://downloads.wordpress.org/plugin/woocommerce-extra-checkout-fields-for-brazil.latest-stable.zip',
    'woocommerce-correios' => 'https://downloads.wordpress.org/plugin/woocommerce-correios.latest-stable.zip',
    'woocommerce-pagseguro' => 'https://downloads.wordpress.org/plugin/woocommerce-pagseguro.latest-stable.zip',
    'woocommerce-pix' => 'https://downloads.wordpress.org/plugin/woocommerce-pix.latest-stable.zip'
];

foreach ($plugins as $plugin_slug => $plugin_url) {
    echo "📥 Baixando {$plugin_slug}...\n";
    
    $plugin_content = file_get_contents($plugin_url);
    if ($plugin_content === false) {
        echo "❌ Erro ao baixar {$plugin_slug}\n";
        continue;
    }
    
    $plugin_zip = $plugin_slug . '.zip';
    file_put_contents($plugin_zip, $plugin_content);
    
    echo "📦 Extraindo {$plugin_slug}...\n";
    $zip = new ZipArchive();
    if ($zip->open($plugin_zip) === TRUE) {
        $zip->extractTo('wp-content/plugins/');
        $zip->close();
        unlink($plugin_zip);
        echo "✅ {$plugin_slug} extraído com sucesso!\n";
        
        // Ativar plugin
        $plugin_file = $plugin_slug . '/' . $plugin_slug . '.php';
        if (file_exists('wp-content/plugins/' . $plugin_file)) {
            $result = activate_plugin($plugin_file);
            if (is_wp_error($result)) {
                echo "⚠️ Erro ao ativar {$plugin_slug}: " . $result->get_error_message() . "\n";
            } else {
                echo "🔌 {$plugin_slug} ativado!\n";
            }
        }
    } else {
        echo "❌ Erro ao extrair {$plugin_slug}\n";
    }
}

// 4. Configurar tema para e-commerce
echo "\n⚙️ Configurando tema para e-commerce...\n";

// Configurar página inicial como loja
update_option('show_on_front', 'page');
$shop_page = get_page_by_path('shop');
if ($shop_page) {
    update_option('page_on_front', $shop_page->ID);
    echo "✅ Página inicial configurada para loja\n";
}

// Configurar menu principal
echo "📋 Configurando menu principal...\n";
$menu_id = wp_create_nav_menu('Menu Principal');
if (!is_wp_error($menu_id)) {
    // Adicionar itens ao menu
    $menu_items = [
        'Início' => '/',
        'Loja' => '/shop',
        'Sobre' => '/sobre',
        'Contato' => '/contato'
    ];
    
    foreach ($menu_items as $title => $url) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => $title,
            'menu-item-url' => home_url($url),
            'menu-item-status' => 'publish'
        ]);
    }
    
    // Atribuir menu ao localização
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    
    echo "✅ Menu principal configurado\n";
}

// 5. Configurar widgets
echo "🎛️ Configurando widgets...\n";
$sidebar_id = 'sidebar-1';
$widgets = [
    'search' => 'WP_Widget_Search',
    'recent-posts' => 'WP_Widget_Recent_Posts',
    'recent-comments' => 'WP_Widget_Recent_Comments',
    'archives' => 'WP_Widget_Archives',
    'categories' => 'WP_Widget_Categories',
    'meta' => 'WP_Widget_Meta'
];

foreach ($widgets as $widget_id => $widget_class) {
    $widget_instance = new $widget_class();
    $widget_instance->widget($sidebar_id, []);
}

echo "✅ Widgets configurados\n";

echo "\n🎉 Instalação concluída!\n";
echo "🌐 Site: http://localhost\n";
echo "🛍️ Loja: http://localhost/shop\n";
echo "⚙️ Admin: http://localhost/wp-admin\n";
echo "📊 Plugins instalados:\n";
echo "  - Yoast SEO\n";
echo "  - WP Super Cache\n";
echo "  - Smush (otimização de imagens)\n";
echo "  - Wordfence (segurança)\n";
echo "  - WooCommerce Extra Checkout Fields for Brazil\n";
echo "  - WooCommerce Correios\n";
echo "  - WooCommerce PagSeguro\n";
echo "  - WooCommerce PIX\n";
?>



