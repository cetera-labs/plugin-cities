.DEFAULT_GOAL := docker

DOCKER = docker
DOCKER_COMPOSE = docker-compose
PROJECT_NAME = pcp
DOCKER_COMPOSE_FILE = -f ./docker-compose.yml
RUN_PHP=$(DOCKER_COMPOSE) $(DOCKER_COMPOSE_FILE) run -w"/var/www/_default" php


build:
	DOCKER_BUILDKIT=1 $(DOCKER_COMPOSE) build --progress=plain php

pull_images:
	$(DOCKER_COMPOSE) $(DOCKER_COMPOSE_FILE) pull

up:
	$(DOCKER_COMPOSE) $(DOCKER_COMPOSE_FILE) -p $(PROJECT_NAME) up

down:
	$(DOCKER_COMPOSE) $(DOCKER_COMPOSE_FILE) -p $(PROJECT_NAME) down

bash:
	$(RUN_PHP) bash