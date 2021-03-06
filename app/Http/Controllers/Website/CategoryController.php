<?php

namespace App\Http\Controllers\Website;

use App\Utility\ApiClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CategoryController
 *
 * @resource Categories
 *
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    protected $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        parent::__construct($apiClient);
        $this->apiClient = $apiClient;
    }

    function viewAll(Request $request)
    {
        $categoriesResponse = $this->apiClient->get('categories', $request->all());

        if (isset($categoriesResponse['status_code']) == 404) {
            abort(404);
        }

        $data = [
            'data' => [
                'categories' => $categoriesResponse,
            ]
        ];

        return view('categories', $data);
    }

    function view(Request $request, $slug)
    {
        $categoryResponse = $this->apiClient->get('categories/'.$slug);
        $request->request->add(['categoryId' => $categoryResponse['id']]);

        $songsResponse = $this->apiClient->get('songs', $request->all());

        $request->request->add(['sessionId' => session()->getId()]);
        $favoritesResponse = $this->apiClient->get('favorites', $request->all());

        if (isset($categoryResponse['status_code']) == 404) {
            abort(404);
        }

        $data = [
            'data' => [
                'category' => $categoryResponse,
                'songs' => $songsResponse,
            ]
        ];

        return view('category', $data);
    }
}
