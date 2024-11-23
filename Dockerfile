# Use the official PHP image with Apache
FROM php:8.2-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Install necessary packages and PHP extensions
RUN apt-get update && apt-get install -y \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libonig-dev \
  libzip-dev \
  zip \
  unzip \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd\
  && pecl install mongodb \
  && docker-php-ext-enable mongodb

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy your application files from the host to the container
COPY . /var/www/html

COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Ensure that the Apache user (www-data) owns the files
RUN chown -R www-data:www-data /var/www/html

# Set the right permissions for your project
RUN chmod -R 755 /var/www/html

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Symfony dependencies via Composer
RUN composer install --no-dev --optimize-autoloader

# Clear Symfony cache for production
RUN php bin/console cache:clear --env=prod --no-debug

# Set permissions for the Symfony var/cache and var/logs directories
RUN chown -R www-data:www-data /var/www/html/var/cache /var/www/html/var/log
RUN chmod -R 775 /var/www/html/var/cache /var/www/html/var/log

# Increase PHP max execution time
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/99-custom.ini

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]