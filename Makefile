install: 
	composer install

test: 
	phpunit tests/mytestsuite.php

remote-upstream:
	git remote add upstream git@github.com:geektesting/testing.git
	git remote -v

get-last-changes:
	 git fetch upstream
	 git checkout master
	 git merge upstream/master

.PHONY: test