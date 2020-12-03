#The application can be run in two ways.
##1) Normal conventional way 
    Create database 'makeabet'
    composer update    
    php artisan migrate
    php artisan serve --port=8080
##2) Using Docker
    sudo docker-compose up -d --build
    sudo docker-compose run  --rm artisan migrate
    
    --To login to mysql server--
    mysql -h 127.0.0.1  -uroot  -p
    
###Please refer to the postman collection, inside the project root for APIs

##Troubleshoot
    sudo chmod +777 -R bootstrap/*
    sudo chmod +777 -R storage/*
    php artisan config:cache
    php artisan view:clear
    php artisan module:optimize
    php artisan optimize
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    composer dump-autoload
~~~~
