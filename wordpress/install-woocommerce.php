<?php
// Script para instalar WooCommerce automaticamente
require_once('wp-config.php');

// Verificar se WooCommerce já está instalado
if (is_plugin_active('woocommerce/woocommerce.php')) {
    echo "✅ WooCommerce já está instalado!\n";
    exit;
}

// Baixar WooCommerce
$woocommerce_url = 'https://downloads.wordpress.org/plugin/woocommerce.latest-stable.zip';
$woocommerce_zip = 'woocommerce.zip';

echo "📥 Baixando WooCommerce...\n";
$woocommerce_content = file_get_contents($woocommerce_url);
file_put_contents($woocommerce_zip, $woocommerce_content);

echo "📦 Extraindo WooCommerce...\n";
$zip = new ZipArchive();
if ($zip->open($woocommerce_zip) === TRUE) {
    $zip->extractTo('wp-content/plugins/');
    $zip->close();
    unlink($woocommerce_zip);
    echo "✅ WooCommerce extraído com sucesso!\n";
} else {
    echo "❌ Erro ao extrair WooCommerce\n";
    exit;
}

// Ativar WooCommerce
echo "🔌 Ativando WooCommerce...\n";
$plugin_file = 'woocommerce/woocommerce.php';
$result = activate_plugin($plugin_file);

if (is_wp_error($result)) {
    echo "❌ Erro ao ativar WooCommerce: " . $result->get_error_message() . "\n";
} else {
    echo "✅ WooCommerce ativado com sucesso!\n";
    echo "🎉 Instalação concluída!\n";
    echo "Acesse: http://localhost/wp-admin\n";
}
?>
