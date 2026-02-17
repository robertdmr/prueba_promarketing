<?php

use Livewire\Component;
use App\Models\Note;
use App\Models\User;
use Livewire\Attributes\Validate;

new class extends Component
{
    public array $notes = [];

    #[Validate('required', message:'El contenido de la nota es obligatorio')]
    #[Validate('min:5', message:'El contenido de la nota debe tener al menos 5 caracteres')]
    #[Validate('max:255', message:'El contenido de la nota no puede exceder los 255 caracteres')]
    public string $newNoteContent = '';
    #[Validate('required', message:'El usuario es obligatorio')]
    public string $newNoteUserId = '';

    public function mount()
    {
        $this->notes = Note::with('user')->get()->toArray();
    }

    public function createNote()
    {
        $this->validate();

        if ($this->newNoteContent && $this->newNoteUserId) {
            Note::create([
                'user_id' => $this->newNoteUserId,
                'content' => $this->newNoteContent,
                'user_noted_id'=>Auth()->id(),
                'date' => now(),
            ]);

            $this->notes = Note::with('user')->get()->toArray();
            $this->newNoteContent = '';
            $this->newNoteUserId = '';
        }
    }

};
?>

<div class="pb-4">
    <h1 class="text-2xl font-bold mb-4">Notas</h1>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <h2 class="text-xl font-bold mb-2">Crear Nota</h2>
            <form wire:submit.prevent="createNote" class="space-y-4">
                <div class="py-2">
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <select id="user_id" wire:model="newNoteUserId"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Selecciona un usuario</option>
                        @foreach (User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('newNoteUserId') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Contenido</label>
                    <textarea id="content" wire:model.live="newNoteContent" rows="3"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                    <p class="text-sm text-gray-500">Cantidad de letras: {{ strlen($this->newNoteContent) }}</p>
                    @error('newNoteContent') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                @if(auth()->user()->can_create_notes)
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Crear</button>
                @endif
            </form>
        </div>

        <div>
            <h2 class="text-xl font-bold mb-2">Lista de Notas</h2>
            <ul class="list-disc pl-5">
                @foreach ($notes as $note)
                <li class="mb-1">
                    <strong>{{ $note['user']['name'] }}</strong> @if($note['aproved']==1)
                    <flux:icon.check /> @endif <br>
                    {{ $note['content'] . ' - ' . \Carbon\Carbon::parse($note['date'])->format('d/m/Y') }}
                </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
