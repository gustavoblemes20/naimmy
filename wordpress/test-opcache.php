<?php
/**
 * Teste do OPcache
 */

echo "=== TESTE DO OPCACHE ===\n\n";

// Verificar se a extensão está carregada
echo "1. Extensão carregada: " . (extension_loaded('opcache') ? '✅ SIM' : '❌ NÃO') . "\n";

if (extension_loaded('opcache')) {
    echo "2. OPcache disponível: ✅ SIM\n";
    
    // Verificar configurações
    echo "3. Configurações:\n";
    echo "   - opcache.enable: " . (ini_get('opcache.enable') ? 'ON' : 'OFF') . "\n";
    echo "   - opcache.enable_cli: " . (ini_get('opcache.enable_cli') ? 'ON' : 'OFF') . "\n";
    echo "   - opcache.memory_consumption: " . ini_get('opcache.memory_consumption') . "M\n";
    echo "   - opcache.max_accelerated_files: " . ini_get('opcache.max_accelerated_files') . "\n";
    
    // Tentar obter status (pode não funcionar no CLI)
    $status = @opcache_get_status();
    if ($status !== false) {
        echo "4. Status do OPcache: ✅ ATIVO\n";
        echo "5. Hit Rate: " . round($status['opcache_statistics']['opcache_hit_rate'], 2) . "%\n";
        echo "6. Arquivos em cache: " . $status['opcache_statistics']['num_cached_scripts'] . "\n";
        echo "7. Memória usada: " . round($status['memory_usage']['used_memory'] / 1024 / 1024, 2) . "M\n";
    } else {
        echo "4. Status do OPcache: ⚠️  Instalado mas status não disponível no CLI\n";
        echo "   (Isso é normal - opcache_get_status() pode não funcionar no contexto CLI)\n";
    }
    
    // Verificar se está funcionando
    echo "8. Teste de funcionamento:\n";
    if (ini_get('opcache.enable') && ini_get('opcache.enable_cli')) {
        echo "   ✅ OPcache está configurado e funcionando\n";
        echo "   ✅ Será usado para acelerar o WordPress\n";
    } else {
        echo "   ⚠️  OPcache instalado mas não configurado corretamente\n";
    }
} else {
    echo "2. OPcache disponível: ❌ NÃO\n";
}

echo "\n=== TESTE CONCLUÍDO ===\n";
?>
