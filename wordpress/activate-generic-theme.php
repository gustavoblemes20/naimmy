<?php
/**
 * Script para ativar o tema Generic E-commerce
 */

// Carregar WordPress
require_once('wp-load.php');

echo "=== ATIVANDO TEMA GENERIC E-COMMERCE ===\n\n";

// 1. Ativar tema
echo "1. Ativando tema...\n";
$theme_name = 'generic-ecommerce';
$theme = wp_get_theme($theme_name);

if ($theme->exists()) {
    switch_theme($theme_name);
    echo "   ✓ Tema '{$theme_name}' ativado com sucesso\n";
} else {
    echo "   ❌ Erro: Tema '{$theme_name}' não encontrado\n";
    echo "   Verifique se o tema está na pasta wp-content/themes/\n";
    exit;
}

// 2. Criar páginas essenciais
echo "2. Criando páginas essenciais...\n";

$pages = array(
    'Home' => array(
        'content' => '<!-- wp:shortcode -->[generic_slider]<!-- /wp:shortcode --><!-- wp:shortcode -->[generic_products limit="8" featured="true"]<!-- /wp:shortcode -->',
        'template' => 'page-home.php'
    ),
    'Sobre' => array(
        'content' => 'Conteúdo sobre nossa empresa...',
        'template' => ''
    ),
    'Contato' => array(
        'content' => 'Formulário de contato...',
        'template' => ''
    ),
    'Política de Privacidade' => array(
        'content' => 'Política de privacidade...',
        'template' => ''
    ),
    'Termos de Uso' => array(
        'content' => 'Termos de uso...',
        'template' => ''
    ),
    'FAQ' => array(
        'content' => 'Perguntas frequentes...',
        'template' => ''
    )
);

foreach ($pages as $title => $data) {
    $page = get_page_by_title($title);
    if (!$page) {
        $page_id = wp_insert_post(array(
            'post_title'    => $title,
            'post_content'  => $data['content'],
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'page_template' => $data['template']
        ));
        
        if ($page_id) {
            echo "   ✓ Página '{$title}' criada (ID: {$page_id})\n";
        } else {
            echo "   ❌ Erro ao criar página '{$title}'\n";
        }
    } else {
        echo "   ℹ️ Página '{$title}' já existe (ID: {$page->ID})\n";
    }
}

// 3. Configurar página inicial
echo "3. Configurando página inicial...\n";
$home_page = get_page_by_title('Home');
if ($home_page) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_page->ID);
    echo "   ✓ Página 'Home' definida como página inicial\n";
} else {
    echo "   ❌ Página 'Home' não encontrada\n";
}

// 4. Criar categorias padrão
echo "4. Criando categorias padrão...\n";
$default_categories = array(
    'Bolsas',
    'Calçados',
    'Roupas',
    'Acessórios',
    'Carteiras',
    'Bijuterias'
);

foreach ($default_categories as $category_name) {
    $term = get_term_by('name', $category_name, 'generic_category');
    if (!$term) {
        $result = wp_insert_term($category_name, 'generic_category');
        if (!is_wp_error($result)) {
            echo "   ✓ Categoria '{$category_name}' criada\n";
        } else {
            echo "   ❌ Erro ao criar categoria '{$category_name}': " . $result->get_error_message() . "\n";
        }
    } else {
        echo "   ℹ️ Categoria '{$category_name}' já existe\n";
    }
}

// 5. Criar produtos de exemplo
echo "5. Criando produtos de exemplo...\n";
$sample_products = array(
    array(
        'title' => 'Bolsa de Couro Premium',
        'content' => 'Bolsa de couro legítimo com acabamento artesanal.',
        'price' => 299.90,
        'sale_price' => 249.90,
        'sku' => 'BOL-001',
        'stock' => 50,
        'featured' => '1',
        'category' => 'Bolsas'
    ),
    array(
        'title' => 'Tênis Esportivo Moderno',
        'content' => 'Tênis confortável para uso diário e esportes.',
        'price' => 199.90,
        'sale_price' => '',
        'sku' => 'TEN-001',
        'stock' => 30,
        'featured' => '1',
        'category' => 'Calçados'
    ),
    array(
        'title' => 'Blusa de Algodão Orgânico',
        'content' => 'Blusa confortável feita com algodão 100% orgânico.',
        'price' => 89.90,
        'sale_price' => '',
        'sku' => 'BLU-001',
        'stock' => 25,
        'featured' => '1',
        'category' => 'Roupas'
    ),
    array(
        'title' => 'Carteira Minimalista',
        'content' => 'Carteira elegante com design minimalista.',
        'price' => 79.90,
        'sale_price' => 59.90,
        'sku' => 'CAR-001',
        'stock' => 40,
        'featured' => '1',
        'category' => 'Carteiras'
    )
);

