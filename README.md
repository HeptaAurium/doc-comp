## INSTALLATION

- Clone the repo
    `git clone https://github.com/HeptaAurium/doc-comp`

## USING DOCKER 
- Set up `env`
    `cp .env.example .env`

- build the application
    `docker-compose up -d --build` 

- Set up the database
    `docker exec -it doc-comp bash`
    `php artisan migrate`

## WITHOUT DOCKER
- Set up `env`
    `cp .env.example .env`

- Set up the database
    `php artisan migrate`
    `php artisan serve`
