@extends('layouts.app')

@section('content')
    <section class="bg-white dark:bg-gray-900 flex items-center justify-center flex-col min-h-screen">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
            <h1
                class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                Compare the contents of your documents
            </h1>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                Get the percentage difference and similarity between the contents of documents in less that two minutes
            </p>
            <div
                class="flex flex-col lg:flex-row mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                <a href="#"
                    class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    Learn more
                </a>
                <a href="#"
                    class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Get started
                    <i class="fa fa-arrow-right ms-2" aria-hidden="true"></i>
                </a>
            </div>
            <form method="POST" id="process-docs" action="/results" enctype="multipart/form-data">
                @csrf
                <div class="w-5/6 lg:w-3/5 mx-auto my-2">
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa fa-upload mb-3 text-2xl text-gray-500 dark:text-gray-400"
                                    aria-hidden="true"></i>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                        to
                                        upload</span></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">DOC, DOCX, TXT</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" name="files[]"
                                accept=".doc, .docx, .txt" multiple />
                        </label>
                    </div>

                    <div class="py-3 files hidden">
                        <div class="dark:text-white my-5 !text-left text-2xl">Uploaded files</div>
                        <ul class="w-full py-3 text-left" id="files-list">
                        </ul>
                        <a id="process-documents"
                            class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 w-full">
                            Process documents
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @push('script')
        <script>
            $(document).ready(function() {
                var files = [];
                $(document).on('change', '#dropzone-file', (e) => {
                    e.preventDefault();
                    console.log(e.target.files);
                    var files = Array.from(e.target.files);
                    let div = $(document).find('#files-list');

                    if (files.length < 2) {
                        alert("Please upload more than one file, use Ctrl or Shift to select multiple files");
                        return false;
                    }

                    if (files) {
                        $(document).find('.files').removeClass('hidden')
                    } else {
                        $(document).find('.files').addClass('hidden');
                    }

                    files.forEach((file) => {
                        const parts = file.name.split('.');
                        const name = parts.slice(0, -1).join('.');
                        const extension = parts[parts.length - 1];
                        const fileSize = file.size;
                        let item = '';

                        item += '<li class="pb-3 sm:pb-4 border-b border-dashed border-gray-300 pt-4">';
                        item += '<div class="flex items-center space-x-4 rtl:space-x-reverse">';
                        item += '<div class="flex-1 min-w-0">';
                        item +=
                            '<p class="text-md uppercase font-medium text-gray-900 truncate dark:text-white">';
                        item += name;
                        item += '</p>';
                        item +=
                            '<p class="text-xs text-gray-500 truncate dark:text-gray-400 uppercase">';
                        item += extension;
                        item += '</p>';
                        item += '</div>';
                        item +=
                            '<div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">';
                        item += (fileSize / 1024).toFixed(2) + ' KB';
                        item += '</div>';
                        item += '</div>';
                        item += '</li>'
                        $(div).append(item);
                    });

                });

                $(document).on('click', '#process-documents', (e) => {
                    e.preventDefault();

                    const files = $(':file')[0].files;

                    $('#process-docs').submit();
                });
            });
        </script>
    @endpush
@endsection
