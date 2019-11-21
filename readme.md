# DOT Intership Technical Test
 This project is a simple application that build by me to fulfill the intership selection at [PT. Digdaya Olah Teknologi Indonesia](https://dot.co.id) 

## Requirements
 I use a Laravel Framework 5.8 that need this requirement:
 - PHP >= 7.1.3
 - BCMath PHP Extension
 - [Composer](https://getcomposer.org/)
 - Ctype PHP Extension
 - cURL PHP Extension
 - JSON PHP Extension
 - Mbstring PHP Extension
 - OpenSSL PHP Extension
 - PDO PHP Extension
 - Tokenizer PHP Extension
 - XML PHP Extension

## Installation
 - Clone this repository
 - Copy `.env.example` to `.env` and update RajaOngkir API Key and Package with your own
 - Run `composer install`
 - You can start the development server using command `php artisan serve`

## Task 1
### Default Array
 1. Start development server using command `php artisan serve`
 2. Open [`http://127.0.0.1:8000/task-one`](http://127.0.0.1:8000/task-one)
 3. See the result of default array in JSON format
### Array Input
 1. Input an array that contains an integer collection as `array` GET parameter separates by commas (`,`) and open it.
 
    Ex: [`http://127.0.0.1:8000/task-one?array=5,3,8,10,1`](http://127.0.0.1:8000/task-one?array=5,3,8,10,1)
 2. See the results in JSON format

## Task 2
### Available endpoint
 - Get all provinces : [`http://127.0.0.1:8000/api/provinces`](http://127.0.0.1:8000/api/provinces)
 - Get province by province id : [`http://127.0.0.1:8000/api/provinces/{provinceId}`](http://127.0.0.1:8000/api/provinces/1)
 - Search province by province name : [`http://127.0.0.1:8000/api/provinces?keyword={keyword}`](http://127.0.0.1:8000/api/provinces/?keyword=karta)
 - Get cities belongs to province id : [`http://127.0.0.1:8000/api/provinces/{provinceId}/cities`](http://127.0.0.1:8000/api/provinces/1/cities)
 - Get city belongs to province id by city id : [`http://127.0.0.1:8000/api/provinces/{provinceId}/cities/{id}`](http://127.0.0.1:8000/api/provinces/1/cities/114)
 - Search cities belongs to province id by city name : [`http://127.0.0.1:8000/api/provinces/{provinceId}/cities?keyword={keyword}`](http://127.0.0.1:8000/api/provinces/1/cities?keyword=karta)

### Format Response
 In a successful response, API will return a response with HTTP Status Code 2xx and JSON in this format:

    {
        "success": true,
        "message": "Request success.",
        "data": {
            "province_id": "1",
            "province": "Bali",
        }
    }

 > _data_ key in the response must be either a single resource or an array of resource

 Then, in a failed response, API will return a response with HTTP Status Code 4xx or 5xx and JSON in this format:

    {
        "success": false,
        "message": "Request failed.",
        "errors": [
            "province_id": "Province ID is invalid.",
            "city_id": "City ID is invalid.",
        ]
    }

 > _errors_ key in the failed response must be an array that every _key_ is taken from the request body key and _value_ declare the error message