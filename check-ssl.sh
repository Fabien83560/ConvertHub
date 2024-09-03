#!/bin/bash
echo "Vérification des fichiers SSL..."
ls -ld /etc/ssl/private/
ls -l /etc/ssl/private/apache-selfsigned.key
ls -l /etc/ssl/certs/apache-selfsigned.crt

if [ ! -f /etc/ssl/private/apache-selfsigned.key ]; then
    echo "SSL key file missing!"
    exit 1
else
    echo "SSL key file found."
fi

exec /usr/sbin/apache2ctl -D FOREGROUND
