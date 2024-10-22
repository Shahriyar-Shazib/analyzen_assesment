Project installation guideline :
    *php: ^8.2.*
    *database: mysql 
    *Composer version 2.7.9
    *npm 10.8.2
        ->first you have to istall xampp which has php version avobe 8.2

        ->then ypu have to install composer 

        ->then you have to install node js in your machine 

        ->then clone the project from the git repository 

        ->after cloning the project create .env file

        ->and pest the.envExample files code as it is

        ->create a database in mysql as given in .env.Example "analyzen_assesment"

        ->after open command line from the project directory and run there commands
            ->composer install or composer update
            ->npm install
            ->npm run build
            ->php artisan key:generate
            ->php artisan migrate --seed
            ->php artisan serve
        you are ready .............
        for testing purpose one user is created
        email:admin@gmail.com
        password:11111111
