<form action="{{ front_route('uploads.index', ['code' => $code]) }}" method="POST">
    @csrf

    <button type="submit">Submit</button>
</form>
