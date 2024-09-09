<x-front-layout>
    <form action="{{ front_route('uploads.index') }}" method="POST">
        @csrf

        <x-button type="submit">Next to Upload Video</x-button>
    </form>
</x-front-layout>
