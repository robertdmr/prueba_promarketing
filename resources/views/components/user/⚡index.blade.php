<?php

use Livewire\Component;

new class extends Component
{
    public array $users = [];

    public function mount()
    {
        $this->users = \App\Models\User::all()->toArray();
    }

    public function changePermissions($userId)
    {
        $user = \App\Models\User::find($userId);
        if ($user) {
            $user->can_create_notes = !$user->can_create_notes;
            $user->save();
            $this->users = \App\Models\User::all()->toArray(); // Refresh the users list
        }
    }

};
?>

<div class="pb-4">
    <h1 class="text-2xl font-bold mb-4">Users</h1>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Notes</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Change
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($users as $user)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user['id'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user['name'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user['email'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user['can_create_notes'] ? 'Yes' : 'No' }}</td>
                <td>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700"
                        wire:click="changePermissions({{ $user['id'] }})">
                        <flux:icon.arrow-path />
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
</div>
