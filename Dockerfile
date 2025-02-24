FROM nginx

COPY ./config/nginx/inner/nginx.conf /etc/nginx/conf.d/nginx.conf

RUN apt-get update
RUN apt-get install --no-install-recommends --no-install-suggests -y \
                        libgd-dev \
                        nginx-module-image-filter

# Запуск Nginx
CMD ["nginx", "-g", "daemon off;"]
