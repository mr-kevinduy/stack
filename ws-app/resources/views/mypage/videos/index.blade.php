<x-layout-mypage>
    <x-section>
        <x-card class="w-full max-w-2xl mx-auto">
            <div class="mb-4">
                List video uploaded.
                <a href="{{ mypage_route('videos.uploads.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Upload Video
                </a>
            </div>
        </x-card>
    </x-section>
</x-layout-mypage>
