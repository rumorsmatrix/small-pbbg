## A (small) sci-fi PPBG

An experiment in using AJAX and Websockets to make a small persistent web based game. Homebrew framework, using [illuminate/database](https://github.com/illuminate/database) and the eloquent ORM. Come [chat to me on twitter](https://twitter.com/rumorsmatrix) about it.


### Installation

  * Clone this repository
  * `composer install`
  * Symlink or otherwise make servable the `public/` directory; update `$router->setBasePath` in  `public/index.php` if needed
  * Provide your own `config/db.php` containing details to pass to `\Illuminate\Database\Capsule\Manager->addConnection()` in this format:
```
return [
   'driver'    => 'mysql',
   'host'      => 'localhost',
   'database'  => 'database_name',
   'username'  => 'username_here',
   'password'  => 'password_here',
   'charset'   => 'utf8',
   'collation' => 'utf8_unicode_ci',
   'prefix'    => '',
];
```
