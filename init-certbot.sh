#!/bin/bash

apachectl start

sleep 10

certbot --apache -d converthub.ortegaf.fr --non-interactive --agree-tos -m fabienortega.290604@gmail.com

apachectl restart

while true; do
  sleep 12h
  certbot renew --quiet
  apachectl restart
done
