run:
	docker-compose up -d && \
	. ~/.nvm/nvm.sh && \
	nvm use && \
	npm run dev

composer:
	docker-compose exec web rm -rf /var/www/html/vendor && \
	docker-compose exec web composer install --working-dir /var/www/html/

composer-dry:
	docker-compose exec web rm -rf /var/www/html/vendor && \
	docker-compose exec web composer update --dry-run