<?php
// Script para configurar SEO
require_once('wp-config.php');

echo "🔍 Configurando SEO...\n\n";

// Configurar Yoast SEO
echo "⚙️ Configurando Yoast SEO...\n";

// Configurações gerais
update_option('wpseo', [
    'version' => '23.0',
    'ms_defaults_set' => true,
    'version' => '23.0'
]);

// Configurações de títulos
update_option('wpseo_titles', [
    'title-home' => '%%sitename%% - %%sitedesc%%',
    'title-shop' => 'Loja - %%sitename%%',
    'title-product' => '%%title%% - %%sitename%%',
    'metadesc-home' => 'Naimmy E-commerce - Moda feminina e masculina de qualidade',
    'metadesc-shop' => 'Confira nossa coleção de roupas, acessórios e calçados',
    'metadesc-product' => '%%excerpt%%'
]);

// Configurações de sitemap
update_option('wpseo_xml', [
    'enablexmlsitemap' => 'on',
    'user_sitemap' => 'on',
    'user_sitemap_name' => 'author-sitemap.xml'
]);

echo "✅ SEO configurado!\n";

echo "\n🎉 Configuração de SEO concluída!\n";
echo "🔍 SEO configurado com Yoast\n";
echo "📊 Sitemap XML ativado\n";
echo "🌐 Acesse: http://localhost/sitemap_index.xml\n";
?>
