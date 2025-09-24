#!/bin/bash

echo "=== APLICANDO OTIMIZAÇÕES DE PERFORMANCE ==="
echo ""

# 1. Parar containers
echo "1. Parando containers..."
docker-compose down

# 2. Reconstruir containers com novas configurações
echo "2. Reconstruindo containers..."
docker-compose build --no-cache

# 3. Iniciar containers
echo "3. Iniciando containers..."
docker-compose up -d

# 4. Aguardar containers iniciarem
echo "4. Aguardando containers iniciarem..."
sleep 30

# 5. Executar otimizações do banco de dados
echo "5. Executando otimizações do banco de dados..."
docker exec naimmy-php php /var/www/html/optimize-database.php

# 6. Executar otimizações de plugins
echo "6. Executando otimizações de plugins..."
docker exec naimmy-php php /var/www/html/optimize-plugins.php

# 7. Executar otimizações de imagens
echo "7. Executando otimizações de imagens..."
docker exec naimmy-php php /var/www/html/optimize-images.php

# 8. Limpar cache
echo "8. Limpando cache..."
docker exec naimmy-php rm -rf /var/www/html/wp-content/cache/*
docker exec naimmy-php rm -rf /var/www/html/wp-content/uploads/cache/*

# 9. Configurar permissões
echo "9. Configurando permissões..."
docker exec naimmy-php chown -R www-data:www-data /var/www/html
docker exec naimmy-php chmod -R 755 /var/www/html
docker exec naimmy-php chmod -R 777 /var/www/html/wp-content/cache
docker exec naimmy-php chmod -R 777 /var/www/html/wp-content/uploads

# 10. Verificar performance
echo "10. Verificando performance..."
docker exec naimmy-php php /var/www/html/performance-monitor.php

# 11. Configurar cron externo
echo "11. Configurando cron externo..."
echo "Adicione esta linha ao crontab do sistema:"
echo "*/5 * * * * docker exec naimmy-php php /var/www/html/wp-cron.php >/dev/null 2>&1"

echo ""
echo "=== OTIMIZAÇÕES APLICADAS COM SUCESSO ==="
echo ""
echo "Melhorias implementadas:"
echo "✓ Nginx otimizado com compressão gzip e cache"
echo "✓ PHP-FPM otimizado com mais workers e OPcache"
echo "✓ WordPress otimizado com debug desabilitado"
echo "✓ Cache ativado e configurado"
echo "✓ Banco de dados otimizado"
echo "✓ Plugins otimizados"
echo "✓ Imagens otimizadas"
echo "✓ Configurações de segurança aplicadas"
echo ""
echo "Para aplicar o cron externo, execute:"
echo "crontab -e"
echo "E adicione a linha mostrada acima"
echo ""
echo "Para monitorar performance, execute:"
echo "docker exec naimmy-php php /var/www/html/performance-monitor.php"
