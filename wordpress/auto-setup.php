<?php
// Script de configuração automática do Naimmy E-commerce
require_once('wp-config.php');

echo "🚀 Iniciando configuração automática do Naimmy E-commerce...\n\n";

// 1. Verificar se WordPress está instalado
if (!get_option('blogname')) {
    echo "❌ WordPress não está instalado. Execute a instalação primeiro.\n";
    exit;
}

echo "✅ WordPress detectado!\n";

// 2. Baixar e instalar WooCommerce
echo "📥 Baixando WooCommerce...\n";
$woocommerce_url = 'https://downloads.wordpress.org/plugin/woocommerce.latest-stable.zip';
$woocommerce_zip = 'woocommerce.zip';

$woocommerce_content = file_get_contents($woocommerce_url);
if ($woocommerce_content === false) {
    echo "❌ Erro ao baixar WooCommerce\n";
    exit;
}

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

// 3. Ativar WooCommerce
echo "🔌 Ativando WooCommerce...\n";
$plugin_file = 'woocommerce/woocommerce.php';
$result = activate_plugin($plugin_file);

if (is_wp_error($result)) {
    echo "❌ Erro ao ativar WooCommerce: " . $result->get_error_message() . "\n";
    exit;
} else {
    echo "✅ WooCommerce ativado com sucesso!\n";
}

// 4. Configurar páginas do WooCommerce
echo "📄 Configurando páginas do WooCommerce...\n";
$pages = [
    'shop' => 'Loja',
    'cart' => 'Carrinho',
    'checkout' => 'Finalizar Compra',
    'myaccount' => 'Minha Conta'
];

foreach ($pages as $slug => $title) {
    $page = get_page_by_path($slug);
    if (!$page) {
        $page_id = wp_insert_post([
            'post_title' => $title,
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => ''
        ]);
        
        if ($page_id) {
            update_option('woocommerce_' . $slug . '_page_id', $page_id);
            echo "✅ Página criada: $title\n";
        }
    }
}

// 5. Configurar moeda e localização
echo "💰 Configurando moeda e localização...\n";
update_option('woocommerce_currency', 'BRL');
update_option('woocommerce_currency_pos', 'left');
update_option('woocommerce_price_thousand_sep', '.');
update_option('woocommerce_price_decimal_sep', ',');
update_option('woocommerce_price_num_decimals', 2);
update_option('woocommerce_country', 'BR');
update_option('woocommerce_default_country', 'BR:SP');

// 6. Configurar dimensões e peso
echo "📏 Configurando dimensões e peso...\n";
update_option('woocommerce_dimension_unit', 'cm');
update_option('woocommerce_weight_unit', 'kg');

// 7. Configurar checkout
echo "🛒 Configurando checkout...\n";
update_option('woocommerce_checkout_privacy_policy_text', 'Seus dados pessoais serão utilizados para processar seu pedido, apoiar sua experiência em todo este site e para outros fins descritos em nossa política de privacidade.');
update_option('woocommerce_terms_page_id', 0);

// 8. Configurar emails
echo "📧 Configurando emails...\n";
update_option('woocommerce_email_from_name', 'Naimmy E-commerce');
update_option('woocommerce_email_from_address', 'noreply@naimmy.com.br');

// 9. Configurar estoque
echo "📦 Configurando estoque...\n";
update_option('woocommerce_manage_stock', 'yes');
update_option('woocommerce_notify_low_stock', 'yes');
update_option('woocommerce_notify_no_stock', 'yes');
update_option('woocommerce_stock_threshold', 2);

// 10. Configurar downloads
echo "⬇️ Configurando downloads...\n";
update_option('woocommerce_downloads_require_login', 'no');
update_option('woocommerce_downloads_grant_access_after_payment', 'yes');

echo "\n🎉 Configuração automática concluída!\n";
echo "🌐 Acesse: http://localhost/wp-admin\n";
echo "👤 Usuário: admin\n";
echo "🔑 Senha: admin123\n";
echo "📧 Email: admin@naimmy.com.br\n";
?>



