<?php
/**
 * Footer do Generic E-commerce
 */
?>

</main><!-- #main -->

<!-- Footer -->
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-content">
            
            <!-- Coluna 1: Informações da Loja -->
            <div class="footer-column">
                <h3 class="footer-title"><?php echo get_bloginfo('name'); ?></h3>
                <p class="footer-description">
                    <?php echo get_bloginfo('description'); ?>
                </p>
                
                <!-- Redes Sociais -->
                <div class="social-links">
                    <?php
                    $facebook = get_theme_mod('generic_facebook', '');
                    $instagram = get_theme_mod('generic_instagram', '');
                    $twitter = get_theme_mod('generic_twitter', '');
                    $youtube = get_theme_mod('generic_youtube', '');
                    ?>
                    
                    <?php if ($facebook) : ?>
                        <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener">
                            <span class="dashicons dashicons-facebook"></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($instagram) : ?>
                        <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener">
                            <span class="dashicons dashicons-instagram"></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($twitter) : ?>
                        <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener">
                            <span class="dashicons dashicons-twitter"></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($youtube) : ?>
                        <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener">
                            <span class="dashicons dashicons-video-alt3"></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Coluna 2: Links Rápidos -->
            <div class="footer-column">
                <h3 class="footer-title"><?php _e('Links Rápidos', 'generic-ecommerce'); ?></h3>
                <ul class="footer-links">
                    <li><a href="<?php echo home_url(); ?>"><?php _e('Início', 'generic-ecommerce'); ?></a></li>
                    <li><a href="<?php echo wc_get_page_permalink('shop'); ?>"><?php _e('Loja', 'generic-ecommerce'); ?></a></li>
                    <li><a href="<?php echo get_permalink(get_page_by_path('sobre')); ?>"><?php _e('Sobre Nós', 'generic-ecommerce'); ?></a></li>
                    <li><a href="<?php echo get_permalink(get_page_by_path('contato')); ?>"><?php _e('Contato', 'generic-ecommerce'); ?></a></li>
                    <li><a href="<?php echo get_permalink(get_page_by_path('politica-privacidade')); ?>"><?php _e('Política de Privacidade', 'generic-ecommerce'); ?></a></li>
                    <li><a href="<?php echo get_permalink(get_page_by_path('termos-uso')); ?>"><?php _e('Termos de Uso', 'generic-ecommerce'); ?></a></li>
                </ul>
            </div>
            
            <!-- Coluna 3: Categorias -->
            <div class="footer-column">
                <h3 class="footer-title"><?php _e('Categorias', 'generic-ecommerce'); ?></h3>
                <ul class="footer-links">
                    <?php
                    $categories = generic_get_product_categories();
                    if ($categories && !is_wp_error($categories)) {
                        foreach (array_slice($categories, 0, 6) as $category) {
                            echo '<li><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
                        }
                    } else {
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
            </div>
            
            <!-- Coluna 4: Contato -->
            <div class="footer-column">
                <h3 class="footer-title"><?php _e('Contato', 'generic-ecommerce'); ?></h3>
                <div class="contact-info">
                    <p>
                        <span class="dashicons dashicons-email"></span>
                        <?php echo get_theme_mod('generic_store_email', 'contato@generic-ecommerce.com'); ?>
                    </p>
                    <p>
                        <span class="dashicons dashicons-phone"></span>
                        <?php echo get_theme_mod('generic_store_phone', '(11) 99999-9999'); ?>
                    </p>
                    <p>
                        <span class="dashicons dashicons-location"></span>
                        <?php echo get_theme_mod('generic_store_address', 'Endereço não configurado'); ?>
                    </p>
                </div>
                
                <!-- Newsletter -->
                <div class="newsletter-signup">
                    <h4><?php _e('Newsletter', 'generic-ecommerce'); ?></h4>
                    <form class="newsletter-form">
                        <input type="email" placeholder="<?php _e('Seu email', 'generic-ecommerce'); ?>" required>
                        <button type="submit"><?php _e('Inscrever', 'generic-ecommerce'); ?></button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="copyright">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>. <?php _e('Todos os direitos reservados.', 'generic-ecommerce'); ?></p>
                </div>
                
                <div class="payment-methods">
                    <span class="payment-label"><?php _e('Formas de Pagamento:', 'generic-ecommerce'); ?></span>
                    <div class="payment-icons">
                        <span class="payment-icon">💳</span>
                        <span class="payment-icon">🏦</span>
                        <span class="payment-icon">📱</span>
                        <span class="payment-icon">💰</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Estilos do Footer -->
<style>
.site-footer {
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    margin-top: 60px;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px 20px;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-bottom: 40px;
}

.footer-column h3.footer-title {
    color: #333;
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: 600;
}

.footer-description {
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

.social-links {
    display: flex;
    gap: 15px;
}

.social-links a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: #333;
    color: #fff;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-links a:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 10px;
}

.footer-links a {
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: var(--secondary-color);
}

.contact-info p {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    color: #666;
}

.contact-info .dashicons {
    margin-right: 10px;
    color: var(--secondary-color);
}

.newsletter-signup h4 {
    margin-bottom: 15px;
    color: #333;
}

.newsletter-form {
    display: flex;
    gap: 10px;
}

.newsletter-form input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.newsletter-form button {
    padding: 10px 20px;
    background: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.newsletter-form button:hover {
    background: var(--secondary-color);
}

.footer-bottom {
    border-top: 1px solid #e9ecef;
    padding-top: 20px;
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.copyright p {
    margin: 0;
    color: #666;
    font-size: 14px;
}

.payment-methods {
    display: flex;
    align-items: center;
    gap: 15px;
}

.payment-label {
    color: #666;
    font-size: 14px;
}

.payment-icons {
    display: flex;
    gap: 10px;
}

.payment-icon {
    font-size: 20px;
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
    }
    
    .newsletter-form {
        flex-direction: column;
    }
}
</style>

<?php wp_footer(); ?>
</body>
</html>
