<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Util\Util;

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
    const PIXABAY_API_URL = 'https://pixabay.com/api/';
    const PEXEL_API_URL = 'https://api.pexels.com/v1/';

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
        return $this->callPexelApi($data);
    }

    /**
     * Call this function to get data from Pexel API
     */
    private function callPexelApi(array $data) {
        $search_url = self::PEXEL_API_URL . "search?query=". urlencode($data['search_text']);
        
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
            $search_url = $search_url . "&color=" . $data['colors'];
        }
        if (!empty($data['page_number'])) {
            $search_url = $search_url . "&page=" . $data['page_number'];
        }

        if (!empty($data['per_page'])) {
            $per_page = $data['per_page'];
        } else {
            $per_page = 20;
        }

        $search_url = $search_url . "&per_page=".$per_page;

        Log::debug($search_url);

        try {
            // Make an API Call
            $response = Http::withHeaders([
                'Authorization' => env('PEXEL_API_KEY')
            ])->get($search_url);

            $this->jsonResponse['data'] = json_decode($response);
            $this->jsonResponse['success'] = true;
        } catch (Exception $ex) {
            $this->jsonResponse['message'] = $ex->getMessage();
        }
        
        if (!empty($data['user_id'])) {
            Log::debug("User Id: ". $data['user_id']);
            $this->saveSearchHistory(intval($data['user_id']), $search_url, '');
        }
        
        return response($this->jsonResponse);
    }

    /**
     * Call this function to get data from Pixabay API
     */
    private function callPixabayApi(array $data) {
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
        
        Log::debug("User Id: ". $data['user_id']);

        if (!empty($data['user_id'])) {
            $this->saveSearchHistory(intval($data['user_id']), $search_url, '');
        }

        return response($this->jsonResponse);
    }

    /**
     * Call this method to save user search history
     */
    private function saveSearchHistory($user_id, $search_url, $search_result) {
        Log::debug($user_id .' - '. $search_url);
        // Save search url into DB
        DB::table('search')->insert(
            ['user_id' => $user_id, 
            'search_query' => $search_url,
            'search_results' => $search_result]
        );
        
        // Call Utility funciton to save User Activity
        Util::saveUserActivity($user_id, 'search', 'Performed Search: '. $search_url);
    }

    public function history(Request $request) {
        $search_history = DB::table('search')
            ->where('user_id', $request->user()->id)->get();
        $this->jsonResponse['data'] = $search_history;
        $this->jsonResponse['success'] = true;
        return response($this->jsonResponse);
    }
}