FROM jejem/php:8.2-apache

RUN apt-get update && apt-get install -y mariadb-client
COPY ./docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
