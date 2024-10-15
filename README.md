## Install project
- Add database
- docker compose run --rm composer install
- Add .env and configure
- docker compose run --rm artisan key:generate
- docker compose run --rm artisan storage:link
- docker compose run --rm artisan migrate
- docker compose run --rm artisan passport:keys
- docker compose run --rm npm --service-ports install
- docker compose run --rm npm --service-ports run dev

## Docker Usage
- **nginx** - `:80`
- **mysql** - `:3306`
- **php** - `:9000`
- **redis** - `:6379`
- **mailhog** - `:8025` 
