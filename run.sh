#!/bin/bash

docker build -t processo_seletivo_docker .
docker run -it -p 8000:8000 processo_seletivo_docker bash -c "php artisan serve --host=0.0.0.0 --port=8000"
# para rodar a aplicação, rode o comando php artisan serve --host=0.0.0.0 --port=8000  