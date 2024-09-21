from tasks import transcode
import os

# Add video to Queue.
# transcode.delay 	: Method add a task to Celery Queue.

videos = [
	'video1.mp4',
	'video2.mp4',
	'video3.mp4',
	'video4.mp4',
	'video5.mp4',
	'video6.mp4',
	'video7.mp4',
]

input_directory = '/var/storage/video-input/'
output_directory = '/var/storage/video-output/'

# Add videos to Queue.
for video in videos:
	input_path = os.path.join(input_directory, video)
	
	transcode.delay(input_path, output_directory)

	print(f"Video {input_path} has been added to Queue.")

