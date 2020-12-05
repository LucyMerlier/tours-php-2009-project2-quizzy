# Simple MVC

## Description

This repository is a simple PHP MVC structure from scratch.

It uses some cool vendors/libraries such as Twig and Grumphp.

This simple MVC structure serves as a basis for a "quizz" type of web application called "Quizzy" that will propose an infinite flow of random questions to the user. From Quizzy's home page, you will be able to display a random question and its possible choices each time you refresh the page. You can click on one of the choices, and you will then be redirected to a page that tells you if the choice you selected is correct or not. For now, you only need to select one of the possible correct choices to win. You can add your own questions and the choices associated with them by clicking the "AJOUTE LES TIENNES" link at the bottom of the page, and following the instructions step by step.

This is a fork made by myself (Lucy Merlier), in order to try and continue to update and improve Quizzy after the Wild Code School project 3 deadline is passed.


### Check on Travis

Travis is checking your code. It's a Continuous Integration (CI) service used on this repository to launch the code verification tools on the github repository itself.

1. Go on [https://travis-ci.com](https://travis-ci.com).
2. Sign up if you don't have account,
3. Look for your project in search bar on the left,

## Installation steps

1. Clone the repo from Github.
2. Run `composer install`.
3. Create *config/db.php* from *config/db.php.dist* file and add your DB parameters. Don't delete the *.dist* file, it must be kept.
```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PWD', 'your_db_password');
```
4. Import `db.sql` in your SQL server, so you can have access to our test questions and their possible choices,
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
6. Go to `localhost:8000` with your favorite browser,
7. Play with the "Quizzy" application, don't hesitate to add your own questions!

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command :

`git config --global core.autocrlf true`

## URLs availables

* Quizzy's home page at [localhost:8000/](localhost:8000/)
* Quizzy's "result" page, that tells you if you won or not (can only be accessed after answering a question) [localhost:8000/question/result](localhost:8000/question/result)
* Quizzy's first part of the form that lets you add your own question [localhost:8000/question/add](localhost:8000/question/add)
* Quizzy's second part of the form that lets you add the associated choices (can only be accessed after adding a question) [localhost:8000/choices/add](localhost:8000/choices/add)
* Quizzy's final page of the form that tells you if your question has been successfully added to the database (can only be accessed after completing the previous steps) [localhost:8000/choices/added](localhost:8000/choices/added)

## How does URL routing work ?

![Simple MVC.png](https://raw.githubusercontent.com/WildCodeSchool/simple-mvc/master/Simple%20-%20MVC.png)
