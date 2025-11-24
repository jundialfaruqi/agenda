# Testing & Deployment Guide - Agenda & Absensi QR Code

## 1. Testing Implementation

### 1.1 Feature Tests Setup

```bash
# Create test directories
mkdir -p tests/Feature/Admin
mkdir -p tests/Feature/Public
mkdir -p tests/Unit/Services

# Create test files
php artisan make:test Admin/OpdManagementTest
php artisan make:test Admin/AgendaManagementTest
php artisan make:test Public/AttendanceTest
php artisan make:test Services/QrCodeServiceTest --unit
php artisan make:test Services/PdfExportServiceTest --unit
```

### 1.2 OPD Management Tests (tests/Feature/Admin/OpdManagementTest.php)

```php
<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Opd;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class OpdManagementTest extends TestCase
{
    use RefreshDatabase;
    
    private $admin;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($this->admin);
    }
    
    /** @test */
    public function admin_can_view_opd_list()
    {
        Opd::factory()->count(5)->create();
        
        $response = $this->get('/admin/opd');
        
        $response->assertStatus(200);
        $response->assertViewHas('opds');
    }
    
    /** @test */
    public function admin_can_create_opd()
    {
        Storage::fake('public');
        
        $opdData = [
            'name' => 'Dinas Komunikasi dan Informatika',
            'alamat' => 'Jl. Sudirman No. 123',
            'telp' => '021-12345678',
            'email' => 'diskominfo@kota.go.id',
            'logo' => UploadedFile::fake()->image('logo.png', 200, 200)
        ];
        
        $response = $this->post('/admin/opd', $opdData);
        
        $response->assertRedirect('/admin/opd');
        $this->assertDatabaseHas('tb_opd', [
            'name' => 'Dinas Komunikasi dan Informatika',
            'email' => 'diskominfo@kota.go.id'
        ]);
        
        Storage::disk('public')->assertExists('logos/logo.png');
    }
    
    /** @test */
    public function admin_cannot_create_opd_with_invalid_data()
    {
        $response = $this->post('/admin/opd', [
            'name' => '',
            'email' => 'invalid-email'
        ]);
        
        $response->assertSessionHasErrors(['name', 'email']);
    }
    
    /** @test */
    public function admin_can_update_opd()
    {
        $opd = Opd::factory()->create();
        
        $response = $this->put("/admin/opd/{$opd->id}", [
            'name' => 'Updated OPD Name',
            'alamat' => 'New Address',
            'telp' => 'New Phone'
        ]);
        
        $response->assertRedirect('/admin/opd');
        $this->assertDatabaseHas('tb_opd', [
            'id' => $opd->id,
            'name' => 'Updated OPD Name'
        ]);
    }
    
    /** @test */
    public function admin_can_delete_opd()
    {
        $opd = Opd::factory()->create();
        
        $response = $this->delete("/admin/opd/{$opd->id}");
        
        $response->assertRedirect('/admin/opd');
        $this->assertSoftDeleted('tb_opd', ['id' => $opd->id]);
    }
    
    /** @test */
    public function admin_cannot_delete_opd_with_related_agendas()
    {
        $opd = Opd::factory()->hasAgendas(2)->create();
        
        $response = $this->delete("/admin/opd/{$opd->id}");
        
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('tb_opd', ['id' => $opd->id]);
    }
}
```

### 1.3 Agenda Management Tests (tests/Feature/Admin/AgendaManagementTest.php)

