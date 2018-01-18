<?php

namespace App\Http\Controllers\Write;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UploadController extends Controller
{
    protected $knownTypes = ['image', 'video'];

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, string $mediaType)
    {
        $this->checkType($mediaType);

        $input = $request->validate($this->rulesForType($mediaType));

        $folder = 'tmpfiles';
        $filename = Storage::disk('local', 'private')
            ->putFile($folder, $request->file);

        return response()->json([
            'success' => true,
            'tmpFile'=> Storage::url($filename)
        ], 201);
    }

    protected function checkType(string $mediaType)
    {
        if (! in_array($mediaType, $this->knownTypes)) {
            abort(404);
        }
    }

    protected function rulesForType(string $mediaType) : array
    {
        switch ($mediaType) {
            case 'image':
                $rules = [
                    'file' => 'required|mimes:jpeg,bmp,png',
                ];
                break;
            case 'video':
                $rules = [
                    'file' => 'required|mimes:mpeg,mp4'
                ];
                break;
            default:
                throw new \InvalidArgumentException("Unknown type.");
        }

        return $rules;
    }
}
