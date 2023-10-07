FROM nginx:1.19-alpine

# CHANGE CONF OF NGINX

RUN mkdir -p /home/web/www
COPY public /home/web/www/public
RUN chmod -R 0755 /home/web