#!/bin/bash
export WEBSERVER_MODE=artisan
docker network inspect felps-pdi-02-network >/dev/null 2>&1 || docker network create --driver bridge felps-pdi-02-network
docker image rm felpspdi02 --force
docker build --build-arg UID=$(id -u) --build-arg GID=$(id -g) --build-arg USER=${USER} -t felpspdi02 -f .docker/install/Dockerfile .
docker compose build --build-arg UID=$(id -u) --build-arg GID=$(id -g) --build-arg USER=${USER}