```php
<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Opd;
use App\Models\Agenda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class AgendaManagementTest extends TestCase
{
    use RefreshDatabase;
    
    private $admin;
    private $opd;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->opd = Opd::factory()->create();
        $this->actingAs($this->admin);
    }
    
    /** @test */
    public function admin_can_view_agenda_list()
    {
        Agenda::factory()->count(3)->create();
        
        $response = $this->get('/admin/agenda');
        
        $response->assertStatus(200);
        $response->assertViewHas('agendas');
    }
    
    /** @test */
    public function admin_can_create_agenda_with_qr_code()
    {
        Storage::fake('public');
        
        $agendaData = [
            'name' => 'Rapat Koordinasi',
            'date' => now()->addDays(7)->format('Y-m-d'),
            'jam_mulai' => '09:00',
            'jam_selesai' => '12:00',
            'opd_id' => $this->opd->id,
            'tempat' => 'Ruang Rapat A',
            'catatan' => 'Pembahasan Rencana Kerja'
        ];
        
        $response = $this->post('/admin/agenda', $agendaData);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('tb_agenda', [
            'name' => 'Rapat Koordinasi',
            'opd_id' => $this->opd->id
        ]);
        
        // Check QR code was generated
        $agenda = Agenda::where('name', 'Rapat Koordinasi')->first();
        $this->assertNotNull($agenda->barcode);
    }
    
    /** @test */
    public function qr_code_is_regenerated_when_agenda_updated()
    {
        Storage::fake('public');
        
        $agenda = Agenda::factory()->create([
            'opd_id' => $this->opd->id,
            'barcode' => 'old-qr-code.svg'
        ]);
        
        $response = $this->put("/admin/agenda/{$agenda->id}", [
            'name' => 'Updated Agenda Name',
            'date' => $agenda->date->format('Y-m-d'),
            'jam_mulai' => $agenda->jam_mulai,
            'jam_selesai' => $agenda->jam_selesai,
            'opd_id' => $this->opd->id,
            'tempat' => $agenda->tempat
        ]);
        
        $response->assertRedirect();
        
        $updatedAgenda = $agenda->fresh();
        $this->assertNotEquals('old-qr-code.svg', $updatedAgenda->barcode);
    }
    
    /** @test */
    public function admin_can_duplicate_agenda()
    {
        $agenda = Agenda::factory()->create([
            'opd_id' => $this->opd->id
        ]);
        
        $response = $this->post("/admin/agenda/{$agenda->id}/duplicate");
        
        $response->assertRedirect();
        $this->assertDatabaseCount('tb_agenda', 2);
        
        $originalAgenda = Agenda::find($agenda->id);
        $duplicatedAgenda = Agenda::where('id', '!=', $agenda->id)->first();
        
        $this->assertEquals($originalAgenda->name . ' (Copy)', $duplicatedAgenda->name);
    }
}
```

### 1.4 Attendance Tests (tests/Feature/Public/AttendanceTest.php)

```php
<?php

namespace Tests\Feature\Public;

use Tests\TestCase;
use App\Models\Opd;
use App\Models\Agenda;
use App\Models\Absensi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;
    
    private $opd;
    private $agenda;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->opd = Opd::factory()->create();
        $this->agenda = Agenda::factory()->create([
            'opd_id' => $this->opd->id,
            'date' => now()->addDays(1)
        ]);
    }
    
    /** @test */
    public function guest_can_access_attendance_form()
    {
        $response = $this->get("/attendance/{$this->agenda->slug}");
        
        $response->assertStatus(200);
        $response->assertViewHas('agenda');
    }
    
    /** @test */
    public function guest_cannot_access_expired_agenda()
    {
        $expiredAgenda = Agenda::factory()->create([
            'date' => now()->subDays(1)
        ]);
        
        $response = $this->get("/attendance/{$expiredAgenda->slug}");
        
        $response->assertRedirect('/');
        $response->assertSessionHas('error');
    }
    
    /** @test */
    public function guest_can_submit_attendance()
    {
        Storage::fake('public');
        
        $attendanceData = [
            'nip_nik' => '1234567890123456',
            'name' => 'John Doe',
            'asal_daerah' => 'dalam_kota',
            'telp' => '081234567890',
            'opd_id' => $this->opd->id,
            'ttd' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=='
        ];
        
        $response = $this->post("/attendance/{$this->agenda->slug}", $attendanceData);
        
        $response->assertRedirect("/attendance/{$this->agenda->slug}/success");
        $this->assertDatabaseHas('tb_absensi', [
            'nip_nik' => '1234567890123456',
            'name' => 'John Doe',
            'agenda_id' => $this->agenda->id
        ]);
    }
    
    /** @test */
    public function duplicate_attendance_is_prevented()
    {
        Absensi::factory()->create([
            'agenda_id' => $this->agenda->id,
            'nip_nik' => '1234567890123456'
        ]);
        
        $response = $this->post("/attendance/{$this->agenda->slug}", [
            'nip_nik' => '1234567890123456',
            'name' => 'John Doe',
            'asal_daerah' => 'dalam_kota',
            'telp' => '081234567890',
            'opd_id' => $this->opd->id,
            'ttd' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=='
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Anda sudah melakukan absensi untuk agenda ini.');
    }
    
    /** @test */
    public function invalid_signature_is_rejected()
    {
        $response = $this->post("/attendance/{$this->agenda->slug}", [
            'nip_nik' => '1234567890123456',
            'name' => 'John Doe',
            'asal_daerah' => 'dalam_kota',
            'telp' => '081234567890',
            'opd_id' => $this->opd->id,
            'ttd' => 'invalid-signature-data'
        ]);
        
        $response->assertSessionHasErrors('ttd');
    }
    
    /** @test */
    public function rate_limiting_prevents_excessive_submissions()
    {
        // Submit multiple times from same IP
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post("/attendance/{$this->agenda->slug}", [
                'nip_nik' => "123456789012345{$i}",
                'name' => "User {$i}",
                'asal_daerah' => 'dalam_kota',
                'telp' => "08123456789{$i}",
                'opd_id' => $this->opd->id,
                'ttd' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=='
            ]);
        }
        
        // 6th attempt should be rate limited
        $response->assertSessionHas('error', 'Terlalu banyak percobaan. Silakan coba lagi dalam 1 jam.');
    }
}
```

