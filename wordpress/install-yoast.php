<?php
// Script para instalar apenas o Yoast SEO
require_once('wp-config.php');

echo "📦 Instalando Yoast SEO...\n\n";

// Instalar Yoast SEO
echo "📥 Baixando Yoast SEO...\n";
$yoast_url = 'https://downloads.wordpress.org/plugin/wordpress-seo.latest-stable.zip';
$yoast_zip = 'yoast.zip';

$yoast_content = file_get_contents($yoast_url);
if ($yoast_content === false) {
    echo "❌ Erro ao baixar Yoast SEO\n";
    exit;
}

file_put_contents($yoast_zip, $yoast_content);

echo "📦 Extraindo Yoast SEO...\n";
$zip = new ZipArchive();
if ($zip->open($yoast_zip) === TRUE) {
    $zip->extractTo('wp-content/plugins/');
    $zip->close();
    unlink($yoast_zip);
    echo "✅ Yoast SEO extraído com sucesso!\n";
} else {
    echo "❌ Erro ao extrair Yoast SEO\n";
    exit;
}

// Ativar plugin
echo "🔌 Ativando Yoast SEO...\n";
$result = activate_plugin('wordpress-seo/wp-seo.php');
if (is_wp_error($result)) {
    echo "❌ Erro ao ativar Yoast SEO: " . $result->get_error_message() . "\n";
} else {
    echo "✅ Yoast SEO ativado!\n";
}

echo "\n🎉 Yoast SEO instalado e ativado!\n";
echo "🌐 Site: http://localhost\n";
echo "⚙️ Admin: http://localhost/wp-admin\n";
?>



