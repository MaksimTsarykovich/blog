
FROM mysql:latest


ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=app
ENV MYSQL_USER=user
ENV MYSQL_PASSWORD=password

COPY my.cnf /etc/mysql/conf.d/

COPY init.sql /docker-entrypoint-initdb.d/

EXPOSE 3306