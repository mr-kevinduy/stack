<form action="{{ front_route('uploads.upload-thumbnail.store', ['code' => $code]) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <button type="submit">Next to Confirm</button>
</form>
