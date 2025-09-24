<?php
/**
 * Script de Otimização de Plugins
 * Desativa plugins desnecessários e otimiza configurações
 */

// Carregar WordPress
require_once('wp-config.php');
require_once('wp-includes/wp-db.php');
require_once('wp-includes/pluggable.php');

echo "=== OTIMIZAÇÃO DE PLUGINS ===\n\n";

// Lista de plugins para desativar (plugins desnecessários ou que impactam performance)
$plugins_to_deactivate = [
    'hello.php', // Plugin Hello Dolly (desnecessário)
];

// Lista de plugins essenciais que devem permanecer ativos
$essential_plugins = [
    'woocommerce/woocommerce.php',
    'woocommerce-correios/woocommerce-correios.php',
    'woocommerce-extra-checkout-fields-for-brazil/woocommerce-extra-checkout-fields-for-brazil.php',
    'woocommerce-pagseguro/woocommerce-pagseguro.php',
    'wordfence/wordfence.php',
    'wordpress-seo/wp-seo.php',
    'wp-smushit/wp-smush.php',
    'wp-super-cache/wp-cache.php'
];

echo "1. Verificando plugins ativos...\n";
$active_plugins = get_option('active_plugins', []);

echo "   Plugins ativos: " . count($active_plugins) . "\n";

// Desativar plugins desnecessários
echo "\n2. Desativando plugins desnecessários...\n";
foreach ($plugins_to_deactivate as $plugin) {
    if (in_array($plugin, $active_plugins)) {
        deactivate_plugins($plugin);
        echo "   ✓ Desativado: $plugin\n";
    }
}

// Verificar plugins essenciais
echo "\n3. Verificando plugins essenciais...\n";
foreach ($essential_plugins as $plugin) {
    if (in_array($plugin, $active_plugins)) {
        echo "   ✓ Ativo: $plugin\n";
    } else {
        echo "   ⚠️  Inativo: $plugin\n";
    }
}

// Otimizar configurações do Wordfence
echo "\n4. Otimizando configurações do Wordfence...\n";
$wordfence_options = get_option('wordfence_options', []);
if (!empty($wordfence_options)) {
    // Reduzir frequência de scans
    $wordfence_options['scanType'] = 'quick';
    $wordfence_options['schedMode'] = 'manual';
    $wordfence_options['maxMem'] = 256;
    update_option('wordfence_options', $wordfence_options);
    echo "   ✓ Configurações do Wordfence otimizadas\n";
}

// Otimizar configurações do Yoast SEO
echo "\n5. Otimizando configurações do Yoast SEO...\n";
$yoast_options = get_option('wpseo', []);
if (!empty($yoast_options)) {
    // Desabilitar features desnecessárias
    $yoast_options['disableadvanced_meta'] = true;
    $yoast_options['disable_author_sitemap'] = true;
    $yoast_options['disable_author_archives'] = true;
    update_option('wpseo', $yoast_options);
    echo "   ✓ Configurações do Yoast SEO otimizadas\n";
}

// Otimizar configurações do WP Smush
echo "\n6. Otimizando configurações do WP Smush...\n";
$smush_options = get_option('wp-smush-settings', []);
if (!empty($smush_options)) {
    // Configurações otimizadas
    $smush_options['auto'] = true;
    $smush_options['lossy'] = true;
    $smush_options['strip_exif'] = true;
    $smush_options['resize'] = true;
    $smush_options['max_width'] = 1920;
    $smush_options['max_height'] = 1920;
    update_option('wp-smush-settings', $smush_options);
    echo "   ✓ Configurações do WP Smush otimizadas\n";
}

// Limpar cache de plugins
echo "\n7. Limpando cache de plugins...\n";
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "   ✓ Cache do WordPress limpo\n";
}

// Limpar cache do WooCommerce
if (class_exists('WC_Cache_Helper')) {
    WC_Cache_Helper::get_transient_version('shipping', true);
    echo "   ✓ Cache do WooCommerce limpo\n";
}

// Estatísticas finais
echo "\n=== ESTATÍSTICAS FINAIS ===\n";
$active_plugins_after = get_option('active_plugins', []);
echo "Plugins ativos antes: " . count($active_plugins) . "\n";
echo "Plugins ativos depois: " . count($active_plugins_after) . "\n";
echo "Plugins desativados: " . (count($active_plugins) - count($active_plugins_after)) . "\n";

echo "\n=== OTIMIZAÇÃO DE PLUGINS CONCLUÍDA ===\n";
?>
