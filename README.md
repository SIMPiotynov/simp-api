# SIMP API

*Initialize the server in 9 steps*

## Table of Contents

- [Installer docker compose](##-installer-docker-compose)
- [Composer install](##-composer-install)
- [Initialiser la BDD](##-initialiser-la-bdd)
- [Run le serveur](##-run-le-serveur)

## Docker Compose Installation
___

1/ Go to the myapp directory:

    cd ./myapp

2/ Run the following command to install and launch Docker Compose:

    sudo docker docker-compose up

✅ You should now have Docker Compose installed and running.


## Composer Installation
___

3/ Go to the root of the project:

    cd ./myapp/my-project

4/ Run the following command to install Composer:

    sudo composer install

✅ You should now have Composer installed.

## Initialize the Database
___

5/ In the .env file of the /my-project directory, locate the following two lines:

- **Running ->** `DATABASE_URL="mysql://simp:monkey@mariadb:3306/bitnami_myapp?serverVersion=10.6"`
- **Update database ->**  `DATABASE_URL="mysql://simp:monkey@0.0.0.0:5069/bitnami_myapp?serverVersion=10.6"`

6/ Comment out the "Running" line and uncomment the "Update database" line.

7/ Run the following command in the /my-project directory to update the database:

    `php bin/console doctrine:schema:update --force`

✅ You should now have the database initialized.

## Run le serveur
___

8/ In the .env file of the /my-project directory, locate the following two lines:

- **Running ->** `DATABASE_URL="mysql://simp:monkey@mariadb:3306/bitnami_myapp?serverVersion=10.6"`
- **Update database ->**  `DATABASE_URL="mysql://simp:monkey@0.0.0.0:5069/bitnami_myapp?serverVersion=10.6"`

9/ Uncomment the "Running" line and comment out the "Update database" line.

10/ Run the server.

✅ You should now have the server running.