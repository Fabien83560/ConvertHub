#!/bin/bash

apachectl start
certbot --apache -d converthub.ortegaf.fr --non-interactive --agree-tos -m fabienortega.290604@gmail.com
apache2-foreground
