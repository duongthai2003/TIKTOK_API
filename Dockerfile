# Bắt đầu từ PHP 7.4 FPM (hoặc phiên bản khác nếu cần)
FROM php:8.2-fpm


# Cài đặt các extension cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    zip unzip git libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Đặt thư mục làm việc
WORKDIR /var/www

# Sao chép mã nguồn Laravel
COPY . /var/www

# Cài đặt các dependency của Laravel qua Composer
RUN composer install

# Phân quyền cho thư mục storage và bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache
