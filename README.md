**DigiTest**

To start:
1. Clone repository
2. Prepare your destination computer as in **http://laravel.com/docs/**
3. When copied, go to your destination folder and run **composer install**
4. Duplicate **.env.example** file and rename it to **.env**
5. In .env change access data to DB
6. Run **php artisan key:generate** from the command line.
7. Run **php artisan cache:clear** from command line
8. Run **php artisan migrate** or **php artisan migrate:refresh --seed** (for fake data) from command line
9. Run **php artisan passport:install** from command line
10. Make sure your webserver is serving pages from project/public folder.


API:
1. Register (or login if use seed - login: test@test.com, pass: 123456)
2. Login and go to API page
3. Create client or Token
4. In all request add in headers "Accept: application/json" and "Authorization: Bearer %YOUR_TOKEN%"
5. All methods and endpoint in ./routes/api.php and API interfaces in in the relevant Controller@methods in validation 

Web:
1. Login or Register after you take access to Transaction page

Cron:
1. File with command in root of project ./crontab.txt
