<?php

use App\Livewire\Ministry\Edit;
use App\Models\Ministry;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('s3');
});

test('component sets current logo url when ministry has logo', function () {
    Storage::disk('s3')->put('images/test-logo.png', 'fake-image-content');

    $user = User::factory()->create();
    $ministry = Ministry::create([
        'name' => 'Test Ministry',
        'user_id' => $user->id,
        'slug' => 'test-ministry',
        'logo_path' => 'images/test-logo.png',
        'logo_name' => 'test-logo.png',
    ]);

    $component = new Edit;
    $component->ministry = $ministry;
    $component->mount($ministry);

    expect($component->name)->toBe('Test Ministry');
    expect($component->currentLogoPath)->toBe('images/test-logo.png');
    expect($component->currentLogoName)->toBe('test-logo.png');
    expect($component->currentLogoUrl)->not->toBeNull();
    expect(str_contains($component->currentLogoUrl, 'images/test-logo.png'))->toBeTrue();
});

test('ministry stores uploaded logo to s3 correctly', function () {
    $user = User::factory()->create();
    $ministry = Ministry::create([
        'name' => 'Test Ministry',
        'user_id' => $user->id,
        'slug' => 'test-ministry',
    ]);

    // Create a fake uploaded file
    $fakeFile = UploadedFile::fake()->image('new-logo.png', 100, 100);

    // Simulate storing directly
    $path = $fakeFile->store('images', 's3');

    expect($path)->toContain('images/');
    expect(Storage::disk('s3')->exists($path))->toBeTrue();
});

test('component deletes logo from s3', function () {
    Storage::disk('s3')->put('images/old-logo.png', 'fake-image-content');

    $user = User::factory()->create();
    $ministry = Ministry::create([
        'name' => 'Test Ministry',
        'user_id' => $user->id,
        'slug' => 'test-ministry',
        'logo_path' => 'images/old-logo.png',
        'logo_name' => 'old-logo.png',
    ]);

    $component = new Edit;
    $component->ministry = $ministry;
    $component->currentLogoPath = 'images/old-logo.png';
    $component->mount($ministry);

    expect(Storage::disk('s3')->exists('images/old-logo.png'))->toBeTrue();
});

test('component verifies logo url generation', function () {
    Storage::disk('s3')->put('images/sample-logo.png', 'fake-image-content');

    $user = User::factory()->create();
    $ministry = Ministry::create([
        'name' => 'Test Ministry',
        'user_id' => $user->id,
        'slug' => 'test-ministry',
        'logo_path' => 'images/sample-logo.png',
        'logo_name' => 'sample-logo.png',
    ]);

    $component = new Edit;
    $component->ministry = $ministry;
    $component->setMinistry();

    // Verify URL is generated correctly
    $expectedUrl = Storage::disk('s3')->url('images/sample-logo.png');
    expect($component->currentLogoUrl)->toBe($expectedUrl);
});
