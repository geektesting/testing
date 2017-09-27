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


# test

test: 
	./vendor/codeception/codeception/codecept run acceptance

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

merge-upstream:
	 git fetch upstream
	 git checkout master
	 git merge upstream/master

get-last-changes: merge-upstream setup autoload


.PHONY: test
