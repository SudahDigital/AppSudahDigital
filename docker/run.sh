#!/bin/sh

umask 0000

cd /var/www

# php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache
#php artisan migrate:fresh
php artisan migrate:rollback

/usr/bin/supervisord -c /etc/supervisord.conf
chown -R root:root storage/
chmod -R 777 storage/
