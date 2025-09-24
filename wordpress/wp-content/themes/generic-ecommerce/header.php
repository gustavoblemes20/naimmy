<?php
/**
 * Header do Generic E-commerce
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Navbar -->
<nav class="navbar" id="navbar">
    <div class="navbar-container">
        <div class="navbar-left">
            <?php
            // Logo
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo '<a href="' . home_url() . '" class="logo">' . get_bloginfo('name') . '</a>';
            }
            ?>
            
            <!-- Menu Principal -->
            <ul class="nav-links">
                <li><a href="<?php echo home_url(); ?>"><?php _e('Início', 'generic-ecommerce'); ?></a></li>
                
                <!-- Categorias Dropdown -->
                <li class="categories-dropdown">
                    <a href="#categorias"><?php _e('Categorias', 'generic-ecommerce'); ?></a>
                    <ul class="dropdown-menu" id="categoriesMenu">
                        <?php
                        $categories = generic_get_product_categories();
                        if ($categories && !is_wp_error($categories)) {
                            foreach ($categories as $category) {
                                echo '<li><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
                            }
                        } else {
                            // Categorias padrão
                            $default_categories = array(
                                __('Bolsas', 'generic-ecommerce'),
                                __('Calçados', 'generic-ecommerce'),
                                __('Roupas', 'generic-ecommerce'),
                                __('Acessórios', 'generic-ecommerce'),
                                __('Carteiras', 'generic-ecommerce'),
                                __('Bijuterias', 'generic-ecommerce')
                            );
                            foreach ($default_categories as $category) {
                                echo '<li><a href="#' . strtolower($category) . '">' . $category . '</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </li>
                
                <!-- Coleções Dropdown -->
                <li class="collections-dropdown">
                    <a href="#colecoes"><?php _e('Coleções', 'generic-ecommerce'); ?></a>
                    <ul class="dropdown-menu" id="collectionsMenu">
                        <?php
                        $collections = generic_get_collections();
                        if ($collections) {
                            foreach ($collections as $collection) {
                                echo '<li><a href="' . get_permalink($collection->ID) . '">' . $collection->post_title . '</a></li>';
                            }
                        } else {
                            echo '<li><a href="#colecoes">' . __('Nenhuma coleção disponível', 'generic-ecommerce') . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                
                <li><a href="<?php echo wc_get_page_permalink('shop'); ?>"><?php _e('Loja', 'generic-ecommerce'); ?></a></li>
                <li><a href="<?php echo get_permalink(get_page_by_path('sobre')); ?>"><?php _e('Sobre', 'generic-ecommerce'); ?></a></li>
                <li><a href="<?php echo get_permalink(get_page_by_path('contato')); ?>"><?php _e('Contato', 'generic-ecommerce'); ?></a></li>
            </ul>
        </div>
        
        <div class="navbar-right">
            <!-- Busca -->
            <div class="search-container">
                <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                    <input type="search" name="s" placeholder="<?php _e('Buscar produtos...', 'generic-ecommerce'); ?>" value="<?php echo get_search_query(); ?>" />
                    <button type="submit"><?php _e('Buscar', 'generic-ecommerce'); ?></button>
                </form>
            </div>
            
            <!-- Carrinho -->
            <?php if (class_exists('WooCommerce')) : ?>
                <div class="cart-container">
                    <a href="<?php echo wc_get_cart_url(); ?>" class="cart-link">
                        <span class="dashicons dashicons-cart"></span>
                        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    </a>
                </div>
            <?php endif; ?>
            
            <!-- Menu Mobile -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
    
    <!-- Menu Mobile -->
    <div class="mobile-menu" id="mobileMenu">
        <ul class="mobile-nav-links">
            <li><a href="<?php echo home_url(); ?>"><?php _e('Início', 'generic-ecommerce'); ?></a></li>
            <li><a href="<?php echo wc_get_page_permalink('shop'); ?>"><?php _e('Loja', 'generic-ecommerce'); ?></a></li>
            <li><a href="<?php echo get_permalink(get_page_by_path('sobre')); ?>"><?php _e('Sobre', 'generic-ecommerce'); ?></a></li>
            <li><a href="<?php echo get_permalink(get_page_by_path('contato')); ?>"><?php _e('Contato', 'generic-ecommerce'); ?></a></li>
        </ul>
    </div>
</nav>

<!-- Conteúdo Principal -->
<main id="main" class="site-main">
