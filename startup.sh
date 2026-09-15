#!/bin/bash
set -e

cd /home/site/wwwroot
rm -f hostingstart.html

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs storage/app/public

if [ ! -f index.php ]; then
	printf '%s\n' '<?php' "require __DIR__ . '/public/index.php';" > index.php
fi

rm -rf assets build
cp -R public/assets assets
cp -R public/build build
php artisan storage:link --force || true

# Tulis nginx config agar semua request diteruskan ke Laravel (index.php)
cat > /etc/nginx/conf.d/default.conf << 'EOF'
server {
    listen 8080;
    root /home/site/wwwroot;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires max;
        log_not_found off;
    }
}
EOF

nginx -s reload 2>/dev/null || true