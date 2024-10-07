@php
    $uploadTypes = [
        ['name' => 'auto', 'title' => 'Thumbnail Generated', 'description' => '* Upload a thumbnail'],
        ['name' => 'upload', 'title' => 'Thumbnail Upload', 'description' => 'Choose file from your computer'],
    ];

    $uploadTypeSelected = $uploadTypes[0];
@endphp

@push('styles')
    <link href="/libs/fine-uploader/fine-uploader-new.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="/libs/fine-uploader/jquery.fine-uploader.js"></script>
    <script type="text/template" id="qq-template-manual-trigger">
        <div class="qq-uploader-selector qq-uploader">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>

            <div class="flex w-full flex-col items-center justify-center gap-2 p-8 text-neutral-600 dark:text-neutral-300">
                <div class="text-gray-300 dark:text-slate-50">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor" class="w-12 h-12 opacity-75">
                        <path fill-rule="evenodd" d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="group flex items-center">
                    <label class="cursor-pointer font-medium text-black group-focus-within:underline dark:text-white">
                        <span class="qq-upload-button-selector qq-upload-button inline-block align-baseline font-bold text-sm m-0">
                            <span>Select files</span>
                        </span>
                    </label>
                    <span class="ms-2">or drag and drop here</span>
                </div>
                <small>PNG, JPG, WebP - Max 1MB</small>
            </div>

            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>

    <script>
        $('#fine-uploader-manual-trigger').fineUploader({
            template: 'qq-template-manual-trigger',
            thumbnails: {
                placeholders: {
                    waitingPath: '/libs/fine-uploader/placeholders/waiting-generic.png',
                    notAvailablePath: '/libs/fine-uploader/placeholders/not_available-generic.png'
                }
            },
            autoUpload: false,
            request: {
                endpoint: "{{ mypage_route('videos.uploads.thumbnail.store', ['code' => $code]) }}",
                customHeaders: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            deleteFile: {
                enabled: true,
                endpoint: "{{ mypage_route('videos.uploads.thumbnail.destroy', ['code' => $code]) }}"
            },
            chunking: {
                enabled: true,
                partSize: 1024 * 1024, // 1 MB
                concurrent: {
                    enabled: true
                },
                success: {
                    // endpoint: "/vendor/fineuploader/php-traditional-server/endpoint.php?done"
                }
            },
            resume: {
                enabled: true
            },
            retry: {
                enableAuto: true,
                showButton: true
            },
            callbacks: {
                onComplete: function(id, name, response) {
                    if (response.success) {
                        window.location.href = "{{ mypage_route('videos.uploads.confirm', ['code' => $code]) }}";
                    }
                }
            }
        });

        // $('#trigger-upload').click(function() {
        //     $('#fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
        // });

        $( "body" ).delegate( "#trigger-upload", "click", function() {
            $('#fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
        });
    </script>
@endpush

<x-layout-front>
    <x-section>
        <x-card class="w-full mx-auto">
            <x-form action="{{ mypage_route('videos.uploads.thumbnail.store', ['code' => $code]) }}">
                <div x-data="{ selectedTab: '{{ $uploadTypeSelected['name'] }}' }">
                    <div class="py-4">
                        <div class="tab-radio">
                            <div @keydown.right.prevent="$focus.wrap().next()" @keydown.left.prevent="$focus.wrap().previous()" class="tab-radio-header grid grid-cols-2 gap-2" role="tablist" aria-label="tab options">
                                @foreach ($uploadTypes as $key => $uploadType)
                                    <div @click="selectedTab = '{{ $uploadType['name'] }}'" :aria-selected="selectedTab === '{{ $uploadType['name'] }}'" :tabindex="selectedTab === '{{ $uploadType['name'] }}' ? '0' : '-1'" {{ $uploadType['name'] !== $uploadTypeSelected['name'] ? '' : 'aria-selected="true" tabindex="0"' }} class="tab-radio-header-element thumbnail_{{ $uploadType['name'] }} relative">
                                        <input class="peer hidden" id="thumbnail_{{ $uploadType['name'] }}" type="radio" name="upload_type" value="{{ $uploadType['name'] }}" {{ $uploadType['name'] === $uploadTypeSelected['name'] ? 'checked' : '' }} />
                                        <span class="absolute pointer-events-none right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-4 border-gray-300 bg-white peer-checked:border-blue-500" :class="selectedTab === 'thumbnail_{{ $uploadType['name'] }}' ? 'border-blue-500' : 'border-gray-300'"></span>
                                        <label class="flex cursor-pointer flex-col rounded-lg border-2 h-full px-4 py-2 text-sm peer-checked:border-blue-500" for="thumbnail_{{ $uploadType['name'] }}" :class="selectedTab === '{{ $uploadType['name'] }}' ? 'border-blue-500' : 'border-gray-300'">
                                            <span class="text-xs font-semibold uppercase">{{ $uploadType['title'] }}</span>
                                            <span class="mt-1 text-sm">{{ $uploadType['description'] }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-radio-content mt-10">
                                @foreach ($uploadTypes as $uploadType)
                                    <div x-show="selectedTab === '{{ $uploadType['name'] }}'" class="tab-radio-content-element thumbnail_upload_file" role="tabpanel" aria-label="{{ $uploadType['name'] }}" {{ $uploadType['name'] !== $uploadTypeSelected['name'] ? 'style="display: none;"' : '' }}>
                                        @if ($uploadType['name'] === 'auto')
                                                <ul x-data="{ selectedThumbnail: 'thumbnail_1' }" class="thumbnails grid grid-cols-5 gap-2">
                                                    @foreach ([
                                                        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS3mHqUdVMQtf_PCJIKFyMvECraaqpOupkXpTr7EPGQlJb_m4AKvZibT06m2Sg2S-N2PcU&usqp=CAU',
                                                        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtelqFA89UN0MZKp2Y6M-GA48SRv4AUEOqJbV2Dc3NxBAivOONBDparEIpL-2OBoU-Xfw&usqp=CAU',
                                                        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8ZPGyvItADPsHDK8-cKPJ1xx9Ka9J9asGrRYoyQFPch_dfjmSOqRXR_ITLrklvN5Rt5o&usqp=CAU',
                                                        'https://img.freepik.com/premium-photo/25-year-old-chinese-girl-with-fair-beautiful-skin-pointed-chin_979350-15.jpg',
                                                        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtelqFA89UN0MZKp2Y6M-GA48SRv4AUEOqJbV2Dc3NxBAivOONBDparEIpL-2OBoU-Xfw&usqp=CAU',
                                                        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7KgSzcqdHNM41hoot-SB2aOE4k4Sf4X9iV4KbfOZshA7fOxtTY55x4yEIB38XhWQKJFA&usqp=CAU',
                                                        'https://img.freepik.com/premium-photo/25-year-old-chinese-girl-with-fair-beautiful-skin-pointed-chin_856434-46.jpg?w=360',
                                                        'https://img.freepik.com/premium-photo/25-year-old-chinese-girl-with-fair-beautiful-skin-pointed-chin_856434-46.jpg?w=360',
                                                        'https://img.freepik.com/premium-photo/25-year-old-chinese-girl-with-fair-beautiful-skin-pointed-chin_856434-36.jpg?w=360',
                                                    ] as $key => $thumbnail)
                                                        <li @click="selectedThumbnail = 'thumbnail_{{ $key + 1 }}'" class="thumbnail thumbnail_{{ $key + 1 }}">
                                                            <input class="peer hidden" id="thumbnail_{{ $key + 1 }}" type="radio" name="thumbnail" value="{{ $key + 1 }}" {{ $key === 0 ? 'checked' : '' }} />
                                                            <label class="flex cursor-pointer flex-col border border-gray-300 p-1 peer-checked:border-blue-500" :class="selectedThumbnail === 'thumbnail_{{ $key + 1 }}' ? 'border-blue-500' : 'border-gray-300'" for="thumbnail_{{ $key + 1 }}">
                                                                <img src="{{ $thumbnail }}" alt="" class="object-cover object-center w-[160px] h-[90px]">
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                        @elseif ($uploadType['name'] === 'upload')
                                            <div id="fine-uploader-manual-trigger"></div>
                                        @else

                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="flex items-center justify-between mt-8">
                        <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ mypage_route('videos.uploads.video.create', ['code' => $code]) }}">
                            Back
                        </a>

                        <button type="{{ $uploadTypeSelected['name'] === 'upload' ? 'button' : 'submit' }}" id="{{ $uploadTypeSelected['name'] === 'upload' ? 'trigger-upload' : 'form-upload' }}" :type="selectedTab === 'upload' ? 'button' : 'submit'" :id="selectedTab === 'upload' ? 'trigger-upload' : 'form-upload'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Upload Thumbnail</button>
                    </div>
                </div>
            </x-form>
        </x-card>
    </x-section>
</x-layout-front>
