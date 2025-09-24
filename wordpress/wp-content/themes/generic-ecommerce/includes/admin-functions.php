<?php
/**
 * Funções do Admin para Generic E-commerce
 */

// Evitar acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// Adicionar menu personalizado no admin
function generic_add_admin_menu() {
    add_menu_page(
        __('Generic E-commerce', 'generic-ecommerce'),
        __('E-commerce', 'generic-ecommerce'),
        'manage_options',
        'generic-ecommerce',
        'generic_admin_dashboard',
        'dashicons-store',
        30
    );
    
    // Submenu Dashboard
    add_submenu_page(
        'generic-ecommerce',
        __('Dashboard', 'generic-ecommerce'),
        __('Dashboard', 'generic-ecommerce'),
        'manage_options',
        'generic-ecommerce',
        'generic_admin_dashboard'
    );
    
    // Submenu Configurações
    add_submenu_page(
        'generic-ecommerce',
        __('Configurações', 'generic-ecommerce'),
        __('Configurações', 'generic-ecommerce'),
        'manage_options',
        'generic-settings',
        'generic_admin_settings'
    );
    
    // Submenu Estatísticas
    add_submenu_page(
        'generic-ecommerce',
        __('Estatísticas', 'generic-ecommerce'),
        __('Estatísticas', 'generic-ecommerce'),
        'manage_options',
        'generic-stats',
        'generic_admin_stats'
    );
    
    // Submenu Upload de Imagens
    add_submenu_page(
        'generic-ecommerce',
        __('Upload de Imagens', 'generic-ecommerce'),
        __('Upload de Imagens', 'generic-ecommerce'),
        'manage_options',
        'generic-media',
        'generic_admin_media'
    );
}
add_action('admin_menu', 'generic_add_admin_menu');

