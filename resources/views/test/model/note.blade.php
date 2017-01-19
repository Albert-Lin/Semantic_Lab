<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/1/20
 * Time: 上午 01:47
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $title }} </title>
</head>
<body>

    <p>
        // Create && Initialize Database <br>
        01. open 127.0.0.1/phpmyadmin <br>
        02. create database <br>
            => semantic_lab, utf8-gernal-ci <br> <br>

        03. open .env in lavarel project <br>
        04. setting db information in .env <br> <br> <br>


        // Setting && Initialize Table <br>
        05. open cmd in Lavarel project foder root <br>
        06. using php artisan command below: <br>
            => php artisan make:migration create_{table_name}s_table <br>
            => e.g., php artisan make:migration create_user_infos_table <br>
            * all the table name should add 's' at end of name, so the formate is {table_name}s <br>
            * if the execute shows ' failed to open stream no such file or directory', <br>
            * used the below command: <br>
                => composer dump_autoload <br>
        07. a migration file will auto create in [Lavarel project] > [database] > [migration] > {createTime}_create_{table_name}s_table.php <br>
        08. open migration file and setting function up() and down() for create and drop table <br>
        09. migration file setting <br> <br>

        // Create Table <br>
        10. After setting schema of table in migration file, using php artisan command below to create table: <br>
            => php artisan migrate <br>
        * all the migration file will execute and create mapping table <br>
        11. For create table we only needs, we create a folder named '! migrations' for saving migrations file which not going to execute. <br> <br>

        // Success <br>
        12. Check database for sure. <br>
        13. Move the migrations files in '! migrations' back to migrations <br> <br>

        // Create Eloquent Model <br>
        14. using php artisan command below to create Eloquent model of table <br>
            => php artisan make:model {table_name_for_class} --migration <br>
        15. for easy management Eloquent models, we create a 'Model' folder under 'app' folder and move the model file just create into 'Model' <br>

    </p>

</body>
</html>
