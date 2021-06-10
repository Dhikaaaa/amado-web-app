<?php

namespace App\Http\Livewire\Loan;

use Livewire\Component;

class ReturnSearch extends Component
{

	public $code;

	protected $rules = [
		'code' => 'required|string|exists:books'
	];

	protected $listeners = ['notFound'];

	public function search()
	{
		$this->validate();

		$this->emit('returnBook', $this->code);
	}

	public function notFound()
	{
		$this->addError('code', 'The code field is invalid');
	}

    public function render()
    {
        return view('livewire.loan.return-search');
    }
}
