#!/bin/sh

cd /var/www

RUN curl --header "X-Consul-Token:${env.CONSUL_TOKEN}" \
-XGET https://consul.sudahdigital.com/v1/kv/dev/apptest.sudahdigital.com?raw=true > .env

# php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache

/usr/bin/supervisord -c /etc/supervisord.conf
