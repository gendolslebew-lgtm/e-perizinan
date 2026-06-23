FROM webdevops/php-apache:8.3

ENV WEB_DOCUMENT_ROOT=/app/public
WORKDIR /app

COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN chown -R application:application /app/storage /app/bootstrap/cache
CMD php artisan migrate --force && apache2-foreground