<?php
/**
 * Template principal do Generic E-commerce
 */

get_header(); ?>

<div class="generic-container">
    <div class="generic-content">
        
        <?php if (is_home() || is_front_page()) : ?>
            <!-- Homepage -->
            <?php get_template_part('templates/homepage'); ?>
        <?php elseif (is_shop() || is_product_category() || is_product_tag()) : ?>
            <!-- Loja -->
            <?php get_template_part('templates/shop'); ?>
        <?php elseif (is_product()) : ?>
            <!-- Produto Individual -->
            <?php get_template_part('templates/single-product'); ?>
        <?php elseif (is_page()) : ?>
            <!-- Página -->
            <div class="page-content">
                <div class="page-header">
                    <h1><?php the_title(); ?></h1>
                </div>
                <div class="page-body">
                    <?php
                    while (have_posts()) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            </div>
        <?php elseif (is_single()) : ?>
            <!-- Post Individual -->
            <div class="single-content">
                <div class="single-header">
                    <h1><?php the_title(); ?></h1>
                    <div class="single-meta">
                        <span class="post-date"><?php echo get_the_date(); ?></span>
                        <span class="post-author"><?php _e('Por', 'generic-ecommerce'); ?> <?php the_author(); ?></span>
                    </div>
                </div>
                <div class="single-body">
                    <?php
                    while (have_posts()) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            </div>
        <?php else : ?>
            <!-- Arquivo -->
            <div class="archive-content">
                <div class="archive-header">
                    <h1><?php the_archive_title(); ?></h1>
                    <?php if (get_the_archive_description()) : ?>
                        <div class="archive-description">
                            <?php the_archive_description(); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="archive-body">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) :
                            the_post();
                            get_template_part('templates/content', get_post_type());
                        endwhile;
                        
                        // Paginação
                        the_posts_pagination(array(
                            'prev_text' => __('Anterior', 'generic-ecommerce'),
                            'next_text' => __('Próximo', 'generic-ecommerce'),
                        ));
                    else :
                        echo '<p>' . __('Nenhum conteúdo encontrado.', 'generic-ecommerce') . '</p>';
                    endif;
                    ?>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
</div>

<?php get_footer(); ?>
