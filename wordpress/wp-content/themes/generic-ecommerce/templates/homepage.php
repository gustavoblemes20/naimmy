<?php
/**
 * Template da Homepage
 */

// Slider da homepage
$sliders = generic_get_homepage_sliders();
?>

<!-- Hero Slider -->
<div class="hero-slider" id="heroSlider">
    <?php if ($sliders) : ?>
        <?php foreach ($sliders as $index => $slider) : ?>
            <?php
            $slider_active = get_post_meta($slider->ID, 'slider_active', true);
            $slider_order = get_post_meta($slider->ID, 'slider_order', true);
            $slider_button_text = get_post_meta($slider->ID, 'slider_button_text', true);
            $slider_button_url = get_post_meta($slider->ID, 'slider_button_url', true);
            
            if (!$slider_active) continue;
            ?>
            <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>" 
                 style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('<?php echo get_the_post_thumbnail_url($slider->ID, 'full'); ?>');">
                <div class="slide-content">
                    <h1 class="slide-title"><?php echo $slider->post_title; ?></h1>
                    <p class="slide-subtitle"><?php echo $slider->post_content; ?></p>
                    <?php if ($slider_button_text && $slider_button_url) : ?>
                        <a href="<?php echo esc_url($slider_button_url); ?>" class="slide-button">
                            <?php echo esc_html($slider_button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <!-- Sliders padrão -->
        <div class="slide active" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
            <div class="slide-content">
                <h1 class="slide-title"><?php _e('Bem-vindo à nossa loja', 'generic-ecommerce'); ?></h1>
                <p class="slide-subtitle"><?php _e('Descubra nossa coleção exclusiva de produtos', 'generic-ecommerce'); ?></p>
                <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="slide-button">
                    <?php _e('Ver Produtos', 'generic-ecommerce'); ?>
                </a>
            </div>
        </div>
        
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1469334031218-e382a71b716b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
            <div class="slide-content">
                <h1 class="slide-title"><?php _e('Nova Coleção', 'generic-ecommerce'); ?></h1>
                <p class="slide-subtitle"><?php _e('Tendências atuais com qualidade excepcional', 'generic-ecommerce'); ?></p>
                <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="slide-button">
                    <?php _e('Explorar', 'generic-ecommerce'); ?>
                </a>
            </div>
        </div>
        
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
            <div class="slide-content">
                <h1 class="slide-title"><?php _e('Ofertas Especiais', 'generic-ecommerce'); ?></h1>
                <p class="slide-subtitle"><?php _e('Descontos imperdíveis em produtos selecionados', 'generic-ecommerce'); ?></p>
                <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="slide-button">
                    <?php _e('Comprar Agora', 'generic-ecommerce'); ?>
                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Controles do slide -->
    <div class="slide-controls">
        <?php
        $slide_count = $sliders ? count($sliders) : 3;
        for ($i = 0; $i < $slide_count; $i++) :
        ?>
            <button class="slide-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></button>
        <?php endfor; ?>
    </div>
</div>

<!-- Seção de Produtos em Destaque -->
<section class="featured-products-section">
    <div class="section-container">
        <div class="section-header">
            <h2 class="section-title"><?php _e('Produtos em Destaque', 'generic-ecommerce'); ?></h2>
            <p class="section-subtitle"><?php _e('Nossos produtos mais populares', 'generic-ecommerce'); ?></p>
        </div>
        
        <div class="products-grid">
            <?php
            $featured_products = generic_get_featured_products(8);
            if ($featured_products) :
                foreach ($featured_products as $product) :
                    $product_price = get_post_meta($product->ID, 'product_price', true);
                    $product_sale_price = get_post_meta($product->ID, 'product_sale_price', true);
                    $product_image = get_the_post_thumbnail_url($product->ID, 'generic-product-thumb');
                    ?>
                    <div class="product-card">
                        <div class="product-image" style="background-image: url('<?php echo $product_image ?: 'https://via.placeholder.com/300x300'; ?>');"></div>
                        <div class="product-info">
                            <h3 class="product-title"><?php echo $product->post_title; ?></h3>
                            <div class="product-price">
                                <?php if ($product_sale_price) : ?>
                                    <span class="sale-price">R$ <?php echo number_format($product_sale_price, 2, ',', '.'); ?></span>
                                    <span class="regular-price">R$ <?php echo number_format($product_price, 2, ',', '.'); ?></span>
                                <?php else : ?>
                                    <span class="price">R$ <?php echo number_format($product_price, 2, ',', '.'); ?></span>
                                <?php endif; ?>
                            </div>
                            <a href="<?php echo get_permalink($product->ID); ?>" class="product-button">
                                <?php _e('Ver Detalhes', 'generic-ecommerce'); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="no-products">
                    <p><?php _e('Nenhum produto em destaque encontrado.', 'generic-ecommerce'); ?></p>
                    <a href="<?php echo admin_url('post-new.php?post_type=generic_product'); ?>" class="button">
                        <?php _e('Adicionar Produtos', 'generic-ecommerce'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="section-footer">
            <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="button button-primary">
                <?php _e('Ver Todos os Produtos', 'generic-ecommerce'); ?>
            </a>
        </div>
    </div>
</section>

<!-- Seção de Coleções -->
<section class="collections-section">
    <div class="section-container">
        <div class="section-header">
            <h2 class="section-title"><?php _e('Nossas Coleções', 'generic-ecommerce'); ?></h2>
            <p class="section-subtitle"><?php _e('Explore nossas coleções temáticas', 'generic-ecommerce'); ?></p>
        </div>
        
        <div class="collections-grid">
            <?php
            $collections = generic_get_collections();
            if ($collections) :
                foreach (array_slice($collections, 0, 4) as $collection) :
                    $collection_image = get_the_post_thumbnail_url($collection->ID, 'generic-collection-thumb');
                    $collection_type = get_post_meta($collection->ID, 'collection_type', true);
                    ?>
                    <div class="collection-card">
                        <div class="collection-image" style="background-image: url('<?php echo $collection_image ?: 'https://via.placeholder.com/400x300'; ?>');"></div>
                        <div class="collection-info">
                            <h3 class="collection-title"><?php echo $collection->post_title; ?></h3>
                            <p class="collection-description"><?php echo wp_trim_words($collection->post_content, 20); ?></p>
                            <a href="<?php echo get_permalink($collection->ID); ?>" class="collection-button">
                                <?php _e('Ver Coleção', 'generic-ecommerce'); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="no-collections">
                    <p><?php _e('Nenhuma coleção encontrada.', 'generic-ecommerce'); ?></p>
                    <a href="<?php echo admin_url('post-new.php?post_type=generic_collection'); ?>" class="button">
                        <?php _e('Criar Coleção', 'generic-ecommerce'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Estilos específicos da homepage -->
<style>
.featured-products-section,
.collections-section {
    padding: 80px 0;
}

.section-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-title {
    font-size: 36px;
    font-weight: 300;
    margin-bottom: 20px;
    color: var(--text-color);
}

.section-subtitle {
    font-size: 18px;
    color: var(--text-light);
    max-width: 600px;
    margin: 0 auto;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.collections-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.collection-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.collection-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.collection-image {
    height: 200px;
    background-size: cover;
    background-position: center;
}

.collection-info {
    padding: 20px;
}

.collection-title {
    font-size: 20px;
    font-weight: 500;
    margin-bottom: 10px;
    color: var(--text-color);
}

.collection-description {
    color: var(--text-light);
    margin-bottom: 20px;
    line-height: 1.6;
}

.collection-button {
    display: inline-block;
    padding: 10px 20px;
    background: var(--primary-color);
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    transition: var(--transition);
}

.collection-button:hover {
    background: var(--secondary-color);
    color: #fff;
}

.section-footer {
    text-align: center;
}

.button-primary {
    display: inline-block;
    padding: 15px 30px;
    background: var(--primary-color);
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    transition: var(--transition);
}

.button-primary:hover {
    background: var(--secondary-color);
    color: #fff;
}

.no-products,
.no-collections {
    text-align: center;
    padding: 40px;
    grid-column: 1 / -1;
}

.no-products p,
.no-collections p {
    margin-bottom: 20px;
    color: var(--text-light);
}

@media (max-width: 768px) {
    .section-title {
        font-size: 28px;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .collections-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- JavaScript do slider -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('heroSlider');
    if (!slider) return;
    
    const slides = slider.querySelectorAll('.slide');
    const dots = slider.querySelectorAll('.slide-dot');
    let currentSlide = 0;
    let slideInterval;
    
    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
        currentSlide = index;
    }
    
    function nextSlide() {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }
    
    function startSlider() {
        slideInterval = setInterval(nextSlide, 5000);
    }
    
    function stopSlider() {
        clearInterval(slideInterval);
    }
    
    // Controles dos dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            stopSlider();
            startSlider();
        });
    });
    
    // Pausar no hover
    slider.addEventListener('mouseenter', stopSlider);
    slider.addEventListener('mouseleave', startSlider);
    
    // Iniciar slider
    startSlider();
});
</script>
