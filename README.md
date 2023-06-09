# Laravel Vue starter kit

Admin user

    E-mail: admin@example.com
    Password: password

Normal user

    E-mail: collaborator@example.com
    Password: password


## Main dependencies

###Front-end:
##
#####Vue
 [Vue](https://github.com/vuejs/vue)
is a progressive framework for building user interfaces.
Unlike other monolithic frameworks, Vue is designed from the ground 
up to be incrementally adoptable. The core library is focused on the 
view layer only, and is easy to pick up and integrate with other libraries
or existing projects. On the other hand, Vue is also perfectly capable 
of powering sophisticated Single-Page Applications when used in combination with [modern tooling](https://vuejs.org/v2/guide/single-file-components.html) and [supporting libraries](https://github.com/vuejs/awesome-vue#components--libraries).
 ##
#####VueRouter  
With Vue.js, we are already composing our application with components.
When adding [VueRouter](https://github.com/vuejs/vue-router) to the mix,
all we need to do is map our components to the routes and let vue-router
know where to render them. In our applications we can manage the routes 
in resources/assets/vue/router/index.ts .
By injecting the router, we get access to it as this.$router as well
 as the current route as this.$route inside of any component.
 <router-link> automatically gets the .router-link-active class when its 
 target route is matched. You can learn more about it in its [API reference](https://router.vuejs.org/en/api/router-link.html).
##
#####Vuex
[Vuex](https://github.com/vuejs/vuex) is a state management pattern + library for Vue.js applications.
 It serves as a centralized store for all the components in an application, 
 with rules ensuring that the state can only be mutated in a predictable fashion. 
 It also integrates with Vue's official [devtools extension](https://github.com/vuejs/vue-devtools) to provide advanced features
  such as zero-config
 time-travel debugging and state snapshot export / import.
 ##
#####vuex-i18n
The [vuex-i18n](https://github.com/dkfbasel/vuex-i18n) plugin provides a vuex module to store localization information and translations
and a plugin to allow easy access from components.
##
#####Vue Auth
 [Vue Auth](https://github.com/websanova/vue-auth) is a simple light-weight authentication library for Vue.js
##       
#####Bootstrap 4      
 [Bootstrap 4](https://github.com/twbs/bootstrap) HTML, CSS, and JavaScript framework for developing responsive, mobile first projects on the web.
##
#####BootstrapVue
[BootstrapVue](https://github.com/bootstrap-vue/bootstrap-vue) 
 provides one of the most comprehensive implementations of Bootstrap 4 components and grid
  system for Vue.js and with extensive and automated WAI-ARIA accessibility markup
  for more information about Bootstrap vue click [here](https://bootstrap-vue.js.org) 
##
#####Font Awesome
[Font Awesome](https://github.com/FortAwesome/Font-Awesome) to learn more click [here](https://github.com/FortAwesome/Font-Awesome)
##
#####TypeScript
 [TypeScript](https://github.com/microsoft/typescript) is a language for application-scale JavaScript. TypeScript adds optional types, classes, and modules to JavaScript. TypeScript supports tools for large-scale JavaScript applications for any browser, for any host, on any OS. TypeScript compiles to readable, standards-based JavaScript.
##
#####Pug
 [Pug](https://github.com/pugjs/pug) is a high-performance template engine heavily influenced by Haml and implemented with JavaScript for Node.js and browsers.
##
#####Sass
 [Sass](https://github.com/sass/node-sass)
##
#####Laravel Mix
 [Laravel Mix](https://github.com/JeffreyWay/laravel-mix) provides a clean, fluent API for defining basic [webpack](https://github.com/webpack/webpack) build steps for your Laravel application.
 Mix supports several common CSS and JavaScript pre-processors.
Form more information about Laravel mix click [here](https://github.com/JeffreyWay/laravel-mix/tree/master/docs#readme) 
##
#####Jest

[Jest](https://github.com/facebook/jest) in our project we use jest for simple javascript testing
The TypeScript code tries to follow the [Airbnb JavaScript Style Guide](https://github.com/airbnb/javascript), the linters are already included and configured.

##
##
###Back-end:
##
 [Laravel](https://github.com/laravel/laravel)
##
[jwt-auth](https://github.com/tymondesigns/jwt-auth) is a JSON Web Token Authentication for Laravel & Lumen 
##
[laravel-vue-i18n-generator](https://github.com/martinlindhe/laravel-vue-i18n-generator)
is a Laravel 5 package that allows you to share our [Laravel localizations](https://laravel.com/docs/5.1/localization) with our vue front-end, using [vue-i18n](https://github.com/kazupon/vue-i18n) or [vuex-i18n](https://github.com/kazupon/vue-i18n).
##
[PHPUnit](https://github.com/sebastianbergmann/phpunit) is a programmer-oriented testing framework for PHP.
 It is an instance of the xUnit architecture for unit testing frameworks.

[Larastan](https://github.com/nunomaduro/larastan) is static analisis of php code. It can found wrong initialization of variables, wrong parameter or return type in PHPDoc.
Configuration is in website\phpstan.neon.dist

##
## Steps to run it:

Remember to search for "TODO change" on the files to change example code.

### Common way



Install PHP and JavaScript dependencies:

    composer install
    yarn

Copy file .env.example to .env
    
    cp .env.example .env

Fill the parameters in .env 


Generate Laravel keys:

    php artisan key:generate

Generate JWT keys

    php artisan jwt:secret

Generate i18n string for Vue, based on Laravel i18n files:

    php artisan vue-i18n:generate

Migrate and seed the database:

    php artisan migrate --seed

(If you get ErrorException::("PDOStatement::execute(): MySQL server has gone away") Raise max_allowed_packet in my.cnf (under [mysqld]) to 8 or 16M .)

Compile all the front-end stuff:

    yarn watch

    - OR -

    yarn prod

Run the server:

    php artisan serve

        - OR -

    php -S localhost:8000 -t public

Open the application in the browser:

    FE: http://localhost:8000
    BE: http://localhost:8000/admin

Test:

    php artisan code:analyse 
      or 
    php artisan code:analyse --paths="app/Applications/Common"

    composer test
    yarn test

##
## Starter Kit Development Workflow

###Folder Structure

1. Front End
  All the frontend dependencies (website/resources/assets)
  Sass code (website/resources/assets/sass)

  Vue code (website/resources/assets/vue)
    Main Vue instance file (website/resources/assets/vue/app.ts)
      Global JS settings (website/resources/assets/vue/bootstrap.js)
      All encompassing App component (website/resources/assets/vue/App.vue)


2. Back End
  Routes for api (website/routes)
  per feature (website/app/Applications)


###Git Workflow

1. Main branch structure
  Development branch with tools and code used for dev (development)
  QA branch deployed on QA server instance for in house testing (qa)
  Staging branch deployed on staging server instance for client testing (staging)
  Prod branch for production value code (prod)

2. Create a new branch for each feature, task or bug
  Naming convention example: git checkout -b task/21465-some-tasks-name-here

3. When ready locally and developer tested merge to development branch, when QA approved merge to staging.

###Task Workflow

  DEV advice: open git annotations for a commit that is similar to the task at hand to see all the changes made

1. Front End (VueJs Components)

  Add the route (website/resources/assets/vue/router/index.ts)
  Create the view that will be the wrapper for the component (website/resources/assets/vue/views)
  Create and add all the components for that feature (website/resources/assets/vue/features)
  Define your variables, try to use types (website/resources/assets/vue/typings)
  For reusable components use (website/resources/assets/vue/components)
  Add constructor to component where initial values of variables are set

  random: sidebar menu items array comes from HomeController.php

2. Back End (Laravel API) 

3. Combined

  Localization
    Static translations are input in associative arrays (website/resources/lang/en)
    and run 'php artisan vue-i18:generate'
    In VueJs the component is website/resources/assets/vue/components/Translation/Locales.vue


###Bug Workflow

1. Front end debugging
  Vue developers tool
  conventional browser debugging
  
### Docker instructions
1. install
- git
- docker https://docs.docker.com/engine/install/ubuntu/
- docker-compose https://docs.docker.com/compose/install/
2. git clone git clone git@bitbucket.org:stefanov/p781-eventlokale.git
3. copy dev_env/sample-linux.env or sample-windows dev_env/.env and modify if needed
- the linux version should work without modification
- for windows you will need to modify the DOCUMENT_ROOT and NODE_ROOT
- paths with ~ will not work. Using the full paths (ex. /home/username/something)
4. If you want to use the default port versions set in the .env file you will need to turn of the apache mysql and redis services if you have them locally
5. From dev_env run:
- docker-compose build
- docker-compose up
6. Test if the container volumes mounted succesfully
- sudo docker exec -it eventlokale-php72 /bin/bash and than look for the project inside the eventlokale directory
- sudo docker exec -it eventlokale-node /bin/bash and than look for the project inside the usr/app directory
7. If there is some issue with the docker configuration at this point and you have previosely run an older configuration please try clearing the cache from the broken docker-compose version
- docker system prune -a
- and go through steps 5 and 6 again
8. Copy website/sample-dev-env.env to website/.env
9. Go to workbench or phpmyadmin and create database schema eventlokale
- import database dump from the dev server
10. docker exec -it lamp-php72 /bin/bash
- run: composer install && php artisan config:cache && php artisan view:clear && php artisan route:clear && composer dump-autoload && php artisan vue-i18n-custom:generate && php artisan migrate
11. (This step seems to not be needed) Go to website/ outside of docker and run:
- echo $USER (Use the username output from this command for the next in place of $USER)
- sudo chown -R www-data. . && sudo setfacl -R -m u:$USER:rwx .
12. Possible errors
- eventlokale-node | error Couldn't find a package.json file in "/usr/app" (NODE_ROOT=~/development/repositories/starter/website is missing from the env file. The path is just an example)
- Got permission denied while trying to connect to the Docker daemon socket at unix:///var/run/docker.sock: Get ..... (Run the command with elevated permissions on ubuntu sudo.)
- Command 'composer' not found, but can be installed with (did you run the command inside the container after executing the previos line?)
- inside eventlokale-node yarn nuxt:dev fails with Unexpected token u in JSON at position ... in nuxt-config.ts (the issue here is that the .env file is missing or the variable is not defined)

13. Usefull commands:
- docker ps -a (Get a list of all running or failed containers)
- docker exec -it eventlokale-php72 /bin/bash (execute commands inside a container)
- docker-compose run node /bin/bash (run a container for a service defined in the docker-compose.yaml file. You will have to execute this command from the dev_env folder)
- docker system prune -a (clear all docker cache containers networks etc ... This will remove docker containers for other projects too not just eventlokale)
