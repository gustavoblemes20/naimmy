<?php
/**
 * Script de Otimização do Banco de Dados
 * Execute este script para otimizar o banco de dados do WordPress
 */

// Carregar WordPress
require_once('wp-config.php');
require_once('wp-includes/wp-db.php');

// Conectar ao banco de dados
$wpdb = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

echo "=== OTIMIZAÇÃO DO BANCO DE DADOS ===\n\n";

// 1. Limpar revisões antigas
echo "1. Limpando revisões antigas...\n";
$revisions = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'revision'");
if ($revisions > 0) {
    $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'revision'");
    echo "   Removidas $revisions revisões antigas\n";
} else {
    echo "   Nenhuma revisão antiga encontrada\n";
}

// 2. Limpar spam e lixo
echo "2. Limpando spam e lixo...\n";
$spam = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_approved = 'spam'");
if ($spam > 0) {
    $wpdb->query("DELETE FROM {$wpdb->comments} WHERE comment_approved = 'spam'");
    echo "   Removidos $spam comentários de spam\n";
} else {
    echo "   Nenhum spam encontrado\n";
}

$trash = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status = 'trash'");
if ($trash > 0) {
    $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_status = 'trash'");
    echo "   Removidos $trash posts na lixeira\n";
} else {
    echo "   Nenhum post na lixeira encontrado\n";
}

// 3. Limpar transients expirados
echo "3. Limpando transients expirados...\n";
$transients = $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_%' AND option_value < UNIX_TIMESTAMP()");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%' AND option_name NOT IN (SELECT CONCAT('_transient_', SUBSTRING(option_name, 19)) FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_%')");
echo "   Limpeza de transients concluída\n";

// 4. Otimizar tabelas
echo "4. Otimizando tabelas...\n";
$tables = $wpdb->get_results("SHOW TABLES", ARRAY_N);
foreach ($tables as $table) {
    $table_name = $table[0];
    $wpdb->query("OPTIMIZE TABLE `$table_name`");
    echo "   Tabela $table_name otimizada\n";
}

// 5. Limpar logs antigos do WooCommerce
echo "5. Limpando logs antigos do WooCommerce...\n";
$wc_logs = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->options} WHERE option_name LIKE 'woocommerce_log_%'");
if ($wc_logs > 0) {
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'woocommerce_log_%'");
    echo "   Removidos $wc_logs logs antigos do WooCommerce\n";
} else {
    echo "   Nenhum log antigo do WooCommerce encontrado\n";
}

// 6. Estatísticas finais
echo "\n=== ESTATÍSTICAS FINAIS ===\n";
$posts = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts}");
$comments = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->comments}");
$options = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->options}");

echo "Posts: $posts\n";
echo "Comentários: $comments\n";
echo "Opções: $options\n";

// 7. Verificar tamanho do banco
$db_size = $wpdb->get_var("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'DB Size in MB' FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "'");
echo "Tamanho do banco: {$db_size} MB\n";

echo "\n=== OTIMIZAÇÃO CONCLUÍDA ===\n";
echo "O banco de dados foi otimizado com sucesso!\n";
?>
