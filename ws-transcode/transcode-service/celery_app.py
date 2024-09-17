from celery import Celery

# Make a Celery application with Redis backend
app = Celery('video_transcoder', broker='redis://:eYVX7EwVmmxKPCDmwMtyKVge8oLd2t81@redis:6379/0')

# Limit concurent tasks.
app.conf.task_annotations = {'*': {'rate_limit': '5/s'}}
app.conf.broker_connection_retry_on_startup = True
# app.conf.task_default_queue = 'transcode_queue' # Name of queue
# app.autodiscover_tasks()

# # Inspect all nodes.
# i = app.control.inspect()

# # Show the items that have an ETA or are scheduled for later processing
# i.scheduled()

# # Show tasks that are currently active.
# i.active()

# # Show tasks that have been claimed by workers
# i.reserved()