EXTENSION := ConfIDentSkin

MW_VERSION ?= 1.35
CHAMELEON_VERSION ?= 4.1.0

EXTENSION_FOLDER := /var/www/html/extensions/${EXTENSION}
COVERAGE_FOLDER := ${EXTENSION_FOLDER}/coverage
PWD := $(shell bash -c "pwd -W 2>/dev/null || pwd")# this way it works on Windows and Linux
IMAGE_NAME := confident-skin:test-${MW_VERSION}-${CHAMELEON_VERSION}
DOCKER_RUN := docker run --rm -v ${PWD}/coverage:${COVERAGE_FOLDER} ${IMAGE_NAME}
PHPUNIT := ${DOCKER_RUN} php tests/phpunit/phpunit.php --testdox -c ${EXTENSION_FOLDER}
NPM := docker run --rm -v ${PWD}/coverage:${COVERAGE_FOLDER} -w ${EXTENSION_FOLDER} ${IMAGE_NAME} npm

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
test: phpunit npm-test

.PHONY: test-coverage
test-coverage: phpunit-coverage npm-test-coverage

.PHONY: phpunit
phpunit:
	${PHPUNIT} ${EXTENSION_FOLDER}/tests/phpunit

.PHONY:
phpunit-coverage:
	${PHPUNIT} ${EXTENSION_FOLDER}/tests/phpunit \
		--coverage-html ${COVERAGE_FOLDER}/php \
		--coverage-clover ${COVERAGE_FOLDER}/php/coverage.xml

.PHONY: npm-test
npm-test:
	${NPM} run test

.PHONY: npm-test-coverage
npm-test-coverage:
	${NPM} run test-coverage
