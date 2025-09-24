<?php
/**
 * Custom Post Types para Generic E-commerce
 */

// Evitar acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// Registrar Custom Post Types
function generic_register_post_types() {
    
    // Produtos
    register_post_type('generic_product', array(
        'labels' => array(
            'name'               => __('Produtos', 'generic-ecommerce'),
            'singular_name'      => __('Produto', 'generic-ecommerce'),
            'menu_name'          => __('Produtos', 'generic-ecommerce'),
            'add_new'            => __('Adicionar Novo', 'generic-ecommerce'),
            'add_new_item'       => __('Adicionar Novo Produto', 'generic-ecommerce'),
            'edit_item'          => __('Editar Produto', 'generic-ecommerce'),
            'new_item'           => __('Novo Produto', 'generic-ecommerce'),
            'view_item'          => __('Ver Produto', 'generic-ecommerce'),
            'search_items'       => __('Buscar Produtos', 'generic-ecommerce'),
            'not_found'          => __('Nenhum produto encontrado', 'generic-ecommerce'),
            'not_found_in_trash' => __('Nenhum produto na lixeira', 'generic-ecommerce'),
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-products',
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'produtos'),
        'query_var'          => true,
    ));
    
    // Coleções
    register_post_type('generic_collection', array(
        'labels' => array(
            'name'               => __('Coleções', 'generic-ecommerce'),
            'singular_name'      => __('Coleção', 'generic-ecommerce'),
            'menu_name'          => __('Coleções', 'generic-ecommerce'),
            'add_new'            => __('Adicionar Nova', 'generic-ecommerce'),
            'add_new_item'       => __('Adicionar Nova Coleção', 'generic-ecommerce'),
            'edit_item'          => __('Editar Coleção', 'generic-ecommerce'),
            'new_item'           => __('Nova Coleção', 'generic-ecommerce'),
            'view_item'          => __('Ver Coleção', 'generic-ecommerce'),
            'search_items'       => __('Buscar Coleções', 'generic-ecommerce'),
            'not_found'          => __('Nenhuma coleção encontrada', 'generic-ecommerce'),
            'not_found_in_trash' => __('Nenhuma coleção na lixeira', 'generic-ecommerce'),
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-images-alt2',
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'colecoes'),
        'query_var'          => true,
    ));
    
    // Sliders
    register_post_type('generic_slider', array(
        'labels' => array(
            'name'               => __('Sliders', 'generic-ecommerce'),
            'singular_name'      => __('Slider', 'generic-ecommerce'),
            'menu_name'          => __('Sliders', 'generic-ecommerce'),
            'add_new'            => __('Adicionar Novo', 'generic-ecommerce'),
            'add_new_item'       => __('Adicionar Novo Slider', 'generic-ecommerce'),
            'edit_item'          => __('Editar Slider', 'generic-ecommerce'),
            'new_item'           => __('Novo Slider', 'generic-ecommerce'),
            'view_item'          => __('Ver Slider', 'generic-ecommerce'),
            'search_items'       => __('Buscar Sliders', 'generic-ecommerce'),
            'not_found'          => __('Nenhum slider encontrado', 'generic-ecommerce'),
            'not_found_in_trash' => __('Nenhum slider na lixeira', 'generic-ecommerce'),
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'show_in_admin_bar'  => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-slides',
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'has_archive'        => false,
        'rewrite'            => false,
        'query_var'          => false,
    ));
    
    // Banners
    register_post_type('generic_banner', array(
        'labels' => array(
            'name'               => __('Banners', 'generic-ecommerce'),
            'singular_name'      => __('Banner', 'generic-ecommerce'),
            'menu_name'          => __('Banners', 'generic-ecommerce'),
            'add_new'            => __('Adicionar Novo', 'generic-ecommerce'),
            'add_new_item'       => __('Adicionar Novo Banner', 'generic-ecommerce'),
            'edit_item'          => __('Editar Banner', 'generic-ecommerce'),
            'new_item'           => __('Novo Banner', 'generic-ecommerce'),
            'view_item'          => __('Ver Banner', 'generic-ecommerce'),
            'search_items'       => __('Buscar Banners', 'generic-ecommerce'),
            'not_found'          => __('Nenhum banner encontrado', 'generic-ecommerce'),
            'not_found_in_trash' => __('Nenhum banner na lixeira', 'generic-ecommerce'),
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'show_in_admin_bar'  => false,
        'menu_position'      => 8,
        'menu_icon'          => 'dashicons-format-image',
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'has_archive'        => false,
        'rewrite'            => false,
        'query_var'          => false,
    ));
}
add_action('init', 'generic_register_post_types');

// Registrar Taxonomias
function generic_register_taxonomies() {
    
    // Categorias de Produtos
    register_taxonomy('generic_category', 'generic_product', array(
        'labels' => array(
            'name'              => __('Categorias', 'generic-ecommerce'),
            'singular_name'     => __('Categoria', 'generic-ecommerce'),
            'search_items'      => __('Buscar Categorias', 'generic-ecommerce'),
            'all_items'         => __('Todas as Categorias', 'generic-ecommerce'),
            'parent_item'       => __('Categoria Pai', 'generic-ecommerce'),
            'parent_item_colon' => __('Categoria Pai:', 'generic-ecommerce'),
            'edit_item'         => __('Editar Categoria', 'generic-ecommerce'),
            'update_item'       => __('Atualizar Categoria', 'generic-ecommerce'),
            'add_new_item'      => __('Adicionar Nova Categoria', 'generic-ecommerce'),
            'new_item_name'     => __('Nome da Nova Categoria', 'generic-ecommerce'),
            'menu_name'         => __('Categorias', 'generic-ecommerce'),
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'rewrite'           => array('slug' => 'categoria'),
    ));
    
    // Tags de Produtos
    register_taxonomy('generic_tag', 'generic_product', array(
        'labels' => array(
            'name'              => __('Tags', 'generic-ecommerce'),
            'singular_name'     => __('Tag', 'generic-ecommerce'),
            'search_items'      => __('Buscar Tags', 'generic-ecommerce'),
            'all_items'         => __('Todas as Tags', 'generic-ecommerce'),
            'edit_item'         => __('Editar Tag', 'generic-ecommerce'),
            'update_item'       => __('Atualizar Tag', 'generic-ecommerce'),
            'add_new_item'      => __('Adicionar Nova Tag', 'generic-ecommerce'),
            'new_item_name'     => __('Nome da Nova Tag', 'generic-ecommerce'),
            'menu_name'         => __('Tags', 'generic-ecommerce'),
        ),
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'rewrite'           => array('slug' => 'tag'),
    ));
    
    // Categorias de Coleções
    register_taxonomy('generic_collection_category', 'generic_collection', array(
        'labels' => array(
            'name'              => __('Categorias de Coleções', 'generic-ecommerce'),
            'singular_name'     => __('Categoria de Coleção', 'generic-ecommerce'),
            'search_items'      => __('Buscar Categorias', 'generic-ecommerce'),
            'all_items'         => __('Todas as Categorias', 'generic-ecommerce'),
            'parent_item'       => __('Categoria Pai', 'generic-ecommerce'),
            'parent_item_colon' => __('Categoria Pai:', 'generic-ecommerce'),
            'edit_item'         => __('Editar Categoria', 'generic-ecommerce'),
            'update_item'       => __('Atualizar Categoria', 'generic-ecommerce'),
            'add_new_item'      => __('Adicionar Nova Categoria', 'generic-ecommerce'),
            'new_item_name'     => __('Nome da Nova Categoria', 'generic-ecommerce'),
            'menu_name'         => __('Categorias de Coleções', 'generic-ecommerce'),
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'rewrite'           => array('slug' => 'categoria-colecao'),
    ));
}
add_action('init', 'generic_register_taxonomies');

// Adicionar colunas personalizadas na listagem de produtos
function generic_product_columns($columns) {
    $new_columns = array();
    
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        
        if ($key === 'title') {
            $new_columns['product_image'] = __('Imagem', 'generic-ecommerce');
            $new_columns['product_price'] = __('Preço', 'generic-ecommerce');
            $new_columns['product_category'] = __('Categoria', 'generic-ecommerce');
            $new_columns['featured'] = __('Destaque', 'generic-ecommerce');
        }
    }
    
    return $new_columns;
}
add_filter('manage_generic_product_posts_columns', 'generic_product_columns');

// Preencher colunas personalizadas
function generic_product_column_content($column, $post_id) {
    switch ($column) {
        case 'product_image':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, 'thumbnail');
            } else {
                echo '<span class="dashicons dashicons-format-image"></span>';
            }
            break;
            
        case 'product_price':
            $price = get_post_meta($post_id, 'product_price', true);
            if ($price) {
                echo 'R$ ' . number_format($price, 2, ',', '.');
            } else {
                echo '—';
            }
            break;
            
        case 'product_category':
            $terms = get_the_terms($post_id, 'generic_category');
            if ($terms && !is_wp_error($terms)) {
                $category_names = array();
                foreach ($terms as $term) {
                    $category_names[] = $term->name;
                }
                echo implode(', ', $category_names);
            } else {
                echo '—';
            }
            break;
            
        case 'featured':
            $featured = get_post_meta($post_id, 'featured_product', true);
            if ($featured) {
                echo '<span class="dashicons dashicons-star-filled" style="color: #ffb900;"></span>';
            } else {
                echo '<span class="dashicons dashicons-star-empty"></span>';
            }
            break;
    }
}
add_action('manage_generic_product_posts_custom_column', 'generic_product_column_content', 10, 2);

// Tornar colunas ordenáveis
function generic_product_sortable_columns($columns) {
    $columns['product_price'] = 'product_price';
    $columns['featured'] = 'featured';
    return $columns;
}
add_filter('manage_edit-generic_product_sortable_columns', 'generic_product_sortable_columns');

// Adicionar filtros na listagem de produtos
function generic_product_filters() {
    global $typenow;
    
    if ($typenow === 'generic_product') {
        // Filtro por categoria
        $categories = get_terms('generic_category');
        if ($categories && !is_wp_error($categories)) {
            echo '<select name="product_category">';
            echo '<option value="">Todas as Categorias</option>';
            foreach ($categories as $category) {
                $selected = isset($_GET['product_category']) && $_GET['product_category'] == $category->slug ? 'selected' : '';
                echo '<option value="' . $category->slug . '" ' . $selected . '>' . $category->name . '</option>';
            }
            echo '</select>';
        }
        
        // Filtro por destaque
        $featured = isset($_GET['featured']) ? $_GET['featured'] : '';
        echo '<select name="featured">';
        echo '<option value="">Todos os Produtos</option>';
        echo '<option value="1" ' . selected($featured, '1', false) . '>Em Destaque</option>';
        echo '<option value="0" ' . selected($featured, '0', false) . '>Não Destacados</option>';
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'generic_product_filters');

// Aplicar filtros na consulta
function generic_product_filter_query($query) {
    global $pagenow, $typenow;
    
    if ($pagenow === 'edit.php' && $typenow === 'generic_product') {
        if (isset($_GET['product_category']) && $_GET['product_category'] !== '') {
            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'generic_category',
                    'field'    => 'slug',
                    'terms'    => $_GET['product_category'],
                ),
            ));
        }
        
        if (isset($_GET['featured']) && $_GET['featured'] !== '') {
            $query->set('meta_query', array(
                array(
                    'key'     => 'featured_product',
                    'value'   => $_GET['featured'],
                    'compare' => '='
                ),
            ));
        }
    }
}
add_action('pre_get_posts', 'generic_product_filter_query');
