PHP_CMD = php
.DEFAULT_GOAL:=help
rebuild:
	@ echo "Esborrant la base de dades..."
	-$(PHP_CMD) bin/console doctrine:database:drop -n --force

	@ echo "Creant-la de nous..."
	$(PHP_CMD) bin/console doctrine:database:create -n

	@ echo "Creant l'estructura..."
	$(PHP_CMD) bin/console doctrine:migrations:migrate -n

	@ echo "Esborrant miniatures..."
	- $(PHP_CMD) bin/console liip:imagine:cache:remove -n


	@ echo "Esborrant i creant el directori si no existeix.."
	-rm -rf public/images
	-mkdir -p public/images/posters
	 chmod 777 -R public/images

	@ echo "Carregant les dades..."
	$(PHP_CMD) bin/console doctrine:fixtures:load -n

help:
	@ echo "Utilitza 'make rebuild' per a regenerar les dades"