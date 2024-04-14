FROM php:8.1-fpm

ENV COMPOSER_ALLOW_SUPERUSER 1

# Instalação das dependências
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar código fonte
WORKDIR /var/www/html
COPY . .

# Instalar dependências do Composer
RUN composer install --no-dev --optimize-autoloader


# Expor a porta 9000 para o Nginx
EXPOSE 9000
CMD ["php-fpm"]
