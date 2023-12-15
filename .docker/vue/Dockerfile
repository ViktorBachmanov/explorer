# syntax = docker/dockerfile:1

FROM node:18.18.2-slim as base
# FROM node:20.9.0-bullseye-slim as base

# Create container's user based on provided user ID if the current container's user id is not equal to host_uid 
ARG HOST_UID

RUN /bin/bash -c 'user_exists(){ id "$HOST_UID" &>/dev/null; }; \
if [[ $HOST_UID -ne $(id -u) ]] && ! user_exists; then adduser --disabled-password --gecos \"\" --uid $HOST_UID new_user; fi'

# Switch to that user
USER ${HOST_UID}

WORKDIR /src

# CMD tail -f /dev/null


#=================================================

# Build local
FROM base as build-local

ENV NODE_ENV=development

# COPY --link package.json package-lock.json .
# RUN npm install

# Run local
FROM base as local

# COPY --from=build-local /src/node_modules /src/node_modules

CMD tail -f /dev/null
# CMD [ "npm", "run", "dev" ]

#===================================================

# Build prod
FROM base as build-prod

# COPY --chmod=777 --link package.json package-lock.json .
# RUN npm install
# RUN npm ci --omit=dev

# COPY --link . .

# RUN npm run build
# RUN npm prune

# Run
FROM base as prod

# ENV PORT=3000

# COPY --from=build-prod /src/.output /src/.output
# COPY --from=build-prod /src/node_modules /src/node_modules

CMD tail -f /dev/null
# CMD [ "npm", "run", "prod" ]
