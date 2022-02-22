#!/bin/sh

umask 0000

cd /var/www

# php artisan migrate:fresh --seed
php artisan migrate:fresh
php artisan cache:clear
php artisan route:cache

/usr/bin/supervisord -c /etc/supervisord.conf
chown -R root:root storage/
chmod -R 777 storage/
