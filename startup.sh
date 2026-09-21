#!/bin/bash
set -e

cd /home/site/wwwroot
rm -f hostingstart.html

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs storage/app/public/berita storage/app/public/potensi storage/app/public/hero storage/app/public/kepala-desa storage/app/public/surat storage/app/public/pengaduan
chmod -R 777 storage bootstrap/cache 2>/dev/null || true

if [ ! -f index.php ]; then
	printf '%s\n' '<?php' "require __DIR__ . '/public/index.php';" > index.php
fi

# Clear compiled views and cached routes/config from previous deployments.
php artisan optimize:clear

# Tulis php.ini custom untuk atasi batas upload 2MB bawaan Azure
mkdir -p /usr/local/etc/php/conf.d 2>/dev/null || true
cat > /usr/local/etc/php/conf.d/uploads.ini << 'PHPINI'
upload_max_filesize = 64M
post_max_size = 64M
memory_limit = 256M
max_input_time = 300
max_execution_time = 300
PHPINI

rm -rf assets build
cp -R public/assets assets
cp -R public/build build

# Pastikan symlink storage berjalan di public/storage -> ../../storage/app/public
php artisan storage:link --force 2>/dev/null || true

# Fallback manual jika artisan storage:link gagal di Azure
if [ ! -L public/storage ] && [ ! -d public/storage ]; then
    ln -sf /home/site/wwwroot/storage/app/public /home/site/wwwroot/public/storage || true
fi

php artisan migrate --force || true

# Tulis nginx config ke /home/site agar persisten lintas restart
cat > /home/site/nginx-default << 'NGINXEOF'
server {
    listen 8080;
    root /home/site/wwwroot;
    index index.php index.html;

    client_max_body_size 64M;

    location /storage/ {
        alias /home/site/wwwroot/storage/app/public/;
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }

    # Route uploaded media through Laravel instead of the generic static-file rule below.
    location ^~ /media/ {
        try_files $uri /index.php?$query_string;
    }

    location / {
        try_files $uri /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 300;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot|webp|avif)$ {
        expires max;
        log_not_found off;
    }
}
NGINXEOF

# Salin ke path nginx yang dikenal Azure App Service PHP
if [ -f /etc/nginx/sites-available/default ]; then
    cp /home/site/nginx-default /etc/nginx/sites-available/default
    cp /home/site/nginx-default /etc/nginx/sites-enabled/default
elif [ -d /etc/nginx/conf.d ]; then
    cp /home/site/nginx-default /etc/nginx/conf.d/default.conf
fi

service nginx reload 2>/dev/null || nginx -s reload 2>/dev/null || true