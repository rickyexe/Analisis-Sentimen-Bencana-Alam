@extends('layouts.admin')

@section('title', 'Dashboard')


@section('content')

    <div class="container-fluid">
        <div class="row">
            <h1 class="m-0 text-dark ml-4 mt-4 mb-3">Dashboard</h1>
        </div>
        <div class="row">
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>000</h3>
                        <p>Data</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="small-box bg-success">
                    <div class="inner">

                        <h3>000</h3>

                        <p>Data</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-chatbubbles"></i>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="small-box bg-secondary">
                    <div class="inner">

                        <h3>000</h3>

                        <p>Data</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-star"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="small-box bg-warning">
                    <div class="inner">

                        <h3 style="color: white">000</h3>

                        <p style="color: white">Data</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-people"></i>
                    </div>
                </div>
            </div>
        </div>


    </div>


@endsection
