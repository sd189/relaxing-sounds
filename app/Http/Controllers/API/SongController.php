<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Service\SongService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SongController
 *
 * @resource Songs
 *
 * @package App\Http\Controllers\API
 */
class SongController extends Controller
{
    private $songService;

    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    public function getSongs(Request $request)
    {
        return $this->songService->getAll($request->all());
    }
}
