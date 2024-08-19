<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Traits\Doc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResultController extends Controller
{
    use Doc;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('result.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = [];
        if (!$request->has('files')) {
            return redirect()->with('message', 'No file uploaded');
        }

        $files = $request->file('files');
        $paths = [];


        foreach ($request->file('files') as $file) {
            $path = [];
            $f = fopen($file, 'rb');
            $contents = fread($f, filesize($file));
            $path['word_count'] = str_word_count($contents);
            $path['string_count'] = strlen($contents);
            $path['file'] = $file->store('uploaded-files', ['disk' => 'public_uploads']);
            $path['file_extension'] = $file->getClientOriginalExtension();
            $path['file_name'] = $file->getClientOriginalName();
            $path['file_size'] = $file->getSize() / 1024;
            array_push($paths, $path);
        }
        $data['paths'] = $paths;
        $data['similarity'] = $this->get_similarity($paths);
        return view('result.index', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        //
    }
}
