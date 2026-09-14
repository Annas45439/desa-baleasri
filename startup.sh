#!/bin/bash
set -e

php artisan storage:link --force || true
php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"