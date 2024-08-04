#!/usr/bin/env bash

upstream="upstream php-upstream {
    server $1:9000;
}
"

echo "$upstream" > "/etc/nginx/conf.d/upstream.conf"
