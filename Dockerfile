FROM richarvey/nginx-php-fpm:latest

COPY . .

# Set environment variables
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Fix nginx routing to Laravel
RUN echo 'server { 
    listen 80; 
    server_name _; 
    root /var/www/html/public; 
    index index.php; 
    
    location / { 
        try_files $uri $uri/ /index.php?$query_string; 
    } 
    
    location ~ \.php$ { 
        include fastcgi_params; 
        fastcgi_pass unix:/var/run/php-fpm.sock; 
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; 
    } 
}' > /etc/nginx/conf.d/default.conf

ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]
