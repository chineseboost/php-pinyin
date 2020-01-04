.PHONY: fix
fix: src tests vendor/autoload.php
	./vendor/bin/php-cs-fixer fix

.PHONY: test
test: src tests vendor/autoload.php
	./vendor/phpmd/phpmd/src/bin/phpmd src text \
		controversial,naming,unusedcode
	./vendor/squizlabs/php_codesniffer/bin/phpcs --standard=PSR2 --colors src
	./vendor/phpunit/phpunit/phpunit

vendor/autoload.php:
	composer install

.PHONY: coverage
coverage: src tests vendor/autoload.php
	mkdir -p build
	rm -rf build/*
	./vendor/phpmd/phpmd/src/bin/phpmd src text \
			controversial,naming,unusedcode \
			--reportfile ./build/phpmd.xml
	./vendor/squizlabs/php_codesniffer/bin/phpcs --standard=PSR2 --colors src \
		--report-file=./build/phpcs.xml
	./vendor/phpunit/phpunit/phpunit --coverage-clover=build/logs/clover.xml \
		--coverage-html=build/coverage --coverage-text
