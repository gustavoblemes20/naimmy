# Dockerfile
FROM php:8.1-fpm-alpine

# Instalar dependências do sistema
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    curl-dev \
    libcurl \
    libxml2-dev \
    oniguruma-dev \
    icu-dev \
    libxml2-dev

# Instalar extensões PHP necessárias para WooCommerce
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        mysqli \
        pdo_mysql \
        zip \
        curl \
        mbstring \
        xml \
        soap \
        intl \
        bcmath \
        opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Forçar PHP-FPM a escutar em IPv4
RUN sed -i 's/listen = 127.0.0.1:9000/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf
RUN sed -i 's/listen = \[::\]:9000/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf

# Expor porta
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]