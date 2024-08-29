FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libzip-dev \
  unzip \
  git \
  curl \
  libicu-dev \
  libxml2-dev \
  nodejs \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd pdo pdo_mysql zip intl xml \
  && pecl install mongodb \
  && docker-php-ext-enable mongodb \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && curl -sS https://get.symfony.com/cli/installer | bash \
  && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
RUN npm install

# Build assets using Webpack Encore
RUN npm run build

# Expose port 80
EXPOSE 80

# Set the Apache document root to the public directory (if using Symfony)
RUN sed -i -e 's|/var/www/html|/var/www/public|g' /etc/apache2/sites-available/000-default.conf

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Start Apache in the foreground
CMD ["apache2-foreground"]