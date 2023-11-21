Symfony Docker Environment 
 
This repository contains a Dockerized Symfony environment for easy setup and development. 



Prerequisites: 

Make sure you have the following installed:

Docker 

 
Getting Started
1. Clone this repository to your local machine. 
2. Navigate to the project directory.

 
Running the Application & Setting Up the Environment 

Run the following command to build the necessary Docker containers: 
 
docker compose build 
 
And then, run: 
 
docker compose up 
 
  
Once the containers are built and are up and running, the Symfony application should be accessible at http://local.symfonychallenge/public/ (make sure to add the mapping to your /etc/hosts file) 
 
The database is accessible at localhost:8080 (thanks to the adminer container), and the credentials for it are in the docker-compose.yml 

 
Should the database not be displaying any data, attach to the web container's console and make sure the database is created and the schema is updated, running: 

php/console doctrine:database:create  

php/console doctrine:schema:update 
 
 
Example of use: 
From the required functionality, for example: to get all products, hit the endpoint: 
http://local.symfonychallenge/public/index.php/product/all 

Which is defined in the MainController.php file. 
