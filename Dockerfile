FROM php:5.6-cli

RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    # Remove stretch-updates, que não existe mais
    sed -i '/stretch-updates/d' /etc/apt/sources.list && \
    # Desativa verificação de data e GPG
    echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid && \
    echo 'Acquire::AllowInsecureRepositories "true";' >> /etc/apt/apt.conf.d/99no-check-valid && \
    echo 'APT::Get::AllowUnauthenticated "true";' >> /etc/apt/apt.conf.d/99no-check-valid

RUN apt-get update --allow-unauthenticated && apt-get install -y --allow-unauthenticated \
    git \
    unzip \
    zip \
    libpq-dev \
    libmcrypt-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_pgsql pgsql mbstring tokenizer mcrypt

RUN curl -sS https://getcomposer.org/installer | php -- --2.2 \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

CMD ["php", "-v"]