### 1.5 Service Unit Tests (tests/Unit/Services/QrCodeServiceTest.php)

```php
<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\QrCodeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class QrCodeServiceTest extends TestCase
{
    use RefreshDatabase;
    
    private $qrCodeService;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->qrCodeService = new QrCodeService();
        Storage::fake('public');
    }
    
    /** @test */
    public function can_generate_qr_code()
    {
        $result = $this->qrCodeService->generateQrCode(1, 'test-slug');
        
        $this->assertNotNull($result);
        $this->assertStringContainsString('qr_codes/', $result);
        $this->assertStringContainsString('.svg', $result);
        
        Storage::disk('public')->assertExists($result);
    }
    
    /** @test */
    public function can_validate_qr_code()
    {
        $result = $this->qrCodeService->generateQrCode(1, 'test-slug');
        
        $this->assertTrue($this->qrCodeService->validateQrCode($result));
    }
    
    /** @test */
    public function invalid_qr_code_fails_validation()
    {
        $this->assertFalse($this->qrCodeService->validateQrCode('non-existent-file.svg'));
    }
    
    /** @test */
    public function can_regenerate_qr_code()
    {
        $agenda = \App\Models\Agenda::factory()->create(['barcode' => 'old-qr.svg']);
        
        $newPath = $this->qrCodeService->regenerateQrCode($agenda);
        
        $this->assertNotEquals('old-qr.svg', $newPath);
        $this->assertEquals($newPath, $agenda->fresh()->barcode);
    }
}
```

### 1.6 Running Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run specific test class
php artisan test tests/Feature/Admin/OpdManagementTest.php

# Run with coverage (requires Xdebug/PCOV)
php artisan test --coverage

# Run with parallel execution
php artisan test --parallel
```

## 2. Deployment Configuration

### 2.1 Environment Configuration (.env.production)

```env
APP_NAME="Agenda & Absensi QR Code"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=daily
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=info

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agenda_absensi
DB_USERNAME=your_username
DB_PASSWORD=your_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

# QR Code Settings
QR_CODE_SIZE=300
QR_CODE_MARGIN=2

# PDF Settings
PDF_ORIENTATION=portrait
PDF_PAGE_SIZE=A4

# Security Settings
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SANCTUM_STATEFUL_DOMAINS=your-domain.com
```

### 2.2 Web Server Configuration (nginx)

```nginx
server {
    listen 80;
    server_name your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com;
    root /var/www/agenda/public;
    index index.php index.html;

    # SSL Configuration
    ssl_certificate /etc/ssl/certs/your-domain.crt;
    ssl_certificate_key /etc/ssl/private/your-domain.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Content-Security-Policy "default-src 'self' 'unsafe-inline' 'unsafe-eval' https: data:" always;

    # Gzip Compression
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
    gzip_vary on;
    gzip_min_length 1000;

    # File Upload Limits
    client_max_body_size 10M;
    client_body_timeout 60s;

    # Logs
    access_log /var/log/nginx/agenda_access.log;
    error_log /var/log/nginx/agenda_error.log;

    # Handle PHP Files
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_buffer_size 32k;
        fastcgi_buffers 8 16k;
        fastcgi_read_timeout 300;
    }

    # Deny Access to Hidden Files
    location ~ /\. {
        deny all;
    }

    # Deny Access to Storage Except Public
    location ~ /storage/(?!app/public) {
        deny all;
    }

    # Cache Static Assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Laravel Rewrite Rules
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
}
```

### 2.3 Deployment Script (deploy.sh)

```bash
#!/bin/bash

# Deployment Script for Agenda & Absensi QR Code

set -e

echo "Starting deployment..."

# Set variables
APP_DIR="/var/www/agenda"
BACKUP_DIR="/var/backups/agenda"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

# Create backup
echo "Creating backup..."
mkdir -p $BACKUP_DIR
tar -czf $BACKUP_DIR/agenda_backup_$TIMESTAMP.tar.gz -C $APP_DIR .

