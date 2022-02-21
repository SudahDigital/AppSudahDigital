#!/bin/sh

cd /var/www

chown -R www:www-data storage/logs
chmod -R 777 storage/logs/laravel.log

# php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache

/usr/bin/supervisord -c /etc/supervisord.conf
chown -R www:www-data storage/logs
chmod -R 777 storage/logs/laravel.log
