
# PT. FAN Integrasi Teknologi

PT. FAN Integrasi Teknologi

## Installation
clone project
```sh
git clone https://github.com/razisek/epresence-fan
```
change directory to project
```sh
cd epresence-fan
```
install dependency
```sh
composer install
```
setting on .env / copy from .env.example\
run migration
```sh
php artisan migrate
```
start the server
```sh
php artisan serve
```
## Unit Test
run this command to run unit testing

```sh
php artisan test
```
## Logic Test
run this command to run Logic Test
### 1. Count Socks

```sh
php artisan socks:count {number}
```
Example : 
```sh
php artisan socks:count 10 20 20 10 10 30 50 10 20
```
![Count Socks Image](https://i.ibb.co.com/94kF5X2/count-socks.png)
### 2. Count Words

```sh
php artisan words:count {sentence}
```
Example : 
```sh
php artisan words:count "Saat meng*ecat tembok, Agung dib_antu oleh Raihan."
```
![Count Words Image](https://i.ibb.co.com/PNz9dtf/count-word.png)
## Postman Documentation
[Click Here](https://restless-trinity-40572.postman.co/workspace/Public-~5e43965f-fffd-414b-8591-07d3287d4039/collection/8663357-a220728b-6dfe-44d8-b8ff-a7f240a16833?action=share&creator=8663357)

## Author
Rachma Azis