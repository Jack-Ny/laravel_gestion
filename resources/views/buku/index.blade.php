@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $('#table').DataTable({
      "iDisplayLength": 50
    });

} );
</script>
@stop
@extends('layouts.app')

@section('content')
<div class="row">

  <div class="col-lg-2">
    <a href="{{ route('buku.create') }}" class="btn btn-primary btn-rounded btn-fw"><i class="fa fa-plus"></i> Ajouter un livre</a>
  </div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <form action="{{ url('import_buku') }}" method="post" class="form-inline" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="input-group {{ $errors->has('importBuku') ? 'has-error' : '' }}">
              <input type="file" class="form-control" name="importBuku" required="">

              <span class="input-group-btn">
                              <button type="submit" class="btn btn-success" style="height: 38px;margin-left: -2px;">Importer</button>
                            </span>
            </div>
          </form>

        </div>
    <div class="col-lg-12">
                  @if (Session::has('message'))
                  <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2" style="margin-top:10px;">{{ Session::get('message') }}</div>
                  @endif
                  </div>
</div>
<div class="row" style="margin-top: 20px;">
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">

                <div class="card-body">
                  <h4 class="card-title pull-left">Livres</h4>
                  <a href="{{url('format_buku')}}" class="btn btn-xs btn-info pull-right">Format du livre</a>
                  <div class="table-responsive">
                    <table class="table table-striped" id="table">
                      <thead>
                        <tr>
                          <th>
                            Titre
                          </th>
                          <th>
                            Numéro ISBN
                          </th>
                          <th>
                            Auteur
                          </th>
                          <th>
                            Année
                          </th>
                          <th>
                            Stock
                          </th>
                          <th>
                            Etagère
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($datas as $data)
                        <tr>
                          <td class="py-1">
                          @if($data->cover)
                            <img src="{{url('images/buku/'. $data->cover)}}" alt="image" style="margin-right: 10px;" />
                          @else
                            <img src="{{url('images/buku/default.png')}}" alt="image" style="margin-right: 10px;" />
                          @endif
                          <a href="{{route('buku.show', $data->id)}}"> 
                            {{$data->judul}}
                          </a>
                          </td>
                          <td>
                          
                            {{$data->isbn}}
                          
                          </td>

                          <td>
                            {{$data->pengarang}}
                          </td>
                          <td>
                            {{$data->tahun_terbit}}
                          </td>
                          <td>
                            {{$data->jumlah_buku}}
                          </td>
                          <td>
                            {{$data->lokasi}}
                          </td>
                          <td>
                          <div class="btn-group dropdown">
                          <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </button>
                          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                            <a class="dropdown-item" href="{{route('buku.edit', $data->id)}}"> Editer</a>
                            <form action="{{ route('buku.destroy', $data->id) }}" class="pull-left"  method="post">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="dropdown-item" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ces données?')"> Supprimer
                            </button>
                          </form>
                           
                          </div>
                        </div>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
               {{--  {!! $datas->links() !!} --}}
                </div>
              </div>
            </div>
          </div>
@endsection