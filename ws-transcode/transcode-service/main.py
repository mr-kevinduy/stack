from tasks import transcode

# Add video to Queue.
# transcode.delay 	: Method add a task to Celery Queue.

videos = [
	'/var/storage/video-input/video1.mp4',
	'/var/storage/video-input/video2.mp4',
	'/var/storage/video-input/video3.mp4',
	'/var/storage/video-input/video4.mp4',
	'/var/storage/video-input/video5.mp4',
	'/var/storage/video-input/video6.mp4',
	'/var/storage/video-input/video7.mp4',
]

# Add videos to Queue.
for video in videos:
	transcode.delay(video)

	print(f"Video {video} has been added to Queue.")
