<?php

use App\Models\User;
use Livewire\Livewire;

test('el usuario autenticado puede crear notas', function () {
    $usuarioAutenticado = User::factory()->create([
        'can_create_notes' => true,
    ]);

    $usuarioDestino = User::factory()->create();

    $this->actingAs($usuarioAutenticado);

    Livewire::test('notes.form')
        ->set('newNoteUserId', (string) $usuarioDestino->id)
        ->set('newNoteContent', 'Nota de prueba creada por usuario autenticado')
        ->call('createNote')
        ->assertDispatched('noteCreated')
        ->assertSet('newNoteUserId', '')
        ->assertSet('newNoteContent', '');

    $this->assertDatabaseHas('notes', [
        'user_id' => $usuarioDestino->id,
        'user_noted_id' => $usuarioAutenticado->id,
        'content' => 'Nota de prueba creada por usuario autenticado',
    ]);
});
