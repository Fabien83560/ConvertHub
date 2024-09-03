# Script to verify SSL files at runtime
RUN echo '#!/bin/bash\n\
if [ ! -f /etc/ssl/private/apache-selfsigned.key ]; then\n\
    echo "SSL key file missing!"\n\
    ls -l /etc/ssl/private/\n\
    exit 1\n\
else\n\
    echo "SSL key file found."\n\
fi' > /check-ssl.sh && chmod +x /check-ssl.sh
