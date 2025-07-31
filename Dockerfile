# 使用官方 PHP 镜像
FROM php:8.1-apache

# 安装 PDO 和 MySQL 扩展
RUN docker-php-ext-install pdo pdo_mysql

# 将本地代码复制到容器中
COPY . /var/www/html/

# 启用 Apache 的 mod_rewrite（如果你有用 .htaccess）
RUN a2enmod rewrite

# 设置工作目录
WORKDIR /var/www/html
