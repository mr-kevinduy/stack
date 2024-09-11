<form action="{{ front_route('uploads.store', ['code' => $code]) }}" method="POST">
    @csrf

    <button type="submit">Submit</button>
</form>
