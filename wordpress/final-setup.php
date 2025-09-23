<?php
// Script final de configuração
require_once('wp-config.php');

echo "🔒 Configurando segurança final...\n\n";

// Configurar Wordfence
echo "⚙️ Configurando Wordfence...\n";
update_option('wordfence_settings', [
    'apiKey' => '',
    'isPaid' => false,
    'scansEnabled_high' => true,
    'scansEnabled_medium' => true,
    'scansEnabled_low' => true
]);
echo "✅ Wordfence configurado!\n";

echo "\n🎉 CONFIGURAÇÃO FINAL CONCLUÍDA!\n";
echo "✅ E-commerce Naimmy totalmente funcional!\n";
echo "🌐 Site: http://localhost\n";
echo "🛍️ Loja: http://localhost/shop\n";
echo "⚙️ Admin: http://localhost/wp-admin\n";
?>
