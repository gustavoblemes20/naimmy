<?php
// Script para configurar categorias de moda do Naimmy
require_once('wp-config.php');

echo "👗 Configurando categorias de moda...\n";

// Categorias principais (Coleções)
$main_categories = [
    'Coleção Primavera/Verão 2025' => 'Coleção de roupas para a estação mais quente do ano',
    'Coleção Outono/Inverno 2025' => 'Coleção de roupas para as estações mais frias',
    'Coleção Básicos' => 'Peças essenciais para o guarda-roupa',
    'Coleção Festa' => 'Roupas elegantes para ocasiões especiais'
];

// Subcategorias
$subcategories = [
    'Bolsas' => [
        'Bolsas de Mão',
        'Bolsas de Ombro', 
        'Bolsas Tote',
        'Bolsas Hobo',
        'Bolsas Mini'
    ],
    'Calças' => [
        'Calças Jeans',
        'Calças de Alfaiataria',
        'Calças Legging',
        'Calças Cargo',
        'Calças de Couro'
    ],
    'Blusas' => [
        'Camisetas',
        'Blusas de Seda',
        'Blusas de Algodão',
        'Blusas de Tricô',
        'Blusas de Manga Longa'
    ],
    'Vestidos' => [
        'Vestidos de Festa',
        'Vestidos Casuais',
        'Vestidos de Trabalho',
        'Vestidos de Praia',
        'Vestidos Longos'
    ],
    'Acessórios' => [
        'Cintos',
        'Luvas',
        'Óculos',
        'Chapéus',
        'Joias'
    ]
];

// Criar categorias principais
foreach ($main_categories as $name => $description) {
    $category = wp_insert_term($name, 'product_cat', [
        'description' => $description,
        'slug' => sanitize_title($name)
    ]);
    
    if (!is_wp_error($category)) {
        echo "✅ Categoria criada: $name\n";
    } else {
        echo "❌ Erro ao criar categoria $name: " . $category->get_error_message() . "\n";
    }
}

// Criar subcategorias
foreach ($subcategories as $parent_name => $children) {
    $parent = get_term_by('name', $parent_name, 'product_cat');
    
    if ($parent) {
        foreach ($children as $child_name) {
            $child = wp_insert_term($child_name, 'product_cat', [
                'parent' => $parent->term_id,
                'slug' => sanitize_title($child_name)
            ]);
            
            if (!is_wp_error($child)) {
                echo "✅ Subcategoria criada: $child_name\n";
            }
        }
    }
}

echo "🎉 Categorias configuradas com sucesso!\n";
?>
