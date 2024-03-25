ReadMe Projet E-Commerce : 

Tout d'abord, mon projet portera sur un site écologique qui fournis des services et des produits dans la norme écologique également, ceci est la parti back-end de mon site.

J'ai choisi (pas vraiment c'était demandé) d'initialiser ce projet avec Laravel via les commandes suivante : 

- composer create-project laravel/Projet-ECommerce
- J'ai également du mettre a jour ma version de node en utilisant nvm use 18

Pour la base de donnée, j'ai choisi mySQL qui est le SGBD avec le quel je me sens le mieux et j'ai le plus travaillé auparavant.

J'ai créé les tables et les colonnes en me basant sur le dossier de conception réalisé en groupe, cela n'a pas été vraiment compliqué, mis a part les tables intermediaires a valeur pivot, qui ont nécéssités un peu de recherche (orders_product & users_product).

Commande utilisé pour la base de donnée & les Factory/Seeder: 

- php artisan make:migration 
- php artisan make:model
- php artisan migrate
- php artisan make:migration exemple_de_migration --table=Exemple
- php artisan make:factory --model=Exemple
- php artisan make:seeder ExempleSeeder
- php artisan db:seed --class=ExempleSeeder
- php artisan migrate:fresh
- php artisan migrate:fresh --seed

J'ai choisi de remplir ma base de données a l'aide de Factory et de Seeders.

Je me suis occupé du CRUD également, pour cela j'ai dû : 

- Créé des controllers (exemple : php artisan make:controller UserController)
- Créé des requests (exemple : php artisan make:request StoreUserRequest)
- Créé des resources (exemple : php artsan make:resource UserResource).
- 

