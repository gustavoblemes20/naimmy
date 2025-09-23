<?php
// Script para configurar atributos de produto para moda
require_once('wp-config.php');

echo "📏 Configurando atributos de produto...\n";

// Atributos de produto
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

// Criar atributos
foreach ($attributes as $name => $config) {
    $attribute = wp_insert_term($name, 'pa_' . sanitize_title($name), [
        'description' => "Atributo $name para produtos de moda"
    ]);
    
    if (!is_wp_error($attribute)) {
        echo "✅ Atributo criado: $name\n";
        
        // Adicionar valores do atributo
        foreach ($config['values'] as $value) {
            $term = wp_insert_term($value, 'pa_' . sanitize_title($name), [
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

echo "🎉 Atributos configurados com sucesso!\n";
?>
