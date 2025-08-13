# 使用官方 PHP 镜像
FROM php:8.1-apache

# 安装必要的依赖和PostgreSQL扩展
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# 将本地代码复制到容器中
COPY . /var/www/html/

# 启用 Apache 的 mod_rewrite
RUN a2enmod rewrite

# 设置工作目录
WORKDIR /var/www/html