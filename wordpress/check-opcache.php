<?php
/**
 * Script de Verificação do OPcache
 */

echo "=== VERIFICAÇÃO DO OPCACHE ===\n\n";

// Verificar se a extensão está carregada
echo "1. Extensão carregada: " . (extension_loaded('opcache') ? '✅ SIM' : '❌ NÃO') . "\n";

if (extension_loaded('opcache')) {
    echo "2. OPcache disponível: ✅ SIM\n";
    
    // Verificar status
    $status = opcache_get_status();
    echo "3. Status do OPcache: " . ($status ? '✅ ATIVO' : '❌ INATIVO') . "\n";
    
    if ($status) {
        echo "4. Hit Rate: " . round($status['opcache_statistics']['opcache_hit_rate'], 2) . "%\n";
        echo "5. Arquivos em cache: " . $status['opcache_statistics']['num_cached_scripts'] . "\n";
        echo "6. Memória usada: " . round($status['memory_usage']['used_memory'] / 1024 / 1024, 2) . "M\n";
        echo "7. Memória livre: " . round($status['memory_usage']['free_memory'] / 1024 / 1024, 2) . "M\n";
        echo "8. Configurações:\n";
        echo "   - opcache.enable: " . (ini_get('opcache.enable') ? 'ON' : 'OFF') . "\n";
        echo "   - opcache.enable_cli: " . (ini_get('opcache.enable_cli') ? 'ON' : 'OFF') . "\n";
        echo "   - opcache.memory_consumption: " . ini_get('opcache.memory_consumption') . "M\n";
        echo "   - opcache.max_accelerated_files: " . ini_get('opcache.max_accelerated_files') . "\n";
    }
} else {
    echo "2. OPcache disponível: ❌ NÃO\n";
    echo "3. Motivo: Extensão não carregada\n";
}

echo "\n=== VERIFICAÇÃO CONCLUÍDA ===\n";
?>
