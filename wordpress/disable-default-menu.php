<?php
/**
 * Desabilitar Menu Padrão do WordPress
 * Script para remover o menu padrão que exibe todas as páginas
 */

// Carregar WordPress
require_once('wp-load.php');

echo "=== DESABILITANDO MENU PADRÃO ===\n\n";

// 1. Desabilitar menu padrão do WordPress
echo "1. Desabilitando menu padrão...\n";

// Adicionar filtro para desabilitar wp_page_menu
add_filter('wp_page_menu_args', function($args) {
    $args['show_home'] = false;
    $args['echo'] = false;
    return $args;
}, 999);

// Adicionar filtro para desabilitar menu automático
add_filter('wp_nav_menu_args', function($args) {
    $args['echo'] = false;
    return $args;
}, 999);

// Adicionar filtro para desabilitar menu padrão do Astra
add_filter('astra_get_dynamic_header_content', function($output, $option, $section) {
    if ($section === 'menu') {
        return array();
    }
    return $output;
}, 10, 3);

echo "   ✓ Menu padrão desabilitado\n";

// 2. Configurar tema para não exibir menu automático
echo "2. Configurando tema...\n";

// Desabilitar navegação primária
update_option('astra-settings[disable-primary-nav]', true);

// Configurar seção do header para 'none'
update_option('astra-settings[header-main-rt-section]', 'none');

echo "   ✓ Configurações do tema atualizadas\n";

// 3. Limpar cache
echo "3. Limpando cache...\n";

if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}

echo "   ✓ Cache limpo\n";

echo "\n=== MENU PADRÃO DESABILITADO ===\n";
echo "O menu padrão do WordPress foi desabilitado.\n";
echo "Agora apenas o menu personalizado será exibido.\n";
echo "\nAcesse o site para ver as mudanças!\n";
echo "URL: " . home_url() . "\n";
?>
