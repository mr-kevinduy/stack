#!/bin/sh
#
# Asynchronous Processing use Supervisord to run background task.
# Job Asynchronous Processing need:
# - Queue System / Queue Server: A task / job management
# 		+ Redis Queue (feature: pub/sub and list operations)
# 		+ RabbitMQ
# 		+ Amazon SQS
#
# - Worker: Create process worker.
# 		+ Node.js and Bull / BullMQ
#
#
# *) With Redis
# apt update -y
# apt install redis-server
# systemctl start redis-server
# systemctl enable redis-server
# 
# - Node.js:
# 	+ npm install express bullmq ffmpeg fluent-ffmpeg redis
# 	+ create worker.js => Refs chatjpt
# 	+ create server.js



########
# Celery 			: A lib Queue management and limit concurrent processing / Task Asynchronous Management.
# Redis / RabbitMQ 	: Task Queue management, backend for Celery.
# FFmpeg 			: Transcoding video tool.

########################
######################## Ubuntu
########################
# Install ffmpeg
# apt install ffmpeg

# Install python3 && pip
# apt install -y python3-pip

########################
######################## Amazon Linux 1 - 2018.03
########################
yum update -y

# Install python3 && pip
# yum list | grep python3
yum install -y python38 python38-pip

# Install with sudo (add flag --user)
python3 -m pip install --upgrade pip

# python3 --version
# python3 -m pip --version

cd /var/app/transcode-service

# Create a virtual environment (venv) is a virtual Python installation in the .venv folder.
# Note: Amazone Linux 2018.03 in docker not support venv => Use virtualenv
# python3 -m venv .venv
# source .venv/bin/activate
# ./.venv/bin/python --version

# If use with virtualenv, install:
python3 -m pip install --user virtualenv
python3 -m virtualenv .virtualenv
# ./.virtualenv/bin/python --version
# ./.virtualenv/bin/pip --version
# Active env
. ./.virtualenv/bin/activate
python --version
pip --version

pip install -r requirements.txt

# # Install python package
# # gunicorn: A WSGI server for Python.
# # flask: A Python Framework
# # flask-cors:
# # celery:
# # pika: lib python for RabbitMQ
# # boto3:
# # moviepy / ffmpeg-python

# # With RabbitMQ
# # python3 -m pip install \
# # 	gunicorn \
# # 	flask \
# # 	flask-cors \
# # 	celery \
# # 	pika \
# # 	ffmpeg-python \
# # 	boto3

# # pip install flask && pip freeze > requirements.txt

# # With Redis:
# pip install \
# 	gunicorn \
# 	flask \
# 	flask-cors \
# 	celery \
# 	redis \
# 	ffmpeg-python \
# 	boto3

# pip freeze > requirements.txt

# # Run app
# # python3 /var/app/transcode-service/transcode-service/main.py
# # python app.py

# # Run Python app with Gunicorn.
# # Example with the Flask app:
# # 	app:app => app.py file of the Flask app.
# # gunicorn --workers 3 --bind 127.0.0.1:8000 app:app

# # Make a service systemd for Gunicorn.
# cat -- << EOS >> etc/systemd/system/gunicorn.service
# [Unit]
# Description=Gunicorn instance to serve Python app
# After=network.target

# [Service]
# User=www-data
# Group=www-data
# WorkingDirectory=/var/app/transcode-service
# ExecStart=/usr/local/bin/gunicorn --workers 3 --bind 127.0.0.1:8000 app:app

# [Install]
# WantedBy=multi-user.target
# EOS

# systemctl start gunicorn
# systemctl enable gunicorn
# 

########################
######################## Amazon Linux 2
########################
# Install python3 && pip
# amazon-linux-extras list | grep python3
# python3 -m venv my_venv
# amazon-linux-extras install python3