<form action="{{ front_route('uploads.index') }}" method="POST">
    @csrf

    <button type="submit">Submit</button>
</form>
