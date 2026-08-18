# Module B - REST API and SSR

## Important information about PATH for admin pages

I used /KZ_Module_B like prefix. Because its required for this infrastructure. Apache configuration is incorrect (/var/www/html). correct version: /var/www/html/KZ_Module_B/public for apache config.

## Access in container

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

its also required before testing
