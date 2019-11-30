#! /bin/bash
# Load environment file
export $(grep -v '^#' .env | xargs)

# Create database
cat ./sql/create-db.sql | docker exec -i ${DB_CONTAINER_NAME} /usr/bin/mysql -u root --password=${DB_ROOT_PASSWORD}
