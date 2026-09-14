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