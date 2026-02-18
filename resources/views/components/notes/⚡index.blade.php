<?php

use Livewire\Component;
use App\Models\Note;
use App\Models\User;
use Livewire\Attributes\Validate;

new class extends Component
{
    public array $notes = [];

    protected $listeners = ['noteCreated' => 'updateNotes'];

    public function mount()
    {
        $this->notes = Note::with(['user', 'notedBy'])->get()->toArray();
    }

    public function updateNotes()
    {
        $this->notes = Note::with(['user', 'notedBy'])->get()->toArray();
    }

};
?>

<div class="pb-4">
    <h1 class="text-2xl font-bold mb-4">Notas</h1>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <h2 class="text-xl font-bold mb-2">Crear Nota</h2>
            <livewire:notes.form />
        </div>

        <div>
            <h2 class="text-xl font-bold mb-2">Lista de Notas</h2>
            <ul class="list-disc pl-5">
                @foreach ($notes as $note)
                <li class="mb-1">
                    <strong>{{ $note['user']['name'] }}</strong> @if($note['aproved']==1)
                    <flux:icon.check /> @endif <br>
                    {{ $note['content'] . ' - ' . \Carbon\Carbon::parse($note['date'])->format('d/m/Y') }}
                    <br>
                    <em><small>Autor: {{ $note['noted_by']['name'] }}</small></em>
                </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
