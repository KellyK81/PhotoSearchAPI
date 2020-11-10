<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SearchController extends AbstractApiController
{
    /**
     * Call this method to search photos using various parameters:
     *  Category, Image Type, Image Author, Size, Orientation, Color
     */
    public function search(Request $request) { 
        
        $validator = Validator::make($request->all(), [
            'free_search_text' => 'required|string|min:3|max:100',
            'category' => 'string|max:65',
            'image_type' => 'string|max:10',
            'image_author' => 'string|max:2|max:65',
            'image_width' => 'integer',
            'image_height' => 'integer',
            'orientation' => 'string|in:horizontal,vertical',
            'color' => 'string|min:3|max:15',
        ]);

        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], Response::HTTP_BAD_REQUEST);            
        }

        return $this->callThirdPartyApis($request->all());

    }

    private function callThirdPartyApis(array $data) {
        // @TODO: Implement the code to call the third party APIs and return the search results.
        return response($this->jsonResponse);
    }
}
