from celery_app import app
import ffmpeg
import os

# Make a transcode video.
# app.task 	: Define a Celery task.
# retry  	: Config Celery auto try if have been error.
@app.task(bind=True)
def transcode(self, input_path, output_directory):
	if not os.path.exists(output_directory):
		os.makedirs(output_directory)

	if not os.path.isfile(input_path):
		print(f"Not found {input_path}")
		return {'status': 'FAILED', 'error': 'Not found '+input_path}

	# filename = request.form['fileName']
	filename = os.path.basename(input_path)
	file_pathname, file_extension = os.path.splitext(input_path)
	output_filename = filename.replace(file_extension, "-output" + file_extension)
	output_path = os.path.join(output_directory, output_filename)

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