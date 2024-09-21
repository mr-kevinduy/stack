from flask import Flask, request, jsonify
from celery import Celery
# import boto3
import ffmpeg

app = Flask(__name__)

# Config Celery with RabbitMQ broker
app.config['CELERY_BROKER_URL'] = 'pyamqp://guest@localhost//' # Connect RabbitMQ on localhost
app.config['CELERY_RESULT_BACKEND'] = 'rpc://'

# Make Celery app
celery = Celery(app.name, broker=app.config['CELERY_BROKER_URL'])
celery.conf.update(app.config)

# Config connect with AWS S3
# s3 = boto3.client('s3', aws_access_key_id='YOUR_ACCESS_KEY', aws_secret_access_key='YOUR_SECRET_ACCESS_KEY', region_name='ap-southeast-1')

# Async task transcode
@celery.task(bind=True, max_retries=3, soft_time_limit=300)
def transcode(self, input_path):
	try:
		# # Download from s3
		# input_file = '/tmp/' + input_path.split('/')[-1]
		# s3.download_file('YOUR_INPUT_BUCKET', input_path.split('/')[-1], input_file)

		output_path = input_path.replace(".mp4", "-transcoded.mp4")

		# Transcode video in here
		ffmpeg.input(input_path).output(output_path, vcodec='libx264', acodec='aac').run(overwrite_output=True)

		# # Upload to s3
		# s3.upload_file(output_path, 'YOUR_OUTPUT_BUCKET', output_path.split('/')[-1])

		return {'status': 'COMPLETED', 'output': output_path}
	except ffmpeg.Error as e:
		self.retry(exc=e, countdown=10)

		return {'status': 'FAILED', 'error': str(e)}

# Api request start a job to add task to Queue
@app.route('/transcode', methods=['POST'])
def transcode_request():
	data = request.json
	file_path = data.get('filePath')

	if not file_path:
		return jsonify({'status': 'FAILED', 'error': 'File path is required'}), 400

	# Add task to Queue.
	task = transcode.apply_async((file_path,))

	return jsonify({'status': 'QUEUED', 'task_id': task.id}), 202


if __name__ == "__main__":
	app.run(debug=True, host='0.0.0.0', port=5000)