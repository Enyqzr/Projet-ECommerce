ReadMe E-Commerce Project:

First of all, my project will focus on an ecological site that provides services and products in the ecological standard also, this is the back-end party of my site.

I chose (not really it was requested) to initialize this project with Laravel via the following commands:
````
- compose create-project laravel/Projet-ECommerce
- I also had to update my node version using nvm use 18
````
For the database, I chose mySQL which is the DBMS with which I feel best and I have worked the most before.

I created the tables and columns based on the design file made in group, it was not really complicated, apart from the intermediate tables with pivot value, which needed a little research (orders_product & users_product).

Command used for database & Factory/Seeder:
````
- php artisan make:migration
````
````
- php artisan make:model
````
````
- php artisan migrate
````
````
- php artisan make:migration exemple_de_migration 
````
````
- --table=Example
````
````
- php artisan make:factory --model=Example
````
````
- php artisan make:seeder ExempleSeeder
````
````
- php artisan db:seed --class=ExempleSeeder
````
````
- php artisan migrate:fresh
````
````
- php artisan migrate:fresh --seed
````
I chose to fill my database with Factory and Seeders.

I took care of the CRUD too, for which I had to:

````
- Create controllers (example: php artisan make:controller UserController)
````
````
- Create requests (example: php artisan make:request StoreUserRequest)
````
````
- Created resources (example: php artsan make:resource UserResource).
````



