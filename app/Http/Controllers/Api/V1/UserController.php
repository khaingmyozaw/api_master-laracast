<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\UserFilter;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Exception;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use PHPUnit\Framework\MockObject\Generator\DuplicateMethodException;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserFilter $filters)
    {
        return UserResource::collection(User::filter($filters)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            return new UserResource(User::create($request->mappedAttributes()));
        }catch (QueryException $exception) {
            return $this->ok('User already exist.', [
                'error' => 'An account has already been taken with the provided email.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($this->included('tickets')) {
            return new UserResource($user->load('tickets'));
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            $user->update($request->mappedAttributes());

            return new UserResource($user);
        } catch (ModelNotFoundException $exception) {
            return $this->error('User cannot be found.', 404);
        }
    }

    public function replace(StoreUserRequest $request, int $user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            $user->update($request->mappedAttributes());

            return new UserResource($user);
        } catch (ModelNotFoundException $exception) {
            return $this->error('User cannot be found.', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
