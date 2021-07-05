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
    <script src="{{asset('/js/weather.js')}}" type="text/javascript"></script>

</body>
</html>
