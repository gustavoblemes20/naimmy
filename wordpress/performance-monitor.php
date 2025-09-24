<?php
/**
 * Monitor de Performance do WordPress
 * Execute este script para verificar a performance do site
 */

// Carregar WordPress
require_once('wp-config.php');
require_once('wp-includes/wp-db.php');

echo "=== MONITOR DE PERFORMANCE ===\n\n";

// 1. Verificar configurações do PHP
echo "1. CONFIGURAÇÕES DO PHP:\n";
echo "   Memory Limit: " . ini_get('memory_limit') . "\n";
echo "   Max Execution Time: " . ini_get('max_execution_time') . "s\n";
echo "   Upload Max Filesize: " . ini_get('upload_max_filesize') . "\n";
echo "   Post Max Size: " . ini_get('post_max_size') . "\n";
echo "   OPcache Status: " . (extension_loaded('opcache') ? 'Ativo' : 'Inativo') . "\n";
if (extension_loaded('opcache')) {
    $opcache = opcache_get_status();
    echo "   OPcache Hit Rate: " . round($opcache['opcache_statistics']['opcache_hit_rate'], 2) . "%\n";
}

// 2. Verificar configurações do WordPress
echo "\n2. CONFIGURAÇÕES DO WORDPRESS:\n";
echo "   WP Memory Limit: " . WP_MEMORY_LIMIT . "\n";
echo "   WP Debug: " . (WP_DEBUG ? 'Ativo' : 'Inativo') . "\n";
echo "   WP Cache: " . (WP_CACHE ? 'Ativo' : 'Inativo') . "\n";
echo "   WP Cron: " . (DISABLE_WP_CRON ? 'Desabilitado' : 'Habilitado') . "\n";

// 3. Verificar plugins ativos
echo "\n3. PLUGINS ATIVOS:\n";
$active_plugins = get_option('active_plugins');
if ($active_plugins) {
    foreach ($active_plugins as $plugin) {
        echo "   - " . $plugin . "\n";
    }
} else {
    echo "   Nenhum plugin ativo encontrado\n";
}

// 4. Verificar tamanho do banco de dados
echo "\n4. BANCO DE DADOS:\n";
$wpdb = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
$db_size = $wpdb->get_var("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'DB Size in MB' FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "'");
echo "   Tamanho: {$db_size} MB\n";

// 5. Verificar cache
echo "\n5. CACHE:\n";
if (file_exists(WP_CONTENT_DIR . '/cache/')) {
    $cache_size = shell_exec("du -sh " . WP_CONTENT_DIR . "/cache/ 2>/dev/null | cut -f1");
    echo "   Cache Size: " . trim($cache_size) . "\n";
} else {
    echo "   Cache: Não encontrado\n";
}

// 6. Verificar uploads
echo "\n6. UPLOADS:\n";
if (file_exists(WP_CONTENT_DIR . '/uploads/')) {
    $uploads_size = shell_exec("du -sh " . WP_CONTENT_DIR . "/uploads/ 2>/dev/null | cut -f1");
    echo "   Uploads Size: " . trim($uploads_size) . "\n";
} else {
    echo "   Uploads: Não encontrado\n";
}

// 7. Teste de performance
echo "\n7. TESTE DE PERFORMANCE:\n";
$start_time = microtime(true);

// Simular carregamento de página
$posts_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status = 'publish'");
$comments_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_approved = '1'");

$end_time = microtime(true);
$execution_time = round(($end_time - $start_time) * 1000, 2);
echo "   Tempo de consulta: {$execution_time}ms\n";
echo "   Posts publicados: " . ($posts_count ?: 0) . "\n";
echo "   Comentários aprovados: " . ($comments_count ?: 0) . "\n";

// 8. Recomendações
echo "\n8. RECOMENDAÇÕES:\n";
if (ini_get('memory_limit') < '512M') {
    echo "   ⚠️  Aumentar memory_limit para 512M ou mais\n";
}
if (!extension_loaded('opcache')) {
    echo "   ⚠️  Ativar OPcache para melhor performance\n";
}
if (WP_DEBUG) {
    echo "   ⚠️  Desabilitar WP_DEBUG em produção\n";
}
if (!$wpdb->get_var("SELECT 1 FROM {$wpdb->options} WHERE option_name = 'wp_super_cache_enabled' AND option_value = '1'")) {
    echo "   ⚠️  Ativar WP Super Cache\n";
}

echo "\n=== MONITOR CONCLUÍDO ===\n";
?>
