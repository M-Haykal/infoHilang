<?php

namespace App\Livewire;

use Livewire\Component;

class Start extends Component
{
    public $name = '';
    public $email = '';
    public $message = '';
    public $submitted = false;

    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'message' => 'required|min:10',
        'subject' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        // Di sini kamu bisa simpan ke database, kirim email, dll.
        // Contoh: ContactForm::create([...]);

        $this->submitted = true;
        $this->reset(['name', 'email', 'message', 'subject']);

        $this->dispatchBrowserEvent('form-submitted');
    }

    public function render()
    {
        return view('livewire.start')->layout('layouts.index')->title('InfoHilang - Bagaimana InfoHilang Bekerja?');
    }
}
