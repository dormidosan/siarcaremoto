@extends('layouts.app')

@section("styles")
    <style>
        #myCarousel.carousel.slide {
            width: 100%;
            max-height: 540px; !important
        }

        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: 100%;
            max-height: 540px; !important
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">

                    <div class="item active">
                        <img src="{{asset("images/E.jpg")}}" alt="Flower">
                        <div class="carousel-caption">
                            <h3>Asamblea General Universitaria</h3>
                            <p>2017-2019</p>
                        </div>
                    </div>

                    <div class="item">
                        <img src="{{asset("images/A.jpg")}}" alt="Chania">
                        <div class="carousel-caption">
                            <h3>Comision de Cultura</h3>
                            <p>AGU-UES 2017-2019</p>
                        </div>
                    </div>

                    <div class="item">
                        <img src="{{asset("images/B.jpg")}}" alt="Chania">
                        <div class="carousel-caption">
                            <h3>Comision de Realidad Nacional y Comunicaciones</h3>
                            <p>AGU-UES 2017-2019</p>
                        </div>
                    </div>

                    <div class="item">
                        <img src="{{asset("images/C.jpg")}}" alt="Flower">
                        <div class="carousel-caption">
                            <h3>Comision de Evaluacion y Desempeño de Autoridades Electas</h3>
                            <p>AGU-UES 2017-2019</p>
                        </div>
                    </div>


                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-text-width"></i>

                    <h3 class="box-title">Block Quotes</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <blockquote>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                        <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
                    </blockquote>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- ./col -->
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-text-width"></i>

                    <h3 class="box-title">Block Quotes Pulled Right</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body clearfix">
                    <blockquote class="pull-right">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                        <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
                    </blockquote>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- ./col -->
    </div>
@endsection

