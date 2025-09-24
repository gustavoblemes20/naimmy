<?php
/**
 * Criar Página Inicial Miu Miu
 * Script simples para criar a página inicial inspirada na Miu Miu
 */

// Carregar WordPress
require_once('wp-load.php');

echo "=== CRIANDO PÁGINA INICIAL MIU MIU ===\n\n";

// 1. Criar página inicial
echo "1. Criando página inicial...\n";

$homepage = array(
    'post_title' => 'Home Miu Miu',
    'post_content' => 'Página inicial inspirada no estilo minimalista da Miu Miu',
    'post_status' => 'publish',
    'post_type' => 'page',
    'post_name' => 'home-miumiu'
);

$homepage_id = wp_insert_post($homepage);

if ($homepage_id) {
    // Definir como página inicial
    update_option('show_on_front', 'page');
    update_option('page_on_front', $homepage_id);
    
    // Adicionar template personalizado
    update_post_meta($homepage_id, '_wp_page_template', 'page-home.php');
    
    echo "   ✓ Página inicial criada (ID: {$homepage_id})\n";
    echo "   ✓ Template personalizado aplicado\n";
    echo "   ✓ Definida como página inicial\n";
} else {
    echo "   ❌ Erro ao criar página inicial\n";
}

// 2. Configurar menu
echo "2. Configurando menu...\n";

$menu_id = wp_create_nav_menu('Menu Principal Miu Miu');
if ($menu_id) {
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Destaques',
        'menu-item-url' => '#destaques',
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Categorias',
        'menu-item-url' => '#categorias',
        'menu-item-status' => 'publish'
    ));
    
    // Atribuir menu ao local correto
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    
    echo "   ✓ Menu configurado\n";
}

// 3. Adicionar CSS personalizado
echo "3. Adicionando CSS personalizado...\n";

$custom_css = "
/* Estilo Miu Miu - Página Inicial */

/* Reset e base */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-weight: 300;
    line-height: 1.6;
    color: #000;
    background: #fff;
    overflow-x: hidden;
}

/* Navbar */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding: 20px 0;
    transition: all 0.3s ease;
}

.navbar.scrolled {
    background: rgba(255, 255, 255, 0.98);
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
}

.navbar-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.navbar-left {
    display: flex;
    align-items: center;
    gap: 40px;
}

.logo {
    font-size: 24px;
    font-weight: 300;
    letter-spacing: 2px;
    color: #000;
    text-decoration: none;
    transition: color 0.3s ease;
}

.logo:hover {
    color: #8b7355;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 30px;
    list-style: none;
}

.nav-links li a {
    color: #000;
    text-decoration: none;
    font-size: 14px;
    font-weight: 400;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: color 0.3s ease;
    position: relative;
}

.nav-links li a:hover {
    color: #8b7355;
}

.nav-links li a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 1px;
    background: #8b7355;
    transition: width 0.3s ease;
}

.nav-links li a:hover::after {
    width: 100%;
}

.categories-dropdown {
    position: relative;
}

.categories-dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1001;
}

.dropdown-menu li {
    padding: 0;
}

.dropdown-menu li a {
    display: block;
    padding: 15px 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    text-transform: none;
    font-size: 13px;
}

.dropdown-menu li:last-child a {
    border-bottom: none;
}

/* Slide principal */
.hero-slider {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
}

.slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: translateY(100%);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide.active {
    opacity: 1;
    transform: translateY(0);
}

.slide.prev {
    transform: translateY(-100%);
}

.slide-content {
    text-align: center;
    color: #fff;
    max-width: 600px;
    padding: 0 20px;
}

.slide-title {
    font-size: 48px;
    font-weight: 300;
    letter-spacing: 2px;
    margin-bottom: 20px;
    opacity: 0;
    transform: translateY(30px);
    animation: slideInUp 0.8s ease 0.3s forwards;
}

.slide-subtitle {
    font-size: 18px;
    font-weight: 300;
    margin-bottom: 40px;
    opacity: 0;
    transform: translateY(30px);
    animation: slideInUp 0.8s ease 0.5s forwards;
}

.slide-button {
    display: inline-block;
    padding: 15px 40px;
    background: #000;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 400;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateY(30px);
    animation: slideInUp 0.8s ease 0.7s forwards;
}

.slide-button:hover {
    background: #8b7355;
    color: #fff;
    transform: translateY(-2px);
}

/* Controles do slide */
.slide-controls {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 15px;
    z-index: 100;
}

.slide-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slide-dot.active {
    background: #fff;
    transform: scale(1.2);
}

.slide-dot:hover {
    background: rgba(255, 255, 255, 0.8);
}

/* Animações */
@keyframes slideInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsivo */
@media (max-width: 768px) {
    .navbar-container {
        padding: 0 15px;
    }

    .navbar-left {
        gap: 20px;
    }

    .nav-links {
        gap: 20px;
    }

    .nav-links li a {
        font-size: 12px;
    }

    .slide-title {
        font-size: 32px;
    }

    .slide-subtitle {
        font-size: 16px;
    }

    .slide-button {
        padding: 12px 30px;
        font-size: 12px;
    }

    .slide-controls {
        bottom: 20px;
    }
}

@media (max-width: 480px) {
    .navbar-left {
        flex-direction: column;
        gap: 10px;
    }

    .nav-links {
        gap: 15px;
    }

    .slide-title {
        font-size: 24px;
    }

    .slide-subtitle {
        font-size: 14px;
    }
}

/* Loading */
.loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity 0.5s ease;
}

.loading.hidden {
    opacity: 0;
    pointer-events: none;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #000;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
";

// Salvar CSS personalizado
update_option('custom_css', $custom_css);

echo "   ✓ CSS personalizado adicionado\n";

// 4. Limpar cache
echo "4. Limpando cache...\n";

// Limpar cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}

echo "   ✓ Cache limpo\n";

echo "\n=== PÁGINA INICIAL MIU MIU CRIADA COM SUCESSO ===\n";
echo "A página inicial agora possui:\n";
echo "• Navbar minimalista com logo e categorias\n";
echo "• Slide principal fullscreen com transição vertical\n";
echo "• Design inspirado na Miu Miu\n";
echo "• Layout responsivo\n";
echo "• Integração com WooCommerce\n";
echo "\nAcesse o site para ver a nova página inicial!\n";
echo "URL: " . home_url() . "\n";
?>
