#/bin/bash
su application -c "cd /app; ./update-dev.sh; php artisan migrate:fresh; php artisan db:seed"
