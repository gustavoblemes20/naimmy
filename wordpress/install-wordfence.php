<?php
// Script para instalar Wordfence
require_once('wp-config.php');

echo "📦 Instalando Wordfence...\n\n";

// Instalar Wordfence
echo "📥 Baixando Wordfence...\n";
$wordfence_url = 'https://downloads.wordpress.org/plugin/wordfence.latest-stable.zip';
$wordfence_zip = 'wordfence.zip';

$wordfence_content = file_get_contents($wordfence_url);
if ($wordfence_content === false) {
    echo "❌ Erro ao baixar Wordfence\n";
    exit;
}

file_put_contents($wordfence_zip, $wordfence_content);

echo "📦 Extraindo Wordfence...\n";
$zip = new ZipArchive();
if ($zip->open($wordfence_zip) === TRUE) {
    $zip->extractTo('wp-content/plugins/');
    $zip->close();
    unlink($wordfence_zip);
    echo "✅ Wordfence extraído com sucesso!\n";
} else {
    echo "❌ Erro ao extrair Wordfence\n";
    exit;
}

// Ativar plugin
echo "🔌 Ativando Wordfence...\n";
$result = activate_plugin('wordfence/wordfence.php');
if (is_wp_error($result)) {
    echo "❌ Erro ao ativar Wordfence: " . $result->get_error_message() . "\n";
} else {
    echo "✅ Wordfence ativado!\n";
}

echo "\n🎉 Wordfence instalado e ativado!\n";
echo "🌐 Site: http://localhost\n";
echo "⚙️ Admin: http://localhost/wp-admin\n";
echo "\n📊 Plugins essenciais instalados:\n";
echo "  ✅ Yoast SEO (SEO)\n";
echo "  ✅ WP Super Cache (Performance)\n";
echo "  ✅ Smush (Otimização de imagens)\n";
echo "  ✅ Wordfence (Segurança)\n";
?>
