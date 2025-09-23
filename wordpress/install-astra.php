<?php
// Script para instalar apenas o tema Astra
require_once('wp-config.php');

echo "🎨 Instalando tema Astra...\n\n";

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

// 3. Configurar página inicial como loja
echo "⚙️ Configurando página inicial...\n";
update_option('show_on_front', 'page');
$shop_page = get_page_by_path('shop');
if ($shop_page) {
    update_option('page_on_front', $shop_page->ID);
    echo "✅ Página inicial configurada para loja\n";
}

echo "\n🎉 Tema Astra instalado e configurado!\n";
echo "🌐 Site: http://localhost\n";
echo "🛍️ Loja: http://localhost/shop\n";
?>
