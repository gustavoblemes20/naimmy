<?php
// Script para instalar Smush
require_once('wp-config.php');

echo "📦 Instalando Smush...\n\n";

// Instalar Smush
echo "📥 Baixando Smush...\n";
$smush_url = 'https://downloads.wordpress.org/plugin/wp-smushit.latest-stable.zip';
$smush_zip = 'smush.zip';

$smush_content = file_get_contents($smush_url);
if ($smush_content === false) {
    echo "❌ Erro ao baixar Smush\n";
    exit;
}

file_put_contents($smush_zip, $smush_content);

echo "📦 Extraindo Smush...\n";
$zip = new ZipArchive();
if ($zip->open($smush_zip) === TRUE) {
    $zip->extractTo('wp-content/plugins/');
    $zip->close();
    unlink($smush_zip);
    echo "✅ Smush extraído com sucesso!\n";
} else {
    echo "❌ Erro ao extrair Smush\n";
    exit;
}

// Ativar plugin
echo "🔌 Ativando Smush...\n";
$result = activate_plugin('wp-smushit/wp-smush.php');
if (is_wp_error($result)) {
    echo "❌ Erro ao ativar Smush: " . $result->get_error_message() . "\n";
} else {
    echo "✅ Smush ativado!\n";
}

echo "\n🎉 Smush instalado e ativado!\n";
echo "🌐 Site: http://localhost\n";
echo "⚙️ Admin: http://localhost/wp-admin\n";
?>