foreach ($sample_products as $product_data) {
    $existing_product = get_posts(array(
        'post_type' => 'generic_product',
        'title' => $product_data['title'],
        'post_status' => 'publish'
    ));
    
    if (empty($existing_product)) {
        $product_id = wp_insert_post(array(
            'post_title'    => $product_data['title'],
            'post_content'  => $product_data['content'],
            'post_status'   => 'publish',
            'post_type'     => 'generic_product'
        ));
        
        if ($product_id) {
            // Adicionar meta dados
            update_post_meta($product_id, 'product_price', $product_data['price']);
            if ($product_data['sale_price']) {
                update_post_meta($product_id, 'product_sale_price', $product_data['sale_price']);
            }
            update_post_meta($product_id, 'product_sku', $product_data['sku']);
            update_post_meta($product_id, 'product_stock', $product_data['stock']);
            update_post_meta($product_id, 'featured_product', $product_data['featured']);
            
            // Adicionar à categoria
            $category = get_term_by('name', $product_data['category'], 'generic_category');
            if ($category) {
                wp_set_post_terms($product_id, array($category->term_id), 'generic_category');
            }
            
            echo "   ✓ Produto '{$product_data['title']}' criado (ID: {$product_id})\n";
        } else {
            echo "   ❌ Erro ao criar produto '{$product_data['title']}'\n";
        }
    } else {
        echo "   ℹ️ Produto '{$product_data['title']}' já existe\n";
    }
}

// 6. Criar coleções de exemplo
echo "6. Criando coleções de exemplo...\n";
$sample_collections = array(
    array(
        'title' => 'Coleção Verão 2024',
        'content' => 'Peças frescas e elegantes para o verão.',
        'type' => 'seasonal',
        'season' => 'summer',
        'year' => '2024',
        'featured' => '1'
    ),
    array(
        'title' => 'Edição Limitada',
        'content' => 'Peças exclusivas em edição limitada.',
        'type' => 'limited',
        'season' => '',
        'year' => '2024',
        'featured' => '1'
    )
);

foreach ($sample_collections as $collection_data) {
    $existing_collection = get_posts(array(
        'post_type' => 'generic_collection',
        'title' => $collection_data['title'],
        'post_status' => 'publish'
    ));
    
    if (empty($existing_collection)) {
        $collection_id = wp_insert_post(array(
            'post_title'    => $collection_data['title'],
            'post_content'  => $collection_data['content'],
            'post_status'   => 'publish',
            'post_type'     => 'generic_collection'
        ));
        
        if ($collection_id) {
            // Adicionar meta dados
            update_post_meta($collection_id, 'collection_type', $collection_data['type']);
            if ($collection_data['season']) {
                update_post_meta($collection_id, 'collection_season', $collection_data['season']);
            }
            update_post_meta($collection_id, 'collection_year', $collection_data['year']);
            update_post_meta($collection_id, 'collection_featured', $collection_data['featured']);
            
            echo "   ✓ Coleção '{$collection_data['title']}' criada (ID: {$collection_id})\n";
        } else {
            echo "   ❌ Erro ao criar coleção '{$collection_data['title']}'\n";
        }
    } else {
        echo "   ℹ️ Coleção '{$collection_data['title']}' já existe\n";
    }
}

// 7. Criar sliders de exemplo
echo "7. Criando sliders de exemplo...\n";
$sample_sliders = array(
    array(
        'title' => 'Bem-vindo à nossa loja',
        'content' => 'Descubra nossa coleção exclusiva de produtos',
        'button_text' => 'Ver Produtos',
        'button_url' => home_url('/loja/'),
        'order' => 1,
        'active' => '1'
    ),
    array(
        'title' => 'Nova Coleção',
        'content' => 'Tendências atuais com qualidade excepcional',
        'button_text' => 'Explorar',
        'button_url' => home_url('/colecoes/'),
        'order' => 2,
        'active' => '1'
    ),
    array(
        'title' => 'Ofertas Especiais',
        'content' => 'Descontos imperdíveis em produtos selecionados',
        'button_text' => 'Comprar Agora',
        'button_url' => home_url('/loja/'),
        'order' => 3,
        'active' => '1'
    )
);

