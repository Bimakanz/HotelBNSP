<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Feature Test AdminAccessTest
 * 
 * Deskripsi: Menguji otorisasi multi-role (Role 1 Guest vs Role 2 Admin)
 *            dan kapabilitas manajemen master kamar dan reservasi.
 * Initial State: Pengguna dengan berbagai role diuji pada endpoint administratif.
 * Final State: Pembatasan hak akses dan operasi CRUD admin terverifikasi aman.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $guest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name'     => 'Admin Test',
            'email'    => 'admin@test.com',
            'role'     => 'admin',
            'password' => Hash::make('password'),
        ]);

        $this->guest = User::create([
            'name'     => 'Guest Test',
            'email'    => 'guest@test.com',
            'role'     => 'guest',
            'password' => Hash::make('password'),
        ]);
    }

    /**
     * Memastikan pengunjung non-login diarahkan ke login saat mengakses rute /admin.
     */
    public function test_visiting_admin_root_redirects_to_login_when_unauthenticated(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    /**
     * Memastikan admin diarahkan ke dashboard saat mengakses rute /admin.
     */
    public function test_visiting_admin_root_redirects_to_dashboard_when_authenticated_as_admin(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');
        $response->assertRedirect('/admin/dashboard');
    }

    /**
     * Memastikan pengunjung non-login diarahkan ke login saat mengakses rute admin.
     */
    public function test_guest_unauthenticated_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Memastikan user dengan role 'guest' ditolak dengan 403 Forbidden saat mengakses admin.
     */
    public function test_user_with_guest_role_is_forbidden_from_admin(): void
    {
        $response = $this->actingAs($this->guest)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    /**
     * Memastikan user dengan role 'admin' berhasil mengakses dashboard admin.
     */
    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Pusat Analitik & Operasional Hotel');
    }

    /**
     * Memastikan admin dapat menambah data master kamar baru.
     */
    public function test_admin_can_create_room(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/rooms', [
            'code'        => 'NEW-01',
            'name'        => 'Penthouse Suite',
            'tagline'     => 'Ultimate Luxury',
            'price'       => 1500000,
            'capacity'    => 4,
            'bed_type'    => '2 King Beds',
            'size'        => '100 m²',
            'description' => 'Kamar paling mewah di lantai teratas.',
            'facilities'  => "Jacuzzi Privat\nButler 24 Jam",
            'is_active'   => 1,
        ]);

        $response->assertRedirect('/admin/rooms');
        $this->assertDatabaseHas('rooms', ['code' => 'NEW-01']);
    }
}

