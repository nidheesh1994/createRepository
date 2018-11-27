# About createRepository

createRepository is used to create the basic interface and repository php files in the Repositories directory. Those who are following repository pattern for laravel development, can easily create repositories using this class.

### Installing

Download the file createRepository into your base folder of the laravel project.

### Create a new repository

To create a new repository open terminal and run the command "php createRepository RepositoryName".
This will generate a repository folder inside app/Repositories with two files RepositoryNameInterface.php and RepositoryNameRepository.php and bind these in the AppServiceProvder.php
