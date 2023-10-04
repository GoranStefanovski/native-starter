# DOCKER TASKS

starter-node-shell: ## Run node container
	docker exec -it starter-node /bin/bash

starter-php-shell: ## Run PHP container
	docker exec -it starter-php8 /bin/bash

starter-mongo-shell: ## Run MongoDB container
	docker exec -it starter-mongo bash
