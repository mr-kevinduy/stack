#!/bin/sh

# Install packages
yum –y update

yum install -y \
    autoconf \
    automake \
    bzip2 \
    bzip2-devel \
    cmake \
    freetype-devel \
    gcc \
    gcc-c++ \
    git \
    libtool \
    make \
    nasm \
    mercurial \
    pkgconfig \
    diffutils \
    zlib-devel \
    wget \
    curl \
    nano \
    vi \
    telnet \
    htop

# Install neofetch
# Usage: neofetch
curl -o /etc/yum.repos.d/konimex-neofetch-epel-6.repo https://copr.fedorainfracloud.org/coprs/konimex/neofetch/repo/epel-6/konimex-neofetch-epel-6.repo
yum install -y neofetch

yum install epel-release -y

# https://www.server-world.info/en/note?os=CentOS_6&p=cpulimit
# Package epel-release-6-8.9.amzn1.noarch already installed and latest version
# yum --enablerepo=epel -y install cpulimit

# ###########
# # The Amazon Linux AMI comes with the EPEL repository source, but it's disabled. So you need to enable it.
# ###########
# # Amazon Linux 1 AMI:
yum-config-manager --enable epel

# # Amazon Linux 2 AMI:
# # amazon-linux-extras install epel -y

yum install -y incron
chkconfig incrond on
echo "editor = /usr/bin/vi" >> /etc/incron.conf
service incrond start

