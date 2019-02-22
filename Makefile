.PHONY: app-install-back app-fix-permission app-install-front app-assets-watch app-assets-build app-cache-clear \
app-reset-data php-cs-fix php-cs-check js-cs-fix update cache-clear

include docker/Makefile

PROJECT_DIR ?= /var/www/html/site

define run-in-container
	docker-compose exec --user $(1) -T $(2) /bin/sh -c "cd $(PROJECT_DIR) && $(3)";
endef

app-fix-permission:
	docker-compose exec --user root php sh -c "chmod -R 775 $(PROJECT_DIR)/var/*"
	docker-compose exec --user root php sh -c "chown -R www-data:www-data $(PROJECT_DIR)"

app-install-back:
	$(call run-in-container,www-data,php,composer install)

#app-install-front:
#	$(call run-in-container,root,node,npm install)
#
#app-assets-watch:
#	$(call run-in-container,root,node,npm run watch)
#
#app-assets-build:
#	$(call run-in-container,root,node,npm run dev)

app-cache-clear:
	$(call run-in-container,www-data,php,php bin/console cache:clear --env=${env})
	$(call run-in-container,www-data,php,php bin/console cache:warmup --env=${env})

#app-reset-data:
##	$(call run-in-container,www-data,php,php bin/console doctrine:database:drop --if-exists --force)
##	$(call run-in-container,www-data,php,php bin/console doctrine:database:create)
##	$(call run-in-container,www-data,php,php bin/console doctrine:schema:create)
#	$(call run-in-container,www-data,php,php bin/console doctrine:fixtures:load --no-interaction)
##	mkdir -p web/assets/mp3/test-mp3
##	cp src/Resources/fixtures/mp3/test-mp3 web/assets/mp3/ -r
#
#php-cs-fix:
#	$(call run-in-container,www-data,php,./vendor/bin/php-cs-fixer fix --allow-risky=yes src --diff --verbose)
#	$(call run-in-container,www-data,php,./vendor/bin/php-cs-fixer fix --allow-risky=yes tests --diff --verbose)
#
#php-cs-check:
#	$(call run-in-container,www-data,php,./vendor/bin/php-cs-fixer fix --allow-risky=yes src --dry-run --diff --verbose)
#
#js-cs-fix:
#	$(call run-in-container,root,node,./node_modules/.bin/eslint --fix  --ext .jsx --ext .js frontend/Dictation/)
#
#update:
#	git pull
#	npm run prod
#	php bin/console cache:clear --env=prod
#	php bin/console cache:warmup --env=prod

cache-clear:
	php bin/console cache:clear --env=prod
	php bin/console cache:warmup --env=prod
