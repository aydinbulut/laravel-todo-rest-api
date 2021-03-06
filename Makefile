MAKEFILE_DIRECTORY_API := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
export PROJECT_LOCATION_API := $(shell echo ${MAKEFILE_DIRECTORY_API})

VENDOR                  = ${PROJECT_LOCATION_API}src/api/vendor/bin/
PROJECT_LOCATION_CLIENT = ${PROJECT_LOCATION_API}src/client/
YARN                    = yarn --cwd ${PROJECT_LOCATION_CLIENT}
DOCKER_COMPOSE          = docker-compose


##
## =============================================================================
##   Docker Environment
## =============================================================================
##

env-start: ## Start the environment
	$(DOCKER_COMPOSE) up -d --remove-orphans
	make env-ps

env-stop: ## Stop the environment
	$(DOCKER_COMPOSE) stop

env-down: ## Stop and remove containers, networks, images, and volumes
	$(DOCKER_COMPOSE) down

env-restart: ## Restart the environment
	make env-stop
	make env-start

env-logs: ## Follow logs generated by all containers
	$(DOCKER_COMPOSE) logs -f --tail=0

env-logs-full: ## Follow logs generated by all containers from the containers creation
	$(DOCKER_COMPOSE) logs -f

env-gomysql: ## Open a terminal in the "mysql" container
	$(DOCKER_COMPOSE) exec mysql sh -c "/bin/bash"

env-goapp: ## Open a terminal in the "php" container
	$(DOCKER_COMPOSE) exec app sh -c "/bin/bash"

env-gonginx: ## Open a terminal in the "nginx" container
	$(DOCKER_COMPOSE) exec nginx sh -c "/bin/bash"

env-ps: ## List all containers managed by the environment
	$(DOCKER_COMPOSE) ps

env-stats: ## Print real-time statistics about containers ressources usage
	$(DOCKER) stats $(docker ps --format={{.Names}})

.PHONY: env-start env-stop env-down env-restart env-logs env-logs-full env-gomysql env-goapp env-gonginx env-ps env-stats


##
## =============================================================================
##   API OPS
## =============================================================================
##

api-migrate: ## Migrate the database
	$(DOCKER_COMPOSE) exec app sh -c "php artisan migrate"

api-seed: ## Seed(populate) the database with fake data
	$(DOCKER_COMPOSE) exec app sh -c "php artisan db:seed"

api-migrate-seed: ## Migrate and seed the database
	make api-migrate
	make api-seed

.PHONY: api-migrate api-seed api-migrate_seed


.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' \
		| sed -e 's/\[32m##/[33m/'
.PHONY: help
