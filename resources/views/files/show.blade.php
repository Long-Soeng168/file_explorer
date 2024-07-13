<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $file->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">{{ $file->title }}</h1>
        <a href="{{ route('files.create', ['parentId' => $file->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Create New Folder/File</a>
        <ul>
            @foreach($file->children as $child)
                <li class="mb-2">
                    <span class="text-lg">{{ $child->title }} ({{ $child->type }})</span>
                    @if($child->type == 'folder')
                        <a href="{{ route('files.show', $child->id) }}" class="text-blue-500 hover:underline">View</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
