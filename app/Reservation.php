<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservation';
    protected $fillable = ['code_reservation', 'anggota_id', 'buku_id', 'date_reservation', 'status', 'ket'];

    public function anggota()
    {
    	return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
    	return $this->belongsTo(Buku::class);
    }
}
