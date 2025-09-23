<?php
// Script para configurar checkout e área do cliente
require_once('wp-config.php');

echo "🛒 Configurando checkout e área do cliente...\n\n";

// 1. Configurar páginas do WooCommerce
echo "📄 Configurando páginas do WooCommerce...\n";

$pages = [
    'shop' => 'Loja',
    'cart' => 'Carrinho',
    'checkout' => 'Finalizar Compra',
    'myaccount' => 'Minha Conta'
];

foreach ($pages as $slug => $title) {
    $page = get_page_by_path($slug);
    if (!$page) {
        $page_id = wp_insert_post([
            'post_title' => $title,
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => ''
        ]);
        
        if ($page_id) {
            update_option('woocommerce_' . $slug . '_page_id', $page_id);
            echo "✅ Página criada: $title\n";
        }
    } else {
        echo "⚠️ Página já existe: $title\n";
    }
}

// 2. Configurar checkout
echo "\n⚙️ Configurando checkout...\n";

// Configurações gerais do checkout
update_option('woocommerce_checkout_privacy_policy_text', 'Seus dados pessoais serão utilizados para processar seu pedido, apoiar sua experiência em todo este site e para outros fins descritos em nossa política de privacidade.');
update_option('woocommerce_terms_page_id', 0);
update_option('woocommerce_checkout_privacy_policy_text', 'Seus dados pessoais serão utilizados para processar seu pedido, apoiar sua experiência em todo este site e para outros fins descritos em nossa política de privacidade.');

// Configurar campos de checkout
update_option('woocommerce_checkout_fields', [
    'billing' => [
        'billing_first_name' => [
            'label' => 'Nome',
            'required' => true,
            'class' => ['form-row-first']
        ],
        'billing_last_name' => [
            'label' => 'Sobrenome',
            'required' => true,
            'class' => ['form-row-last']
        ],
        'billing_company' => [
            'label' => 'Empresa',
            'required' => false,
            'class' => ['form-row-wide']
        ],
        'billing_cpf' => [
            'label' => 'CPF',
            'required' => true,
            'class' => ['form-row-first']
        ],
        'billing_cnpj' => [
            'label' => 'CNPJ',
            'required' => false,
            'class' => ['form-row-last']
        ],
        'billing_address_1' => [
            'label' => 'Endereço',
            'required' => true,
            'class' => ['form-row-wide']
        ],
        'billing_address_2' => [
            'label' => 'Complemento',
            'required' => false,
            'class' => ['form-row-wide']
        ],
        'billing_city' => [
            'label' => 'Cidade',
            'required' => true,
            'class' => ['form-row-wide']
        ],
        'billing_state' => [
            'label' => 'Estado',
            'required' => true,
            'class' => ['form-row-wide']
        ],
        'billing_postcode' => [
            'label' => 'CEP',
            'required' => true,
            'class' => ['form-row-wide']
        ],
        'billing_phone' => [
            'label' => 'Telefone',
            'required' => true,
            'class' => ['form-row-wide']
        ],
        'billing_email' => [
            'label' => 'E-mail',
            'required' => true,
            'class' => ['form-row-wide']
        ]
    ],
    'shipping' => [
        'shipping_first_name' => [
            'label' => 'Nome',
            'required' => true,
            'class' => ['form-row-first']
        ],
        'shipping_last_name' => [
            'label' => 'Sobrenome',
            'required' => true,
            'class' => ['form-row-last']
        ],
        'shipping_company' => [
            'label' => 'Empresa',
            'required' => false,
            'class' => ['form-row-wide']
        ],
        'shipping_address_1' => [
            'label' => 'Endereço',
            'required' => true,
            'class' => ['form-row-wide']
        ],
        'shipping_address_2' => [
            'label' => 'Complemento',
            'required' => false,
            'class' => ['form-row-wide']
        ],
        'shipping_city' => [
            'label' => 'Cidade',
            'required' => true,
            'class' => ['form-row-wide']
        ],
        'shipping_state' => [
            'label' => 'Estado',
            'required' => true,
            'class' => ['form-row-wide']
        ],
        'shipping_postcode' => [
            'label' => 'CEP',
            'required' => true,
            'class' => ['form-row-wide']
        ]
    ]
]);

echo "✅ Checkout configurado!\n";

// 3. Configurar área do cliente
echo "\n👤 Configurando área do cliente...\n";

// Configurar páginas da área do cliente
$account_pages = [
    'orders' => 'Pedidos',
    'downloads' => 'Downloads',
    'edit-address' => 'Endereços',
    'edit-account' => 'Detalhes da conta',
    'customer-logout' => 'Sair'
];

foreach ($account_pages as $slug => $title) {
    $page = get_page_by_path($slug);
    if (!$page) {
        $page_id = wp_insert_post([
            'post_title' => $title,
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => ''
        ]);
        
        if ($page_id) {
            echo "✅ Página criada: $title\n";
        }
    }
}

// Configurar permissões da área do cliente
update_option('woocommerce_myaccount_downloads_endpoint', 'downloads');
update_option('woocommerce_myaccount_edit_address_endpoint', 'edit-address');
update_option('woocommerce_myaccount_edit_account_endpoint', 'edit-account');
update_option('woocommerce_myaccount_orders_endpoint', 'orders');
update_option('woocommerce_myaccount_payment_methods_endpoint', 'payment-methods');
update_option('woocommerce_myaccount_lost_password_endpoint', 'lost-password');
update_option('woocommerce_myaccount_customer_logout_endpoint', 'customer-logout');

echo "✅ Área do cliente configurada!\n";

// 4. Configurar carrinho
echo "\n🛒 Configurando carrinho...\n";

// Configurações do carrinho
update_option('woocommerce_cart_redirect_after_add', 'no');
update_option('woocommerce_enable_ajax_add_to_cart', 'yes');
update_option('woocommerce_cart_page_id', get_option('woocommerce_cart_page_id'));
update_option('woocommerce_checkout_page_id', get_option('woocommerce_checkout_page_id'));

echo "✅ Carrinho configurado!\n";

echo "\n🎉 Configuração de checkout e área do cliente concluída!\n";
echo "🛒 Checkout configurado com campos brasileiros\n";
echo "👤 Área do cliente configurada\n";
echo "🛍️ Carrinho configurado\n";
echo "🌐 Acesse: http://localhost/shop\n";
echo "⚙️ Admin: http://localhost/wp-admin\n";
?>
