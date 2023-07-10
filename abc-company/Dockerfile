# Base image
FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    default-mysql-client \
    libpq-dev \
    zlib1g-dev \
    libicu-dev \
    unzip \
    zip \
    wget \
    gnupg2

# Download and add the phpMyAdmin GPG key
RUN wget -O /etc/apt/trusted.gpg.d/phpmyadmin.gpg https://packages.sury.org/php/apt.gpg

# Add the phpMyAdmin repository
RUN echo "deb https://packages.sury.org/php/ buster main" > /etc/apt/sources.list.d/phpmyadmin.list

# Update packages
RUN apt-get update

# Install PHP extensions
RUN apt-get install -y --no-install-recommends \
    libxml2-dev \
    libonig-dev && \
    docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    intl \
    mbstring \
    xml

# Download and install phpMyAdmin
RUN wget https://files.phpmyadmin.net/phpMyAdmin/5.1.1/phpMyAdmin-5.1.1-all-languages.zip -O phpmyadmin.zip && \
    unzip phpmyadmin.zip && \
    mv phpMyAdmin-5.1.1-all-languages /usr/share/phpmyadmin && \
    rm phpmyadmin.zip && \
    cp /usr/share/phpmyadmin/config.sample.inc.php /usr/share/phpmyadmin/config.inc.php && \
    sed -i "s/\$cfg\['Servers'\]\[\$i\]\['AllowNoPassword'\] = false;/\$cfg\['Servers'\]\[\$i\]\['AllowNoPassword'\] = true;/g" /usr/share/phpmyadmin/config.inc.php

# Configure Nginx
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Copy project files
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install project dependencies
RUN composer install --no-interaction

# Set permissions
RUN chown -R www-data:www-data var

# Expose port
EXPOSE 80

# Start Nginx and PHP-FPM
CMD service nginx start && php-fpm