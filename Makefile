ci: composer-validate phpmd phpcs php-cs-fixer phpunit

composer-validate:
	./composer.phar validate

phpmd:
	./vendor/bin/phpmd ./src text codesize,controversial,design,naming,unusedcode
	./vendor/bin/phpmd ./tests text codesize,controversial,design,naming,unusedcode

phpcs:
	./vendor/bin/phpcs --standard=psr2 ./src --standard=phpcs-ruleset.xml
	./vendor/bin/phpcs --standard=psr2 ./tests --standard=phpcs-ruleset.xml --ignore=./tests/manual_io/console_output.php

php-cs-fixer:
	./vendor/bin/php-cs-fixer --dry-run --verbose fix ./src --fixers=unused_use
	./vendor/bin/php-cs-fixer --dry-run --verbose fix ./tests --fixers=unused_use

phpunit:
	./vendor/bin/phpunit
