# Imagem base PHP 8.2 + Apache
FROM php:8.2-apache

# Instala extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia os arquivos para o Apache
COPY ./src /var/www/html/

# Permissões
RUN chown -R www-data:www-data /var/www/html

# Expor porta do Apache
EXPOSE 80
