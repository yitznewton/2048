ci: composer-validate phpmd phpcs php-cs-fixer phpunit

composer-validate:
	./composer.phar validate

phpmd:
	./vendor/bin/phpmd ./src text codesize,controversial,design,naming,unusedcode

phpcs:
	./vendor/bin/phpcs --standard=psr2 ./src --standard=phpcs-ruleset.xml

php-cs-fixer:
	./vendor/bin/php-cs-fixer --dry-run --verbose fix ./src --fixers=unused_use

phpunit:
	./vendor/bin/phpunit
