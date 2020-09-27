<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href={{asset('css/main.css')}} rel="stylesheet" />
    <title>Welcome to the world of analytics stuff</title>
    <style>
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #fff;
            display: none;
        }
        .preloader .loading {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%,-50%);
            font: 14px arial;
        }

        .gif {
            margin-left: 10%;
        }

        .alert {
            margin-top: -3%;
            font-size: 3em;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            font-family: 'Montserrat', sans-serif;
        }

        .cardExplanation {
            border-radius: 10px;
            justify-content: center;
        }


        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            line-height: 60px;
            background-color: #f5f5f5;
        }



        .bold {
            font-weight: bold;
        }


    </style>
    <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
</head>
<body>
<div class="preloader">
    <div class="loading">
        <img class="gif" src="https://file.mockplus.com/image/2018/04/d938fa8c-09d3-4093-8145-7bb890cf8a76.gif" alt="">
        <p class="alert">Mohon Tunggu Sebentar, Sistem Sedang Menyiapkan Hasil Pencarian Anda</p>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">KBA</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
{{--    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">--}}
{{--        <div class="navbar-nav">--}}
{{--            <a class="nav-link active" href="#">Beranda <span class="sr-only">(current)</span></a>--}}
{{--        </div>--}}
{{--    </div>--}}
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2 mt-5">
            <div class="s003">
                <form>
                    <div class="inner-form">
                        <div class="input-field second-wrap">
                            <input id="search" type="text" placeholder="Cari tingkat bencana alam daerah tertentu..." />
                        </div>
                        <div class="input-field third-wrap">
                            <button class="btn-search" id="searchButton" type="button">
                                <svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>


        </div>

    </div>
    <div class="row">
        <div class="col-md-12 cardExplanation shadow-lg mt-3" style="text-align: center">
            <h1 >Apa itu <span style="font-weight: bold; color: #ff0000">Bencana Alam?</span></h1>
            <p>Menurut Undang-Undang Nomor 24 Tahun 2007, <span class="bold">bencana alam</span> adalah adalah bencana yang diakibatkan oleh peristiwa atau serangkaian peristiwa yang disebabkan oleh alam antara lain berupa gempa bumi, tsunami, gunung meletus, banjir, kekeringan, angin topan, dan tanah longsor.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 cardExplanation shadow-lg mt-5" style="text-align: center">
            <h1 >Apa tujuan website ini dibuat?</h1>
            <p>Website ini dibuat agar masyarakat dapat mengetahui tingkatan bencana yang terjadi di suatu daerah dengan cepat</p>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 cardExplanation shadow-lg mt-5" style="text-align: center">
            <h1>Bagaimana cara kerja website ini?</h1>
            <p>Website ini akan mengumpulkan tweet dari media sosial Twitter berdasarkan kata pencarian yang dimasukkan oleh user. Data tweet hasil pencarian ini akan olah dengan algoritma machine learning untuk didapatkan kesimpulan tingkatan bencana alam yang terjadi sesuai daerah sesuai dengan kata pencarian.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 cardExplanation shadow-lg mt-5" style="text-align: center">
            <h1>DISCLAIMER</h1>
            <p>Hasil pencarian dari website ini tidak bisa dijadikan patokan utama dalam penentuan tingkatan bencana.</p>

        </div>
    </div>



</div>
<footer class="footer">
    <div class="container" style="margin-right: auto">
        <span>Ricky Gideon 2020</span>
    </div>
</footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('js/extention/choices.js')}}"></script>

{{--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script type="text/javascript">

    document.getElementById("searchButton").addEventListener("click", search);

    $("#search").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            search();
        }
    });

    function search(){
        var id = document.getElementById("search").value
        window.location.href = "{{ url('hasil-analisa') }}" + '/' + id;
        $(".preloader").fadeIn();
    }


</script>
</body>
</html>
