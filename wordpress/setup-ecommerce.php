<?php
// Script para configurar categorias e atributos do e-commerce
require_once('wp-config.php');

echo "👗 Configurando categorias e atributos do Naimmy E-commerce...\n\n";

// 1. Configurar categorias principais (Coleções)
echo "📂 Criando categorias principais...\n";
$main_categories = [
    'Coleção Primavera/Verão 2025' => 'Coleção de roupas para a estação mais quente do ano',
    'Coleção Outono/Inverno 2025' => 'Coleção de roupas para as estações mais frias',
    'Coleção Básicos' => 'Peças essenciais para o guarda-roupa',
    'Coleção Festa' => 'Roupas elegantes para ocasiões especiais',
    'Coleção Esportiva' => 'Roupas confortáveis para atividades físicas'
];

foreach ($main_categories as $name => $description) {
    $category = wp_insert_term($name, 'product_cat', [
        'description' => $description,
        'slug' => sanitize_title($name)
    ]);
    
    if (!is_wp_error($category)) {
        echo "✅ Categoria criada: $name\n";
    } else {
        echo "⚠️ Categoria já existe: $name\n";
    }
}

// 2. Configurar subcategorias
echo "\n📁 Criando subcategorias...\n";
$subcategories = [
    'Bolsas' => [
        'Bolsas de Mão' => 'Bolsas pequenas para uso diário',
        'Bolsas de Ombro' => 'Bolsas médias para ombro',
        'Bolsas Tote' => 'Bolsas grandes para trabalho',
        'Bolsas Hobo' => 'Bolsas descontraídas',
        'Bolsas Mini' => 'Bolsas pequenas para eventos'
    ],
    'Calças' => [
        'Calças Jeans' => 'Calças de jeans para todos os estilos',
        'Calças de Alfaiataria' => 'Calças elegantes para trabalho',
        'Calças Legging' => 'Calças justas e confortáveis',
        'Calças Cargo' => 'Calças com bolsos laterais',
        'Calças de Couro' => 'Calças de couro para looks marcantes'
    ],
    'Blusas' => [
        'Camisetas' => 'Camisetas básicas e estampadas',
        'Blusas de Seda' => 'Blusas elegantes de seda',
        'Blusas de Algodão' => 'Blusas confortáveis de algodão',
        'Blusas de Tricô' => 'Blusas de tricô para inverno',
        'Blusas de Manga Longa' => 'Blusas com manga longa'
    ],
    'Vestidos' => [
        'Vestidos de Festa' => 'Vestidos elegantes para ocasiões especiais',
        'Vestidos Casuais' => 'Vestidos confortáveis para o dia a dia',
        'Vestidos de Trabalho' => 'Vestidos profissionais',
        'Vestidos de Praia' => 'Vestidos leves para praia',
        'Vestidos Longos' => 'Vestidos longos para eventos'
    ],
    'Acessórios' => [
        'Cintos' => 'Cintos de diversos estilos',
        'Luvas' => 'Luvas para inverno e moda',
        'Óculos' => 'Óculos de sol e grau',
        'Chapéus' => 'Chapéus e bonés',
        'Joias' => 'Pulseiras, colares e anéis'
    ]
];

foreach ($subcategories as $parent_name => $children) {
    $parent = get_term_by('name', $parent_name, 'product_cat');
    
    if ($parent) {
        foreach ($children as $child_name => $child_description) {
            $child = wp_insert_term($child_name, 'product_cat', [
                'parent' => $parent->term_id,
                'description' => $child_description,
                'slug' => sanitize_title($child_name)
            ]);
            
            if (!is_wp_error($child)) {
                echo "✅ Subcategoria criada: $child_name\n";
            } else {
                echo "⚠️ Subcategoria já existe: $child_name\n";
            }
        }
    }
}

// 3. Configurar atributos de produto
echo "\n📏 Configurando atributos de produto...\n";
$attributes = [
    'Tamanho' => [
        'type' => 'select',
        'order_by' => 'menu_order',
        'has_archives' => false,
        'values' => ['PP', 'P', 'M', 'G', 'GG', 'XG', '34', '36', '38', '40', '42', '44', '46', '48']
    ],
    'Cor' => [
        'type' => 'select',
        'order_by' => 'menu_order',
        'has_archives' => false,
        'values' => ['Preto', 'Branco', 'Azul', 'Vermelho', 'Verde', 'Amarelo', 'Rosa', 'Roxo', 'Marrom', 'Cinza', 'Bege', 'Coral']
    ],
    'Material' => [
        'type' => 'select',
        'order_by' => 'menu_order',
        'has_archives' => false,
        'values' => ['Algodão', 'Poliéster', 'Seda', 'Lã', 'Jeans', 'Couro', 'Sintético', 'Linho', 'Malha', 'Tricô']
    ],
    'Estilo' => [
        'type' => 'select',
        'order_by' => 'menu_order',
        'has_archives' => false,
        'values' => ['Casual', 'Formal', 'Esportivo', 'Festa', 'Trabalho', 'Praia', 'Inverno', 'Verão', 'Vintage', 'Moderno']
    ],
    'Marca' => [
        'type' => 'select',
        'order_by' => 'menu_order',
        'has_archives' => true,
        'values' => ['Naimmy', 'Nike', 'Adidas', 'Zara', 'H&M', 'Uniqlo', 'Gap', 'Levi\'s', 'Calvin Klein', 'Tommy Hilfiger']
    ]
];

foreach ($attributes as $name => $config) {
    $attribute_name = 'pa_' . sanitize_title($name);
    
    // Verificar se atributo já existe
    $existing = get_term_by('name', $name, $attribute_name);
    if ($existing) {
        echo "⚠️ Atributo já existe: $name\n";
        continue;
    }
    
    $attribute = wp_insert_term($name, $attribute_name, [
        'description' => "Atributo $name para produtos de moda"
    ]);
    
    if (!is_wp_error($attribute)) {
        echo "✅ Atributo criado: $name\n";
        
        // Adicionar valores do atributo
        foreach ($config['values'] as $value) {
            $term = wp_insert_term($value, $attribute_name, [
                'slug' => sanitize_title($value)
            ]);
            
            if (!is_wp_error($term)) {
                echo "  ✅ Valor adicionado: $value\n";
            }
        }
    } else {
        echo "❌ Erro ao criar atributo $name: " . $attribute->get_error_message() . "\n";
    }
}

// 4. Configurar tags de produto
echo "\n🏷️ Configurando tags de produto...\n";
$tags = [
    'Novo', 'Promoção', 'Mais Vendido', 'Tendência', 'Clássico', 'Elegante', 'Confortável', 'Moderno', 'Vintage', 'Esportivo'
];

foreach ($tags as $tag) {
    $term = wp_insert_term($tag, 'product_tag', [
        'slug' => sanitize_title($tag)
    ]);
    
    if (!is_wp_error($term)) {
        echo "✅ Tag criada: $tag\n";
    }
}

echo "\n🎉 Configuração do e-commerce concluída!\n";
echo "📊 Categorias, subcategorias, atributos e tags configurados com sucesso!\n";
?>
