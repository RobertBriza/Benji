run:
	docker-compose up -d && \
	. ~/.nvm/nvm.sh && \
	nvm use && \
	npm run dev
