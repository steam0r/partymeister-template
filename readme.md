## About PartyMeister

## Installation

### Docker standalone

1. Go to ./docker

2. Run the following command


    docker-compose up --build --force-recreate -d


3. After the images are running successfully, run the following script to create the database


    docker exec -it docker_app_1 /bin/bash

    php artisan db:seed

4. Go to http://localhost and the frontend page should show up
5. You can find the backend on http://localhost/backend and log in with
    1. User: motor@esmaili.info
    2. Password: admin
    
6. Go nuts!
