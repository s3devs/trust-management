# Qaravel (qaravel)

php artisan serve --host=api.ev2.gomedia  --port=80
c:\windows\system32\drivers\etc\hosts


[Qaravel](https://gitlab.com/DepokSarkar/qaravel) is a Combination of Laravel and Quasar

## Install the dependencies
```bash
yarn
```

## Add Configuration
```bash
cp .env.example .env
cp .env.frontend .env.frontend.dev
```

## Configuration for Laravel Sanctum

 We have used Laravel Sanctum SPA authentication. Laravel Sanctum provides a featherweight authentication system for SPAs (single page applications), mobile applications, and simple, token based APIs. Sanctum allows each user of your application to generate multiple API tokens for their account. These tokens may be granted abilities / scopes which specify which actions the tokens are allowed to perform. Please check laravel default [sanctum configuration](https://laravel.com/docs/8.x/sanctum#spa-authentication)

```bash
SANCTUM_STATEFUL_DOMAINS=jnelectrical.gomedia:8081 (for local you have to include your port)
SESSION_DOMAIN=.jnelectrical.gomedia
```

Add your database details on .env
Change your app url from .env.frontend.dev (if you want to deploy it in local) | .env.frontend and .env

## Migrate the Database
```bash
php artisan migrate:fresh --seed
```

### Start the app in development mode (hot-code reloading, error reporting, etc.)
```bash
yarn start:web
```

### Build the app for production
```bash
yarn build:web
```

### Lint the files
```bash
yarn run lint
```

### How to deply it in local?

Valet is a Laravel development environment for Mac minimalists. No Vagrant, no /etc/hosts file. You can even share your sites publicly using local tunnels. Yeah, we like it too. We used valet to deploy this project. Check the configuration of [Laravel Valet](https://laravel.com/docs/8.x/valet)

### How to deply it in web?

First build your app then move all files in server and run following command
```bash
cp .htaccess.example .htaccess
```

### Customize the configuration
See [Configuring quasar.conf.js](https://quasar.dev/quasar-cli/quasar-conf-js).
