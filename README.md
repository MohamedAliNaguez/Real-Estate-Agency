# Real Estate Agency API 
 Back End Developer Take-home Assignment for Danubio

## Description
A RESTful API for managing real estate properties. It allows users to create, update, and search for properties by type, address, size, number of bedrooms, price, and location.

## Features
- Create new properties (House/Apartment).
- Search for properties by filters (type, address, size, bedrooms, price).
- Search for properties within a geographical radius (latitude, longitude).

## Technologies
- **Backend**: PHP 8.2.12 with Laravel 11.33.2
- **Database**: MySQL

## Installation

### Prerequisites
- PHP 8.x
- Composer
- MySQL
- Git

### Steps
## 1. Clone the repository:  

   git clone https://github.com/MohamedAliNaguez/Real-Estate-Agency.git
   cd real-estate-agency
   cd real-estate-agency-app

## 2. Install dependencies:

   composer install

## 3. Configure the .env file:

 cp .env.example .env

## 4. Run migrations and seed the database:

  php artisan migrate --seed

## 5. Start server: 

  php artisan serve

## 6. Access the API:

Base URL: http://127.0.0.1:8000

| Method | Endpoint                | Description                              |
|--------|-------------------------|------------------------------------------|
| POST   | `/api/properties`       | Create a new property                   |
| GET    | `/api/properties`       | List all properties                     |
| GET    | `/api/properties/{id}`  | View a specific property                |
| PUT    | `/api/properties/{id}`  | Update a property                       |
| DELETE | `/api/properties/{id}`  | Delete a property                       |
| GET    | `/api/properties/search`| Search properties with filters          |
| GET    | `/api/properties/nearby`| Search properties within a radius       |

Example of search api test : http://127.0.0.1:8000/api/properties/search?type=Apartment

Example of nearby api test : http://127.0.0.1:8000/api/properties/nearby?latitude=40.71280000&longitude=-74.00600000&radius=10000

## 7. Possible improvements :

+ Add authentication and role-based access.
+ Implement pagination.
+ Enhanced Filtering
+ Add unit and integration tests.
+ Data Validation and Error Handling.





