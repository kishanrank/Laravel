@extends('layouts.frontend')

@section('header')
<div id="post-header" class="page-header">
    <div class="background-img"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="text-dark">About Us</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-md-1"></div>

<div class="col-md-10 text-center">
    <div class="section-row">
        <p>Lorem ipsum dolor sit amet, ea eos tibique expetendis, tollit viderer ne nam. No ponderum accommodare eam, purto nominavi cum ea, sit no dolores tractatos. Scripta principes quaerendum ex has, ea mei omnes eruditi. Nec ex nulla mandamus, quot omnesque mel et. Amet habemus ancillae id eum, justo dignissim mei ea, vix ei tantas aliquid. Cu laudem impetus conclusionemque nec, velit erant persius te mel. Ut eum verterem perpetua scribentur.</p>
        <figure class="figure-img">
            <img class="img-responsive" src="{{asset('app/img/about-1.jpg')}}" alt="">
        </figure>
        <p>Vix mollis admodum ei, vis legimus voluptatum ut, vis reprimique efficiendi sadipscing ut. Eam ex animal assueverit consectetuer, et nominati maluisset repudiare nec. Rebum aperiam vis ne, ex summo aliquando dissentiunt vim. Quo ut cibo docendi. Suscipit indoctum ne quo, ne solet offendit hendrerit nec. Case malorum evertitur ei vel.</p>
    </div>
    <div class="row section-row">
        <div class="col-md-6">
            <figure class="figure-img">
                <img class="img-responsive" src="{{asset('/app/img/about-2.jpg')}}" alt="">
            </figure>
        </div>
        <div class="col-md-6">
            <h3>Our Mission</h3>
            <p>Id usu mutat debet tempor, fugit omnesque posidonium nec ei. An assum labitur ocurreret qui, eam aliquid ornatus tibique ut.</p>
            <ul class="list-style">
                <li><p>Vix mollis admodum ei, vis legimus voluptatum ut.</p></li>
                <li><p>Cu cum alia vide malis. Vel aliquid facilis adolescens.</p></li>
                <li><p>Laudem rationibus vim id. Te per illum ornatus.</p></li>
            </ul>
        </div>
    </div>
</div>
<div class="col-md-1"></div>
@endsection