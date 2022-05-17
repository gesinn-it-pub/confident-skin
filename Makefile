MW_VERSION ?= 1.35
CHAMELEON_VERSION ?= 4.1.0

PWD := $(shell bash -c "pwd -W 2>/dev/null || pwd")# this way it works on Windows and Linux
IMAGE_NAME := confident-skin:test-${MW_VERSION}-${CHAMELEON_VERSION}
DOCKER_RUN := docker run --rm -v ${PWD}/coverage:/var/www/html/coverage ${IMAGE_NAME}
PHPUNIT := ${DOCKER_RUN} php tests/phpunit/phpunit.php --testdox
NPM := docker run --rm -v ${PWD}/coverage:/var/www/html/coverage -w /var/www/html/extensions/ConfIDentSkin ${IMAGE_NAME} npm

.PHONY: all
all:

.PHONY: ci
ci: build test

.PHONY: ci-coverage
ci-coverage: build test-coverage

.PHONY: build
build:
	docker build --tag ${IMAGE_NAME} \
		--build-arg=MW_VERSION=${MW_VERSION} \
		--build-arg=CHAMELEON_VERSION=${CHAMELEON_VERSION} \
		.

.PHONY: test
test: phpunit node-qunit

.PHONY: test-coverage
test-coverage: phpunit-coverage node-qunit-coverage

.PHONY: phpunit
phpunit:
	${PHPUNIT} -c extensions/ConfIDentSkin extensions/ConfIDentSkin/tests/phpunit

.PHONY:
phpunit-coverage:
	${PHPUNIT} -c extensions/ConfIDentSkin extensions/ConfIDentSkin/tests/phpunit \
		--coverage-html coverage/php \
		--coverage-clover coverage/php/coverage.xml

.PHONY: node-qunit
node-qunit:
	${NPM} run node-qunit

.PHONY: node-qunit-coverage
node-qunit-coverage:
	${NPM} run node-qunit-coverage
