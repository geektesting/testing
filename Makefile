# composer

install: 
	composer install 
	cd public/assets/ && npm install

update:
	composer update

autoload:
	composer dump-autoload -o


# test

test: 
	phpunit tests/mytestsuite.php

lint:
	./vendor/bin/phpcs ./* --ignore=vendor/,tests/ --extensions=php --colors --standard=PSR1 -v


# npm and webpack

deploy:
	cd public/assets/ && npm run deploy

watch:
	cd public/assets/ && npm run watch


# test js

test-js:
	cd public/assets/ && npm run test

lint-js:
	cd public/assets/ && npm run lint


# update local repo

remote-upstream:
	git remote add upstream https://github.com/geektesting/testing.git
	git remote -v

get-last-changes:
	 git fetch upstream
	 git checkout master
	 git merge upstream/master

.PHONY: test