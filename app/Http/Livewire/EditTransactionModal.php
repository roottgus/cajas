<?php
// app/Http/Livewire/EditTransactionModal.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BoxTransaction;

class EditTransactionModal extends Component
{
    public bool   $open     = false;
    public int    $txId;
    public string $type;
    public int    $quantity;
    public string $notes;

    // Escucha evento de navegador llamado "open-edit-modal"
    protected $listeners = [
        'open-edit-modal' => 'openModal',
    ];

    // Recibe directamente los cuatro parámetros
    public function openModal(string $type, int $txId, int $quantity, ?string $notes): void
    {
        $this->type     = $type;
        $this->txId     = $txId;
        $this->quantity = $quantity;
        $this->notes    = $notes;
        $this->open     = true;
    }

    public function closeModal(): void
    {
        $this->open = false;
    }

    protected function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
            'notes'    => 'nullable|string',
        ];
    }

    public function save(): void
    {
        $this->validate();

        BoxTransaction::findOrFail($this->txId)->update([
            'quantity' => $this->quantity,
            'notes'    => $this->notes,
        ]);

        $this->open = false;
        $this->emitUp('transaction-updated');
    }

    public function render()
    {
        return view('livewire.edit-transaction-modal');
    }
}
