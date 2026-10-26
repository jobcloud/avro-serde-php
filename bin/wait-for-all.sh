#!/usr/bin/env bash

ZOOKEEPER_IPV4=${ZOOKEEPER_IPV4:-localhost}
KAFKA_BROKER_IPV4=${KAFKA_BROKER_IPV4:-localhost}
SCHEMA_REGISTRY_IPV4=${SCHEMA_REGISTRY_IPV4:-localhost}

# With DOCKER_NETWORK set, the checks run inside that network. This is required on
# macOS, where containers are not reachable from the host by their IP address.
wait_for() {
    if [ -n "${DOCKER_NETWORK:-}" ]; then
        docker run --rm --network "${DOCKER_NETWORK}" -v "${PWD}/bin":/wait:ro php:8.2-cli bash /wait/wait-for-it.sh "$@"
    else
        bin/wait-for-it.sh "$@"
    fi
}

# KRaft setups (docker-compose.kraft.yml) have no ZooKeeper
if [[ "${COMPOSE_FILE:-}" != *kraft* ]]; then
    wait_for "${ZOOKEEPER_IPV4}:2181" -t 60 -- echo "zookeeper is up"
fi
wait_for "${KAFKA_BROKER_IPV4}:9092" -t 60 -- echo "kafka broker is up"
wait_for "${SCHEMA_REGISTRY_IPV4}:8081" -t 60 -- echo "schema registry is up"
