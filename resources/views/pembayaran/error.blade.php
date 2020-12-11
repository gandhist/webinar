@include('pembayaran.template')

<div class="container">
    <div class="jumbotron mt-3">
      <h1>Error</h1>
      <h3>Terjadi error atas Tagihan anda</h3>
      <p class="lead"> No Tagihan : {{ $data->no_tagihan ?? 'N/A' }}
        <br>
        Status : {{ $data->status }}
    </p>
      <a class="btn btn-lg btn-primary" href="{{ url('/') }}" role="button">Halaman Utama &raquo;</a>
    </div>
</div>
