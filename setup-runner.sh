#!/bin/bash
set -e

# =====================================
# CONFIGURAÇÕES PERSONALIZÁVEIS
# =====================================
GITLAB_URL="https://gitlab.com"
GITLAB_TOKEN="glrt-KWv8ucIv4fkdZIFb4BX0Om86MQpwOjE4aTEwZgp0OjMKdToyanY5cBg.01.1j1pjouvb"
RUNNER_NAME="gitlab-runner-job"
RUNNER_IMAGE="gitlab/gitlab-runner:alpine-v17.6.1"
DOCKER_IMAGE_DEFAULT="docker:dind"
MEMORY="64m"
MEMORY_RESERVATION="32m"
MEMORY_SWAP="128m"
CPUS=".1"

# =====================================
# CRIAÇÃO DO VOLUME (se não existir)
# =====================================
if ! docker volume inspect gitlab-runner-config >/dev/null 2>&1; then
  echo "📦 Criando volume gitlab-runner-config..."
  docker volume create gitlab-runner-config >/dev/null
else
  echo "✅ Volume gitlab-runner-config já existe."
fi

# =====================================
# CRIAÇÃO DO CONTAINER (se não existir)
# =====================================
if ! docker ps -a --format '{{.Names}}' | grep -q "^${RUNNER_NAME}$"; then
  echo "🚀 Criando container ${RUNNER_NAME}..."
  docker run -d \
    --name "${RUNNER_NAME}" \
    --restart always \
    --memory-reservation "${MEMORY_RESERVATION}" \
    --memory "${MEMORY}" \
    --memory-swap "${MEMORY_SWAP}" \
    --cpus "${CPUS}" \
    -v /var/run/docker.sock:/var/run/docker.sock \
    -v gitlab-runner-config:/etc/gitlab-runner \
    -v /etc/timezone:/etc/timezone:ro \
    -v /usr/share/zoneinfo:/usr/share/zoneinfo:ro \
    "${RUNNER_IMAGE}"
else
  echo "✅ Container ${RUNNER_NAME} já existe."
fi

# =====================================
# REGISTRO DO RUNNER (se ainda não registrado)
# =====================================
echo "🧩 Verificando se o runner já está registrado..."
if ! docker exec "${RUNNER_NAME}" gitlab-runner list 2>/dev/null | grep -q "${RUNNER_NAME}"; then
  echo "🔧 Registrando runner no GitLab..."
  docker exec -it --privileged "${RUNNER_NAME}" gitlab-runner register --non-interactive \
    --url "${GITLAB_URL}" \
    --registration-token "${GITLAB_TOKEN}" \
    --executor "docker" \
    --docker-image "${DOCKER_IMAGE_DEFAULT}" \
    --docker-volumes "/var/run/docker.sock:/var/run/docker.sock" \
    --docker-privileged \
    --description "${RUNNER_NAME}" \
    --tag-list "docker,node,play" \
    --run-untagged="true" \
    --locked="false"
else
  echo "✅ Runner já está registrado."
fi

echo ""
echo "🎉 Runner configurado e em execução!"
docker ps | grep "${RUNNER_NAME}"
