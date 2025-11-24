<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Opd;
use App\Models\Agenda;
use App\Models\Absensi;
use Illuminate\Support\Facades\Hash;

class AgendaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $opd;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->opd = Opd::create([
            'name' => 'Test OPD',
            'singkatan' => 'TOPD',
            'alamat' => 'Test Address',
            'telp' => '081234567890'
        ]);

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);
    }

    public function test_dashboard_page_loads()
    {
        $response = $this->actingAs($this->user)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_opd_index_page_loads()
    {
        $response = $this->actingAs($this->user)->get('/opd');
        $response->assertStatus(200);
    }

    public function test_agenda_index_page_loads()
    {
        $response = $this->actingAs($this->user)->get('/agenda');
        $response->assertStatus(200);
    }

    public function test_agenda_creation()
    {
        $agendaData = [
            'name' => 'Test Agenda',
            'opd_id' => $this->opd->id,
            'user_id' => $this->user->id,
            'date' => now()->addDays(7)->format('Y-m-d'),
            'jam_mulai' => '09:00',
            'jam_selesai' => '12:00',
            'link_zoom' => 'https://zoom.us/test',
            'link_paparan' => 'https://example.com/presentation',
            'catatan' => 'Test notes',
            'slug' => 'test-agenda'
        ];

        $agenda = Agenda::create($agendaData);
        
        $this->assertDatabaseHas('tb_agenda', [
            'name' => 'Test Agenda',
            'opd_id' => $this->opd->id
        ]);
        
        $this->assertNotNull($agenda->slug);
    }

    public function test_attendance_creation()
    {
        $agenda = Agenda::create([
            'name' => 'Test Agenda',
            'opd_id' => $this->opd->id,
            'user_id' => $this->user->id,
            'date' => now()->addDays(7)->format('Y-m-d'),
            'jam_mulai' => '09:00',
            'jam_selesai' => '12:00',
            'slug' => 'test-agenda'
        ]);

        $attendanceData = [
            'agenda_id' => $agenda->id,
            'nama' => 'John Doe',
            'nip_nik' => '1234567890',
            'jabatan' => 'Manager',
            'instansi' => 'Test Institution',
            'telepon' => '081234567890',
            'email' => 'john@example.com',
            'status' => 'hadir',
            'catatan' => 'Test attendance'
        ];

        $attendance = Absensi::create([
            'agenda_id' => $agenda->id,
            'name' => 'Test Participant',
            'nip_nik' => '1234567890',
            'asal_daerah' => 'dalam_kota',
            'telp' => '081234567890',
            'instansi' => 'Test Institution',
            'waktu_hadir' => now()
        ]);
        
        $this->assertDatabaseHas('tb_absensi', [
            'name' => 'Test Participant',
            'agenda_id' => $agenda->id
        ]);
        
        $this->assertNotNull($attendance->waktu_hadir);
    }

    public function test_public_attendance_form_access()
    {
        $agenda = Agenda::create([
            'name' => 'Test Agenda',
            'opd_id' => $this->opd->id,
            'user_id' => $this->user->id,
            'date' => now()->addDays(7)->format('Y-m-d'),
            'jam_mulai' => '09:00',
            'jam_selesai' => '12:00',
            'slug' => 'test-agenda'
        ]);

        $response = $this->get("/absensi/{$agenda->id}/{$agenda->slug}");
        $response->assertStatus(200);
    }
}