foreach ($sample_sliders as $slider_data) {
    $existing_slider = get_posts(array(
        'post_type' => 'generic_slider',
        'title' => $slider_data['title'],
        'post_status' => 'publish'
    ));
    
    if (empty($existing_slider)) {
        $slider_id = wp_insert_post(array(
            'post_title'    => $slider_data['title'],
            'post_content'  => $slider_data['content'],
            'post_status'   => 'publish',
            'post_type'     => 'generic_slider'
        ));
        
        if ($slider_id) {
            // Adicionar meta dados
            update_post_meta($slider_id, 'slider_order', $slider_data['order']);
            update_post_meta($slider_id, 'slider_button_text', $slider_data['button_text']);
            update_post_meta($slider_id, 'slider_button_url', $slider_data['button_url']);
            update_post_meta($slider_id, 'slider_active', $slider_data['active']);
            
            echo "   ✓ Slider '{$slider_data['title']}' criado (ID: {$slider_id})\n";
        } else {
            echo "   ❌ Erro ao criar slider '{$slider_data['title']}'\n";
        }
    } else {
        echo "   ℹ️ Slider '{$slider_data['title']}' já existe\n";
    }
}

// 8. Configurar menus
echo "8. Configurando menus...\n";
$menu_name = 'Menu Principal';
$menu = wp_get_nav_menu_object($menu_name);

if (!$menu) {
    $menu_id = wp_create_nav_menu($menu_name);
    
    if ($menu_id) {
        // Adicionar itens ao menu
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Início',
            'menu-item-url' => home_url('/'),
            'menu-item-status' => 'publish'
        ));
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Loja',
            'menu-item-url' => wc_get_page_permalink('shop'),
            'menu-item-status' => 'publish'
        ));
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Sobre',
            'menu-item-url' => get_permalink(get_page_by_title('Sobre')),
            'menu-item-status' => 'publish'
        ));
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Contato',
            'menu-item-url' => get_permalink(get_page_by_title('Contato')),
            'menu-item-status' => 'publish'
        ));
        
        // Atribuir menu à localização
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
        
        echo "   ✓ Menu '{$menu_name}' criado e configurado\n";
    } else {
        echo "   ❌ Erro ao criar menu\n";
    }
} else {
    echo "   ℹ️ Menu '{$menu_name}' já existe\n";
}

// 9. Configurar widgets
echo "9. Configurando widgets...\n";
$widget_text = array(
    1 => array(
        'title' => 'Sobre Nós',
        'text' => 'Somos uma loja especializada em produtos de qualidade com foco na satisfação do cliente.'
    ),
    2 => array(
        'title' => 'Contato',
        'text' => 'Entre em contato conosco através do formulário ou redes sociais.'
    )
);

update_option('widget_text', $widget_text);
update_option('sidebars_widgets', array(
    'footer-1' => array('text-1'),
    'footer-2' => array('text-2')
));

echo "   ✓ Widgets configurados\n";

// 10. Limpar cache
echo "10. Limpando cache...\n";
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}
if (function_exists('w3tc_flush_all')) {
    w3tc_flush_all();
}
if (function_exists('wp_super_cache_clear_cache')) {
    wp_super_cache_clear_cache();
}

echo "   ✓ Cache limpo\n";

echo "\n=== TEMA GENERIC E-COMMERCE ATIVADO COM SUCESSO ===\n";
echo "O sistema genérico de e-commerce foi configurado com:\n";
echo "• Tema ativado e configurado\n";
echo "• Páginas essenciais criadas\n";
echo "• Categorias de produtos configuradas\n";
echo "• Produtos de exemplo adicionados\n";
echo "• Coleções criadas\n";
echo "• Sliders configurados\n";
echo "• Menus configurados\n";
echo "• Widgets configurados\n";
echo "• Cache limpo\n\n";
echo "Acesse o painel admin para personalizar:\n";
echo "• Produtos: " . admin_url('edit.php?post_type=generic_product') . "\n";
echo "• Coleções: " . admin_url('edit.php?post_type=generic_collection') . "\n";
echo "• Sliders: " . admin_url('edit.php?post_type=generic_slider') . "\n";
echo "• Configurações: " . admin_url('admin.php?page=generic-ecommerce') . "\n\n";
echo "Acesse o site: " . home_url() . "\n";
?>
