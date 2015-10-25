# BugLife

可视化Bug追踪系统的领导者。

## 简介

程序员的一生，需要在不断的消灭BUG中度过。一款高效的Bug追踪系统，对提高程序员的生活幸福指数是很有必要的。BugLife就是这么一款Bug追踪系统，她解决了：

  * 通过截图为核心，清晰明了的描述BUG；
  * 通过ctrl+c, ctrl+v就能快速添加BUG；
  * 通过简单的鼠标、快捷键操作，就能完成BUG的认领、修复、验证等状态变更操作。


## 系统版本

v0.0.1，目前系统只能达到Demo的程度，尚在不断的迭代中，如需了解系统状态，请提issue。




## 运行截图

![截图1](demo/1.png)
![截图2](demo/2.png)
![截图3](demo/3.png)

## 系统配置

```
server {
    listen 80;
    server_name bugworld.dev;
    root /var/www/bugworld/web;

    access_log /var/log/nginx/bugworld.access.log;
    error_log /var/log/nginx/bugworld.error.log;

    location / {
        index index.php;
        try_files $uri @rewriteapp;
    }

    location @rewriteapp {
        rewrite ^(.*)$ /index.php/$1 last;
    }

    location ~ ^/(index|index_dev)\.php(/|$) {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 8 128k;
    }

    location ~* \.(jpg|jpeg|gif|png|ico|swf)$ {
        expires 3y;
        access_log off;
        gzip off;
    }

    location ~* \.(css|js)$ {
        access_log off;
        expires 3y;
    }
}
```