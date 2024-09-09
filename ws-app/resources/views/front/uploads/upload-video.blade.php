<form action="{{ front_route('uploads.index') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <button type="submit">Next to Upload Thumbnail</button>
</form>
