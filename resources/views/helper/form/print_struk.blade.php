<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Print</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
        integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div style="">
        <div class="row px-3">
            <div class="col-12">--------------------------------</div>
            {{-- <strong class="col-12">Apotek Ananda</strong>
            <small class="col-12">Jl. Siliwangi No. 201 Cirebon</small> --}}
            <div class="col-12">===============================</div>
            {{-- <small class="col-12">#D4FT6-1255</small>
            <small class="col-12">Tipe : Umum</small>
            <small class="col-12">Tanggal : 01-01-2022</small>
            <div class="col-12">=================</div>
            <small class="col-12">Mycoral Cr 5gr</small>
            <small class="col-12">Rp.17.000 X 1 = Rp.17.000</small>
            <div class="col-12">-----------------------------</div>
            <small class="col-6">Total</small>
            <small class="col-6 text-right">= Rp.17.000</small>
            <div class="col-12">-----------------------------</div>
            <small class="col-12">Petugas : Admin</small>
            <div class="col-12">-----------------------------</div>
            <small class="col-12 text-center">- Terima Kasih -</small> --}}

        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
</body>
<script type="text/javascript">
    $(document).ready(function() {
        window.print();
    });
</script>

</html>
