
jQuery(document).ready(function() {
        var searchRequest = null;
        $("#search").keyup(function() {
            var minlength = 1;
            var that = this;
            var value = $(this).val();
            var entitySelector = $("#entitiesNav").html('');
            if (value.length >= minlength ) {
                if (searchRequest != null)
                    searchRequest.abort();
                searchRequest = $.ajax({
                    type: "GET",
                    url: "{{ path('ajax_search') }}",
                    data: {
                        'q' : value
                    },
                    dataType: "json",
                    success: function(msg){
                        console.log(Object.keys(msg))
                        $('#eventsBody').empty()
                        if(Object.keys(msg)[0] !== "message") {
                            Object.keys(msg).forEach(i => {
                                console.log(msg[i].Titre)
                        $('#entitiesNav').append(
                            `<div class="card mb-4">
                <div class="container-fluid pt-5" style="display:flex; justify-content: flex-start;flex-wrap: wrap;">

                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px; margin-right:-22px">

                           <a href="" class="cat-img position-relative overflow-hidden mb-3">
                            <img class="img-fluid" src="${  msg[i].image_prop }"
                              style="width: 140px ; height: 140px"  alt="">
                        </a>
                        <h5 class="font-weight-semi-bold m-0">
                        ${msg[i].id }
                        <hr>
                    </h5>
                    <h5 class="font-weight-semi-bold m-0">
                        ${msg[i].nom_prop }
                        <hr>
                    </h5>
                    <p class="card-text">${msg[i].Categorie}  ${msg[i].prenom_prop }<br>
                        Description: <br>
                        Lieu: </p>
                    <div class="text-primary" style="...">
                   
                    </div>
                </div>
        </div>
            </div>`
                        )
                    })
                } else {
                    $('#entitiesNav').html("<h3>Aucun props existant!</h3>")
                }

                //we need to check if the value is the same
                /* if (value===$(that).val()) {
                     var result = JSON.parse(msg);
                     $.each(result, function(key, arr) {
                         $.each(arr, function(id, value) {
                             if (key === 'posts') {
                                 if (id !== 'error') {
                                     console.log(value[1]);
                                     entitySelector.append('<li><b>'+value[1]+'</b><a href="/detailedpost/'+id+'">'+'<img src="/uploads/post/'+value[0]+'" style="width: 50px; height: 50px"/>'+'</a></li>');
                                 } else {
                                     entitySelector.append('<li class="errorLi">'+value+'</li>');
                                 }
                             }
                         });
                     });
                 }*/
            }
            });
        }
    });
    });

