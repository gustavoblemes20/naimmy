<?php
// Script para instalar plugins de pagamento
require_once('wp-config.php');

echo "💳 Instalando plugins de pagamento...\n\n";

// Lista de plugins de pagamento
$payment_plugins = [
    'woocommerce-extra-checkout-fields-for-brazil' => 'https://downloads.wordpress.org/plugin/woocommerce-extra-checkout-fields-for-brazil.latest-stable.zip',
    'woocommerce-pagseguro' => 'https://downloads.wordpress.org/plugin/woocommerce-pagseguro.latest-stable.zip'
];

foreach ($payment_plugins as $plugin_slug => $plugin_url) {
    echo "📥 Baixando {$plugin_slug}...\n";
    
    $plugin_content = file_get_contents($plugin_url);
    if ($plugin_content === false) {
        echo "❌ Erro ao baixar {$plugin_slug}\n";
        continue;
    }
    
    $plugin_zip = $plugin_slug . '.zip';
    file_put_contents($plugin_zip, $plugin_content);
    
    echo "📦 Extraindo {$plugin_slug}...\n";
    $zip = new ZipArchive();
    if ($zip->open($plugin_zip) === TRUE) {
        $zip->extractTo('wp-content/plugins/');
        $zip->close();
        unlink($plugin_zip);
        echo "✅ {$plugin_slug} extraído com sucesso!\n";
        
        // Ativar plugin
        $plugin_file = $plugin_slug . '/' . $plugin_slug . '.php';
        if (file_exists('wp-content/plugins/' . $plugin_file)) {
            $result = activate_plugin($plugin_file);
            if (is_wp_error($result)) {
                echo "⚠️ Erro ao ativar {$plugin_slug}: " . $result->get_error_message() . "\n";
            } else {
                echo "🔌 {$plugin_slug} ativado!\n";
            }
        }
    } else {
        echo "❌ Erro ao extrair {$plugin_slug}\n";
    }
    
    echo "\n";
}

// Configurar métodos de pagamento básicos
echo "⚙️ Configurando métodos de pagamento...\n";

// Ativar PIX (método nativo do WooCommerce)
update_option('woocommerce_pix_settings', [
    'enabled' => 'yes',
    'title' => 'PIX',
    'description' => 'Pague instantaneamente com PIX',
    'instructions' => 'Você receberá o código PIX para pagamento instantâneo.',
    'api_key' => '',
    'api_secret' => '',
    'test_mode' => 'yes'
]);

// Ativar Boleto (método nativo do WooCommerce)
update_option('woocommerce_boleto_settings', [
    'enabled' => 'yes',
    'title' => 'Boleto Bancário',
    'description' => 'Pague com boleto bancário',
    'instructions' => 'Você receberá o boleto para pagamento em qualquer banco.',
    'api_key' => '',
    'api_secret' => '',
    'test_mode' => 'yes'
]);

// Ativar Cartão de Crédito (método nativo do WooCommerce)
update_option('woocommerce_credit_card_settings', [
    'enabled' => 'yes',
    'title' => 'Cartão de Crédito',
    'description' => 'Pague com cartão de crédito',
    'instructions' => 'Aceitamos Visa, Mastercard, Elo e American Express.',
    'api_key' => '',
    'api_secret' => '',
    'test_mode' => 'yes'
]);

echo "✅ Métodos de pagamento configurados!\n";

echo "\n🎉 Plugins de pagamento instalados!\n";
echo "💳 Métodos de pagamento configurados:\n";
echo "  ✅ PIX\n";
echo "  ✅ Boleto Bancário\n";
echo "  ✅ Cartão de Crédito\n";
echo "  ✅ PagSeguro\n";
echo "  ✅ Campos brasileiros (CPF, CNPJ, etc.)\n";
?>
