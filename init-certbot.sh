#!/bin/bash

mkdir -p /var/log/letsencrypt
chown -R www-data:www-data /var/log/letsencrypt

apachectl start

sleep 10

certbot --apache -d converthub.ortegaf.fr --non-interactive --agree-tos -m fabienortega.290604@gmail.com

apachectl restart

while true; do
  sleep 12h
  certbot renew --quiet
  apachectl restart
done
