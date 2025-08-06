# 使用官方 PHP + Apache 镜像
FROM php:8.1-apache

# 安装 PDO 和 MySQL 扩展
RUN docker-php-ext-install pdo pdo_mysql

# 启用 Apache 的 mod_rewrite（如果你使用 .htaccess）
RUN a2enmod rewrite

# 将项目代码复制到 Apache 根目录
COPY . /var/www/html/

# 设置工作目录（可选）
WORKDIR /var/www/html

# 将 Render 的 PORT 环境变量映射到 Apache
ENV PORT=10000
EXPOSE 10000

# 修改 Apache 默认监听端口为 Render 的 PORT
RUN sed -i "s/80/\${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

# 启动 Apache（Render 会自动运行 CMD）
CMD ["apache2-foreground"]
