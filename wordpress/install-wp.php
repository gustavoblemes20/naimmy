<?php
// Script de instalação do WordPress para Naimmy
require_once('wp-config.php');

// Verificar se já está instalado
if (get_option('blogname')) {
    echo "WordPress já está instalado!\n";
    exit;
}

// Configurações da instalação
$blog_title = 'Naimmy E-commerce';
$admin_user = 'admin';
$admin_password = 'admin123';
$admin_email = 'admin@naimmy.com.br';

// Executar instalação
$result = wp_install($blog_title, $admin_user, $admin_email, true, '', $admin_password);

if ($result) {
    echo "✅ WordPress instalado com sucesso!\n";
    echo "URL: http://localhost\n";
    echo "Usuário: $admin_user\n";
    echo "Senha: $admin_password\n";
    echo "Email: $admin_email\n";
} else {
    echo "❌ Erro na instalação do WordPress\n";
}
?>
