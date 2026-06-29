<?php

use App\Models\Perspective;
use App\Models\Objective;
use App\Models\Kpi;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can access strategy map page', function () {
    // Seed some basic perspectives & objectives
    $p = Perspective::create([
        'name' => 'Customer & Stakeholder',
        'color' => 'blue',
        'hex_color' => '#2563eb',
        'description' => 'Focuses on customer satisfaction.',
        'order' => 1,
    ]);

    $o = Objective::create([
        'perspective_id' => $p->id,
        'code' => 'O1',
        'title' => 'Improve Customer Satisfaction',
        'intended_result' => 'HAU has become known for high satisfaction.',
        'owner' => 'CG',
        'order' => 1,
    ]);

    $response = $this->get('/strategy-map');
    $response->assertStatus(200);
    $response->assertSee('BSC Strategy Map');
    $response->assertSee('Customer & Stakeholder');
    $response->assertSee('O1');
    $response->assertSee('Improve Customer Satisfaction');
});
