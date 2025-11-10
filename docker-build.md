## Fazer login no gitlab registry

## Criar a imagem
```sh
docker build -t social-backend  . 
```

## Criar o container
```sh
docker run -d -p 8080:80 --name laravel-app social-backend
```
## Commitar o container
```sh
docker commit laravel-app registry.gitlab.com/mouragilvan/social-media-backend/social-backend:latest
```

## Subir a imagem
```sh
docker push registry.gitlab.com/mouragilvan/social-media-backend/social-backend:latest
```

## Comandos do Play Docker
```sh
docker login registry.gitlab.com
docker pull registry.gitlab.com/mouragilvan/social-media-backend/social-backend:latest
docker run -d -p 8080:80 --name social-backend registry.gitlab.com/mouragilvan/social-media-backend/social-backend:latest
```