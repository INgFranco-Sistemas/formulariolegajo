FROM node:20-alpine AS build

WORKDIR /app/frontend-formdatos

COPY frontend-formdatos/package.json frontend-formdatos/package-lock.json ./

RUN npm ci

COPY frontend-formdatos/ ./

ARG VITE_API_BASE_URL=/api
ENV VITE_API_BASE_URL=$VITE_API_BASE_URL

RUN npm run build

FROM nginx:1.27-alpine

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=build /app/frontend-formdatos/dist /usr/share/nginx/html

EXPOSE 80
