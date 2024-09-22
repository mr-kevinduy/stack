from tasks import transcode
from flask import Flask, request, jsonify
import os
# import boto3

app = Flask(__name__)

# Config connect with AWS S3
# s3 = boto3.client('s3', aws_access_key_id='YOUR_ACCESS_KEY', aws_secret_access_key='YOUR_SECRET_ACCESS_KEY', region_name='ap-southeast-1')

# Api request start a job to add task to Queue
@app.route('/transcode/start', methods=['POST'])
def transcode_start():
	data = request.json
	file_path = data.get('filePath')

	if not file_path:
		return jsonify({'status': 'FAILED', 'error': 'File path is required'}), 400

	input_directory = '/var/storage/video-input/'
	output_directory = '/var/storage/video-output/'
	input_path = os.path.join(input_directory, file_path)
	

	# Add task to Queue.
	# task = transcode.apply_async((file_path,))
	task = transcode.delay(input_path, output_directory)

	return jsonify({'status': 'QUEUED', 'task_id': task.id}), 202


if __name__ == "__main__":
	app.run(debug=True, host='0.0.0.0', port=5000)