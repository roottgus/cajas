<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BoxTransaction;

class BoxModal extends Component
{
    public bool $open = false;
    public ?string $type = null;
    public ?int $vendorId = null;

    public ?int $quantity = null;
    public ?string $notes = null;
    public ?string $successMessage = null;

    /**
     * Escucha únicamente los eventos que abren o cierran el modal
     */
    protected $listeners = [
        'open-report-modal'  => 'openModal',
        'close-report-modal' => 'closeModal',
    ];

    /**
     * Abre el modal (tipo: "issue" o "return", vendorId opcional)
     */
    public function openModal(string $type, ?int $vendorId): void
    {
        $this->type           = $type;
        $this->vendorId       = $vendorId;
        $this->quantity       = null;
        $this->notes          = null;
        $this->successMessage = null;
        $this->open           = true;
    }

    /**
     * Cierra el modal
     */
    public function closeModal(): void
    {
        $this->open = false;
    }

    protected function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Guarda la transacción y muestra un mensaje de éxito
     */
    public function save(): void
    {
        $this->validate();

        BoxTransaction::create([
            'vendor_id' => $this->vendorId,
            'type'      => $this->type,
            'quantity'  => $this->quantity,
            'notes'     => $this->notes,
        ]);

        $this->successMessage = $this->type === 'issue'
            ? 'Entrega de caja registrado exitosamente.'
            : 'Recibido de caja registrada exitosamente.';

        $this->quantity = null;
        $this->notes    = null;
    }

    public function render()
    {
        return view('livewire.box-modal');
    }
}
