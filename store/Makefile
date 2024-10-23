MAKE_BUILD=./.docker/build.sh

NIX_OS := $(shell uname -s)

ifeq ($(OS),Windows_NT)
	EXECUTABLE=winpty
else
	EXECUTABLE=
endif

ifeq ($(NIX_OS),Darwin)
	SED_ON=sed -i "" 's/OCTANE=0/OCTANE=1/g' .env
	SED_OFF=sed -i "" 's/OCTANE=1/OCTANE=0/g' .env
else
	SED_ON=sed -i 's/OCTANE=0/OCTANE=1/g' .env
	SED_OFF=sed -i 's/OCTANE=1/OCTANE=0/g' .env
endif

build: ## Build containers images
	make env && $(MAKE_BUILD)

migrate: ## Run migrations and seeds
	clear && $(EXECUTABLE) docker compose exec php bash -c "php artisan migrate && php artisan db:seed && php artisan route:clear"

install: ## Run composer, install vendor
	clear && docker compose up -d
	rm -rf vendor;\
	$(EXECUTABLE) docker run -it -v $(pwd):/var/www felpspdi02 bash -c "composer install && php artisan key:generate"

queue: ## Run migrate queue
	docker compose up -d && clear && $(EXECUTABLE) docker compose exec php bash -c "php artisan queue:work --sleep=3 --tries=3"

clear: ## Clear screen
	docker compose down && clear && $(EXECUTABLE) docker compose exec php bash -c "php artisan config:clear && php artisan cache:clear && php artisan route:clear"

start: ## Up containers with laravel serve
	export WEBSERVER_MODE=artisan ; \
    make env && $(SED_OFF) ; \
	docker compose up -d

start-octane: ## Up containers with octane
	export WEBSERVER_MODE=swoole ; \
    make env && $(SED_ON) ; \
	docker compose up -d

stop: ## Stop containers
	docker compose stop

ps: ## PS docker
	docker compose ps

logs: ## Logs docker
	docker compose logs -f $(container)

test-phpstan: ## run phpstan
	clear && $(EXECUTABLE) docker compose exec php bash -c "./vendor/bin/phpstan analyse --memory-limit=2G -a ./vendor/autoload.php $(phpfiles)"

test-pint: ## run pint
	clear && $(EXECUTABLE) docker compose exec php bash -c "./vendor/bin/pint"

test-pest: ## run tests with pest
	clear && $(EXECUTABLE) docker compose exec php bash -c "php artisan test"

env: ## Copy .env.example to .env
	if [ ! -f .env ] ; \
    then \
         cp .env.example .env ; \
    fi;

orphan-clear: ## Remove orphan container
	docker compose up -d --remove-orphans

shell: ## Access bash in, php container
	clear && $(EXECUTABLE) docker run -it -v $(pwd):/var/www felpspdi02 bash

shell-container: ## Access bash in, php container but, use docker-composer settings
	clear && $(EXECUTABLE) docker compose exec php bash

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help
