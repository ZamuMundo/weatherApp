
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
                    html_card += '<p class=\"card-text text-uppercase\"><strong>Tª Max:</strong> '+result.tempMax+' <strong>Tª Min:</strong> '+result.tempMin+'</p>';
                    html_card += '<p class=\"card-text text-uppercase\"><strong>Amanecer:</strong> '+result.sunrise+' <strong>Anochecer:</strong> '+result.sunset+'</p>';
                    html_card += '<p class=\"card-text text-uppercase\"><strong>LLuvia Historia:</strong> '+result.lastDayRain+'</p>';
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
