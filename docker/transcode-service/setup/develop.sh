#!/bin/sh

########################
######################## Amazon Linux 1 - 2018.03
########################
yum update -y

# Install python3 && pip
# yum list | grep python3
yum install -y python38 python38-pip

# Install with sudo (add flag --user)
python3 -m pip install --upgrade pip

# If use with virtualenv, install:
python3 -m pip install --user virtualenv