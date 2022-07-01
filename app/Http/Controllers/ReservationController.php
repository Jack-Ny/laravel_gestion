<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Buku;
use App\Anggota;
use App\Reservation;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;


class ReservationController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->level == 'user') {
            $datas = Reservation::where('anggota_id', Auth::user()->anggota->id)
                ->get();
        } else {
            $datas = Reservation::get();
        }
        return view('reservation.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $getRow = Reservation::orderBy('id', 'DESC')->get();
        $rowCount = $getRow->count();

        $lastId = $getRow->first();

        $kode = "DR00001";

        if ($rowCount > 0) {
            if ($lastId->id < 9) {
                $kode = "DR0000" . '' . ($lastId->id + 1);
            } else if ($lastId->id < 99) {
                $kode = "DR000" . '' . ($lastId->id + 1);
            } else if ($lastId->id < 999) {
                $kode = "DR00" . '' . ($lastId->id + 1);
            } else if ($lastId->id < 9999) {
                $kode = "DR0" . '' . ($lastId->id + 1);
            } else {
                $kode = "DR" . '' . ($lastId->id + 1);
            }
        }

        $bukus = Buku::where('jumlah_buku', '>', 0)->get();
        $anggotas = Anggota::get();
        return view('reservation.create', compact('bukus', 'kode', 'anggotas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code_reservation' => 'required|string|max:255',
            'date_reservation' => 'required',
            'buku_id' => 'required',
            'anggota_id' => 'required',

        ]);

        $reservation = Reservation::create([
            'code_reservation' => $request->get('code_reservation'),
            'date_reservation' => $request->get('date_reservation'),
            'buku_id' => $request->get('buku_id'),
            'anggota_id' => $request->get('anggota_id'),
            'ket' => $request->get('ket'),
            'status' => 'pinjam'
        ]);

        $reservation->buku->where('id', $reservation->buku_id)
            ->update([
                'jumlah_buku' => ($reservation->buku->jumlah_buku - 1),
            ]);

        alert()->success('Accepté', 'Les données ont été ajoutées!');
        return redirect()->route('reservation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = Reservation::findOrFail($id);


        if ((Auth::user()->level == 'user') && (Auth::user()->anggota->id != $data->anggota_id)) {
            Alert::info('Oups..', 'vous ne pouvez pas entrez dans cette zone.');
            return redirect()->to('/');
        }


        return view('reservation.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Reservation::findOrFail($id);

        if ((Auth::user()->level == 'user') && (Auth::user()->anggota->id != $data->anggota_id)) {
            Alert::info('Oups..', 'vous ne pouvez pas entrez dans cette zone.');
            return redirect()->to('/');
        }

        return view('buku.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        $reservation->update([
            'status' => 'kembali'
        ]);

        $reservation->buku->where('id', $reservation->buku->id)
            ->update([
                'jumlah_buku' => ($reservation->buku->jumlah_buku + 1),
            ]);

        alert()->success('Accepté.', 'Les données ont été modifiées!');
        return redirect()->route('reservation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Reservation::find($id)->delete();
        alert()->success('Accepté', 'Les données ont été supprimées!');
        return redirect()->route('reservation.index');
    }
}
