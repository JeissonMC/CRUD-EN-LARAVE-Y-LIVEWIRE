<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Persona;

class Personas extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre, $apellido, $telefono, $direccion;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.personas.view', [
            'personas' => Persona::latest()
						->orWhere('nombre', 'LIKE', $keyWord)
						->orWhere('apellido', 'LIKE', $keyWord)
						->orWhere('telefono', 'LIKE', $keyWord)
						->orWhere('direccion', 'LIKE', $keyWord)
						->paginate(10),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->nombre = null;
		$this->apellido = null;
		$this->telefono = null;
		$this->direccion = null;
    }

    public function store()
    {
        $this->validate([
		'nombre' => 'required',
		'apellido' => 'required',
		'telefono' => 'required',
		'direccion' => 'required',
        ]);

        Persona::create([ 
			'nombre' => $this-> nombre,
			'apellido' => $this-> apellido,
			'telefono' => $this-> telefono,
			'direccion' => $this-> direccion
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Persona Successfully created.');
    }

    public function edit($id)
    {
        $record = Persona::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre = $record-> nombre;
		$this->apellido = $record-> apellido;
		$this->telefono = $record-> telefono;
		$this->direccion = $record-> direccion;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombre' => 'required',
		'apellido' => 'required',
		'telefono' => 'required',
		'direccion' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Persona::find($this->selected_id);
            $record->update([ 
			'nombre' => $this-> nombre,
			'apellido' => $this-> apellido,
			'telefono' => $this-> telefono,
			'direccion' => $this-> direccion
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Persona Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Persona::where('id', $id);
            $record->delete();
        }
    }
}
