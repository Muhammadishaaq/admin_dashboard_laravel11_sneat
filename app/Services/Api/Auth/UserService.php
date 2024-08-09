<?php

namespace App\Services\Api\Auth;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Hash;
use Auth;


class UserService
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function register(array $data)
    {
        $user = $this->model::create([
            'name'   => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
        ]);
        $user->assignRole('user');
        return $user;
    }

    public function login(array $data)
    {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['user'] = $user;
            return $success;
        }

    }

    public function update_profile($data)
    {
        $user = $this->model::find(auth()->user()->id);
        $imagePath=null;
        if (isset($data['profile_image']) && $user->profile_image) {
            $this->deleteImage($user->profile_image);
        }

        if (isset($data['profile_image'])) {

            $imagePath = $this->uploadImage($data['profile_image']);

        }
        $user->update([
            'name'   => $data['name'] ?? $user->name,
            'profile_image'=>$imagePath,
            'profile_image_url'=>asset($imagePath),
        ]);
        return $user;
    }

    public function update_password($data)
    {
        $user = $this->model::find(auth()->user()->id);
        $update = $user->update([
            'password'     => Hash::make($data['password']) ?? $user->password,
        ]);
        return $update;
    }

    private function uploadImage(UploadedFile $file)
    {
        $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('profile_image/'), $imageName);
        return 'profile_image/' . $imageName;
    }

    private function deleteImage($imagePath)
    {
        if (file_exists(public_path($imagePath))) {
            unlink(public_path($imagePath));
        }
    }
}