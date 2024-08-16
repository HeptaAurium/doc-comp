<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Traits\Aspose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResultController extends Controller
{
    use Aspose;
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
        if (!$request->has('files')) {
            return redirect()->with('message', 'No file uploaded');
        }

        $files = $request->file('files');
        $paths = [];

        foreach ($request->file('files') as $file) {
            $path = $file->store('uploaded-files', ['disk' => 'public_uploads']);
            array_push($paths, $path);
        }
        $results = $this->example($paths);
        return redirect()->back()->with('message', 'Files uploaded successfully');
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
