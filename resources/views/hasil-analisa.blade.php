<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <link href={{asset('css/main.css')}} rel="stylesheet" />
    <title>Hasil Analisa</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-link active" href="{{url('/')}}">Beranda <span class="sr-only">(current)</span></a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2 mt-5">
            <h1 style="text-align: center">Hasil analisa untuk <span style="font-weight: bold; font-style: italic">{{$query}}</span> </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <table id="result" class="table table-striped table-bordered" style="width:100%; text-align: center">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Tweet</th>
                    <th>Kategori Bencana</th>
                </tr>
                </thead>
                <tbody>
                @for($i = 0 ; $i < count($finalData) ; $i++)
                    <tr>
                        <td>{{$finalData[$i][0]}}</td>
                        <td>{{ucwords($finalData[$i][1])}}</td>
                        <td>{{ucwords($finalData[$i][2])}}</td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3" style="justify-content: center">
            <canvas id="chart" width="100" height="100"></canvas>
        </div>

    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('js/extention/choices.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src='https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js'></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#result').DataTable();
    } );
    const ctx = document.getElementById('chart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Kecil', 'Sedang', 'Besar'],
            datasets: [{
                label: 'Hasil Analisa Tingkatan Bencana',
                data: [{{$kecil}}, {{$sedang}}, {{$besar}}],
                backgroundColor: [
                    'red',
                    'green',
                    'blue'
                ],
                borderColor: [
                    'red',
                    'green',
                    'blue'
                ],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
</body>
</html>
