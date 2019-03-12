# Phonebook RESTful JSON API

## Introduction
Phonebook contains users records. Each user has properties:

  * First name
  * Last name
  * Phone number
  * Country code
  * Timezone name
  * CreatedAt (sets automaticaly by database)
  * UpdatedAt (updates automaticaly by database)


## API Methods

  * **GET /users** - Get list of all users in phonebook. Supports pagination by adding **skip** and **take** parameters to the request query. Example: /users?skip=3&take=2
  * **GET /user/{id}** - Get properties of one user by ID (only numbers)
  * **POST /users/search** - Search users by passing a keyword in a request body. Request body should contain field **keyword** and a search part. Example: {"keyword":"Donald"}
  * **PUT /user** - Create user. All user properties shoud be provided via request body in JSON format. **All fields are required**.
  * **PATCH /user/{id}** - Update user by ID. Like in creating users for updating all properties must be given in request body. But in this case **none of parameters are required**. You can update only first name and/or phone number
  * **DELETE /user/{id}** - Deletes user by ID from phonebook.

## Basic JSON Request Body
    {
        "first_name":"Dexter",
        "last_name":"Morgan",
        "phone_number":"+111 222 3334455",
        "country_code":"US",
        "timezone": "America/New_York"
    }
This is an example of full properties list that is required when creating a user

## How it was done
For purpose of developing described API it was made a desicion to create a tiny little framework which has router, controllers, models with Eloquent ORM and a few helper classess and functions

### Folder structure
    ├── _migrations
    ├── app
    │   ├── Controllers
    │   ├── Helpers
    │   └── Models
    ├── config
    ├── core
    │   └── lib
    ├── _migrations
    ├── public
    ├── routes
    ├── storage
    │   ├── cache
    │   └── log
    └── vendor

  * **_migrations** - contains database migration files in plain SQL format. For creating migrations, migrating and rollback use **php migrate ** command (see bellow)
  * **app** - contains all your code wich is needed for you project. There are separate folders for Controllers, Models and if needed Helpers
  * **config** - is a folder with configuration files, such as database access
  * **core** - is the core of tiny framework which contains all framework classes and libraries
  * **public** - web accessed public folder
  * **routes** - containes diffinitions for project http routes
  * **storage** folder needed for cache and log file
  * **vendor** - standart folder for third party pakages

### Database migration
Framework has a self made simple migration system which allows you to create migration files, migrate database and roll back migrations.

    $ php migrate help

      Self made migration system with migration files as plain SQL-scripts
      Usage: php migrate commands
      Commands:
          help      This help message.          Example: php migrate help
          init      Initializing migrate table. Example: php migrate init
          create    Create new migration file.  Example: php migrate create UserTable
          rollback  Rollback last transaction.  Example: php migrate rollback

