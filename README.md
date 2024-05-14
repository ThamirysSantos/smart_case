# Smart Fast Pay - Tech Test

## Índice

- [Development](#Development)
  - [Tecnology](#Tecnology)
  - [Setup](#Setup)
  - [Archtecture](#Archtecture)
  - [Makefile](#Makefile)
  - [Swagger](#Swagger)
- [Developer](#Developer)

## Development

### Tecnology

Technologies used in the project:

 - [PHP 8](https://www.php.net/)
| [Laravel 11](https://laravel.com/)
| [MYSQL 8](https://www.mysql.com/)
| [Docker](https://www.docker.com/)

### Setup

- #### Commands
  - You must have [Docker](https://www.docker.com/) installed on your machine
  - Setup commands to run the project:
    - Run to copy the environment variables to the .env .
      ```
      cp .env.example .env
      ```
    - Run  to create the image and upload the container, generate app key, execute migrations and seeders.
      ```
      make setup
      ```
    - Run  to generate JWT token secret at .env file.
      ```
      make jwt-generate
      ```
    - Run to generate API documentation
      ```
        make swagger-generate
      ```
- #### Sedders
  - when running seeder:
    - the payment_method table will be populated with the methods ['PIX',   'BOLETO', 'BANK_TRANSFER']
    - The merchant table will be populated with two merchants where you can use the credentials below:
      - merchant 1:
          ```
            {
              "email": "test1@gmail.com",
              "password": "paswword"  
            }
          ```
      - merchant 2:
          ```
            {
              "email": "test2@gmail.com",
              "password": "paswword"  
            }
          ```
- #### Docker Config
  - in the dockerfile the ports of the app and the database are specified, so you can access database at port `3308`, and endpoints at `http://localhost:8005`.

### Makefile
- available commands on makefile:
  - `make up` to create the image and upload the container.
  - `make down` to stop containers and removes containers, networks, volumes, and images created by up.
  - `make generate-key` to install the dependencies.
  - `make bash` to access the application container.
  - `make optimize` to clear cache and perform autoload and optimize.
  - `make migrate` to run migrations.
  - `make migrate-reset` to reset migrations.
  - `make seed` to run sedders.
### Swagger
- Api documentation can be acessed on [http://localhost:8005/api/documentation#/](http://localhost:8005/api/documentation#/)

### Archtecture
  - This project was developed based on clean architecture.

📦 app<br>
┣ 📂 Domain<br>
┃ ┃ ┣ 📂 Contracts<br>
┃ ┃ ┣ 📂 Dtos<br>
┣ 📂 Infrastructure<br>
┃ ┗ 📂 Http<br>
┃ ┃ ┣ 📂 Controllers<br>
┃ ┃ ┣ 📂 Requests<br>
┃ ┣ 📂 Persistence<br>
┃ ┃ ┣ 📂 Models<br>
┃ ┃ ┣ 📂 Repositories<br>
┣ 📂 UseCases<br>
┗ 📂 Utils<br>

## Developer

Thamirys Gonçalves Santos<br>
[Email](mailto:thamirysgoncalves.prog@gmail.com)<br>
[Linkedin](https://www.linkedin.com/in/thamirysgoncalves/)
