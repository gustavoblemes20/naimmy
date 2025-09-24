<?php
/**
 * Verificação Final de Performance
 * Script para verificar todas as otimizações aplicadas
 */

// Carregar WordPress
require_once('wp-config.php');
require_once('wp-includes/wp-db.php');
require_once('wp-includes/pluggable.php');

echo "=== VERIFICAÇÃO FINAL DE PERFORMANCE ===\n\n";

// 1. Verificar configurações do PHP
echo "1. CONFIGURAÇÕES DO PHP:\n";
echo "   Memory Limit: " . ini_get('memory_limit') . "\n";
echo "   Max Execution Time: " . ini_get('max_execution_time') . "s\n";
echo "   Upload Max Filesize: " . ini_get('upload_max_filesize') . "\n";
echo "   Post Max Size: " . ini_get('post_max_size') . "\n";

// Verificar OPcache
if (extension_loaded('opcache')) {
    $opcache_status = opcache_get_status();
    if ($opcache_status !== false) {
        echo "   OPcache: ✅ ATIVO\n";
        echo "   Hit Rate: " . round($opcache_status['opcache_statistics']['opcache_hit_rate'], 2) . "%\n";
        echo "   Arquivos em cache: " . $opcache_status['opcache_statistics']['num_cached_scripts'] . "\n";
        echo "   Memória usada: " . round($opcache_status['memory_usage']['used_memory'] / 1024 / 1024, 2) . "M\n";
    } else {
        echo "   OPcache: ⚠️  Instalado mas não ativo\n";
    }
} else {
    echo "   OPcache: ❌ NÃO DISPONÍVEL\n";
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
    echo "   Total: " . count($active_plugins) . " plugins\n";
    foreach ($active_plugins as $plugin) {
        echo "   ✓ " . $plugin . "\n";
    }
} else {
    echo "   Nenhum plugin ativo encontrado\n";
}

// 4. Verificar banco de dados
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

// Teste de consultas
$posts_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status = 'publish'");
$comments_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_approved = '1'");

$end_time = microtime(true);
$execution_time = round(($end_time - $start_time) * 1000, 2);

echo "   Tempo de consulta: {$execution_time}ms\n";
echo "   Posts publicados: " . ($posts_count ?: 0) . "\n";
echo "   Comentários aprovados: " . ($comments_count ?: 0) . "\n";

// 8. Resumo de otimizações
echo "\n8. RESUMO DE OTIMIZAÇÕES:\n";

$optimizations = [];

// Verificar memory limit
if (ini_get('memory_limit') >= '512M') {
    $optimizations[] = "✅ Memory Limit: 512M+";
} else {
    $optimizations[] = "⚠️  Memory Limit: " . ini_get('memory_limit');
}

// Verificar debug
if (!WP_DEBUG) {
    $optimizations[] = "✅ WP Debug: Desabilitado";
} else {
    $optimizations[] = "⚠️  WP Debug: Ativo";
}

// Verificar cache
if (WP_CACHE) {
    $optimizations[] = "✅ WP Cache: Ativo";
} else {
    $optimizations[] = "⚠️  WP Cache: Inativo";
}

// Verificar cron
if (DISABLE_WP_CRON) {
    $optimizations[] = "✅ WP Cron: Externo";
} else {
    $optimizations[] = "⚠️  WP Cron: Interno";
}

// Verificar OPcache
if (extension_loaded('opcache') && opcache_get_status() !== false) {
    $optimizations[] = "✅ OPcache: Ativo";
} else {
    $optimizations[] = "⚠️  OPcache: Inativo";
}

foreach ($optimizations as $optimization) {
    echo "   $optimization\n";
}

// 9. Score de performance
echo "\n9. SCORE DE PERFORMANCE:\n";
$score = 0;
$total = 5;

if (ini_get('memory_limit') >= '512M') $score++;
if (!WP_DEBUG) $score++;
if (WP_CACHE) $score++;
if (DISABLE_WP_CRON) $score++;
if (extension_loaded('opcache') && opcache_get_status() !== false) $score++;

$percentage = round(($score / $total) * 100);
echo "   Score: $score/$total ($percentage%)\n";

if ($percentage >= 80) {
    echo "   Status: 🚀 EXCELENTE\n";
} elseif ($percentage >= 60) {
    echo "   Status: ✅ BOM\n";
} elseif ($percentage >= 40) {
    echo "   Status: ⚠️  REGULAR\n";
} else {
    echo "   Status: ❌ PRECISA MELHORAR\n";
}

echo "\n=== VERIFICAÇÃO CONCLUÍDA ===\n";
?>
