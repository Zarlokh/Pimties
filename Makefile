DC=docker compose
EXEC=$(DC) exec
EXEC-PHP-NO-TTY=$(EXEC) -T --user=1000 php
EXEC-PHP=$(EXEC) --user=1000 php
EXEC-PHP-ROOT=$(EXEC) php
RUN-NODE=$(DC) run --rm node
RUN-NODE-TI=$(DC) run --rm -Ti node

##Install :
install: init-git-hook npm-install-build	## Installe le projet
init-git-hook:	## Installe les git-hook
	./tools/install/init-git-hook.sh
npm-install:	## Lance un npm install
	$(RUN-NODE) npm install
npm-build:	## Lance un npm run build
	$(RUN-NODE) npm run build
npm-watch:	## Lance un npm run watch
	$(RUN-NODE-TI) npm run watch
npm-install-build: npm-install npm-build	## Lance un npm-install suivi d'un npm-build

##Containers :
php:		## Se connecte au container php
	$(EXEC-PHP) bash

php-root:	## Se connecte au container php en root
	$(EXEC-PHP-ROOT) bash

##Quality :
all-quality: php-cs-fixer psalm	## Lance php-cs-fixer et psalm

php-cs-fixer:	## Lance php-cs-fixer
	$(EXEC-PHP-NO-TTY) tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src

psalm:	## Lance psalm
	$(EXEC-PHP-NO-TTY) ./tools/psalm/psalm.phar

##HELP
help:                                                        ## show the help
	@grep -E '(^[0-9a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.DEFAULT_GOAL := help
