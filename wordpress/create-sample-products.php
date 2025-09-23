<?php
// Script para criar produtos de exemplo do Naimmy E-commerce
require_once('wp-config.php');

echo "🛍️ Criando produtos de exemplo...\n\n";

// Produtos de exemplo
$sample_products = [
    [
        'name' => 'Vestido Elegante Preto',
        'description' => 'Vestido elegante preto perfeito para ocasiões especiais. Confeccionado em tecido de alta qualidade com corte que valoriza o corpo feminino.',
        'short_description' => 'Vestido elegante preto para ocasiões especiais',
        'price' => 299.90,
        'sale_price' => 249.90,
        'sku' => 'VEST-001',
        'category' => 'Vestidos de Festa',
        'tags' => ['Elegante', 'Festa', 'Preto', 'Novo'],
        'attributes' => [
            'Tamanho' => ['P', 'M', 'G', 'GG'],
            'Cor' => ['Preto', 'Azul', 'Vermelho'],
            'Material' => ['Seda', 'Poliéster'],
            'Estilo' => ['Festa', 'Elegante']
        ],
        'images' => [
            'https://via.placeholder.com/800x1200/000000/FFFFFF?text=Vestido+Preto+1',
            'https://via.placeholder.com/800x1200/000000/FFFFFF?text=Vestido+Preto+2'
        ]
    ],
    [
        'name' => 'Calça Jeans Skinny',
        'description' => 'Calça jeans skinny com modelagem justa e confortável. Ideal para looks casuais e descontraídos.',
        'short_description' => 'Calça jeans skinny confortável',
        'price' => 159.90,
        'sale_price' => 129.90,
        'sku' => 'CALC-001',
        'category' => 'Calças Jeans',
        'tags' => ['Casual', 'Jeans', 'Confortável', 'Tendência'],
        'attributes' => [
            'Tamanho' => ['34', '36', '38', '40', '42'],
            'Cor' => ['Azul', 'Preto', 'Cinza'],
            'Material' => ['Jeans'],
            'Estilo' => ['Casual', 'Moderno']
        ],
        'images' => [
            'https://via.placeholder.com/800x1200/4169E1/FFFFFF?text=Jeans+Azul+1',
            'https://via.placeholder.com/800x1200/4169E1/FFFFFF?text=Jeans+Azul+2'
        ]
    ],
    [
        'name' => 'Blusa de Seda Estampada',
        'description' => 'Blusa de seda com estampa floral delicada. Peça versátil que pode ser usada no trabalho ou em ocasiões especiais.',
        'short_description' => 'Blusa de seda estampada versátil',
        'price' => 189.90,
        'sale_price' => 159.90,
        'sku' => 'BLUS-001',
        'category' => 'Blusas de Seda',
        'tags' => ['Seda', 'Estampada', 'Elegante', 'Versátil'],
        'attributes' => [
            'Tamanho' => ['P', 'M', 'G', 'GG'],
            'Cor' => ['Rosa', 'Azul', 'Verde'],
            'Material' => ['Seda'],
            'Estilo' => ['Elegante', 'Trabalho']
        ],
        'images' => [
            'https://via.placeholder.com/800x1200/FF69B4/FFFFFF?text=Blusa+Rosa+1',
            'https://via.placeholder.com/800x1200/FF69B4/FFFFFF?text=Blusa+Rosa+2'
        ]
    ],
    [
        'name' => 'Bolsa Tote de Couro',
        'description' => 'Bolsa tote de couro legítimo com alças confortáveis. Perfeita para o dia a dia e para viagens.',
        'short_description' => 'Bolsa tote de couro legítimo',
        'price' => 399.90,
        'sale_price' => 349.90,
        'sku' => 'BOLS-001',
        'category' => 'Bolsas Tote',
        'tags' => ['Couro', 'Tote', 'Confortável', 'Durabilidade'],
        'attributes' => [
            'Tamanho' => ['M', 'G'],
            'Cor' => ['Marrom', 'Preto', 'Bege'],
            'Material' => ['Couro'],
            'Estilo' => ['Casual', 'Trabalho']
        ],
        'images' => [
            'https://via.placeholder.com/800x1200/8B4513/FFFFFF?text=Bolsa+Marrom+1',
            'https://via.placeholder.com/800x1200/8B4513/FFFFFF?text=Bolsa+Marrom+2'
        ]
    ],
    [
        'name' => 'Cinto de Couro Clássico',
        'description' => 'Cinto de couro clássico com fivela dourada. Acessório essencial para qualquer guarda-roupa.',
        'short_description' => 'Cinto de couro clássico com fivela dourada',
        'price' => 89.90,
        'sale_price' => 69.90,
        'sku' => 'CINT-001',
        'category' => 'Cintos',
        'tags' => ['Couro', 'Clássico', 'Dourado', 'Essencial'],
        'attributes' => [
            'Tamanho' => ['90', '95', '100', '105', '110'],
            'Cor' => ['Marrom', 'Preto'],
            'Material' => ['Couro'],
            'Estilo' => ['Clássico', 'Formal']
        ],
        'images' => [
            'https://via.placeholder.com/800x1200/8B4513/FFFFFF?text=Cinto+Marrom+1',
            'https://via.placeholder.com/800x1200/8B4513/FFFFFF?text=Cinto+Marrom+2'
        ]
    ]
];

