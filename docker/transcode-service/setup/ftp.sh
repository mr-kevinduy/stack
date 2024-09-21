#!/bin/sh

# Install packages
yum –y update

yum install -y vsftpd

/etc/vsftpd/vsftpd.conf
anonymous_enable=YES
anonymous_enable=NO
pasv_enable=YES
pasv_min_port=1024
pasv_max_port=1048
pasv_address=<Public IP of your instance>

# User Restricting to their Home Directory
chroot_local_user=YES

systemctl restart vsftpd

adduser ftpuser
passwd ftpuser

cd /etc
mkdir -p /etc/ftptest
chmod a+rwx ftptest
usermod -d /etc/ftptest/ ftpuser

# Add to root group
usermod -a -G root ftpuser

systemctl restart vsftpd

# automatically start when your server boots.
chkconfig --level 345 vsftpd on

# Problem facing Issue in accessing FTP
nano /etc/vsftpd/vsftpd.conf
allow_writeable_chroot=YES

systemctl restart vsftpd