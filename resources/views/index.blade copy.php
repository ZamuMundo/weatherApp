<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Weather Simulator</title>

    <link rel="stylesheet" href="{{asset('/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <script src="{{asset('/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/bootstrap.js')}}" type="text/javascript"></script>
</head>
<body class="bg_general">

    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
          <span class="navbar-brand mb-0 h1">WEATHER APP</span>
        </div>
      </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h3>Escribe el nombre de una ciudad</h3>
                <form method="post" action="/">
                    @csrf
                    <div class="mb-3">

                      <input type="text" class="form-control" name="city" id="inputCity">
                    </div>
                    <button type="submit" id="btnCity" class="btn btn-primary">Submit</button>
                  </form>
            </div>
        </div>

        <div class="container mt-5">
            <div id='card' class="row justify-content-center"></div>
        </div>

    </div>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function(){
          $('#btnCity').click(function(e) {
            e.preventDefault();

            var sourceCity = $('#inputCity').val();

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var data = {
              city: sourceCity,
            };

            var url = "/";

            $.post(url, data, function(result) {

                const icon = 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/'+result.icon+'.svg';

                /** Remove si existe **/
                $('#card').children().remove();
                $('input[type="text"]').val('');

                /** create card **/
                if(result.status == 200){
                    let html_card = '<div class=\"card border-light mb-3\" style=\"max-width: 18rem;\">';
                    html_card += '<div class=\"card-header\"><div class="row text-center"><div class="col-lg-8"><h5 class="text-uppercase">'+result.city+'</h5></div><div class="col-lg-4"><h5>'+result.temp+'º<h5></div></div></div>';
                    html_card += '<div class=\"card-body\">';
                    html_card += '<div class="row d-flex align-items-center"><div class="col-sm-6"><h5 class="text-uppercase">'+result.weather+'</h5></div><div class="col-sm-6"><img class="img-fluid" src="'+icon+'" alt=""></div></div>'
                    html_card += '<h5 class=\"card-title text-uppercase\">'+result.description+'</h5>'
                    html_card += '<p class=\"card-text text-uppercase\">Max:'+result.tempMax+' Min:'+result.tempMin+'</p>';
                    html_card += '<p class=\"card-text text-uppercase\">Amanecer: '+result.sunrise+' Anochecer: '+result.sunset+'</p>';
                    html_card += '<p class=\"card-text text-uppercase\">lluvia historia: '+result.lastDayRain+'</p>';
                    html_card += '</div>';
                    html_card += '</div>';

                    let weather_card = $(html_card);
                    $('#card').append(weather_card);
                }else{
                    /** create alert **/
                    let html_alert = '<div class="alert alert-primary" role="alert">Es posible que la ciudad no exista, prueba de nuevo. Una Opción Almería</div>';
                    let weather_card = $(html_alert);
                    $('#card').append(weather_card);
                }


            }).fail(function(){

                //$('#resp').html('Algo salio mal');

            });


          });
        });
    </script>
</body>
</html>
