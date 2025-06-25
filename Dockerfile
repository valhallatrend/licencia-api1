
FROM php:8.1-apache

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar archivos al contenedor
COPY public/ /var/www/html/

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