// Dashboard principal
function generic_admin_dashboard() {
    ?>
    <div class="wrap">
        <h1><?php _e('Dashboard - Generic E-commerce', 'generic-ecommerce'); ?></h1>
        
        <div class="generic-dashboard-widgets">
            <div class="generic-widget-row">
                <div class="generic-widget">
                    <h3><?php _e('Estatísticas Gerais', 'generic-ecommerce'); ?></h3>
                    <div class="generic-stats-grid">
                        <div class="stat-item">
                            <span class="stat-number"><?php echo wp_count_posts('generic_product')->publish; ?></span>
                            <span class="stat-label"><?php _e('Produtos', 'generic-ecommerce'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo wp_count_posts('generic_collection')->publish; ?></span>
                            <span class="stat-label"><?php _e('Coleções', 'generic-ecommerce'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo wp_count_posts('generic_slider')->publish; ?></span>
                            <span class="stat-label"><?php _e('Sliders', 'generic-ecommerce'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo wp_count_posts('generic_banner')->publish; ?></span>
                            <span class="stat-label"><?php _e('Banners', 'generic-ecommerce'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="generic-widget-row">
                <div class="generic-widget">
                    <h3><?php _e('Produtos em Destaque', 'generic-ecommerce'); ?></h3>
                    <?php
                    $featured_products = generic_get_featured_products(5);
                    if ($featured_products) {
                        echo '<ul class="featured-products-list">';
                        foreach ($featured_products as $product) {
                            echo '<li>';
                            echo '<a href="' . get_edit_post_link($product->ID) . '">';
                            if (has_post_thumbnail($product->ID)) {
                                echo get_the_post_thumbnail($product->ID, 'thumbnail');
                            }
                            echo '<span>' . $product->post_title . '</span>';
                            echo '</a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p>' . __('Nenhum produto em destaque encontrado.', 'generic-ecommerce') . '</p>';
                    }
                    ?>
                </div>
                
                <div class="generic-widget">
                    <h3><?php _e('Ações Rápidas', 'generic-ecommerce'); ?></h3>
                    <div class="quick-actions">
                        <a href="<?php echo admin_url('post-new.php?post_type=generic_product'); ?>" class="button button-primary">
                            <?php _e('Adicionar Produto', 'generic-ecommerce'); ?>
                        </a>
                        <a href="<?php echo admin_url('post-new.php?post_type=generic_collection'); ?>" class="button">
                            <?php _e('Adicionar Coleção', 'generic-ecommerce'); ?>
                        </a>
                        <a href="<?php echo admin_url('post-new.php?post_type=generic_slider'); ?>" class="button">
                            <?php _e('Adicionar Slider', 'generic-ecommerce'); ?>
                        </a>
                        <a href="<?php echo admin_url('post-new.php?post_type=generic_banner'); ?>" class="button">
                            <?php _e('Adicionar Banner', 'generic-ecommerce'); ?>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="generic-widget-row">
                <div class="generic-widget">
                    <h3><?php _e('Configurações da Loja', 'generic-ecommerce'); ?></h3>
                    <div class="store-settings">
                        <p><strong><?php _e('Nome da Loja:', 'generic-ecommerce'); ?></strong> <?php echo generic_get_option('store_name', 'Generic E-commerce'); ?></p>
                        <p><strong><?php _e('Email:', 'generic-ecommerce'); ?></strong> <?php echo generic_get_option('store_email', 'contato@generic-ecommerce.com'); ?></p>
                        <p><strong><?php _e('Telefone:', 'generic-ecommerce'); ?></strong> <?php echo generic_get_option('store_phone', '(11) 99999-9999'); ?></p>
                        <p><strong><?php _e('Endereço:', 'generic-ecommerce'); ?></strong> <?php echo generic_get_option('store_address', 'Endereço não configurado'); ?></p>
                        <a href="<?php echo admin_url('admin.php?page=generic-settings'); ?>" class="button">
                            <?php _e('Editar Configurações', 'generic-ecommerce'); ?>
                        </a>
                    </div>
                </div>
                
                <div class="generic-widget">
                    <h3><?php _e('Status do Sistema', 'generic-ecommerce'); ?></h3>
                    <div class="system-status">
                        <p><span class="status-indicator green"></span> <?php _e('WordPress:', 'generic-ecommerce'); ?> <?php echo get_bloginfo('version'); ?></p>
                        <p><span class="status-indicator green"></span> <?php _e('Tema:', 'generic-ecommerce'); ?> Generic E-commerce v<?php echo GENERIC_ECOMMERCE_VERSION; ?></p>
                        <p><span class="status-indicator green"></span> <?php _e('PHP:', 'generic-ecommerce'); ?> <?php echo PHP_VERSION; ?></p>
                        <p><span class="status-indicator green"></span> <?php _e('Memória:', 'generic-ecommerce'); ?> <?php echo ini_get('memory_limit'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .generic-dashboard-widgets {
        display: grid;
        gap: 20px;
        margin-top: 20px;
    }
    
    .generic-widget-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .generic-widget {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 20px;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    
    .generic-widget h3 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 16px;
    }
    
    .generic-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }
    
    .stat-item {
        text-align: center;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 4px;
    }
    
    .stat-number {
        display: block;
        font-size: 24px;
        font-weight: bold;
        color: #0073aa;
    }
    
    .stat-label {
        display: block;
        font-size: 12px;
        color: #666;
        text-transform: uppercase;
        margin-top: 5px;
    }
    
    .featured-products-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .featured-products-list li {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .featured-products-list li:last-child {
        border-bottom: none;
    }
    
    .featured-products-list li a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #333;
    }
    
    .featured-products-list li img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 10px;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    
    .quick-actions .button {
        text-align: center;
        padding: 10px;
    }
    
    .store-settings p {
        margin: 10px 0;
    }
    
    .system-status p {
        display: flex;
        align-items: center;
        margin: 10px 0;
    }
    
    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 10px;
    }
    
    .status-indicator.green {
        background: #46b450;
    }
    
    .status-indicator.red {
        background: #dc3232;
    }
    
    .status-indicator.yellow {
        background: #ffb900;
    }
    
    @media (max-width: 768px) {
        .generic-widget-row {
            grid-template-columns: 1fr;
        }
        
        .generic-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
    </style>
    <?php
}

// Página de configurações
function generic_admin_settings() {
    if (isset($_POST['submit'])) {
        // Salvar configurações
        $settings = array(
            'store_name'    => sanitize_text_field($_POST['store_name']),
            'store_email'   => sanitize_email($_POST['store_email']),
            'store_phone'   => sanitize_text_field($_POST['store_phone']),
            'store_address' => sanitize_textarea_field($_POST['store_address']),
            'store_logo'    => sanitize_text_field($_POST['store_logo']),
            'primary_color' => sanitize_hex_color($_POST['primary_color']),
            'secondary_color' => sanitize_hex_color($_POST['secondary_color']),
            'accent_color'  => sanitize_hex_color($_POST['accent_color']),
            'text_color'    => sanitize_hex_color($_POST['text_color']),
            'font_family'   => sanitize_text_field($_POST['font_family']),
            'social_facebook' => esc_url($_POST['social_facebook']),
            'social_instagram' => esc_url($_POST['social_instagram']),
            'social_twitter' => esc_url($_POST['social_twitter']),
            'social_youtube' => esc_url($_POST['social_youtube']),
        );
        
        update_option('generic_ecommerce_options', $settings);
        echo '<div class="notice notice-success"><p>' . __('Configurações salvas com sucesso!', 'generic-ecommerce') . '</p></div>';
    }
    
    $options = get_option('generic_ecommerce_options', array());
    ?>
    <div class="wrap">
        <h1><?php _e('Configurações - Generic E-commerce', 'generic-ecommerce'); ?></h1>
        
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="store_name"><?php _e('Nome da Loja', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="store_name" name="store_name" value="<?php echo esc_attr($options['store_name'] ?? 'Generic E-commerce'); ?>" class="regular-text" />
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="store_email"><?php _e('Email', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="email" id="store_email" name="store_email" value="<?php echo esc_attr($options['store_email'] ?? 'contato@generic-ecommerce.com'); ?>" class="regular-text" />
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="store_phone"><?php _e('Telefone', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="store_phone" name="store_phone" value="<?php echo esc_attr($options['store_phone'] ?? '(11) 99999-9999'); ?>" class="regular-text" />
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="store_address"><?php _e('Endereço', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <textarea id="store_address" name="store_address" rows="3" cols="50"><?php echo esc_textarea($options['store_address'] ?? ''); ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="store_logo"><?php _e('Logo da Loja', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="hidden" id="store_logo" name="store_logo" value="<?php echo esc_attr($options['store_logo'] ?? ''); ?>" />
                        <button type="button" class="button" id="upload_logo_button"><?php _e('Selecionar Logo', 'generic-ecommerce'); ?></button>
                        <div id="logo_preview"></div>
                    </td>
                </tr>
            </table>
            
            <h2><?php _e('Cores do Tema', 'generic-ecommerce'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="primary_color"><?php _e('Cor Primária', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="color" id="primary_color" name="primary_color" value="<?php echo esc_attr($options['primary_color'] ?? '#000000'); ?>" />
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="secondary_color"><?php _e('Cor Secundária', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="color" id="secondary_color" name="secondary_color" value="<?php echo esc_attr($options['secondary_color'] ?? '#8b7355'); ?>" />
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="accent_color"><?php _e('Cor de Destaque', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="color" id="accent_color" name="accent_color" value="<?php echo esc_attr($options['accent_color'] ?? '#f5f5f5'); ?>" />
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="text_color"><?php _e('Cor do Texto', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="color" id="text_color" name="text_color" value="<?php echo esc_attr($options['text_color'] ?? '#000000'); ?>" />
                    </td>
                </tr>
            </table>
            
            <h2><?php _e('Redes Sociais', 'generic-ecommerce'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="social_facebook"><?php _e('Facebook', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="url" id="social_facebook" name="social_facebook" value="<?php echo esc_attr($options['social_facebook'] ?? ''); ?>" class="regular-text" />
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="social_instagram"><?php _e('Instagram', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="url" id="social_instagram" name="social_instagram" value="<?php echo esc_attr($options['social_instagram'] ?? ''); ?>" class="regular-text" />
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="social_twitter"><?php _e('Twitter', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="url" id="social_twitter" name="social_twitter" value="<?php echo esc_attr($options['social_twitter'] ?? ''); ?>" class="regular-text" />
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="social_youtube"><?php _e('YouTube', 'generic-ecommerce'); ?></label>
                    </th>
                    <td>
                        <input type="url" id="social_youtube" name="social_youtube" value="<?php echo esc_attr($options['social_youtube'] ?? ''); ?>" class="regular-text" />
                    </td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Upload de logo
        $('#upload_logo_button').click(function(e) {
            e.preventDefault();
            
            var frame = wp.media({
                title: 'Selecionar Logo',
                multiple: false,
                library: { type: 'image' }
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#store_logo').val(attachment.id);
                $('#logo_preview').html('<img src="' + attachment.url + '" style="max-width: 200px; margin-top: 10px;" />');
            });
            
            frame.open();
        });
        
        // Carregar preview do logo existente
        var logoId = $('#store_logo').val();
        if (logoId) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_attachment_url',
                    attachment_id: logoId
                },
                success: function(response) {
                    if (response.success) {
                        $('#logo_preview').html('<img src="' + response.data + '" style="max-width: 200px; margin-top: 10px;" />');
                    }
                }
            });
        }
    });
    </script>
    <?php
}

// Página de estatísticas
function generic_admin_stats() {
    ?>
    <div class="wrap">
        <h1><?php _e('Estatísticas - Generic E-commerce', 'generic-ecommerce'); ?></h1>
        
        <div class="generic-stats-container">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3><?php _e('Produtos', 'generic-ecommerce'); ?></h3>
                    <div class="stat-number"><?php echo wp_count_posts('generic_product')->publish; ?></div>
                    <div class="stat-description"><?php _e('Total de produtos cadastrados', 'generic-ecommerce'); ?></div>
                </div>
                
                <div class="stat-card">
                    <h3><?php _e('Coleções', 'generic-ecommerce'); ?></h3>
                    <div class="stat-number"><?php echo wp_count_posts('generic_collection')->publish; ?></div>
                    <div class="stat-description"><?php _e('Total de coleções criadas', 'generic-ecommerce'); ?></div>
                </div>
                
                <div class="stat-card">
                    <h3><?php _e('Categorias', 'generic-ecommerce'); ?></h3>
                    <div class="stat-number"><?php echo wp_count_terms('generic_category'); ?></div>
                    <div class="stat-description"><?php _e('Total de categorias de produtos', 'generic-ecommerce'); ?></div>
                </div>
                
                <div class="stat-card">
                    <h3><?php _e('Sliders', 'generic-ecommerce'); ?></h3>
                    <div class="stat-number"><?php echo wp_count_posts('generic_slider')->publish; ?></div>
                    <div class="stat-description"><?php _e('Total de sliders ativos', 'generic-ecommerce'); ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .generic-stats-container {
        margin-top: 20px;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .stat-card {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    
    .stat-card h3 {
        margin: 0 0 10px 0;
        color: #333;
    }
    
    .stat-number {
        font-size: 36px;
        font-weight: bold;
        color: #0073aa;
        margin: 10px 0;
    }
    
    .stat-description {
        color: #666;
        font-size: 14px;
    }
    </style>
    <?php
}

// Página de upload de mídia
function generic_admin_media() {
    ?>
    <div class="wrap">
        <h1><?php _e('Upload de Imagens - Generic E-commerce', 'generic-ecommerce'); ?></h1>
        
        <div class="generic-media-uploader">
            <div class="upload-area" id="upload-area">
                <div class="upload-content">
                    <span class="dashicons dashicons-cloud-upload"></span>
                    <h3><?php _e('Arraste e solte suas imagens aqui', 'generic-ecommerce'); ?></h3>
                    <p><?php _e('ou clique para selecionar arquivos', 'generic-ecommerce'); ?></p>
                    <button type="button" class="button button-primary" id="select-images"><?php _e('Selecionar Imagens', 'generic-ecommerce'); ?></button>
                </div>
            </div>
            
            <div class="upload-progress" id="upload-progress" style="display: none;">
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>
                <div class="progress-text" id="progress-text">0%</div>
            </div>
            
            <div class="uploaded-images" id="uploaded-images"></div>
        </div>
    </div>
    
    <style>
    .generic-media-uploader {
        max-width: 800px;
        margin: 20px 0;
    }
    
    .upload-area {
        border: 2px dashed #ccd0d4;
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .upload-area:hover {
        border-color: #0073aa;
        background: #f0f6fc;
    }
    
    .upload-area.dragover {
        border-color: #0073aa;
        background: #e6f3ff;
    }
    
    .upload-content .dashicons {
        font-size: 48px;
        color: #ccd0d4;
        margin-bottom: 20px;
    }
    
    .upload-content h3 {
        margin: 0 0 10px 0;
        color: #333;
    }
    
    .upload-content p {
        margin: 0 0 20px 0;
        color: #666;
    }
    
    .upload-progress {
        margin: 20px 0;
    }
    
    .progress-bar {
        width: 100%;
        height: 20px;
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: #0073aa;
        width: 0%;
        transition: width 0.3s ease;
    }
    
    .progress-text {
        text-align: center;
        margin-top: 10px;
        font-weight: bold;
    }
    
    .uploaded-images {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    
    .uploaded-image {
        position: relative;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .uploaded-image img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    
    .uploaded-image .image-actions {
        position: absolute;
        top: 5px;
        right: 5px;
        display: flex;
        gap: 5px;
    }
    
    .uploaded-image .image-actions button {
        background: rgba(0,0,0,0.7);
        color: white;
        border: none;
        border-radius: 3px;
        padding: 5px;
        cursor: pointer;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var uploadArea = $('#upload-area');
        var selectButton = $('#select-images');
        var progressDiv = $('#upload-progress');
        var progressFill = $('#progress-fill');
        var progressText = $('#progress-text');
        var uploadedImages = $('#uploaded-images');
        
        // Drag and drop
        uploadArea.on('dragover', function(e) {
            e.preventDefault();
            uploadArea.addClass('dragover');
        });
        
        uploadArea.on('dragleave', function(e) {
            e.preventDefault();
            uploadArea.removeClass('dragover');
        });
        
        uploadArea.on('drop', function(e) {
            e.preventDefault();
            uploadArea.removeClass('dragover');
            var files = e.originalEvent.dataTransfer.files;
            uploadFiles(files);
        });
        
        // Click to select
        uploadArea.on('click', function() {
            selectButton.click();
        });
        
        selectButton.on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Selecionar Imagens',
                multiple: true,
                library: { type: 'image' }
            });
            
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var files = [];
                selection.map(function(attachment) {
                    files.push(attachment.attributes);
                });
                uploadFiles(files);
            });
            
            frame.open();
        });
        
        function uploadFiles(files) {
            if (files.length === 0) return;
            
            progressDiv.show();
            var uploaded = 0;
            var total = files.length;
            
            files.forEach(function(file, index) {
                var formData = new FormData();
                formData.append('action', 'generic_upload_image');
                formData.append('file', file);
                formData.append('nonce', '<?php echo wp_create_nonce('generic_upload_nonce'); ?>');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            uploaded++;
                            addImageToGrid(response.data);
                        }
                        
                        var progress = (uploaded / total) * 100;
                        progressFill.css('width', progress + '%');
                        progressText.text(Math.round(progress) + '%');
                        
                        if (uploaded === total) {
                            setTimeout(function() {
                                progressDiv.hide();
                            }, 1000);
                        }
                    },
                    error: function() {
                        uploaded++;
                        var progress = (uploaded / total) * 100;
                        progressFill.css('width', progress + '%');
                        progressText.text(Math.round(progress) + '%');
                    }
                });
            });
        }
        
        function addImageToGrid(imageData) {
            var imageHtml = '<div class="uploaded-image">';
            imageHtml += '<img src="' + imageData.url + '" alt="' + imageData.title + '" />';
            imageHtml += '<div class="image-actions">';
            imageHtml += '<button onclick="copyImageUrl(\'' + imageData.url + '\')" title="Copiar URL">📋</button>';
            imageHtml += '<button onclick="deleteImage(' + imageData.id + ')" title="Excluir">🗑️</button>';
            imageHtml += '</div>';
            imageHtml += '</div>';
            
            uploadedImages.append(imageHtml);
        }
    });
    
    function copyImageUrl(url) {
        navigator.clipboard.writeText(url).then(function() {
            alert('URL copiada para a área de transferência!');
        });
    }
    
    function deleteImage(imageId) {
        if (confirm('Tem certeza que deseja excluir esta imagem?')) {
            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'generic_delete_image',
                    image_id: imageId,
                    nonce: '<?php echo wp_create_nonce('generic_upload_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    }
    </script>
    <?php
}

// AJAX para upload de imagens
function generic_upload_image() {
    check_ajax_referer('generic_upload_nonce', 'nonce');
    
    if (!current_user_can('upload_files')) {
        wp_send_json_error('Permissão negada');
    }
    
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }
    
    $uploadedfile = $_FILES['file'];
    $upload_overrides = array('test_form' => false);
    
    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
    
    if ($movefile && !isset($movefile['error'])) {
        $attachment = array(
            'post_mime_type' => $movefile['type'],
            'post_title'     => sanitize_file_name($uploadedfile['name']),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        
        $attach_id = wp_insert_attachment($attachment, $movefile['file']);
        
        if (!is_wp_error($attach_id)) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $movefile['file']);
            wp_update_attachment_metadata($attach_id, $attach_data);
            
            wp_send_json_success(array(
                'id' => $attach_id,
                'url' => $movefile['url'],
                'title' => $attachment['post_title']
            ));
        }
    }
    
    wp_send_json_error('Erro no upload');
}
add_action('wp_ajax_generic_upload_image', 'generic_upload_image');

// AJAX para excluir imagem
function generic_delete_image() {
    check_ajax_referer('generic_upload_nonce', 'nonce');
    
    if (!current_user_can('delete_posts')) {
        wp_send_json_error('Permissão negada');
    }
    
    $image_id = intval($_POST['image_id']);
    
    if (wp_delete_attachment($image_id, true)) {
        wp_send_json_success('Imagem excluída com sucesso');
    } else {
        wp_send_json_error('Erro ao excluir imagem');
    }
}
add_action('wp_ajax_generic_delete_image', 'generic_delete_image');
