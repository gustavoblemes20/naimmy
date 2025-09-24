<?php
// Teste de conexão com o banco de dados
$host = 'mysql:3306';
$dbname = 'naimmy_db';
$username = 'naimmy_user';
$password = 'naimmy_password_2024';

try {
    $pdo = new PDO("mysql:host=mysql;port=3306;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexão com banco de dados: SUCESSO!\n";
    echo "Host: $host\n";
    echo "Database: $dbname\n";
    echo "User: $username\n";
} catch(PDOException $e) {
    echo "❌ Erro na conexão: " . $e->getMessage() . "\n";
}
?>


