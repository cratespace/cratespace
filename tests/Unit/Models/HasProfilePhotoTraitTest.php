<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasProfilePhotoTraitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function all_users_have_profile_photos()
    {
        $user = create(User::class, ['profile_photo_path' => null]);

        $this->assertNotNull($user->profile_photo_url);
    }

    /** @test */
    public function a_user_can_update_their_profile_photo()
    {
        Storage::fake('profile-photos');
        $photo = UploadedFile::fake()->image('avatar.jpg');
        $user = create(User::class, ['profile_photo_path' => null]);
        $previousProfilePhoto = $user->profile_photo_url;
        $user->updateProfilePhoto($photo);

        $this->assertNotSame($previousProfilePhoto, $user->fresh()->profile_photo_url);
    }

    /** @test */
    public function a_user_can_delete_their_profile_photo()
    {
        Storage::fake('profile-photos');
        $photo = UploadedFile::fake()->image('avatar.jpg');

        $user = create(User::class, ['profile_photo_path' => Str::random(40)]);

        $user->updateProfilePhoto($photo);
        $this->assertNotNull($user->fresh()->profile_photo_path);

        $user->deleteProfilePhoto();
        $this->assertNull($user->fresh()->profile_photo_path);
    }
}
