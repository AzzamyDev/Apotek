<?php

namespace App\Http\Livewire\Admin\Karyawan;

use App\Models\Jabatan;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $users = User::role('karyawan')->get();
        return view('livewire.admin.karyawan.index')->with(compact('users'));
    }
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('karyawan')->with('success', 'Data berhasil di hapus');
    }
}
