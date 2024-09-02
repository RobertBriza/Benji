run:
	docker-compose up -d && \
	. ~/.nvm/nvm.sh && \
	nvm use v18.20.3 && \
	npm run dev
