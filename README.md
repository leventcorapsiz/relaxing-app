## Installation via Docker

Clone repository & install dependencies 
  
     docker run --rm \
         -v $(pwd):/opt \
         -w /opt \
         laravelsail/php80-composer:latest \
         composer install
     
Update your hosts file with your docker/docker-machine ip

     192.168.99.100 relaxing-app.test

Set env

     cp .env.example .env     
     
Boot containers

      ./vendor/bin/sail up -d   