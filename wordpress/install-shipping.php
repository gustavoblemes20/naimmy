<?php
// Script para instalar e configurar frete
require_once('wp-config.php');

echo "🚚 Instalando e configurando frete...\n\n";

// Instalar plugin dos Correios
echo "📥 Baixando WooCommerce Correios...\n";
$correios_url = 'https://downloads.wordpress.org/plugin/woocommerce-correios.latest-stable.zip';
$correios_zip = 'correios.zip';

$correios_content = file_get_contents($correios_url);
if ($correios_content === false) {
    echo "❌ Erro ao baixar WooCommerce Correios\n";
    exit;
}

file_put_contents($correios_zip, $correios_content);

echo "📦 Extraindo WooCommerce Correios...\n";
$zip = new ZipArchive();
if ($zip->open($correios_zip) === TRUE) {
    $zip->extractTo('wp-content/plugins/');
    $zip->close();
    unlink($correios_zip);
    echo "✅ WooCommerce Correios extraído com sucesso!\n";
} else {
    echo "❌ Erro ao extrair WooCommerce Correios\n";
    exit;
}

// Ativar plugin
echo "🔌 Ativando WooCommerce Correios...\n";
$result = activate_plugin('woocommerce-correios/woocommerce-correios.php');
if (is_wp_error($result)) {
    echo "❌ Erro ao ativar WooCommerce Correios: " . $result->get_error_message() . "\n";
} else {
    echo "✅ WooCommerce Correios ativado!\n";
}

// Configurar métodos de frete
echo "⚙️ Configurando métodos de frete...\n";

// Configurar PAC
update_option('woocommerce_pac_settings', [
    'enabled' => 'yes',
    'title' => 'PAC',
    'description' => 'Entrega em até 5 dias úteis',
    'shipping_class' => '',
    'show_delivery_time' => 'yes',
    'additional_time' => '0',
    'fee' => '0',
    'free_shipping_min_value' => '0',
    'declared_value' => 'yes',
    'own_hands' => 'no',
    'receipt_notification' => 'no',
    'debug' => 'no'
]);

// Configurar SEDEX
update_option('woocommerce_sedex_settings', [
    'enabled' => 'yes',
    'title' => 'SEDEX',
    'description' => 'Entrega em até 2 dias úteis',
    'shipping_class' => '',
    'show_delivery_time' => 'yes',
    'additional_time' => '0',
    'fee' => '0',
    'free_shipping_min_value' => '0',
    'declared_value' => 'yes',
    'own_hands' => 'no',
    'receipt_notification' => 'no',
    'debug' => 'no'
]);

// Configurar frete grátis
update_option('woocommerce_free_shipping_settings', [
    'enabled' => 'yes',
    'title' => 'Frete Grátis',
    'description' => 'Frete grátis para compras acima de R$ 200',
    'requires' => 'min_amount',
    'min_amount' => '200.00',
    'ignore_discounts' => 'no',
    'requires_coupon' => 'no',
    'coupon_id' => '',
    'show_delivery_time' => 'yes',
    'additional_time' => '0'
]);

echo "✅ Métodos de frete configurados!\n";

// Configurar zona de entrega
echo "🌍 Configurando zona de entrega...\n";

// Criar zona de entrega para Brasil
$zone = new WC_Shipping_Zone();
$zone->set_zone_name('Brasil');
$zone->set_zone_order(1);
$zone->save();

// Adicionar países à zona
$zone->add_location('BR', 'country');
$zone->save();

echo "✅ Zona de entrega configurada!\n";

echo "\n🎉 Configuração de frete concluída!\n";
echo "🚚 Métodos de frete configurados:\n";
echo "  ✅ PAC (até 5 dias úteis)\n";
echo "  ✅ SEDEX (até 2 dias úteis)\n";
echo "  ✅ Frete Grátis (acima de R$ 200)\n";
echo "  ✅ Cálculo automático via API dos Correios\n";
?>



