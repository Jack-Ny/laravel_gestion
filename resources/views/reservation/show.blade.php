@extends('layouts.app')

@section('content')

<div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Détails <b>{{$data->code_reservation}}</b></h4>
                    <div class="form-group">
                            <div class="col-md-6">
                                <img width="200" height="200" @if($data->buku->cover) src="{{ asset('images/buku/'.$data->buku->cover) }}" @endif />
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('code_reservation') ? ' has-error' : '' }}">
                            <label for="code_reservation" class="col-md-4 control-label">Code de la réservation</label>
                            <div class="col-md-6">
                                <input id="code_reservation" type="text" class="form-control" name="code_reservation" value="{{$data->code_reservation}}" required readonly="">
                            </div>
                        </div>
                         <div class="form-group{{ $errors->has('date_reservation') ? ' has-error' : '' }}">
                            <label for="date_reservation" class="col-md-4 control-label">Date de la réservation</label>
                            <div class="col-md-3">
                                <input id="date_reservation" type="date" class="form-control" name="date_reservation" value="{{ date('Y-m-d', strtotime($data->date_reservation)) }}" readonly="">
                            </div>
                        </div>
                        </div>


                        <div class="form-group">
                            <label for="anggota_id" class="col-md-4 control-label">Livre</label>
                            <div class="col-md-6">
                                <input id="buku" type="text" class="form-control" readonly="" value="{{$data->buku->judul}}">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="anggota_id" class="col-md-4 control-label">Abonnés</label>
                            <div class="col-md-6">
                                <input id="anggota_nama" type="text" class="form-control" readonly="" value="{{$data->anggota->nama}}">

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('ket') ? ' has-error' : '' }}">
                            <label for="ket" class="col-md-4 control-label">Statut</label>
                            <div class="col-md-6">
                                @if($data->status == 'pinjam')
                                  <label class="badge badge-warning">réserver</label>
                                @else
                                  <label class="badge badge-success">non réserver</label>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('ket') ? ' has-error' : '' }}">
                            <label for="ket" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <input id="ket" type="text" class="form-control" name="ket" value="{{ $data->ket }}" readonly="">
                            </div>
                        </div>

                        <a href="{{route('reservation.index')}}" class="btn btn-light pull-right">Retour</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

</div>


@endsection