# Rambutan Gallery

A photo management system based on the PHP Laravel Framework and VueJs.
The subject is inspired by Lychee: https://github.com/electerious/Lychee

This project is a prototypical approach for implementing the Event Sourcing & CQRS pattern currently under development in my spare time. Use at your own risk.
(I am aware that the subject is probably not a real world use case for ES/CQRS.)

The ES part relies on Broadway https://github.com/broadway/broadway 
and the patterns applied are following various tutorials and open source libraries on the matter. Only to mention some:

- Laravel Broadway Package: https://github.com/nWidart/Laravel-broadway + Demo Project
- Event Sourcing, CQRS and Laravel https://gistlog.co/scazz/e9e0f83d09fd9c3396b9

## Installation 

### Local development with Docker:

Requires:
- docker >= 17.0: https://www.docker.com/get-docker
- docker-compose >= 1.13: https://docs.docker.com/compose/install

It is using the [laradock](http://laradock.io) stack of docker containers. 

        cd docker
        cp env-example .env

After customizing .env if necessary run:
        
        docker-compose up -d


### Setup Laravel

    cp .env.example .env
    # Generate application key
    artisan key:generate
    # Install composer dependencies
    composer install
    # Run migrations inside workspace container
    cd docker && docker-compose exec --user=laradock workspace php artisan migrate --seed    


Navigate to [http://localhost](http://localhost) or create an entry in your `/etc/hosts`, e.g. `127.0.0.1 rambutan.local`


### Socket.IO

Rambutan uses Socket.IO https://socket.io/docs together with Redis for broadcasting updates from Server to Clients.

The server script at `./socket/app.js` is being hosted from the socketio container. In order to work the socketio host ip must be set in your .env.

Alternatively, the script can be run locally via node. It requires express, ioredis, socket.io to be installed as npm packages and must have access to the Redis instance.
