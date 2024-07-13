<?php
namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::where('parent_id', null)->get();
        return view('files.index', compact('files'));
    }

    public function create($parentId = null)
    {
        return view('files.create', compact('parentId'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file',
            'type' => 'required|in:folder,file',
            'parent_id' => 'nullable|exists:files,id',
        ]);

        $fileData = [
            'title' => $validatedData['title'],
            'type' => $validatedData['type'],
            'parent_id' => $validatedData['parent_id'] ?? null,
        ];

        if ($request->hasFile('file')) {
            $fileData['file_name'] = $request->file('file')->store('files');
        }

        File::create($fileData);

        return redirect()->route('files.index')->with('success', 'File or folder created successfully.');
    }

    public function show(File $file)
    {
        return view('files.show', compact('file'));
    }

    public function destroy(File $file)
    {
        if ($file->type == 'file' && $file->file_name) {
            Storage::delete($file->file_name);
        }

        $file->delete();

        return redirect()->route('files.index')->with('success', 'File or folder deleted successfully.');
    }
}
