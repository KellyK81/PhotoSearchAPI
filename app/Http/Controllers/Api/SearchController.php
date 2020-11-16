<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SearchController extends AbstractApiController
{
    const PIXABAY_API_URL = "https://pixabay.com/api/";

    /**
     * Call this method to search photos using various parameters:
     *  Category, Image Type, Image Author, Size, Orientation, Color
     */
    public function search(Request $request) { 
        
        $validator = Validator::make($request->all(), [
            'search_text' => 'required|string|min:3|max:100',
            'category' => 'string|max:65',
            'image_type' => 'string|max:10',
            'image_author' => 'string|max:2|max:65',
            'min_width' => 'integer',
            'min_height' => 'integer',
            'orientation' => 'string|in:horizontal,vertical',
            'colors' => 'string|min:3|max:15',
            'page_number' => 'integer|min:1',
        ]);

        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], Response::HTTP_BAD_REQUEST);            
        }

        return $this->callThirdPartyApis($request->all());
    }

    private function callThirdPartyApis(array $data) {
        $search_url = self::PIXABAY_API_URL . "?key=". env('PIXABAY_API_KEY','') . 
            "&q=" . urlencode($data['search_text']);
        
        if (!empty($data['category'])) {
            $search_url = $search_url . "&category=" . $data['category'];
        }
        if (!empty($data['image_type'])) {
            $search_url = $search_url . "&image_type=" . $data['image_type'];
        }
        if (!empty($data['min_width'])) {
            $search_url = $search_url . "&min_width=" . $data['min_width'];
        }
        if (!empty($data['min_height'])) {
            $search_url = $search_url . "&min_height=" . $data['min_height'];
        }
        if (!empty($data['orientation'])) {
            $search_url = $search_url . "&orientation=" . $data['orientation'];
        }
        if (!empty($data['colors'])) {
            $search_url = $search_url . "&colors=" . $data['colors'];
        }
        if (!empty($data['page_number'])) {
            $search_url = $search_url . "&page=" . $data['page_number'];
        }

        Log::debug($search_url);

        try {
            // Make an API Call
            $response = Http::get($search_url);
            $this->jsonResponse['data'] = json_decode($response);
            $this->jsonResponse['success'] = true;
        } catch (Exception $ex) {
            $this->jsonResponse['message'] = $ex->getMessage();
        }
        
        return response($this->jsonResponse);
    }
}