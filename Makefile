.PHONY: app-install-back app-fix-permission app-install-front app-assets-watch app-assets-build app-cache-clear \
app-reset-data php-cs-fix php-cs-check js-cs-fix update cache-clear sonata-update-core-routes sonata-update-snapshots

include docker/Makefile

PROJECT_DIR ?= /var/www/html/site

env ?= dev

define run-in-container
	docker-compose exec --user $(1) -T $(2) /bin/sh -c "cd $(PROJECT_DIR) && $(3)";
endef

app-fix-permission:
	docker-compose exec --user root php sh -c "chmod -R 775 $(PROJECT_DIR)/var/*"
	docker-compose exec --user root php sh -c "chown -R www-data:www-data $(PROJECT_DIR)"

app-install-back:
	$(call run-in-container,www-data,php,composer install)

app-install-front:
	$(call run-in-container,root,node,npm install)

app-assets-watch:
	$(call run-in-container,root,node,npm run watch)

app-assets-build:
	$(call run-in-container,root,node,npm run dev)

app-cache-clear:
	$(call run-in-container,www-data,php,php bin/console cache:clear --env=${env})
	$(call run-in-container,www-data,php,php bin/console cache:warmup --env=${env})

app-data-reset:
	$(call run-in-container,www-data,php,php bin/console doctrine:database:create --if-not-exists)
	make app-unmigrate
	make app-migrate
	make app-fixture-load
	make app-cache-clear

app-unmigrate:
	$(call run-in-container,www-data,php,php bin/console doctrine:migration:migrate first)

app-migrate:
	$(call run-in-container,www-data,php,php bin/console doctrine:migration:migrate)

app-fixture-load:
	$(call run-in-container,www-data,php,php bin/console hautelook:fixtures:load --env=dev --no-interaction)

app-cs-fix:
	$(call run-in-container,www-data,php,./vendor/bin/php-cs-fixer fix --allow-risky=yes --show-progress=dots --verbose)

app-cs-check:
	$(call run-in-container,www-data,php,./vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run --diff --verbose)

app-test:
	$(call run-in-container,www-data,php,./bin/phpunit)

app-composer:
	$(call run-in-container,www-data,php,php -d memory_limit=-1 /usr/local/bin/composer $(TASK))

app-lint-yaml:
	$(call run-in-container,www-data,php,php bin/console lint:yaml config)

app-lint-twig:
	$(call run-in-container,www-data,php,php bin/console lint:twig templates)

sonata-update-core-routes:
	$(call run-in-container,www-data,php,php bin/console sonata:page:update-core-routes --site=all)

sonata-update-snapshots:
	$(call run-in-container,www-data,php,php bin/console sonata:page:create-snapshots --site=all)
