<?php
// Script para corrigir atributos do WooCommerce
require_once('wp-config.php');

echo "🔧 Corrigindo atributos do WooCommerce...\n\n";

// Verificar se WooCommerce está ativo
if (!class_exists('WooCommerce')) {
    echo "❌ WooCommerce não está ativo. Ativando...\n";
    activate_plugin('woocommerce/woocommerce.php');
}

// Registrar taxonomias de atributos
if (function_exists('wc_register_attribute_taxonomies')) {
    wc_register_attribute_taxonomies();
    echo "✅ Taxonomias de atributos registradas!\n";
}

// Atributos para criar
$attributes = [
    'Tamanho' => [
        'name' => 'Tamanho',
        'slug' => 'tamanho',
        'type' => 'select',
        'order_by' => 'menu_order',
        'has_archives' => false
    ],
    'Cor' => [
        'name' => 'Cor',
        'slug' => 'cor',
        'type' => 'select',
        'order_by' => 'menu_order',
        'has_archives' => false
    ],
    'Material' => [
        'name' => 'Material',
        'slug' => 'material',
        'type' => 'select',
        'order_by' => 'menu_order',
        'has_archives' => false
    ],
    'Estilo' => [
        'name' => 'Estilo',
        'slug' => 'estilo',
        'type' => 'select',
        'order_by' => 'menu_order',
        'has_archives' => false
    ]
];

// Criar atributos
foreach ($attributes as $name => $config) {
    $attribute_id = wc_create_attribute($config);
    
    if (!is_wp_error($attribute_id)) {
        echo "✅ Atributo criado: {$name} (ID: {$attribute_id})\n";
        
        // Registrar a taxonomia
        $taxonomy_name = 'pa_' . $config['slug'];
        if (!taxonomy_exists($taxonomy_name)) {
            register_taxonomy($taxonomy_name, 'product', [
                'labels' => [
                    'name' => $name,
                    'singular_name' => $name
                ],
                'hierarchical' => false,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => false
            ]);
            echo "  ✅ Taxonomia registrada: {$taxonomy_name}\n";
        }
        
        // Adicionar termos
        $terms = [
            'Tamanho' => ['PP', 'P', 'M', 'G', 'GG', 'XG'],
            'Cor' => ['Preto', 'Branco', 'Azul', 'Vermelho', 'Verde', 'Amarelo'],
            'Material' => ['Algodão', 'Poliéster', 'Seda', 'Lã', 'Jeans'],
            'Estilo' => ['Casual', 'Formal', 'Esportivo', 'Festa']
        ];
        
        if (isset($terms[$name])) {
            foreach ($terms[$name] as $term) {
                $term_result = wp_insert_term($term, $taxonomy_name);
                if (!is_wp_error($term_result)) {
                    echo "    ✅ Termo adicionado: {$term}\n";
                }
            }
        }
    } else {
        echo "❌ Erro ao criar atributo {$name}: " . $attribute_id->get_error_message() . "\n";
    }
}

echo "\n🎉 Atributos corrigidos com sucesso!\n";
echo "🛍️ Acesse a loja: http://localhost/shop\n";
echo "⚙️ Painel admin: http://localhost/wp-admin\n";
?>
