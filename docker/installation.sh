#! /bin/bash
# Load environment file
export $(grep -v '^#' .env | xargs)

# Create database
docker exec -i ${CONTAINER_NAME} /bin/bash /tmp/pm-installation.sh
