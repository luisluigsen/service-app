#!/bin/bash

OS = $(shell uname)
UID = $(shell id -u)
DOCKER_BE = monolith-service-app-be

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

start: ## Start the containers
	docker network create monolith-service-app-network || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	cp -n .env.dist .env || true
	U_ID=${UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

build: ## Rebuilds all the containers
	docker network create monolith-service-app-network || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	cp -n .env.dist .env || true
	U_ID=${UID} docker-compose build

prepare: ## Runs backend commands
	$(MAKE) composer-install
	$(MAKE) migrations
	$(MAKE) migrations-test

# Backend commands
composer-install: ## Installs composer dependencies
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} composer install --no-interaction

.PHONY: migrations
migrations: ## Run migrations for dev/prod environments
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} bin/console doctrine:migrations:migrate -n

migrations-test: ## Run migrations for test environments
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} bin/console doctrine:migrations:migrate -n --env=test

be-logs: ## Tails the Symfony dev log
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} tail -f var/log/dev.log
# End backend commands

ssh-be: ## bash into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash

code-style: ## Runs php-cs to fix code styling following Symfony rules
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} php-cs-fixer fix src --rules=@Symfony

.PHONY: tests
tests:
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} vendor/bin/simple-phpunit -c phpunit.xml.dist
