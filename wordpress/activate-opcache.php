<?php
/**
 * Script para Ativar OPcache
 * Verifica e ativa o OPcache se necessário
 */

echo "=== ATIVAÇÃO DO OPCACHE ===\n\n";

// Verificar se OPcache está disponível
if (!extension_loaded('opcache')) {
    echo "❌ OPcache não está disponível nesta instalação do PHP\n";
    echo "   O OPcache deve ser compilado com o PHP ou instalado como extensão\n";
    exit;
}

echo "✅ OPcache está disponível\n";

// Verificar status atual
$opcache_status = opcache_get_status();
if ($opcache_status === false) {
    echo "❌ OPcache não está ativo\n";
    echo "   Verificando configuração...\n";
    
    // Verificar configurações
    echo "   opcache.enable: " . (ini_get('opcache.enable') ? 'Ativo' : 'Inativo') . "\n";
    echo "   opcache.enable_cli: " . (ini_get('opcache.enable_cli') ? 'Ativo' : 'Inativo') . "\n";
    echo "   opcache.memory_consumption: " . ini_get('opcache.memory_consumption') . "M\n";
    echo "   opcache.max_accelerated_files: " . ini_get('opcache.max_accelerated_files') . "\n";
    
    echo "\n⚠️  OPcache não está funcionando. Verifique as configurações do PHP-FPM\n";
    echo "   As configurações estão no arquivo php-fpm.conf\n";
} else {
    echo "✅ OPcache está ativo e funcionando\n";
    echo "   Hit rate: " . round($opcache_status['opcache_statistics']['opcache_hit_rate'], 2) . "%\n";
    echo "   Arquivos em cache: " . $opcache_status['opcache_statistics']['num_cached_scripts'] . "\n";
    echo "   Memória usada: " . round($opcache_status['memory_usage']['used_memory'] / 1024 / 1024, 2) . "M\n";
    echo "   Memória livre: " . round($opcache_status['memory_usage']['free_memory'] / 1024 / 1024, 2) . "M\n";
}

echo "\n=== VERIFICAÇÃO CONCLUÍDA ===\n";
?>
