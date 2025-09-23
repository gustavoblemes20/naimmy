<?php
// Script para configurar performance
require_once('wp-config.php');

echo "⚡ Configurando performance...\n\n";

// Configurar WP Super Cache
echo "⚙️ Configurando WP Super Cache...\n";
update_option('wp_super_cache_1', 'on');
update_option('wp_super_cache_2', 'on');
update_option('wp_super_cache_3', 'on');
echo "✅ WP Super Cache configurado!\n";

// Configurar Smush
echo "⚙️ Configurando Smush...\n";
update_option('wp_smush_settings', [
    'auto' => true,
    'lossy' => true,
    'strip_exif' => true,
    'resize' => true,
    'original' => false
]);
echo "✅ Smush configurado!\n";

echo "\n🎉 Performance configurada!\n";
echo "⚡ Cache ativado\n";
echo "🖼️ Otimização de imagens ativada\n";
?>
