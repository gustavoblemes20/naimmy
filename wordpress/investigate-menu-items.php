<?php
/**
 * Investigar Itens do Menu
 * Script para descobrir de onde vêm os itens indesejados
 */

// Carregar WordPress
require_once('wp-load.php');

echo "=== INVESTIGANDO ITENS DO MENU ===\n\n";

// 1. Verificar todos os menus
echo "1. VERIFICANDO TODOS OS MENUS:\n";
$menus = wp_get_nav_menus();

if (empty($menus)) {
    echo "   Nenhum menu encontrado\n";
} else {
    foreach ($menus as $menu) {
        echo "   Menu: {$menu->name} (ID: {$menu->term_id})\n";
        
        $items = wp_get_nav_menu_items($menu->term_id);
        if ($items) {
            foreach ($items as $item) {
                echo "     - {$item->title} ({$item->url})\n";
            }
        } else {
            echo "     Nenhum item encontrado\n";
        }
        echo "\n";
    }
}

// 2. Verificar localizações de menu
echo "2. VERIFICANDO LOCALIZAÇÕES DE MENU:\n";
$locations = get_theme_mod('nav_menu_locations');

if (empty($locations)) {
    echo "   Nenhuma localização de menu configurada\n";
} else {
    foreach ($locations as $location => $menu_id) {
        echo "   Localização: {$location} -> Menu ID: {$menu_id}\n";
        
        if ($menu_id) {
            $menu = wp_get_nav_menu_object($menu_id);
            if ($menu) {
                echo "     Menu: {$menu->name}\n";
            }
        }
    }
}

// 3. Verificar páginas
echo "\n3. VERIFICANDO PÁGINAS:\n";
$pages = get_posts(array(
    'post_type' => 'page',
    'posts_per_page' => -1,
    'post_status' => 'publish'
));

if (empty($pages)) {
    echo "   Nenhuma página encontrada\n";
} else {
    foreach ($pages as $page) {
        echo "   Página: {$page->post_title} (ID: {$page->ID})\n";
    }
}

// 4. Verificar configurações do WooCommerce
echo "\n4. VERIFICANDO CONFIGURAÇÕES DO WOOCOMMERCE:\n";
if (class_exists('WooCommerce')) {
    $shop_page_id = get_option('woocommerce_shop_page_id');
    $cart_page_id = get_option('woocommerce_cart_page_id');
    $checkout_page_id = get_option('woocommerce_checkout_page_id');
    $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
    
    echo "   Shop Page ID: {$shop_page_id}\n";
    echo "   Cart Page ID: {$cart_page_id}\n";
    echo "   Checkout Page ID: {$checkout_page_id}\n";
    echo "   My Account Page ID: {$myaccount_page_id}\n";
    
    // Verificar se essas páginas existem
    if ($shop_page_id) {
        $shop_page = get_post($shop_page_id);
        if ($shop_page) {
            echo "   Shop Page: {$shop_page->post_title}\n";
        }
    }
    if ($cart_page_id) {
        $cart_page = get_post($cart_page_id);
        if ($cart_page) {
            echo "   Cart Page: {$cart_page->post_title}\n";
        }
    }
    if ($checkout_page_id) {
        $checkout_page = get_post($checkout_page_id);
        if ($checkout_page) {
            echo "   Checkout Page: {$checkout_page->post_title}\n";
        }
    }
    if ($myaccount_page_id) {
        $myaccount_page = get_post($myaccount_page_id);
        if ($myaccount_page) {
            echo "   My Account Page: {$myaccount_page->post_title}\n";
        }
    }
} else {
    echo "   WooCommerce não está ativo\n";
}

// 5. Verificar widgets
echo "\n5. VERIFICANDO WIDGETS:\n";
$sidebars = array('sidebar-1', 'sidebar-2', 'footer-1', 'footer-2', 'footer-3', 'footer-4');

foreach ($sidebars as $sidebar) {
    $widgets = get_option('widget_' . $sidebar);
    if ($widgets && is_array($widgets)) {
        echo "   Sidebar {$sidebar}: " . count($widgets) . " widgets\n";
        foreach ($widgets as $widget) {
            if (is_array($widget) && isset($widget['title'])) {
                echo "     - {$widget['title']}\n";
            }
        }
    }
}

// 6. Verificar se há menu sendo exibido automaticamente
echo "\n6. VERIFICANDO MENU AUTOMÁTICO:\n";
$auto_menu = wp_nav_menu(array(
    'echo' => false,
    'fallback_cb' => false
));

if ($auto_menu) {
    echo "   Menu automático encontrado\n";
    echo "   Conteúdo: " . substr(strip_tags($auto_menu), 0, 200) . "...\n";
} else {
    echo "   Nenhum menu automático\n";
}

// 7. Verificar configurações do tema
echo "\n7. VERIFICANDO CONFIGURAÇÕES DO TEMA:\n";
$current_theme = wp_get_theme();
echo "   Tema atual: {$current_theme->get('Name')}\n";
echo "   Versão: {$current_theme->get('Version')}\n";

// 8. Verificar se há menu padrão sendo exibido
echo "\n8. VERIFICANDO MENU PADRÃO:\n";
$default_menu = wp_get_nav_menu_object('primary');
if ($default_menu) {
    echo "   Menu 'primary' encontrado: {$default_menu->name}\n";
} else {
    echo "   Menu 'primary' não encontrado\n";
}

// 9. Verificar se há menu sendo exibido no header
echo "\n9. VERIFICANDO HEADER:\n";
$header_menu = wp_nav_menu(array(
    'theme_location' => 'primary',
    'echo' => false,
    'fallback_cb' => false
));

if ($header_menu) {
    echo "   Menu do header encontrado\n";
    echo "   Conteúdo: " . substr(strip_tags($header_menu), 0, 200) . "...\n";
} else {
    echo "   Nenhum menu no header\n";
}

// 10. Verificar se há menu sendo exibido no footer
echo "\n10. VERIFICANDO FOOTER:\n";
$footer_menu = wp_nav_menu(array(
    'theme_location' => 'footer',
    'echo' => false,
    'fallback_cb' => false
));

if ($footer_menu) {
    echo "   Menu do footer encontrado\n";
    echo "   Conteúdo: " . substr(strip_tags($footer_menu), 0, 200) . "...\n";
} else {
    echo "   Nenhum menu no footer\n";
}

echo "\n=== INVESTIGAÇÃO CONCLUÍDA ===\n";
?>
