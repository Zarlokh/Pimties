DC=docker compose
DC-EXEC=$(DC) exec
DC-EXEC-PHP-NO-TTY=$(DC-EXEC) -T --user=1000 php
DC-EXEC-PHP=$(DC-EXEC) --user=1000 php
DC-EXEC-PHP-ROOT=$(DC-EXEC) php

##Install :
init-git-hook:
	./tools/install/init-git-hook.sh

##Containers :
php:		## Se connecte au container php
	$(DC-EXEC-PHP) bash

php-root:	## Se connecte au container php en root
	$(DC-EXEC-PHP-ROOT) bash

##Quality :
all-quality: php-cs-fixer psalm	## Lance php-cs-fixer et psalm

php-cs-fixer:	## Lance php-cs-fixer
	$(DC-EXEC-PHP-NO-TTY) tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src

psalm:	## Lance psalm
	$(DC-EXEC-PHP-NO-TTY) ./tools/psalm/psalm.phar

##HELP
help:                                                        ## show the help
	@grep -E '(^[0-9a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.DEFAULT_GOAL := help
