# Document Manager

Document Management Microservice developed in Laravel and using MySQL as Database.

## Getting Started

1. Download the repository
2. Duplicate */app/.env.example* changing to */app/.env* and modifying the environment variables
2. Run *composer install* to install all packages used
3. Run *php artisan migrate* to up all tables to the database
4. Run *php artisan storage:link* to make the public link with storage folder
5. Run *php artisan serve* to run the application

---

## Auth Keys

For sample, some APIKeys were created to explore the API functionalities

- **Viewer Key:** uW9zP5R+2yjT8/X4K7QqLh9nA6C1vfSd
- **Editor Key:** 5Zs6L9Kp3y2+VuQGzI4zXhDPT1oRw/Aq

## Endpoints

The endpoints are separated according to the user's authorizations (according to the user's APIKey)

### Viewer Endpoints

- **GET :: / ->** Returns the list of endpoints
- **GET :: /ping ->** Verify if the server is up, returning the string 'pong'
- **GET :: /document/types ->** Returns the list of document types
- **GET :: /document/cols/{documenttype_id} ->** Returns the list of columns and values ​​of a document type
- **GET :: /document/pdf/{documenttype_name} ->** Generates a PDF of a document

---

### Editor Endpoints

- **POST :: /document/types/add ->** Adds a new document type
    ```
    {
        name :: string
    }
    ```
- **PUT :: /document/types/edit/{id} ->** Edit a document type
    ```
    {
        name :: string
    }
    ```
- **DELETE :: /document/types/delete/{id} ->** Delete a document type

- **POST :: /document/cols/make/{documenttype_id} ->** Creates all columns of a document type
    ```
    {
        "columns": [
            {
                name :: string
                typecol :: string ("string", "int", "bool", ...)
            },
            {
                ...
            }
        ]
    }
    ```
- **POST :: /document/cols/add/{documenttype_id} ->** Adds a new column to a document type
    ```
    {
        name :: string
        typecol :: string ("string", "int", "bool", ...)
    }
    ```
- **PUT :: /document/cols/edit/{documenttype_id} ->** Edit a column of a document type
    ```
    {
        name :: string
        typecol :: string ("string", "int", "bool", ...)
    }
    ```
- **POST :: /document/values/add/{documenttype_id} ->** Inserts a row of values ​​(all columns) into a document
    ```
    {
        field1: type_of_field1,
        ...
    }
    ```

---

## Observations

- During development, the **EAV (Entity-Attribute-Value)** pattern was chosen instead for the document types's dynamic columns control instead of a **JSON method**, aiming at service scalability, since large JSONs have a worse performance relational systems queries than traditional SQL (even using ORM) queries with 1xN or NXN relations.

- A simple bearer authorization validation was implemented using the header **Authorization = Bearer APIKEY**. This provides a basic security level to the microservice.

- The Database used is an MySQL server up in a 3rd party server.

- All Docker compose scripts were implemented, but for a microservice, is recomended adapt the files to the others microservices.

- The performance was affected by the database server used for this demonstration. For the project performance validation, the usage of another database server is recommended.