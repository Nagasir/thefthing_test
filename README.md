## How To Start

Do the following steps inside the root folder to run this app

1. `docker-compose up -d --build`
2. `docker-compose run --rm composer install`
3. `docker-compose run --rm artisan migrate --seed`
4. `docker-compose run --rm npm run dev`
3. Access the app on http://localhost:7777