// Criar produtos
foreach ($sample_products as $product_data) {
    echo "📦 Criando produto: {$product_data['name']}...\n";
    
    // Criar produto
    $product = wp_insert_post([
        'post_title' => $product_data['name'],
        'post_content' => $product_data['description'],
        'post_excerpt' => $product_data['short_description'],
        'post_status' => 'publish',
        'post_type' => 'product',
        'meta_input' => [
            '_price' => $product_data['price'],
            '_regular_price' => $product_data['price'],
            '_sale_price' => $product_data['sale_price'],
            '_sku' => $product_data['sku'],
            '_manage_stock' => 'yes',
            '_stock' => 10,
            '_stock_status' => 'instock',
            '_visibility' => 'visible',
            '_featured' => 'yes',
            '_weight' => '0.5',
            '_length' => '30',
            '_width' => '20',
            '_height' => '5'
        ]
    ]);
    
    if ($product && !is_wp_error($product)) {
        echo "✅ Produto criado: {$product_data['name']}\n";
        
        // Adicionar categoria
        $category = get_term_by('name', $product_data['category'], 'product_cat');
        if ($category) {
            wp_set_post_terms($product, $category->term_id, 'product_cat');
            echo "  ✅ Categoria adicionada: {$product_data['category']}\n";
        }
        
        // Adicionar tags
        if (!empty($product_data['tags'])) {
            wp_set_post_terms($product, $product_data['tags'], 'product_tag');
            echo "  ✅ Tags adicionadas: " . implode(', ', $product_data['tags']) . "\n";
        }
        
        // Adicionar atributos
        if (!empty($product_data['attributes'])) {
            foreach ($product_data['attributes'] as $attr_name => $values) {
                $attribute_name = 'pa_' . sanitize_title($attr_name);
                $term_ids = [];
                
                foreach ($values as $value) {
                    $term = get_term_by('name', $value, $attribute_name);
                    if ($term) {
                        $term_ids[] = $term->term_id;
                    }
                }
                
                if (!empty($term_ids)) {
                    wp_set_post_terms($product, $term_ids, $attribute_name);
                    echo "  ✅ Atributo adicionado: $attr_name\n";
                }
            }
        }
        
        // Adicionar imagens (placeholder)
        if (!empty($product_data['images'])) {
            $image_urls = $product_data['images'];
            $attachment_ids = [];
            
            foreach ($image_urls as $index => $image_url) {
                $attachment_id = wp_insert_attachment([
                    'post_mime_type' => 'image/jpeg',
                    'post_title' => $product_data['name'] . ' - Imagem ' . ($index + 1),
                    'post_content' => '',
                    'post_status' => 'inherit'
                ], false, $product);
                
                if ($attachment_id) {
                    $attachment_ids[] = $attachment_id;
                    
                    if ($index === 0) {
                        set_post_thumbnail($product, $attachment_id);
                    }
                }
            }
            
            if (!empty($attachment_ids)) {
                echo "  ✅ Imagens adicionadas: " . count($attachment_ids) . " imagens\n";
            }
        }
        
    } else {
        echo "❌ Erro ao criar produto: {$product_data['name']}\n";
    }
    
    echo "\n";
}

echo "🎉 Produtos de exemplo criados com sucesso!\n";
echo "🛍️ Acesse a loja: http://localhost/shop\n";
echo "⚙️ Painel admin: http://localhost/wp-admin\n";
?>
