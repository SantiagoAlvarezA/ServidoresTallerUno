$(document).ready(function () {
    show();

    console.log("holamundos") 
    $("#save_user").on("click", function () {
        registerUser();  
        console.log("holamundo")   

    });

    function registerUser() {
        var name = $("#name").val();
        var lastname = $("#last_name").val();
        var address = $("#address").val();
        var phone = $("#phone").val();
        var document = $("#document").val();

        $.ajax({
            type: 'POST',
            url: '../Php/Register.php',
            data:
            {
                "name": name,
                "lastname": lastname,
                "address": address,
                "phone": phone,
                "document": document,
                "action": "register"
            }
        })
        .done(function(params) {
            show();
            clearFormRegister();
        })

    }

    function show() {
        $.ajax({
            type: 'POST',
            url: '../Php/Register.php',
            data:
            {
                "action": "show"
            }
        })
            .done(function (data) {
                $("table#show_users tbody tr").remove();
                var array = JSON.parse(data);
                var n = 1;

                array.forEach(element => {
                    var usr = "";
                    usr = usr.concat(
                        "<tr>",
                        "<td>" + n + "</td>",
                        "<td>" + element.document + "</td>",
                        "<td>" + element.name + "</td>",
                        "<td>" + element.lastname + "</td>",
                        "<td>" + element.phone + "</td>",
                        "<td>" + element.address + "</td>",
                        "<td><button type='button' value='"+ element.id +"' class='btn btn-danger' id='delete'>Delete</button></td>",
                        "<td><button type='button' value='"+ element.id +"' class='btn btn-success' id='update'>Update</button></td>",
                        "</tr>"
                    );
                    n++;
                    $("table#show_users tbody").append(usr).closest("table#show_users");

                });

            })
    }

    function clearFormRegister() {
        $("#name").val('');
        $("#last_name").val('');
        $("#address").val('');
        $("#phone").val('');
        $("#document").val('');
    }

    $("#show_users").on("click", "#delete", function () {
        
        delete_user(this.value);

    });

    function delete_user(id){
        var option = confirm('desea eliminar este usuario?');
        if(option){
            $.ajax({
                type: 'POST',
                url: '../Php/Register.php',
                data:
                {
                    "id": id,
                    "action": "delete"
                }
            })
            .done(function(msg){
                console.log(msg)
                show();
            })
        }
    }

})