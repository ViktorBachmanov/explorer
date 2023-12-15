FROM nginx:alpine AS base

WORKDIR /etc/nginx/templates


FROM base AS local

COPY ./local/templates/ .


FROM base AS prod

COPY ./prod/templates/ .

# COPY ./certbot/conf/ /etc/nginx/ssl/