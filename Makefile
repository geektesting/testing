install: 
	composer install

test: 
	phpunit tests/mytestsuite.php

lint:
	./vendor/bin/phpcs public/ --extensions=php --colors --standard=PSR1 -v

remote-upstream:
	git remote add upstream https://github.com/geektesting/testing.git
	git remote -v

get-last-changes:
	 git fetch upstream
	 git checkout master
	 git merge upstream/master

.PHONY: test