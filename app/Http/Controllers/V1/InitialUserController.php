<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InitialUserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InitialUserController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->success('The user information is available.', (new InitialUserResource($request->user()))->resolve());
    }
}
