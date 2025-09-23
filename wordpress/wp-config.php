<?php
/**
 * Configuração do WordPress para Naimmy E-commerce
 * Ambiente Docker com Caddy + PHP-FPM + MySQL
 */

// Configurações do banco de dados
define('DB_NAME', 'naimmy_db');
define('DB_USER', 'naimmy_user');
define('DB_PASSWORD', 'naimmy_password_2024');
define('DB_HOST', 'mysql:3306');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

// Chaves de segurança únicas
define('AUTH_KEY',         'naimmy_auth_key_2024_unique_secure');
define('SECURE_AUTH_KEY',  'naimmy_secure_auth_key_2024_unique');
define('LOGGED_IN_KEY',    'naimmy_logged_in_key_2024_unique');
define('NONCE_KEY',        'naimmy_nonce_key_2024_unique');
define('AUTH_SALT',        'naimmy_auth_salt_2024_unique');
define('SECURE_AUTH_SALT', 'naimmy_secure_auth_salt_2024_unique');
define('LOGGED_IN_SALT',   'naimmy_logged_in_salt_2024_unique');
define('NONCE_SALT',       'naimmy_nonce_salt_2024_unique');

// Prefixo das tabelas
$table_prefix = 'wp_';

// Configurações de debug
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// Configurações de memória e upload
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '256M');

// Configurações de URL
define('WP_HOME', 'http://localhost');
define('WP_SITEURL', 'http://localhost');

// Configurações de cache
define('WP_CACHE', true);

// Configurações de segurança
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', false);

// Configurações de WooCommerce
define('WOOCOMMERCE_USE_HTTPS', false);

// Configurações de upload
define('UPLOADS_USE_YEARMONTH_FOLDERS', true);

// Configurações de autosave
define('AUTOSAVE_INTERVAL', 300);
define('WP_POST_REVISIONS', 3);

// Configurações de trash
define('EMPTY_TRASH_DAYS', 7);

// Configurações de cron
define('DISABLE_WP_CRON', false);

// Configurações de compressão
define('COMPRESS_CSS', true);
define('COMPRESS_SCRIPTS', true);

// Configurações de SSL (para produção)
define('FORCE_SSL_ADMIN', false);

// Configurações de cache
define('WP_CACHE_KEY_SALT', 'naimmy_cache_salt_2024');

// Configurações de multisite (desabilitado)
define('MULTISITE', false);

// Configurações de linguagem
define('WPLANG', 'pt_BR');

// Configurações de timezone
define('WP_DEFAULT_THEME', 'twentytwentyfour');

// Configurações de arquivo
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

// Carregar WordPress
require_once ABSPATH . 'wp-settings.php';
