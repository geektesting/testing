# composer and install

install: setup setup-js create-env autoload

setup: 
	composer install

setup-js:
	cd public/assets/ && npm install

update:
	composer update

autoload:
	composer dump-autoload -o

create-env:
	cd config/ && cp -n .env.example .env || :

create-db:
	mysql -e 'CREATE DATABASE IF NOT EXISTS testing;'
	cd db/  mysql -u root testing < db.sql && \
    mysql -u root testing < cats.sql  && \
    mysql -u root testing < qcats.sql


# test
start-server:
	./vendor/php-kit/php-server/bin/php-server start -p 8001 -r public/ --global

stop-server:
	./vendor/php-kit/php-server/bin/php-server stop -p 8001

codecept: 
	./vendor/codeception/codeception/codecept run acceptance --debug

test: start-server codecept stop-server

lint:
	./vendor/bin/phpcs ./* --ignore=vendor/,tests/ --extensions=php --colors --standard=PSR1 -v


# npm and webpack

deploy:
	cd public/assets/ && npm run deploy

watch:
	cd public/assets/ && npm run watch &


# test js

test-js:
	cd public/assets/ && npm run test

lint-js:
	cd public/assets/ && npm run lint


# update local repo

remote-upstream:
	git remote add upstream https://github.com/geektesting/testing.git
	git remote -v

merge-upstream:
	 git fetch upstream
	 git checkout master
	 git merge upstream/master

get-last-changes: merge-upstream setup autoload


.PHONY: test
