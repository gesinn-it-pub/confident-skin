MW_VERSION ?= 1.35
CHAMELEON_VERSION ?= 4.1.0

PWD := $(shell bash -c "pwd -W 2>/dev/null || pwd")# this way it works on Windows and Linux
IMAGE_NAME := confident-skin:test-${MW_VERSION}-${CHAMELEON_VERSION}
DOCKER_RUN := docker run --rm -v ${PWD}/coverage:/var/www/html/coverage ${IMAGE_NAME}
PHPUNIT := ${DOCKER_RUN} php tests/phpunit/phpunit.php --testdox

test:
	make build phpunit

test-coverage:
	make build phpunit-coverage

build:
	docker build --tag ${IMAGE_NAME} \
		--build-arg=MW_VERSION=${MW_VERSION} \
		--build-arg=CHAMELEON_VERSION=${CHAMELEON_VERSION} \
		.

phpunit:
	${PHPUNIT} -c extensions/ConfIDentSkin extensions/ConfIDentSkin/tests/phpunit

phpunit-coverage:
	${PHPUNIT} -c extensions/ConfIDentSkin extensions/ConfIDentSkin/tests/phpunit \
		--coverage-html coverage/php \
		--coverage-clover coverage/php/coverage.xml
