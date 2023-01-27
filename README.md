# SIMP API

*Initialize the server in 9 steps*

## Table of Contents

- [Docker Compose Installation](#docker-compose-installation)
- [Composer installation](#composer-installation)
- [Initialize the Database](#initialize-the-database)
- [Run the serveur](#run-the-serveur)

## Docker Compose Installation
___

1/ Run the following command to install and launch Docker Compose:

    sudo docker docker-compose up

✅ You should now have Docker Compose installed and running.


## Composer Installation
___

2/ Go to the root of the project:

    cd ./api

3/ Run the following command to install Composer:

    sudo composer install

✅ You should now have Composer installed.

## Initialize the Database
___

4/ In the .env file of the /api directory, locate the following two lines:

- **Running ->** `DATABASE_URL="mysql://simp:monkey@mariadb:3306/bitnami_myapp?serverVersion=10.6"`
- **Update database ->**  `DATABASE_URL="mysql://simp:monkey@0.0.0.0:5069/bitnami_myapp?serverVersion=10.6"`

5/ Comment out the "Running" line and uncomment the "Update database" line.

6/ Run the following command in the /api directory to update the database:

    `php bin/console doctrine:schema:update --force`

✅ You should now have the database initialized.

## Run the serveur
___

7/ In the .env file of the /api directory, locate the following two lines:

- **Running ->** `DATABASE_URL="mysql://simp:monkey@mariadb:3306/bitnami_myapp?serverVersion=10.6"`
- **Update database ->**  `DATABASE_URL="mysql://simp:monkey@0.0.0.0:5069/bitnami_myapp?serverVersion=10.6"`

8/ Uncomment the "Running" line and comment out the "Update database" line.

9/ Run the server.

✅ You should now have the server running.