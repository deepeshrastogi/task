# Task Management

## Process

Clone the project using "git clone https://github.com/deepeshrastogi/task.git"

## Setup Task Management

1 - Create a new database "task"

2 - Rename file .env.example to .env

3 - Run the given below commands step by step
    
    > composer update
    
    > php artisan optimize
    
    > php artisan migrate
    
    > php artisan db:seed --class=TaskSeeder
    
    > php artisan serve --port=8000

4 - I have created an API Collection folder which exists in the root folder, Please import the given collection in Postman software.

5 - Please use given below Login Details
    email : admin@yopmail.com
    password : admin@123


## Create a new account/Login
![signup](https://github.com/deepeshrastogi/task/assets/38438355/82184960-7f3b-48ad-9d27-a827a45dde1a)
![login](https://github.com/deepeshrastogi/task/assets/38438355/cadf704d-9ca9-419b-ad4b-6990857edb85)

## Create new Task
![task_creation1](https://github.com/deepeshrastogi/task/assets/38438355/0d878566-19d7-46ed-bb15-b0cc80f18d7b)
![task_creation2](https://github.com/deepeshrastogi/task/assets/38438355/42abfb8a-b3f6-4e39-8316-1637475c7a6c)

## Get tasks list with filter options
![task_list1](https://github.com/deepeshrastogi/task/assets/38438355/9877014f-812e-4814-8746-376fb09463f9)
![tasks_list2](https://github.com/deepeshrastogi/task/assets/38438355/3f9c1c67-07db-4700-93d9-4e0479d4a590)