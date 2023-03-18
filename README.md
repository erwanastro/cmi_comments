# MCI Comments

This project is a relative to a technical test for MCI. The aim of it is to develop a comment system.
The comments are related to a catalog of movies.

The catalog is public, but you need to log with your Google account in order to post some comments.

## Start the project

### Prerequisites

Docker is mandatory to start this project.

### Docker

You first need to up the docker containers:

```bash
docker-compose up
```

### Database

A postgres database will be instanced automatically through docker. But we'll need some movies in the catalog to make the project work:

```bash
bin/console doctrine:migration:migrate --no-interaction
bin/console doctrine:fixtures:load --no-interaction
```

### Google credentials

In order to allow the comment authors to log with their Google account, you need to fill the google secrets in the `.env` file by creating new `ID clients OAuth 2.0
` for your [google project](https://console.cloud.google.com/apis/credentials?hl=fr).

### Access through your preferred browser

There you go, launch the command `symfony serve` and access the application on [http://localhost:8000](http://localhost:8000).
