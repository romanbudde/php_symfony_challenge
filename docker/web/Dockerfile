FROM php:8.1-apache

RUN apt-get update \
&& apt-get install -y apt-utils vim curl sqlite3 mc \
&& pecl install xdebug

# PHP extensions
RUN \
    docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
    && docker-php-ext-install pdo_mysql

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
	chromium-driver \
    software-properties-common \
    && apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    libfreetype6-dev \
    libicu-dev \
    libssl-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libedit-dev \
    libedit2 \
    # pdo_pgsql \
	# libcurl3 \
	libcurl3-dev \
    libpq-dev \
    libxslt1-dev \
    libzip-dev \
    # https://github.com/docker-library/php/issues/880
    libonig-dev \
    #agregado freetype
    # freetype \
    apt-utils \
    gnupg \
    git \
    vim \
    wget \
    curl \
    lynx \
    psmisc \
    unzip \
    tar \
    cron \
    bash-completion

#Install Dependencies
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg
RUN docker-php-ext-configure gd
RUN apt-get update
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-install opcache
RUN docker-php-ext-install bcmath 
RUN docker-php-ext-install curl 
RUN docker-php-ext-install intl
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install ctype
RUN docker-php-ext-install iconv
RUN docker-php-ext-install dom
RUN docker-php-ext-install soap
RUN docker-php-ext-install fileinfo
RUN docker-php-ext-install simplexml
# RUN docker-php-ext-install openssl
# RUN docker-php-ext-install tokenizer
RUN docker-php-ext-install xmlwriter
# RUN docker-php-ext-install spl
# RUN docker-php-ext-install hash
RUN docker-php-ext-install xsl
RUN docker-php-ext-install pdo
# RUN docker-php-ext-install json
RUN docker-php-ext-install zip

RUN apt-get update && \
    \
    apt-get install -y --no-install-recommends \
        libldap2-dev \
        libldb-dev \
        libldb-dev \
        libmcrypt-dev \
        libxml2-dev \
        libsodium-dev \
        # libonig-dev agregado: 
        # https://github.com/docker-library/php/issues/880
        libonig-dev \
        zlib1g-dev

# RUN apt-get update && \
#     \
#     apt-get install -y --no-install-recommends \
#         php-pgsql

RUN docker-php-ext-install pdo_pgsql

RUN a2enmod rewrite
RUN a2enmod headers

RUN docker-php-ext-install sockets
RUN docker-php-ext-install sodium

RUN a2enmod ssl

RUN ln -sf /dev/stdout /var/log/apache2/access.log \
    && ln -sf /dev/stderr /var/log/apache2/error.log

#WORDPRESS
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli


COPY ./php/composer /usr/local/bin/composer

# RUN wget https://get.symfony.com/cli/installer -O - | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony
WORKDIR /var/www/html/

RUN composer
RUN composer create-project symfony/skeleton AaxisTest

USER root

RUN chmod 777 -R /var/www \
    && chown -R www-data:www-data /var/www \
    && usermod -u 1000 www-data \
    && chsh -s /bin/bash www-data

EXPOSE 80
EXPOSE 443