# Pull latest code
echo "Pulling latest code..."
cd $APP_DIR
git pull origin main

# Install/update dependencies
echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Clear and cache configurations
echo "Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Generate storage link
echo "Creating storage link..."
php artisan storage:link

# Set permissions
echo "Setting permissions..."
chown -R www-data:www-data $APP_DIR
find $APP_DIR -type d -exec chmod 755 {} \;
find $APP_DIR -type f -exec chmod 644 {} \;
chmod -R 775 $APP_DIR/storage
chmod -R 775 $APP_DIR/bootstrap/cache

# Restart services
echo "Restarting services..."
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx

# Run post-deployment tests
echo "Running post-deployment tests..."
php artisan test --filter="*SmokeTest*" || true

echo "Deployment completed successfully!"
echo "Backup saved to: $BACKUP_DIR/agenda_backup_$TIMESTAMP.tar.gz"
```

### 2.4 Make deployment script executable

```bash
chmod +x deploy.sh
```

## 3. Performance Optimization

### 3.1 Database Optimization

```php
// Add indexes in migrations
Schema::table('tb_absensi', function (Blueprint $table) {
    $table->index(['agenda_id', 'nip_nik']);
    $table->index(['created_at']);
});

Schema::table('tb_agenda', function (Blueprint $table) {
    $table->index(['opd_id', 'date']);
    $table->index(['slug']);
});

Schema::table('tb_opd', function (Blueprint $table) {
    $table->index(['name']);
});
```

### 3.2 Caching Implementation

```php
// In controllers
public function index()
{
    $agendas = Cache::remember('agendas.page.' . request('page', 1), 3600, function () {
        return Agenda::with('opd')
            ->orderBy('date', 'desc')
            ->paginate(10);
    });
    
    return view('agenda.index', compact('agendas'));
}

// In models
class Agenda extends Model
{
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($agenda) {
            Cache::forget('agendas.page.*');
        });
        
        static::updated(function ($agenda) {
            Cache::forget('agendas.page.*');
        });
        
        static::deleted(function ($agenda) {
            Cache::forget('agendas.page.*');
        });
    }
}
```

### 3.3 Image Optimization

```bash
# Install image optimization packages
composer require spatie/laravel-image-optimizer

# Configure in config/app.php
'providers' => [
    // ...
    Spatie\LaravelImageOptimizer\ImageOptimizerServiceProvider::class,
],

'aliases' => [
    // ...
    'ImageOptimizer' => Spatie\LaravelImageOptimizer\Facades\ImageOptimizer::class,
],
```

### 3.4 Queue Configuration

```php
// Configure queue worker
php artisan queue:work --queue=default,pdf-export,qr-generation --tries=3 --timeout=120

// In .env
QUEUE_CONNECTION=database
QUEUE_RETRY_AFTER=90
```

## 4. Monitoring & Logging

### 4.1 Application Monitoring

```bash
# Install Laravel Telescope (development only)
composer require laravel/telescope
php artisan telescope:install
php artisan migrate

# Install Laravel Horizon for queue monitoring
composer require laravel/horizon
php artisan horizon:install
```

### 4.2 Health Checks

```php
// app/Console/Commands/HealthCheck.php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class HealthCheck extends Command
{
    protected $signature = 'health:check';
    protected $description = 'Run health checks for the application';
    
    public function handle()
    {
        $checks = [
            'Database Connection' => $this->checkDatabase(),
            'Storage Disk' => $this->checkStorage(),
            'Cache System' => $this->checkCache(),
            'QR Code Generation' => $this->checkQrCodeGeneration(),
            'PDF Generation' => $this->checkPdfGeneration(),
        ];
        
        $allPassed = true;
        foreach ($checks as $name => $result) {
            $status = $result ? '✅ PASS' : '❌ FAIL';
            $this->info("{$name}: {$status}");
            
            if (!$result) {
                $allPassed = false;
            }
        }
        
        return $allPassed ? 0 : 1;
    }
    
    private function checkDatabase()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            $this->error("Database error: {$e->getMessage()}");
            return false;
        }
    }
    
    private function checkStorage()
    {
        try {
            Storage::disk('public')->put('health_check.txt', 'test');
            Storage::disk('public')->delete('health_check.txt');
            return true;
        } catch (\Exception $e) {
            $this->error("Storage error: {$e->getMessage()}");
            return false;
        }
    }
    
    private function checkCache()
    {
        try {
            Cache::put('health_check', 'test', 1);
            return Cache::get('health_check') === 'test';
        } catch (\Exception $e) {
            $this->error("Cache error: {$e->getMessage()}");
            return false;
        }
    }
    
    private function checkQrCodeGeneration()
    {
        try {
            $service = new \App\Services\QrCodeService();
            $path = $service->generateQrCode(999, 'health-check');
            Storage::disk('public')->delete($path);
            return true;
        } catch (\Exception $e) {
            $this->error("QR Code error: {$e->getMessage()}");
            return false;
        }
    }
    
    private function checkPdfGeneration()
    {
        try {
            $service = new \App\Services\PdfExportService();
            // Test PDF generation without actual export
            return true;
        } catch (\Exception $e) {
            $this->error("PDF error: {$e->getMessage()}");
            return false;
        }
    }
}
```

### 4.3 Scheduled Tasks

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Clean up old QR codes
    $schedule->command('cleanup:qr-codes')->daily();
    
    // Clean up old PDF files
    $schedule->command('cleanup:pdf-files')->weekly();
    
    // Backup database
    $schedule->command('backup:database')->dailyAt('02:00');
    
    // Generate reports
    $schedule->command('reports:generate')->dailyAt('08:00');
    
    // Health check
    $schedule->command('health:check')->everySixHours();
}
```

