<x-layout-front>
    <x-section>
        <x-card class="w-full max-w-lg mx-auto">
            <x-form action="{{ mypage_route('videos.uploads.index.store', ['code' => $code]) }}">
                <div class="mb-4">
                    <x-form.input
                        name="title"
                        label="Title"
                    />
                </div>

                <div class="flex items-center justify-between mt-8">
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                        Back
                    </a>
                    <x-button type="submit">Next to Upload Video</x-button>
                </div>

            </x-form>
        </x-card>
    </x-section>
</x-layout-front>
