#1. bang

##[ Endpoint ]
* /properties: POST, GET </br>
* /properties/{property_id}: GET, PUT </br>
* /properties/{property_id}/roomtypes: POST, GET
</br>
<hr/>

#2. Requirments

##[ Git ]
### git clone
```sh
git clone git@github.com:yjkim0/bang.git .
```

</br>

##[ Docker ]
###docker install
* [docker for mac](https://download.docker.com/mac/stable/Docker.dmg)

###docker setup
```sh
docker pull yjkim0/php-travis
docker run -d -v `pwd`:/var/www -p 3307:3306 -p 8000:80 --name php-travis yjkim0/php-travis
docker exec php-travis /bin/sh -c "cd /var/www; composer update"
docker exec php-travis /bin/sh -c "cd /var/www; ./vendor/bin/phpcs -sw --standard=PSR2 --ignore=config.php app"
docker exec php-travis /bin/sh -c "cd /var/www; ./vendor/bin/phpmd app text cleancode"
docker exec php-travis /bin/sh -c "cd /var/www; phpunit"
```
* docker run 실행 시  위  Git clone한 디렉토리에서 수행

###docker bash connect
```sh
docker exec -it php-travis bash
```

</br>

##[ PHPUnit Test ]
###Test Commands in docker
```sh
docker exec php-travis /bin/sh -c "cd /var/www; phpunit ./tests/roomtypetest"
```
