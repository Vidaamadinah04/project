<!-- resources/views/pelanggan/payment.blade.php -->
@extends('layout.main')

@section('content')
<div class="container">
    <h1>Proses Pembayaran</h1>
    <div class="row">
        <div class="col-md-12">
            <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
        </div>
    </div>
</div>

<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                console.log(result);
            },
            onPending: function(result){
                console.log(result);
            },
            onError: function(result){
                console.log(result);
            },
            onClose: function(){
                console.log('Customer closed the popup without finishing the payment');
            }
        });
    });
</script>
@endsection
