### Pigeon API ###
Service support UserPigeon.

### Requirements

- PHP 8.0 or newer
- [Composer](http://getcomposer.org)
- [Lumen](https://lumen.laravel.com/)
- Docker and Docker Compose
- Approach DDD architecture.

### Documentation ###
```
http://localhost/api/documentation
```

### Database ###
the database and sql script pushed in the database/ folder.

### Improve in the future ###
- Add caching layer to retrieve pigeon info and order by day.
- Currently, I apply binary search algorithm to find the position O(nlog(n)). 
We can find other alg with Big O smaller.


### Installation
Clone the repository:

```bash
https://github.com/cuongvm/pigeon-api
```

Copy the `.env` file

```
cp env.example .env
```

Build docker image (cached or non-cache)

```
docker-compose build
```

```
docker-compose build --no-cache
```

Run docker image

```
docker-compose up
```

Run the following command to install the package through Composer:

```bash
docker-compose exec php composer install
```

Stop docker

```
docker-compose down
```
