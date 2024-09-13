# Upload and Transcode video

Client 									=> Server::App
[Server::App] FTP 						=> Server::Transcode
[Server::Transcode] Batch				=> AWS::S3
[Server::Transcode] TranscodeService	=> AWS::S3

# FFmpeg Service

- FFmpeg tools
- Python : Queue, ffmpeg.
- FTP
- Incron

# MinIO Service