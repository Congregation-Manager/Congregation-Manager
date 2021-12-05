Congregation Manager
========================
Tool to manage Congregation based on Symfony framework

Requirements
------------

* PHP 8.0 or higher;
* PDO PHP extension enabled (as you prefer);
* [Git][git];
* and the [usual Symfony application requirements][requirements].

Installation
------------

Move to the desired folder and clone the repository by launching one of the following commands:

```bash
git clone git@github.com:lruozzi9/congregation-manager.git # for SSH
git clone https://github.com/lruozzi9/congregation-manager.git # for HTTPS auth
gh repo clone lruozzi9/congregation-manager # if you have the GitHub CLI
```

Move to the project dir:

```bash
cd congregation-manager
```

Install composer dependencies:

```bash
composer install --no-dev # For production
composer install # For development
```

Usage
-----

You can install or develop on this project using both:

 - Local runtime environment: in this setup the webserver and PHP is installed and run directly on your machine. Only services (Postgres, MailHog, etc...) run with Docker containers. This setup is especially useful on macOS where using a Docker runtime results in bad performances due to filesystem sync latency with bind mounted volumes.
 - Docker runtime environment: in this setup both the runtime and services are run on Docker containers.

### Local runtime environment

First, you have to configure your env variables by creating the .env.local file.

    touch .env.local

Now you need to copy the local runtime docker-compose.yml example.

    cp docker.compose.override.local-runtime-sample.yml docker.compose.override.yml

Then change the env variables with the previous one.

Run the docker services.

    docker-composer up -d

There's no need to configure anything to run the application. If you have
[installed Symfony][symfony_cli] binary, run this command:

```bash
symfony serve
```

Then access the application in your browser at the given URL (<https://localhost:8000> by default).

If you don't have the Symfony binary installed, run `php -S localhost:8000 -t public/`
to use the built-in PHP web server or [configure a web server][web_server] like Nginx or
Apache to run the application.

### Docker runtime environment

[WIP][#4]

Tests
-----

Create your test environment database by creating a custom .env.test.local.

Execute this command to run tests:

```bash
composer run test
```

[git]: https://git-scm.com/
[requirements]: https://symfony.com/doc/current/reference/requirements.html
[symfony_cli]: https://symfony.com/download
[web_server]: https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
[#4]: https://github.com/lruozzi9/congregation-manager/issues/4
