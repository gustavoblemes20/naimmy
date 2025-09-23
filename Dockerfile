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
        bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expor porta
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]
