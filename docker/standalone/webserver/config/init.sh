#/bin/bash
if [ -d "/app/vendor" ]; then
  su application -c "/chromedriver/chromedriver &"
fi
