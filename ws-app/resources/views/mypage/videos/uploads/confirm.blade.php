<form action="{{ mypage_route('videos.uploads.store', ['code' => $code]) }}" method="POST">
    @csrf

    <div class="flex items-center justify-between mt-8">
        <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ front_route('videos.uploads.upload-thumbnail.create', ['code' => $code]) }}">
            Back
        </a>
        <x-button type="submit">Create Video</x-button>
    </div>
</form>
