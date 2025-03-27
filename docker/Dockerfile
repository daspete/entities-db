FROM php:8.4-fpm

RUN apt-get update 

RUN apt-get install -y --no-install-recommends \
    libssl-dev \
    zlib1g-dev \
    curl \
    git \
    unzip \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libzip-dev \
    unzip

RUN pecl install apcu 

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

RUN docker-php-ext-install -j$(nproc) \
    zip \
    opcache \
    intl \
    mysqli \
    pdo \
    pdo_mysql \
    gd
    
RUN docker-php-ext-enable \
    apcu \
    sodium \
    pdo_mysql \
    gd

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

EXPOSE 9000
