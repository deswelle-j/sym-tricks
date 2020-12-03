# sym-tricks
Community site about snowboard in symfony 4

## Require

 * [php 7.2](https://www.php.net/downloads.php#v7.2.27)
 * [mysql](https://dev.mysql.com/downloads/installer/)
 * [composer](https://getcomposer.org/doc/00-intro.md)
 * [apache](http://httpd.apache.org/docs/2.4/fr/install.html)
 * [nodejs](https://nodejs.org/en/) and [npm](https://www.npmjs.com/)

## Project Installation 

It's easy to install 
Clone the repo in your server with the following command:
```bash
git clone https://github.com/deswelle-j/sym-tricks.git
```

Enter the following command to install the vendors:
```bash
composer update
```

To create the database, edit the .env file

on the line 32 DATABASE_URL=mysql://root:@127.0.0.1:3306/sym-tricks
```bash
Enter your crendentials
```
Exemple:
```bash
 DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
```

To compile the css and js you need to run the npm command
```bash
 npm run build
```
for production file and 
```bash
npm run dev
```
for dev file
If you want to use mailer
Enter your credentials line 24 you can use [mailtrap](https://mailtrap.io/) catch your email (there's a free limited use)
```bash
exemple of configuration with mailtrap MAILER_DSN=smtp://username:password@smtp.mailtrap.io:2525/?encryption=ssl&auth_mode=login
```

Run the command:
```bash
php bin/console doctrine:database:create
```

You can load a “fake” set of data into your database with the fixtures
Run the following command:
```bash
php bin/console doctrine:fixtures:load
```

If you want to run the site localy
Run the command:
```bash
php bin/console server:run
```

the commande will write the adresse to access to your site
```bash
example  [OK] Server listening on http://127.0.0.1:8000
```

The page can access to the site with the following URL:
http://127.0.0.1:8000

## You can now navigate in your local site

## Code Quality ?

code quality was checked by adding codeclimate to the project you can see the last analysis 

<a href="https://codeclimate.com/github/deswelle-j/sym-tricks/maintainability"><img src="https://api.codeclimate.com/v1/badges/b1a84cb113d75aed9f68/maintainability" /></a>
