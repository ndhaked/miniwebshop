## About Project

Laravel verison 10.0

PHP v: 8.2

Clone Project from git https://github.com/ndhaked/miniwebshop.git

git clone https://github.com/ndhaked/miniwebshop.git

STEP 1: Run Command: composer update

STEP 2: Run Command: php artisan module:migrate Api

STEP 3: Run Command: php artisan module:seed Api

STEP 4: Run Command: php artisan serve

API URL: http://127.0.0.1:8000

1) http://127.0.0.1:8000/api/orders GET : Get All Orders
2) http://127.0.0.1:8000/api/orders/add POST : Add New Order
3) http://127.0.0.1:8000/api/orders/{id}/update POST : Update Order
4) http://127.0.0.1:8000/api/orders/{id} DELETE : Delete Order
5) http://127.0.0.1:8000/api/orders/{id}/add POST : Add Product To Order
6) http://127.0.0.1:8000/api/orders/{id}/pay POST : Create Payment Order
