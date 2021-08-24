<?php

namespace Tests\Feature;

use App\Domains\Permission\UsersRepository;
use App\Models\User;
use App\Repository\RepositoryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class WildcardPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function testWildcardExample()
    {

        $email = 'pipiega@test.com';

        /** @var User $user */
        $user = User::query()->firstOrCreate(
            [
                'email' => $email,
                'name' => 'grybas',
                'password' => 'dar didesnis grybas',
            ]
        );

//        $this->be($user);

        // ================================================================================================
        // == from example https://spatie.be/docs/laravel-permission/v3/basic-usage/wildcard-permissions
        // ================================================================================================

        Permission::create(['name' => 'posts.*']);
        $user->givePermissionTo('posts.*');
// is the same as
        Permission::create(['name' => 'posts']);
        $user->givePermissionTo('posts');

// will be true
        $this->assertTrue($user->can('posts.create'));
        $this->assertTrue($user->can('posts.edit'));
        $this->assertTrue($user->can('posts.delete'));

        $this->assertFalse($user->can('belenkas'));
    }
}
