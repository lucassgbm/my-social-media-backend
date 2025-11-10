FROM webdevops/php-apache:8.2-alpine

WORKDIR /app

COPY . .
RUN mkdir storage/app/public/users/
COPY avatar.jpg storage/app/public/users/avatar.jpg
RUN chmod -R 777 storage