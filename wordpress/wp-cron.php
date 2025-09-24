<?php
/**
 * Cron Externo do WordPress
 * Execute este arquivo via cron do sistema para melhor performance
 * 
 * Adicione ao crontab:
 * */5 * * * * /usr/bin/php /var/www/html/wp-cron.php >/dev/null 2>&1
 */

// Definir timeout
set_time_limit(300);

// Carregar WordPress
require_once('wp-config.php');
require_once('wp-includes/wp-db.php');
require_once('wp-includes/pluggable.php');
require_once('wp-includes/cron.php');

// Executar cron do WordPress
wp_cron();

echo "Cron executado em: " . date('Y-m-d H:i:s') . "\n";
?>