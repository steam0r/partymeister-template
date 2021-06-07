## About PartyMeister

## Installation

### Docker standalone

1. Copy .env.docker.standalone to .env and adjust settings if necessary

2. Go to ./docker/standalone

3. Copy .env.example to .env and adjust the settings if necessary

4. Run the following command


    docker-compose up --build --force-recreate -d

5. After the images are running successfully, run the following script to create the database


    ./after-build.sh

6. After that, run the last command (this will populate the database get everything ready)


    ./installation.sh


7. Go to http://localhost and the frontend page should show up
8. You can find the backend on http://localhost/backend and log in with
    1. User: motor@esmaili.info
    2. Password: admin
    
9. Go nuts!
