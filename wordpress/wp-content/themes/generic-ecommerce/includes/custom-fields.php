<?php
/**
 * Custom Fields para Generic E-commerce
 */

// Evitar acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// Adicionar meta boxes
function generic_add_meta_boxes() {
    // Meta box para produtos
    add_meta_box(
        'generic_product_details',
        __('Detalhes do Produto', 'generic-ecommerce'),
        'generic_product_meta_box_callback',
        'generic_product',
        'normal',
        'high'
    );
    
    // Meta box para coleções
    add_meta_box(
        'generic_collection_details',
        __('Detalhes da Coleção', 'generic-ecommerce'),
        'generic_collection_meta_box_callback',
        'generic_collection',
        'normal',
        'high'
    );
    
    // Meta box para sliders
    add_meta_box(
        'generic_slider_details',
        __('Detalhes do Slider', 'generic-ecommerce'),
        'generic_slider_meta_box_callback',
        'generic_slider',
        'normal',
        'high'
    );
    
    // Meta box para banners
    add_meta_box(
        'generic_banner_details',
        __('Detalhes do Banner', 'generic-ecommerce'),
        'generic_banner_meta_box_callback',
        'generic_banner',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'generic_add_meta_boxes');

// Meta box para produtos
function generic_product_meta_box_callback($post) {
    wp_nonce_field('generic_product_meta_box', 'generic_product_meta_box_nonce');
    
    $price = get_post_meta($post->ID, 'product_price', true);
    $sale_price = get_post_meta($post->ID, 'product_sale_price', true);
    $sku = get_post_meta($post->ID, 'product_sku', true);
    $stock = get_post_meta($post->ID, 'product_stock', true);
    $featured = get_post_meta($post->ID, 'featured_product', true);
    $gallery = get_post_meta($post->ID, 'product_gallery', true);
    $sizes = get_post_meta($post->ID, 'product_sizes', true);
    $colors = get_post_meta($post->ID, 'product_colors', true);
    $weight = get_post_meta($post->ID, 'product_weight', true);
    $dimensions = get_post_meta($post->ID, 'product_dimensions', true);
    $shipping = get_post_meta($post->ID, 'product_shipping', true);
    $warranty = get_post_meta($post->ID, 'product_warranty', true);
    $video_url = get_post_meta($post->ID, 'product_video_url', true);
    $related_products = get_post_meta($post->ID, 'related_products', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="product_price"><?php _e('Preço', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="number" id="product_price" name="product_price" value="<?php echo esc_attr($price); ?>" step="0.01" min="0" />
                <p class="description"><?php _e('Preço do produto em reais', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_sale_price"><?php _e('Preço de Promoção', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="number" id="product_sale_price" name="product_sale_price" value="<?php echo esc_attr($sale_price); ?>" step="0.01" min="0" />
                <p class="description"><?php _e('Preço promocional (opcional)', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_sku"><?php _e('SKU', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="text" id="product_sku" name="product_sku" value="<?php echo esc_attr($sku); ?>" />
                <p class="description"><?php _e('Código único do produto', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_stock"><?php _e('Estoque', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="number" id="product_stock" name="product_stock" value="<?php echo esc_attr($stock); ?>" min="0" />
                <p class="description"><?php _e('Quantidade em estoque', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="featured_product"><?php _e('Produto em Destaque', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="checkbox" id="featured_product" name="featured_product" value="1" <?php checked($featured, '1'); ?> />
                <label for="featured_product"><?php _e('Exibir na homepage', 'generic-ecommerce'); ?></label>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_gallery"><?php _e('Galeria de Imagens', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="hidden" id="product_gallery" name="product_gallery" value="<?php echo esc_attr($gallery); ?>" />
                <button type="button" class="button" id="upload_gallery_button"><?php _e('Selecionar Imagens', 'generic-ecommerce'); ?></button>
                <div id="gallery_preview"></div>
                <p class="description"><?php _e('Selecione múltiplas imagens para a galeria', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_sizes"><?php _e('Tamanhos Disponíveis', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="text" id="product_sizes" name="product_sizes" value="<?php echo esc_attr($sizes); ?>" />
                <p class="description"><?php _e('Separados por vírgula (ex: P, M, G, GG)', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_colors"><?php _e('Cores Disponíveis', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="text" id="product_colors" name="product_colors" value="<?php echo esc_attr($colors); ?>" />
                <p class="description"><?php _e('Separadas por vírgula (ex: Preto, Branco, Azul)', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_weight"><?php _e('Peso (kg)', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="number" id="product_weight" name="product_weight" value="<?php echo esc_attr($weight); ?>" step="0.01" min="0" />
                <p class="description"><?php _e('Peso do produto para cálculo de frete', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_dimensions"><?php _e('Dimensões (cm)', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="text" id="product_dimensions" name="product_dimensions" value="<?php echo esc_attr($dimensions); ?>" placeholder="L x A x P" />
                <p class="description"><?php _e('Formato: Largura x Altura x Profundidade', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_shipping"><?php _e('Informações de Frete', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <textarea id="product_shipping" name="product_shipping" rows="3" cols="50"><?php echo esc_textarea($shipping); ?></textarea>
                <p class="description"><?php _e('Informações sobre frete e entrega', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_warranty"><?php _e('Garantia', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="text" id="product_warranty" name="product_warranty" value="<?php echo esc_attr($warranty); ?>" />
                <p class="description"><?php _e('Período de garantia do produto', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_video_url"><?php _e('URL do Vídeo', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="url" id="product_video_url" name="product_video_url" value="<?php echo esc_attr($video_url); ?>" />
                <p class="description"><?php _e('Link para vídeo do produto (YouTube, Vimeo, etc.)', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="related_products"><?php _e('Produtos Relacionados', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="text" id="related_products" name="related_products" value="<?php echo esc_attr($related_products); ?>" />
                <p class="description"><?php _e('IDs dos produtos relacionados separados por vírgula', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
    </table>
    
    <script>
    jQuery(document).ready(function($) {
        // Upload de galeria
        $('#upload_gallery_button').click(function(e) {
            e.preventDefault();
            
            var frame = wp.media({
                title: 'Selecionar Imagens da Galeria',
                multiple: true,
                library: { type: 'image' }
            });
            
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var ids = [];
                var preview = $('#gallery_preview');
                preview.empty();
                
                selection.map(function(attachment) {
                    ids.push(attachment.id);
                    preview.append('<img src="' + attachment.attributes.url + '" style="max-width: 100px; margin: 5px;" />');
                });
                
                $('#product_gallery').val(ids.join(','));
            });
            
            frame.open();
        });
        
        // Carregar preview da galeria existente
        var galleryIds = $('#product_gallery').val();
        if (galleryIds) {
            var ids = galleryIds.split(',');
            var preview = $('#gallery_preview');
            preview.empty();
            
            ids.forEach(function(id) {
                if (id.trim()) {
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'get_attachment_url',
                            attachment_id: id.trim()
                        },
                        success: function(response) {
                            if (response.success) {
                                preview.append('<img src="' + response.data + '" style="max-width: 100px; margin: 5px;" />');
                            }
                        }
                    });
                }
            });
        }
    });
    </script>
    <?php
}

// Meta box para coleções
function generic_collection_meta_box_callback($post) {
    wp_nonce_field('generic_collection_meta_box', 'generic_collection_meta_box_nonce');
    
    $collection_type = get_post_meta($post->ID, 'collection_type', true);
    $collection_season = get_post_meta($post->ID, 'collection_season', true);
    $collection_year = get_post_meta($post->ID, 'collection_year', true);
    $collection_products = get_post_meta($post->ID, 'collection_products', true);
    $collection_banner = get_post_meta($post->ID, 'collection_banner', true);
    $collection_featured = get_post_meta($post->ID, 'collection_featured', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="collection_type"><?php _e('Tipo de Coleção', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <select id="collection_type" name="collection_type">
                    <option value=""><?php _e('Selecione...', 'generic-ecommerce'); ?></option>
                    <option value="seasonal" <?php selected($collection_type, 'seasonal'); ?>><?php _e('Sazonal', 'generic-ecommerce'); ?></option>
                    <option value="limited" <?php selected($collection_type, 'limited'); ?>><?php _e('Edição Limitada', 'generic-ecommerce'); ?></option>
                    <option value="collaboration" <?php selected($collection_type, 'collaboration'); ?>><?php _e('Colaboração', 'generic-ecommerce'); ?></option>
                    <option value="capsule" <?php selected($collection_type, 'capsule'); ?>><?php _e('Cápsula', 'generic-ecommerce'); ?></option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="collection_season"><?php _e('Temporada', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <select id="collection_season" name="collection_season">
                    <option value=""><?php _e('Selecione...', 'generic-ecommerce'); ?></option>
                    <option value="spring" <?php selected($collection_season, 'spring'); ?>><?php _e('Primavera', 'generic-ecommerce'); ?></option>
                    <option value="summer" <?php selected($collection_season, 'summer'); ?>><?php _e('Verão', 'generic-ecommerce'); ?></option>
                    <option value="autumn" <?php selected($collection_season, 'autumn'); ?>><?php _e('Outono', 'generic-ecommerce'); ?></option>
                    <option value="winter" <?php selected($collection_season, 'winter'); ?>><?php _e('Inverno', 'generic-ecommerce'); ?></option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="collection_year"><?php _e('Ano', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="number" id="collection_year" name="collection_year" value="<?php echo esc_attr($collection_year); ?>" min="2020" max="2030" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="collection_products"><?php _e('Produtos da Coleção', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="text" id="collection_products" name="collection_products" value="<?php echo esc_attr($collection_products); ?>" />
                <p class="description"><?php _e('IDs dos produtos separados por vírgula', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="collection_banner"><?php _e('Banner da Coleção', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="hidden" id="collection_banner" name="collection_banner" value="<?php echo esc_attr($collection_banner); ?>" />
                <button type="button" class="button" id="upload_banner_button"><?php _e('Selecionar Banner', 'generic-ecommerce'); ?></button>
                <div id="banner_preview"></div>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="collection_featured"><?php _e('Coleção em Destaque', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="checkbox" id="collection_featured" name="collection_featured" value="1" <?php checked($collection_featured, '1'); ?> />
                <label for="collection_featured"><?php _e('Exibir na homepage', 'generic-ecommerce'); ?></label>
            </td>
        </tr>
    </table>
    
    <script>
    jQuery(document).ready(function($) {
        // Upload de banner
        $('#upload_banner_button').click(function(e) {
            e.preventDefault();
            
            var frame = wp.media({
                title: 'Selecionar Banner',
                multiple: false,
                library: { type: 'image' }
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#collection_banner').val(attachment.id);
                $('#banner_preview').html('<img src="' + attachment.url + '" style="max-width: 300px;" />');
            });
            
            frame.open();
        });
    });
    </script>
    <?php
}

// Meta box para sliders
function generic_slider_meta_box_callback($post) {
    wp_nonce_field('generic_slider_meta_box', 'generic_slider_meta_box_nonce');
    
    $slider_order = get_post_meta($post->ID, 'slider_order', true);
    $slider_button_text = get_post_meta($post->ID, 'slider_button_text', true);
    $slider_button_url = get_post_meta($post->ID, 'slider_button_url', true);
    $slider_active = get_post_meta($post->ID, 'slider_active', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="slider_order"><?php _e('Ordem', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="number" id="slider_order" name="slider_order" value="<?php echo esc_attr($slider_order); ?>" min="1" />
                <p class="description"><?php _e('Ordem de exibição do slider', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="slider_button_text"><?php _e('Texto do Botão', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="text" id="slider_button_text" name="slider_button_text" value="<?php echo esc_attr($slider_button_text); ?>" />
                <p class="description"><?php _e('Texto do botão de ação', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="slider_button_url"><?php _e('URL do Botão', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="url" id="slider_button_url" name="slider_button_url" value="<?php echo esc_attr($slider_button_url); ?>" />
                <p class="description"><?php _e('Link para onde o botão deve levar', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="slider_active"><?php _e('Slider Ativo', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="checkbox" id="slider_active" name="slider_active" value="1" <?php checked($slider_active, '1'); ?> />
                <label for="slider_active"><?php _e('Exibir este slider', 'generic-ecommerce'); ?></label>
            </td>
        </tr>
    </table>
    <?php
}

// Meta box para banners
function generic_banner_meta_box_callback($post) {
    wp_nonce_field('generic_banner_meta_box', 'generic_banner_meta_box_nonce');
    
    $banner_position = get_post_meta($post->ID, 'banner_position', true);
    $banner_url = get_post_meta($post->ID, 'banner_url', true);
    $banner_active = get_post_meta($post->ID, 'banner_active', true);
    $banner_start_date = get_post_meta($post->ID, 'banner_start_date', true);
    $banner_end_date = get_post_meta($post->ID, 'banner_end_date', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="banner_position"><?php _e('Posição', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <select id="banner_position" name="banner_position">
                    <option value=""><?php _e('Selecione...', 'generic-ecommerce'); ?></option>
                    <option value="top" <?php selected($banner_position, 'top'); ?>><?php _e('Topo', 'generic-ecommerce'); ?></option>
                    <option value="middle" <?php selected($banner_position, 'middle'); ?>><?php _e('Meio', 'generic-ecommerce'); ?></option>
                    <option value="bottom" <?php selected($banner_position, 'bottom'); ?>><?php _e('Rodapé', 'generic-ecommerce'); ?></option>
                    <option value="sidebar" <?php selected($banner_position, 'sidebar'); ?>><?php _e('Barra Lateral', 'generic-ecommerce'); ?></option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="banner_url"><?php _e('URL do Banner', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="url" id="banner_url" name="banner_url" value="<?php echo esc_attr($banner_url); ?>" />
                <p class="description"><?php _e('Link para onde o banner deve levar', 'generic-ecommerce'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="banner_start_date"><?php _e('Data de Início', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="date" id="banner_start_date" name="banner_start_date" value="<?php echo esc_attr($banner_start_date); ?>" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="banner_end_date"><?php _e('Data de Fim', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="date" id="banner_end_date" name="banner_end_date" value="<?php echo esc_attr($banner_end_date); ?>" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="banner_active"><?php _e('Banner Ativo', 'generic-ecommerce'); ?></label>
            </th>
            <td>
                <input type="checkbox" id="banner_active" name="banner_active" value="1" <?php checked($banner_active, '1'); ?> />
                <label for="banner_active"><?php _e('Exibir este banner', 'generic-ecommerce'); ?></label>
            </td>
        </tr>
    </table>
    <?php
}

// Salvar meta boxes
function generic_save_meta_boxes($post_id) {
    // Verificar nonce e permissões
    if (!isset($_POST['generic_product_meta_box_nonce']) && 
        !isset($_POST['generic_collection_meta_box_nonce']) && 
        !isset($_POST['generic_slider_meta_box_nonce']) && 
        !isset($_POST['generic_banner_meta_box_nonce'])) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Salvar campos de produtos
    if (get_post_type($post_id) === 'generic_product') {
        $fields = array(
            'product_price', 'product_sale_price', 'product_sku', 'product_stock',
            'featured_product', 'product_gallery', 'product_sizes', 'product_colors',
            'product_weight', 'product_dimensions', 'product_shipping', 'product_warranty',
            'product_video_url', 'related_products'
        );
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Salvar campos de coleções
    if (get_post_type($post_id) === 'generic_collection') {
        $fields = array(
            'collection_type', 'collection_season', 'collection_year',
            'collection_products', 'collection_banner', 'collection_featured'
        );
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Salvar campos de sliders
    if (get_post_type($post_id) === 'generic_slider') {
        $fields = array(
            'slider_order', 'slider_button_text', 'slider_button_url', 'slider_active'
        );
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Salvar campos de banners
    if (get_post_type($post_id) === 'generic_banner') {
        $fields = array(
            'banner_position', 'banner_url', 'banner_start_date', 'banner_end_date', 'banner_active'
        );
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
add_action('save_post', 'generic_save_meta_boxes');

// AJAX para obter URL da imagem
function generic_get_attachment_url() {
    $attachment_id = intval($_POST['attachment_id']);
    $url = wp_get_attachment_url($attachment_id);
    
    if ($url) {
        wp_send_json_success($url);
    } else {
        wp_send_json_error('Imagem não encontrada');
    }
}
add_action('wp_ajax_get_attachment_url', 'generic_get_attachment_url');
