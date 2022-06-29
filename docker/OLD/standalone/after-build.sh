#! /bin/bash
# Load environment file
export $(grep -v '^#' .env | xargs)

# Create database
echo "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` DEFAULT CHARACTER SET UTF8mb4 COLLATE utf8mb4_bin;" | docker exec -i ${DB_CONTAINER_NAME} /usr/bin/mysql -u root --password=${DB_ROOT_PASSWORD}