## 5. Troubleshooting Guide

### 5.1 Common Issues and Solutions

#### QR Code Generation Fails

```bash
# Check GD extension
php -m | grep -i gd

# Install if missing
sudo apt-get install php-gd

# Check permissions
ls -la storage/app/public/qr_codes/
```

#### PDF Export Issues

```bash
# Check DomPDF requirements
php -m | grep -i dom

# Clear view cache
php artisan view:clear

# Check temp directory permissions
ls -la /tmp/
```

#### File Upload Problems

```bash
# Check upload limits in php.ini
grep -i "upload_max_filesize" /etc/php/8.2/fpm/php.ini
grep -i "post_max_size" /etc/php/8.2/fpm/php.ini

# Check storage permissions
sudo chown -R www-data:www-data storage/
sudo chmod -R 775 storage/
```

#### Database Connection Issues

```bash
# Test connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check MySQL service
sudo systemctl status mysql

# Check credentials
php artisan config:cache
```

#### Queue Processing Issues

```bash
# Check queue status
php artisan queue:status

# Restart queue worker
php artisan queue:restart

# Check failed jobs
php artisan queue:failed
```

### 5.2 Debug Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Show routes
php artisan route:list

# Check configuration
php artisan config:show database

# Test email
php artisan tinker
>>> Mail::raw('Test email', function ($message) {
...     $message->to('admin@example.com')->subject('Test');
... });

# Check disk space
df -h

# Check memory usage
free -h
```

### 5.3 Performance Monitoring

```bash
# Monitor database queries
php artisan db:monitor

# Check slow queries
mysql -u root -p -e "SHOW PROCESSLIST;"

# Monitor system resources
top
htop

# Check Laravel logs
tail -f storage/logs/laravel.log

# Check Nginx logs
tail -f /var/log/nginx/agenda_error.log
```

## 6. Backup and Recovery

### 6.1 Database Backup

```bash
# Manual backup
mysqldump -u username -p agenda_absensi > backup_agenda_$(date +%Y%m%d_%H%M%S).sql

# Automated backup script
#!/bin/bash
BACKUP_DIR="/var/backups/database"
DB_NAME="agenda_absensi"
DB_USER="backup_user"
DB_PASS="backup_password"

mkdir -p $BACKUP_DIR
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/agenda_$(date +%Y%m%d_%H%M%S).sql.gz

# Keep only last 30 days
find $BACKUP_DIR -name "agenda_*.sql.gz" -mtime +30 -delete
```

### 6.2 File System Backup

```bash
# Backup storage files
tar -czf storage_backup_$(date +%Y%m%d_%H%M%S).tar.gz storage/app/public/

# Backup entire application
tar -czf app_backup_$(date +%Y%m%d_%H%M%S).tar.gz /var/www/agenda/
```

### 6.3 Recovery Procedures

```bash
# Restore database
mysql -u username -p agenda_absensi < backup_file.sql

# Restore files
tar -xzf storage_backup_20240101_120000.tar.gz -C /var/www/agenda/

# Restore application
tar -xzf app_backup_20240101_120000.tar.gz -C /var/www/
```

This comprehensive testing and deployment guide ensures your Agenda & Absensi QR Code application is properly tested, deployed, and maintained with proper monitoring and troubleshooting procedures.
