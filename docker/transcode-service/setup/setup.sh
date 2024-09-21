#!/bin/sh

CURRENT_PATH=$(pwd)
SETUP_PATH="$CURRENT_PATH"
APP_PATH="$(dirname "$SETUP_PATH")"

chmod +x "$SETUP_PATH/*.sh"

# Install needed packages
sh "$SETUP_PATH/install.sh"

# Build ffmpeg
if [ ! -f "$APP_PATH/bin/ffmpeg" ]; then
  sh "$SETUP_PATH/ffmpeg_build.sh $APP_PATH"
else
  cp -R "$APP_PATH/bin/*" "/usr/bin"
fi

# Setup App
sh "$SETUP_PATH/app.sh $APP_PATH"

# Confirm
ffmpeg -version

###########
# The Amazon Linux AMI comes with the EPEL repository source, but it's disabled. So you need to enable it.
###########
# Amazon Linux 1 AMI:
# yum-config-manager --enable epel

# Amazon Linux 2 AMI:
# amazon-linux-extras install epel -y

# yum install -y incron
# service incrond start
