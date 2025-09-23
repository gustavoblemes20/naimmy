-- Script de inicialização do banco de dados Naimmy
-- Configurações otimizadas para WooCommerce

-- Configurar charset e collation
ALTER DATABASE naimmy_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Configurações de performance para WooCommerce
SET GLOBAL innodb_buffer_pool_size = 1073741824; -- 1GB
SET GLOBAL innodb_log_file_size = 268435456; -- 256MB
SET GLOBAL innodb_flush_log_at_trx_commit = 2;
SET GLOBAL innodb_flush_method = 'O_DIRECT';
SET GLOBAL query_cache_size = 67108864; -- 64MB
SET GLOBAL query_cache_type = 1;
SET GLOBAL max_connections = 200;

-- Criar usuário específico para WooCommerce
CREATE USER IF NOT EXISTS 'naimmy_user'@'%' IDENTIFIED BY 'naimmy_password_2024';
GRANT ALL PRIVILEGES ON naimmy_db.* TO 'naimmy_user'@'%';
FLUSH PRIVILEGES;

-- Configurações específicas para WooCommerce
SET SESSION sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO';
