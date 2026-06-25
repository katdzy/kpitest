<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the application returns the dashboard at root', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('University Portal');
    $response->assertSee('Institutional Records');
});

test('the kpis route returns a successful response', function () {
    $response = $this->get('/kpis');
    $response->assertStatus(200);
});

test('the scholarships route returns a successful response', function () {
    $response = $this->get('/scholarships');
    $response->assertStatus(200);
});

test('the outreach route returns a successful response', function () {
    $response = $this->get('/outreach');
    $response->assertStatus(200);
});

test('the accreditations route returns a successful response', function () {
    $response = $this->get('/accreditations');
    $response->assertStatus(200);
});

test('the research route returns a successful response', function () {
    $response = $this->get('/research');
    $response->assertStatus(200);
});
