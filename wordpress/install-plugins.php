<?php
// Script para instalar plugins essenciais
require_once('wp-config.php');

echo "📦 Instalando plugins essenciais...\n\n";

// Lista de plugins essenciais
$plugins = [
    'wordpress-seo' => 'https://downloads.wordpress.org/plugin/wordpress-seo.latest-stable.zip',
    'wp-super-cache' => 'https://downloads.wordpress.org/plugin/wp-super-cache.latest-stable.zip',
    'smush' => 'https://downloads.wordpress.org/plugin/wp-smushit.latest-stable.zip',
    'wordfence' => 'https://downloads.wordpress.org/plugin/wordfence.latest-stable.zip'
];

foreach ($plugins as $plugin_slug => $plugin_url) {
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

echo "🎉 Plugins essenciais instalados!\n";
echo "📊 Plugins instalados:\n";
echo "  - Yoast SEO (SEO)\n";
echo "  - WP Super Cache (Performance)\n";
echo "  - Smush (Otimização de imagens)\n";
echo "  - Wordfence (Segurança)\n";
?>
