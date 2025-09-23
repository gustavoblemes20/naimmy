<?php
// Script para instalar WP Super Cache
require_once('wp-config.php');

echo "📦 Instalando WP Super Cache...\n\n";

// Instalar WP Super Cache
echo "📥 Baixando WP Super Cache...\n";
$cache_url = 'https://downloads.wordpress.org/plugin/wp-super-cache.latest-stable.zip';
$cache_zip = 'cache.zip';

$cache_content = file_get_contents($cache_url);
if ($cache_content === false) {
    echo "❌ Erro ao baixar WP Super Cache\n";
    exit;
}

file_put_contents($cache_zip, $cache_content);

echo "📦 Extraindo WP Super Cache...\n";
$zip = new ZipArchive();
if ($zip->open($cache_zip) === TRUE) {
    $zip->extractTo('wp-content/plugins/');
    $zip->close();
    unlink($cache_zip);
    echo "✅ WP Super Cache extraído com sucesso!\n";
} else {
    echo "❌ Erro ao extrair WP Super Cache\n";
    exit;
}

// Ativar plugin
echo "🔌 Ativando WP Super Cache...\n";
$result = activate_plugin('wp-super-cache/wp-cache.php');
if (is_wp_error($result)) {
    echo "❌ Erro ao ativar WP Super Cache: " . $result->get_error_message() . "\n";
} else {
    echo "✅ WP Super Cache ativado!\n";
}

echo "\n🎉 WP Super Cache instalado e ativado!\n";
echo "🌐 Site: http://localhost\n";
echo "⚙️ Admin: http://localhost/wp-admin\n";
?>
