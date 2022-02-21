#!/bin/sh

cd /var/www

chmod -R 777 storage
# php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache

/usr/bin/supervisord -c /etc/supervisord.conf
