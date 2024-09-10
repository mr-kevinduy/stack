@push('styles')
    <link href="/libs/fine-uploader/fine-uploader-new.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="/libs/fine-uploader/jquery.fine-uploader.js"></script>
    <script type="text/template" id="qq-template-manual-trigger">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="buttons flex items-center justify-between mb-4">
                <div class="qq-upload-button-selector qq-upload-button inline-block align-baseline font-bold text-sm">
                    <div>Select files</div>
                </div>
                <button type="button" id="trigger-upload" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="icon-upload icon-white"></i> Upload
                </button>
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
            request: {
                customHeaders: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                endpoint: "{{ front_route('uploads.upload', ['code' => $code]) }}"
            },
            thumbnails: {
                placeholders: {
                    waitingPath: '/libs/fine-uploader/placeholders/waiting-generic.png',
                    notAvailablePath: '/libs/fine-uploader/placeholders/not_available-generic.png'
                }
            },
            autoUpload: false
        });

        $('#trigger-upload').click(function() {
            $('#fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
        });
    </script>
@endpush

<x-front-layout>
    <x-section>
        <x-card class="w-full max-w-lg mx-auto">
            <div id="fine-uploader-manual-trigger"></div>
            {{-- <x-form action="{{ front_route('uploads.upload-video', ['code' => $code]) }}" enctype="multipart/form-data">
                <div class="mb-4">
                    <x-form.input
                        name="title"
                        label="Title"
                        type="file"
                    />
                </div>

                <div class="flex items-center justify-between mt-8">
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                        Back
                    </a>
                    <x-button type="submit">Next to Upload Thumbnail</x-button>
                </div>
            </x-form> --}}
        </x-card>
    </x-section>
</x-front-layout>
