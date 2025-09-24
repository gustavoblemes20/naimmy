/**
 * JavaScript personalizado para o tema Miu Miu
 */

jQuery(document).ready(function($) {
    // Smooth scroll para links internos
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 1000);
        }
    });
    
    // Adicionar classe ao header quando scroll
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
    });
    
    // Animação de hover nos produtos
    $('.woocommerce ul.products li.product').hover(
        function() {
            $(this).addClass('hovered');
        },
        function() {
            $(this).removeClass('hovered');
        }
    );
    
    // Lazy loading para imagens
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
    
    // Adicionar loading ao carrinho
    $('.add_to_cart_button').on('click', function() {
        $(this).addClass('loading');
        $(this).text('Adicionando...');
    });
    
    // Remover loading quando carregar
    $(document).on('added_to_cart', function() {
        $('.add_to_cart_button').removeClass('loading');
        $('.add_to_cart_button').text('Adicionar ao carrinho');
    });
    
    // Mobile menu toggle
    $('.menu-toggle').on('click', function() {
        $('.main-navigation').toggleClass('mobile-open');
        $(this).toggleClass('active');
    });
    
    // Fechar menu mobile ao clicar em link
    $('.main-navigation a').on('click', function() {
        $('.main-navigation').removeClass('mobile-open');
        $('.menu-toggle').removeClass('active');
    });
    
    // Adicionar classe ao body quando menu mobile está aberto
    $('.menu-toggle').on('click', function() {
        $('body').toggleClass('menu-open');
    });
    
    // Fechar menu mobile ao clicar fora
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.main-navigation, .menu-toggle').length) {
            $('.main-navigation').removeClass('mobile-open');
            $('.menu-toggle').removeClass('active');
            $('body').removeClass('menu-open');
        }
    });
    
    // Adicionar efeito de fade in aos elementos
    function fadeInOnScroll() {
        $('.fade-in').each(function() {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('visible');
            }
        });
    }
    
    $(window).on('scroll', fadeInOnScroll);
    fadeInOnScroll();
    
    // Adicionar classe aos produtos para animação
    $('.woocommerce ul.products li.product').addClass('fade-in');
    
    // Configurar formulários
    $('form').on('submit', function() {
        $(this).addClass('submitting');
    });
    
    // Adicionar validação básica
    $('input[required]').on('blur', function() {
        if ($(this).val() === '') {
            $(this).addClass('error');
        } else {
            $(this).removeClass('error');
        }
    });
    
    // Adicionar classe de erro ao CSS
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .error {
                border-color: #d32f2f !important;
                box-shadow: 0 0 0 2px rgba(211, 47, 47, 0.2) !important;
            }
            .loading {
                opacity: 0.7;
                pointer-events: none;
            }
            .fade-in {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            .fade-in.visible {
                opacity: 1;
                transform: translateY(0);
            }
            .scrolled {
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            @media (max-width: 768px) {
                .main-navigation {
                    position: fixed;
                    top: 0;
                    left: -100%;
                    width: 80%;
                    height: 100vh;
                    background: #fff;
                    z-index: 9999;
                    transition: left 0.3s ease;
                    padding-top: 80px;
                }
                .main-navigation.mobile-open {
                    left: 0;
                }
                .main-navigation ul {
                    flex-direction: column;
                    padding: 20px;
                }
                .main-navigation li {
                    margin: 10px 0;
                }
                .menu-toggle {
                    display: block;
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 10000;
                    background: #000;
                    color: #fff;
                    border: none;
                    padding: 10px 15px;
                    cursor: pointer;
                }
                .menu-toggle.active {
                    background: #8b7355;
                }
                body.menu-open {
                    overflow: hidden;
                }
            }
        `)
        .appendTo('head');
});
