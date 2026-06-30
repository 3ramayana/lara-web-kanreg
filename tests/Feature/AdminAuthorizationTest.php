<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Departement;
use Spatie\Permission\Models\Role;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Filament might need some basic setup or specific routes, but we can test the base route
        $this->adminRole = Role::create(['name' => 'admin']);
        $this->userRole = Role::create(['name' => 'user']);
        
        $departement = Departement::create(['name' => 'IT', 'slug' => 'it']);
        
        $this->adminUser = User::factory()->create(['departement_id' => $departement->id]);
        $this->adminUser->assignRole('admin');
        
        $this->regularUser = User::factory()->create(['departement_id' => $departement->id]);
        $this->regularUser->assignRole('user');
    }

    public function test_guest_cannot_access_admin_panel(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_regular_user_cannot_access_filament_resources(): void
    {
        $this->actingAs($this->regularUser);

        // Accessing a resource should return 403 Forbidden due to AdminPolicy
        $response = $this->get('/admin/posts');
        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_filament_resources(): void
    {
        $this->actingAs($this->adminUser);

        // Accessing a resource should return 200 OK for admin
        $response = $this->get('/admin/posts');
        $response->assertStatus(200);
    }
}
