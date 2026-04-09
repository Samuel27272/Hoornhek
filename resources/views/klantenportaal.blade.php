@extends('layouts.app-klantenportaal')

@section('content')

<!-- HERO -->
<section class="hero">
    <div class="overlay">
        <h1>HoornHek</h1>
        <h2>Zitten om te leren</h2>
    </div>
</section>

<!-- OVER ONS -->
<section id="about" class="about">
    <div class="container">
        <div class="text">
            <h1>Over ons</h1>
            <h2>Arrestantencomplex</h2>
            <p>
                Voor de politie is het Arrestantencomplex te Houten ontworpen. In het complex zijn 105 politiecellen met nevenruimten opgenomen. Verder is er een totale verhoorfaciliteit ingericht met twintig verhoorkamers en twee verhoorstudio’s. Welstand en Monumenten Midden Nederland heeft het gebouw in juni 2006 verkozen tot plan van de maand door met de navolgende motivatie:
            </p>
            <p>
                “Het complex ademt rust uit en het heeft een soort alzijdigheid. Het totaal is zeer hoogwaardig vormgegeven”, “Het complex ziet er op het eerste gezicht simpel uit, maar is toch in de vormgeving en materiaalkeuze hoogwaardig. Bovendien is de routing in het gebouw vanwege tal van veiligheidsaspecten complex’.
            </p>
        </div>

        <div class="image">
            <img src="{{ asset('images/interior.jpg') }}">
        </div>
    </div>
</section>

<!-- HISTORIE -->
<section class="history">
    <div class="container">
        <img src="{{ asset('images/model.jpg') }}">

        <div>
            <h2>Historie</h2>
            <p>
                De handhaving van de openbare orde was van oudsher een taak van de schout. Maar deze kon nooit overal tegelijk zijn en had meerdere taken. Wanneer er in de 18e eeuw een probleem was met bedelaars of landlopers, kreeg de schout hulp van weerbare mannen. Raakte de verdachte gewond of stierf deze, dan gingen de mannen vrijuit.
            </p>
            <p>
                In maart 1811 richt Keizer Napoleon een politiemacht naar Frans model in. Er komt op het platteland een boswachter en een veldwachter. Het zijn vaak oud-militairen die in deze functie stappen. Ze waren onbewapend en bij grotere overtredingen moest de gendarmerie uit de stad erbij worden gehaald.
            </p>
            <p>
                Een veldwachter heeft in het begin geen hoog aanzien. Hij wordt slecht betaald en heeft neventaken als bode of opzichter bij openbare werken.
            </p>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="contact">
    <h2>Contact</h2>
    <p>Tel: 085 483 80 05</p>
    <p>Email: hoornhek@info.nl</p>
</section>

@endsection
