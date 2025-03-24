# Usando imagem oficial do PHP 8.3 com extensões do PostgreSQL
FROM php:8.3-fpm

# Instala extensões necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

#instala debuger
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto para dentro do container
COPY . .

# Expor a porta do PHP
EXPOSE 9000
