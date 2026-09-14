#!/bin/bash
set -e

cd /home/site/wwwroot
rm -f hostingstart.html

if [ ! -f index.php ]; then
	printf '%s\n' '<?php' "require __DIR__ . '/public/index.php';" > index.php
fi

ln -sfn public/assets assets
ln -sfn public/build build
php artisan storage:link --force || true