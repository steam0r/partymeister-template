#/bin/bash
su application -c "cd /app; composer install; php artisan migrate:fresh; php artisan db:seed"
