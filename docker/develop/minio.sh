#!/bin/sh
#
# - Linux: Ubuntu, Centos

# MinIO Client
# Refs: https://min.io/docs/minio/linux/reference/minio-mc.html?ref=docs
curl https://dl.min.io/client/mc/release/linux-amd64/mc \
	--create-dirs \
	-o $HOME/minio-binaries/mc

chmod +x $HOME/minio-binaries/mc
export PATH=$PATH:$HOME/minio-binaries/

# Check cli
# mc --help

# # Set alias and auth with ACCESS_KEY
# bash +o history
# # mc alias set ALIAS HOSTNAME ACCESS_KEY SECRET_KEY
# mc alias set s3 http://minio:9000 tNziExWRreYDu48wfRRb mj78eEWyUENnocsLqzc51OomYnBo0ltipwZJmkfI
# bash -o history

# # Test connect
# mc admin info s3

# # cli
# mc ls s3
# mc cp /var/www/app/README.md s3/video-inputbucket