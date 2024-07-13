<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Explorer</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">File Explorer</h1>

        <h2 class="text-xl mb-4">Current Path:
            <span class="text-gray-700">
                @php
                    $parts = $path ? explode('/', $path) : [];
                    $currentPath = '';
                @endphp
                @foreach($parts as $index => $part)
                    @php
                        $currentPath .= $part . '/';
                    @endphp
                    @if($part)
                        / <a href="{{ route('file.explorer.folder', str_replace('/', '-', trim($currentPath, '/'))) }}" class="text-blue-500 hover:underline capitalize">
                            {{ $part }}
                        </a>
                    @endif
                @endforeach
            </span>
        </h2>

        <form action="{{ route('file.explorer.upload') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="flex items-center">
                <input type="file" name="file" class="border border-gray-300 p-2 rounded mr-2">
                <input type="hidden" name="path" value="{{ $path ?? '/' }}">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Upload File</button>
            </div>
        </form>

        <form action="{{ route('file.explorer.createFolder') }}" method="POST" class="mb-6">
            @csrf
            <div class="flex items-center">
                <input type="text" name="folder_name" placeholder="Folder Name" class="border border-gray-300 p-2 rounded mr-2">
                <input type="hidden" name="path" value="{{ $path ?? '/' }}">
                <button type="submit" class="bg-green-500 text-white p-2 rounded">Create Folder</button>
            </div>
        </form>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Folders</h3>
            <ul class="list-disc pl-5">
                @foreach($folders as $folder)
                    <li class="mb-1 flex items-center">
                        <a href="{{ route('file.explorer.folder', str_replace('/', '-', $folder)) }}" class="text-blue-500 hover:underline">
                            {{ basename($folder) }}
                        </a>
                        <form action="{{ route('file.explorer.rename') }}" method="POST" class="ml-4 flex items-center">
                            @csrf
                            <input type="hidden" name="path" value="{{ $path }}">
                            <input type="hidden" name="old_name" value="{{ basename($folder) }}">
                            <input type="hidden" name="old_path" value="{{ $folder }}">
                            <input type="text" name="new_name" placeholder="New name" class="border border-gray-300 p-1 rounded mr-2">
                            <button type="submit" class="bg-yellow-500 text-white p-1 rounded">Rename</button>
                        </form>
                        <form action="{{ route('file.explorer.delete') }}" method="POST" class="ml-4">
                            @csrf
                            <input type="hidden" name="path" value="{{ $path }}">
                            <input type="hidden" name="name" value="{{ basename($folder) }}">
                            <button type="submit" class="bg-red-500 text-white p-1 rounded">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Files</h3>
            <ul class="list-disc pl-5">
                @foreach($files as $file)
                    <li class="mb-1 flex items-center">
                        {{ basename($file) }}
                        <form action="{{ route('file.explorer.rename') }}" method="POST" class="ml-4 flex items-center">
                            @csrf
                            <input type="hidden" name="path" value="{{ $path }}">
                            <input type="hidden" name="old_name" value="{{ basename($file) }}">
                            <input type="hidden" name="old_path" value="{{ $file }}">
                            <input type="text" name="new_name" placeholder="New name" class="border border-gray-300 p-1 rounded mr-2">
                            <button type="submit" class="bg-yellow-500 text-white p-1 rounded">Rename</button>
                        </form>
                        <form action="{{ route('file.explorer.delete') }}" method="POST" class="ml-4">
                            @csrf
                            <input type="hidden" name="path" value="{{ $path }}">
                            <input type="hidden" name="name" value="{{ basename($file) }}">
                            <button type="submit" class="bg-red-500 text-white p-1 rounded">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</body>
</html>
