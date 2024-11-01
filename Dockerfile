# Sử dụng hình ảnh PHP có sẵn với phiên bản 8.1-fpm
FROM php:8.1-fpm

# Cài đặt các tiện ích cần thiết
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Cài đặt các PHP extension cần thiết
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tạo thư mục làm việc
WORKDIR /var/www

# Copy toàn bộ mã nguồn vào container
COPY . .

# # Thiết lập quyền cho thư mục storage và bootstrap/cache
# RUN chown -R www-data:www-data /var/www \
#     && chmod -R 775 /var/www/storage \
#     && chmod -R 775 /var/www/bootstrap/cache

# Expose cổng 9000 để dùng với nginx
EXPOSE 9000

CMD ["php-fpm"]
