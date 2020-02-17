<?php

namespace App\Http\Controllers\API;

use App\Entity\Favorite;
use App\Service\SongService;
use Illuminate\Validation\Rule;
use Validator;
use App\Service\FavoriteService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class FavoriteController
 *
 * @resource Favorites
 *
 * @package App\Http\Controllers\API
 */
class FavoriteController extends Controller
{
    private $favoriteService;
    private $songService;

    public function __construct(FavoriteService $favoriteService, SongService $songService)
    {
        $this->favoriteService = $favoriteService;
        $this->songService = $songService;
    }

    public function getFavorites(Request $request)
    {
        return $this->favoriteService->getAll($request->all());
    }

    public function addToFavorite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sessionId' => 'required|filled',
            'songId' => 'required|filled',
        ]);

        if ($validator->fails()) {
            $this->throwUnprocessableEntity($validator);
        }

        /** @var Favorite $favorite */
        $favorite = new Favorite();
        $favorite = $this->handleEntity($favorite, $request->all());

        if ($request->get('songId')) {
            $song = $this->songService->getSongObject($request->get('songId'));
            if (!$song) {
                $this->throwNotFoundEntity(trans_choice('messages.error.not_found', 0, ['entity' => trans_choice('messages.entity.song', 0)]));
            }
            $favorite->setSong($song);
        }

        $favorite = $this->favoriteService->save($favorite);

        return response()->json(['id' => $favorite->getId()]);
    }
}
