install:
	composer install

console:
	psysh --config psysh.php

lint:
	composer run-script phpcs -- --standard=PSR2 src tests

lint-fix:
	composer run-script phpcbf -- --standard=PSR2 src bin

test:
	composer run-script phpunit tests
