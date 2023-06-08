<?php

namespace App\Repositories;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserDeleted;
use App\Events\Models\User\UserUpdated;
use App\Exceptions\GeneralJsonException;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserRepository extends BaseRepository
{

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes){
            $created = User::query()->create([
                'name' => data_get($attributes, 'name'),
                'email' => data_get($attributes, 'email'),
                'password' => data_get($attributes, 'email')
            ]);
            throw_if(!$created, GeneralJsonException::class, 'Failed to create.');
            event(new UserCreated($created));
            Mail::to($created)->send(new WelcomeMail($created));
            return $created;
        });
    }

    /**
     * @param User $user
     * @param array $attributes
     * @return mixed
     */
    public function update($user, array $attributes)
    {
        return DB::transaction(function () use($user, $attributes){
            $updated = $user->update([
                'name' => data_get($attributes, 'name', $user->name),
                'email' => data_get($attributes, 'email', $user->email),
                'password' => data_get($attributes, 'password', $user->password)
            ]);
//            if(!$updated){
//                throw new \Exception('Failed to update user.');
//            }
            throw_if(!$updated, GeneralJsonException::class, 'Failed to update user.');
            event(new UserUpdated($user));
            return $user;
        });
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function delete($user)
    {
        return DB::transaction(function () use($user){
            $deleted = $user->forceDelete();
//            if(!$deleted){
//                throw new \Exception("cannot delete user.");
//            }
            throw_if(!$deleted, GeneralJsonException::class, 'cannot delete user.');
            event(new UserDeleted($user));
            return $deleted;
        });
    }
}
