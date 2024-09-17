# Setup

```sh
pip install \
	gunicorn \
	flask \
	flask-cors \
	celery \
	redis \
	ffmpeg-python \
	boto3

pip freeze > requirements.txt
```

# Development

```sh
cd /var/app/transcode-service
python3 -m virtualenv .virtualenv
. ./.virtualenv/bin/activate
# python --version
# pip --version
pip install -r requirements.txt

# Start Worker
celery -A tasks worker -E --concurrency=2 --loglevel=INFO
# Inspect active queues.
celery -A tasks inspect active_queues

. ./.virtualenv/bin/activate
# Run publisher.
cd /var/storage/video-input
# wget https://github.com/mediaelement/mediaelement-files/raw/master/big_buck_bunny.mp4
wget http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4
cp BigBuckBunny.mp4 ./video1.mp4
cp BigBuckBunny.mp4 ./video2.mp4
cp BigBuckBunny.mp4 ./video3.mp4
cp BigBuckBunny.mp4 ./video4.mp4

python transcode-service/main.py
```

# Python

```sh
####################################
############# Redis ################
####################################
/transcode-service/celery_app.py
/transcode-service/tasks.py
/transcode-service/main.py
# Celery 			: A lib Queue management and limit concurrent processing / Task Asynchronous Management.
# Redis 			: Task Queue management, backend for Celery.
# FFmpeg 			: Transcoding video tool.
apt update -y
apt install -y ffmpeg

pip install \
	celery \
	redis \
	flask \
	ffmpeg-python \
	boto3

# Run Celery Worker with config limit 5 concurrency tasks.
# -A tasks 			: Application name
# -E 				: task events: ON -> to monitor tasks in this worker
# --concurrency=5 	: Limit tasks have concurrency processing.
# redis-server
cd transcode-service
celery -A tasks worker -E --concurrency=2 --loglevel=INFO
celery -A tasks inspect active_queues
python transcode-service/main.py

####################################
############# RabbitMQ #############
#####################################

# ========== Transcode Server ==========
/transcode-service/app.py
apt-get update -y
apt-get install -y rabbitmq-server
apt install -y ffmpeg

systemctl enable rabbitmq-server
systemctl start rabbitmq-server

pip install \
	celery \
	pika \
	flask \
	ffmpeg-python \
	boto3

# Run Celery Worker with config limit 5 concurrency tasks.
# -A app.celery 	: Specific Celery application from app.py
# --concurrency=5 	: Limit tasks have concurrency processing.
celery -A app.celery worker --concurrency=5 --loglevel=INFO
python app.py


# ========== Laravel Server ==========
php artisan serve --host=0.0.0.0 --port=8000

# Config Nginx
cat -- << EOS >> /etc/nginx/nginx.d/transcode-service.conf
server {
	listen 80;
	server_name laravel-server-ip;

	location / {
		# Config web server in here.
		proxy_pass http://127.0.0.1:8000;
		proxy_set_header Host $host;
		proxy_set_header X-Real-IP $remote_addr;
		proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
		proxy_set_header X-Forwarded-Proto $scheme;
	}

	location /transcode {
		proxy_pass http://127.0.0.1:5000;
		proxy_set_header Host $host;
		proxy_set_header X-Real-IP $remote_addr;
		proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
		proxy_set_header X-Forwarded-Proto $scheme;
	}
}
EOS

nginx -t
systemctl reload nginx


############# Monitoring #############
- CloudWatch: CPU, RAM, Disk I/O of EC2
- Logging: Laravel log, Python server log => Logrotate

############# Testing #############
- Stress Test
- Load test

############# Risk - Giả định các trường hợp có thể xảy ra #############
- Service stop (Transcode stop / Queue stop / Celery Stop / S3 not connect, ...)
- Service Break (Transcode service break / Queue break / Celery break ...)
- Server stop
- Full Disk
- Big Video File
- Many Video file uploaded.
```