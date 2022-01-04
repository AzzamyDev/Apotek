<?php

namespace App\Http\Livewire\Admin\Karyawan;

use App\Models\User;
use App\Models\Jabatan;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Form extends Component
{
    public function render()
    {
        $jabatans = Jabatan::all();
        return view('livewire.admin.karyawan.form')->with(compact('jabatans'));
    }

    public $name, $telepon, $jabatan, $username, $password, $user_id;
    protected $listeners = ['open' => 'loadKaryawan'];

    protected $rules = [
        'username' => 'required|unique:users',
        'name' => 'required|unique:users',
        'telepon' => 'required',
        'password' => 'required|min:5',
    ];

    public function loadKaryawan($uid)
    {
        $this->resetErrorBag();
        $this->resetForm();
        $this->fill($uid ? User::findOrFail($uid) : new User);
        $this->user_id = $uid != '' ? $uid : '';
        // dd($this->jabatan);

        $this->emit('toggleFormModal');
    }

    public function resetForm()
    {
        $this->user_id = null;
        $this->name = '';
        $this->telepon = '';
        $this->jabatan = '';
        $this->username = '';
        $this->password = '';
    }

    public function submit()
    {
        if ($this->id == null) {
            $this->validate([
                'username' => 'required|unique:users',
                'name' => 'required|unique:users',
                'telepon' => 'required',
                'password' => 'required|min:5',
            ]);
        }
        $this->validate([
            'username' => 'required',
            'name' => 'required',
            'telepon' => 'required',
            'password' => 'required|min:5',
        ]);

        $user = User::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->name,
            'jabatan' => $this->jabatan,
            'telepon' => $this->telepon,
            'username' => $this->username,
            'password' => $this->password,
        ]);
        $user->assignRole('karyawan');

        $this->emit('toggleFormModal');
        return redirect()->route('karyawan')->with('success', 'Data berhasil di simpan');
    }
}
