FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy application files
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html

# Set permissions for .htaccess
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Ensure /tmp is writable
RUN chmod -R 777 /tmp

# Expose port 80
EXPOSE 80
