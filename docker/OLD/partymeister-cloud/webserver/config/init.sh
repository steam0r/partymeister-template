#/bin/bash
if [ -d "/app/vendor" ]; then
  su application -c "php /app/artisan partymeister:slides:webdriver start"
fi
