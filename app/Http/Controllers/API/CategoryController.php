<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Service\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CategoryController
 *
 * @resource Categories
 *
 * @package App\Http\Controllers\API
 */
class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getCategories(Request $request)
    {
        return $this->categoryService->getAll($request->all());
    }

    /*
     * @Route("/{slug}", requirements={"slug"})
     *
     * @Method({"GET"})
     */
    public function getCategory($slug)
    {
        $category = $this->categoryService->getCategory($slug);

        if (!$category) {
            $this->throwNotFoundEntity(trans_choice('messages.error.not_found',0, ['entity' => trans_choice('messages.entity.category', 0)]));
        }

        return $category;
    }
}
