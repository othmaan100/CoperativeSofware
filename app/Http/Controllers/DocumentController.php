<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function download(Document $document)
    {
        abort_unless(Document::userCanView(Auth::user(), $document->documentable), 403);

        return Storage::disk('local')->download($document->file_path, $document->original_filename);
    }
}
