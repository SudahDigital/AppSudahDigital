#!/bin/sh

s3fs sudahdigital /var/www/storage/public -o nonempty -o passwd_file=/root/.passwd-s3fs

umask 0000

cd /var/www

# php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache
#php artisan migrate


/usr/bin/supervisord -c /etc/supervisord.conf
chown -R root:root storage/
chmod -R 777 storage/
