<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['class_id', 'section_id', 'name', 'phone', 'email', 'address', 'photo', 'password', 'gender'];

    public function generatePassword($password)
    {
        if($password != null)
        {
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    public function remove()
    {
        $this->removePhoto();
        $this->delete();
    }

    public function removePhoto()
    {
        if($this->photo != null)
        {
            Storage::delete('images/' . $this->photo);
        }
    }
}
