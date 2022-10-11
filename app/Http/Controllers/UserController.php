<?php

namespace App\Http\Controllers;

use App\Jobs\FileUpload;
use App\Models\Hour;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller {

    public function index()
    {

        return Inertia::render('Users/View', [
            'users' => \App\Models\User::query()
                ->when(\Illuminate\Support\Facades\Request::input('search'), function($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' => $user->username,
                ]),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'file' => 'image|nullable',
            'name' => 'required',
            'username' => 'nullable|string',
            'email' => 'email|required|unique:users,email',
            'password' => 'required',
        ]);
        $user = \App\Models\User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $file = [];
        $file[] = $request->file;
        if($request->file)
        {
            //remove the current profile picture
            if($user->hasMedia('Profile'))
            {
                $fileId = $user->getFirstMedia('Profile')->id;
                MediaController::fileDeleteMethod($fileId);
            }
            // This uploads Profile images to a users profile
            dispatch(new FileUpload($file, $user, 'Profile'))->onQueue('low')->afterResponse();
        }

        return to_route('users.index');
    }

    public function show(User $user)
    {

        return Inertia::render('Users/Show', [
            'user' => $user
                ->fill([
                    'id' => $user->id,
                    'name' => ucfirst($user->name),
                    'email' => $user->email,
                    'username' => $user->username,
                    'date' => Carbon::parse($user->created_at)->diffForHumans(),
                    'photo' => $user->Photo(),
                ]),
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user->fill([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'photo' => $user->Photo(),
            ]),
        ]);
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'file' => 'image|nullable',
            'name' => 'required',
            'username' => 'nullable|string',
            'email' => 'email|required',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        $file = [];
        $file[] = $request->file;
        if($request->file)
        {
            //remove the current profile picture
            if($user->hasMedia('Profile'))
            {
                $fileId = $user->getFirstMedia('Profile')->id;
                MediaController::fileDeleteMethod($fileId);
            }
            // This uploads Profile images to a users profile
            dispatch(new FileUpload($file, $user, 'Profile'))->onQueue('low')->afterResponse();
        }

        return to_route('users.show', $user->id);
    }


    public function delete(User $user)
    {
        if(auth()->user()->cant('delete', User::class))
        {
            return ErrorController::forbidden(route('home'), 'Unauthorised to delete User.');
        }
        $user->delete();

        return to_route('users.index');
    }

    public function find(User $user)
    {
        return $user;
    }

}
