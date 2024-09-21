#!/bin/sh
#
#

# Install ffmpeg
# apt install ffmpeg

# Install ruby
apt install -y \
	ruby \
	ruby-dev \
	build-essential

# Install ruby package
# bundler:
# puma: A Rack server for Ruby (puma or unicorn)
gen install \
	bundler \
	puma

# Run Ruby app with Puma.
# Example run Ruby on Rails app:
# puma -b tcp://127.0.0.1:9292

# Make a service systemd for Puma.
cat -- << EOS >> etc/systemd/system/puma.service
[Unit]
Description=Puma HTTP Server
After=network.target

[Service]
User=www-data
Group=www-data
WorkingDirectory=/var/app/transcode-service
ExecStart=/usr/local/bin/puma -C config/puma.rb
Restart=always

[Install]
WantedBy=multi-user.target
EOS

systemctl start puma
systemctl enable puma