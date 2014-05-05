ci: composer-validate phpmd phpcs php-cs-fixer

composer-validate:
	./composer.phar validate

phpmd:
	./vendor/bin/phpmd ./src text codesize,controversial,design,naming,unusedcode
	./vendor/bin/phpmd ./tests text codesize,controversial,design,naming,unusedcode

phpcs:
	./vendor/bin/phpcs --standard=psr2 ./src
	./vendor/bin/phpcs --standard=psr2 ./tests

php-cs-fixer:
	./vendor/bin/php-cs-fixer --dry-run --verbose fix ./src --fixers=unused_use
	./vendor/bin/php-cs-fixer --dry-run --verbose fix ./tests --fixers=unused_use

phpunit:
	./vendor/bin/phpunit
