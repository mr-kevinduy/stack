FROM amazonlinux:1

ARG BUILD_VERSION
ARG BUILD_DATE
ARG VCS_REF

# https://github.com/opencontainers/image-spec/blob/main/annotations.md
LABEL org.opencontainers.image.title="FFmpeg Service"
LABEL org.opencontainers.image.version=$BUILD_VERSION
LABEL org.opencontainers.image.authors="KevinDuy <mr.kevinduy@gmail.com>"
LABEL org.opencontainers.image.created=$BUILD_DATE
LABEL org.opencontainers.image.revision=$VCS_REF

RUN sed -i 's/timeout=5/timeout=300/g' /etc/yum.repos.d/amzn-*
RUN yum update -y && yum install file -y

RUN mkdir -p /scripts
RUN mkdir -p /var/videos
RUN mkdir -p /var/transcoded

RUN mkdir -p /root/ffmpeg
COPY setup /root/ffmpeg/setup
RUN sed -i $'s/\r$//' /root/ffmpeg/setup/*.sh
RUN chmod +x /root/ffmpeg/setup/*.sh

RUN mkdir -p /usr/local/ffmpeg_build
COPY bin /usr/local/ffmpeg_build/bin
RUN chmod +x /usr/local/ffmpeg_build/bin/*
RUN cp -R /usr/local/ffmpeg_build/bin/ffmpeg /usr/bin

# Install basic packages
RUN /root/ffmpeg/setup/install.sh
RUN /root/ffmpeg/setup/ftp.sh

# Build ffmpeg.
# RUN /root/ffmpeg/setup/ffmpeg_build.sh
