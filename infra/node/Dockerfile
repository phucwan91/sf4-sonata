FROM node:8

ARG UID=1000
ARG GID=1000

RUN npm install yarn --global \
    && usermod -u $UID www-data \
    && groupmod -g $GID www-data \
