/**
 * JavaScript principal do Generic E-commerce
 */

(function($) {
    'use strict';
    
    // Inicializar quando o DOM estiver pronto
    $(document).ready(function() {
        initNavbar();
        initMobileMenu();
        initSearch();
        initCart();
        initProductGrid();
        initLazyLoading();
        initSmoothScroll();
    });
    
    // Navbar scroll effect
    function initNavbar() {
        const navbar = $('#navbar');
        if (!navbar.length) return;
        
        $(window).scroll(function() {
            if ($(window).scrollTop() > 50) {
                navbar.addClass('scrolled');
            } else {
                navbar.removeClass('scrolled');
            }
        });
    }
    
    // Menu mobile
    function initMobileMenu() {
        const mobileToggle = $('#mobileMenuToggle');
        const mobileMenu = $('#mobileMenu');
        
        if (!mobileToggle.length || !mobileMenu.length) return;
        
        mobileToggle.on('click', function() {
            $(this).toggleClass('active');
            mobileMenu.toggleClass('active');
            $('body').toggleClass('menu-open');
        });
        
        // Fechar menu ao clicar em um link
        mobileMenu.find('a').on('click', function() {
            mobileToggle.removeClass('active');
            mobileMenu.removeClass('active');
            $('body').removeClass('menu-open');
        });
        
        // Fechar menu ao clicar fora
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.navbar').length) {
                mobileToggle.removeClass('active');
                mobileMenu.removeClass('active');
                $('body').removeClass('menu-open');
            }
        });
    }
    
    // Busca
    function initSearch() {
        const searchForm = $('.search-container form');
        if (!searchForm.length) return;
        
        searchForm.on('submit', function(e) {
            const searchTerm = $(this).find('input[name="s"]').val().trim();
            if (!searchTerm) {
                e.preventDefault();
                return false;
            }
        });
        
        // Busca em tempo real (opcional)
        const searchInput = searchForm.find('input[name="s"]');
        let searchTimeout;
        
        searchInput.on('input', function() {
            clearTimeout(searchTimeout);
            const term = $(this).val().trim();
            
            if (term.length >= 3) {
                searchTimeout = setTimeout(function() {
                    performLiveSearch(term);
                }, 300);
            }
        });
    }
    
    // Busca em tempo real
    function performLiveSearch(term) {
        $.ajax({
            url: generic_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'generic_live_search',
                search_term: term,
                nonce: generic_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    displaySearchResults(response.data);
                }
            }
        });
    }
    
    // Exibir resultados da busca
    function displaySearchResults(results) {
        // Implementar exibição dos resultados
        console.log('Resultados da busca:', results);
    }
    
    // Carrinho
    function initCart() {
        const cartLink = $('.cart-link');
        if (!cartLink.length) return;
        
        // Atualizar contador do carrinho
        $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
            updateCartCount();
        });
        
        $(document.body).on('removed_from_cart', function(event, fragments, cart_hash, $button) {
            updateCartCount();
        });
    }
    
    // Atualizar contador do carrinho
    function updateCartCount() {
        $.ajax({
            url: generic_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'generic_get_cart_count',
                nonce: generic_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('.cart-count').text(response.data.count);
                }
            }
        });
    }
    
    // Grid de produtos
    function initProductGrid() {
        const productsGrid = $('.products-grid');
        if (!productsGrid.length) return;
        
        // Filtros de produtos
        const filterButtons = $('.product-filters button');
        filterButtons.on('click', function() {
            const filter = $(this).data('filter');
            filterProducts(filter);
        });
        
        // Ordenação de produtos
        const sortSelect = $('.product-sort select');
        sortSelect.on('change', function() {
            const sortBy = $(this).val();
            sortProducts(sortBy);
        });
        
        // Carregar mais produtos
        const loadMoreBtn = $('.load-more-products');
        loadMoreBtn.on('click', function() {
            loadMoreProducts();
        });
    }
    
    // Filtrar produtos
    function filterProducts(filter) {
        $.ajax({
            url: generic_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'generic_filter_products',
                filter: filter,
                nonce: generic_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('.products-grid').html(response.data.html);
                }
            }
        });
    }
    
    // Ordenar produtos
    function sortProducts(sortBy) {
        $.ajax({
            url: generic_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'generic_sort_products',
                sort_by: sortBy,
                nonce: generic_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('.products-grid').html(response.data.html);
                }
            }
        });
    }
    
    // Carregar mais produtos
    function loadMoreProducts() {
        const page = parseInt($('.load-more-products').data('page')) || 1;
        const nextPage = page + 1;
        
        $.ajax({
            url: generic_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'generic_load_more_products',
                page: nextPage,
                nonce: generic_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('.products-grid').append(response.data.html);
                    $('.load-more-products').data('page', nextPage);
                    
                    if (!response.data.has_more) {
                        $('.load-more-products').hide();
                    }
                }
            }
        });
    }
    
    // Lazy loading de imagens
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }
    
    // Smooth scroll
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            
            const target = $(this.getAttribute('href'));
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800);
            }
        });
    }
    
    // Utilitários
    window.GenericEcommerce = {
        // Função para exibir notificações
        showNotification: function(message, type = 'info') {
            const notification = $(`
                <div class="notification notification-${type}">
                    <span class="notification-message">${message}</span>
                    <button class="notification-close">&times;</button>
                </div>
            `);
            
            $('body').append(notification);
            
            setTimeout(() => {
                notification.addClass('show');
            }, 100);
            
            notification.find('.notification-close').on('click', function() {
                notification.removeClass('show');
                setTimeout(() => notification.remove(), 300);
            });
            
            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        },
        
        // Função para formatar preços
        formatPrice: function(price) {
            return 'R$ ' + parseFloat(price).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },
        
        // Função para debounce
        debounce: function(func, wait, immediate) {
            let timeout;
            return function() {
                const context = this;
                const args = arguments;
                const later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }
    };
    
})(jQuery);

// Estilos para notificações
const notificationStyles = `
<style>
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #333;
    color: #fff;
    padding: 15px 20px;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 9999;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    max-width: 300px;
}

.notification.show {
    transform: translateX(0);
}

.notification-info {
    background: #0073aa;
}

.notification-success {
    background: #46b450;
}

.notification-warning {
    background: #ffb900;
    color: #333;
}

.notification-error {
    background: #dc3232;
}

.notification-message {
    display: block;
    margin-right: 20px;
}

.notification-close {
    position: absolute;
    top: 5px;
    right: 10px;
    background: none;
    border: none;
    color: inherit;
    font-size: 18px;
    cursor: pointer;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .notification {
        right: 10px;
        left: 10px;
        max-width: none;
    }
}
</style>
`;

document.head.insertAdjacentHTML('beforeend', notificationStyles);
