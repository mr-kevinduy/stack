from celery_app import app
import ffmpeg
import os

# Make a transcode video.
# app.task 	: Define a Celery task.
# retry  	: Config Celery auto try if have been error.
@app.task(bind=True)
def transcode(self, input_path):
	# file_name = request.form['fileName']
	# input_path = os.path.join(UPLOAD_FOLDER, file_name)
	output_path = input_path.replace(".mp4", "-transcoded.mp4")

	UPLOAD_FOLDER = 'uploads'
	if not os.path.exists(UPLOAD_FOLDER):
		os.makedirs(UPLOAD_FOLDER)

	try:
		# Transcode video in here
		(ffmpeg
		.input(input_path)
		.output(output_path, vcodec='libx264', acodec='aac')
		.run(overwrite_output=True))

		print(f"Transcoding completed: {output_path}")

		return {'status': 'COMPLETED', 'output': output_path}
	except ffmpeg.Error as e:
		print(f"Error occurred during transcoding: {str(e)}")

		raise self.retry(exc=e, countdown=10, max_retries=3)
		
		return {'status': 'FAILED', 'error': str(e)}