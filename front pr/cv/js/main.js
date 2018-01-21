            function listFunction() {
                document.getElementById("list-result").style.display = "block";
                document.getElementById("table-result").style.display = "none";
            };

            function tableFunction() {
                document.getElementById("table-result").style.display = "block";
                document.getElementById("list-result").style.display = "none";
            };

            function checkFields(form) {
                var checks_radios = form.find(':checkbox, :radio'),
                    inputs = form.find(':input').not(checks_radios).not('[type="submit"],[type="button"],[type="reset"]'); 
                
                var checked = checks_radios.filter(':checked, :selected');
                var filled = inputs.filter(function(){
                    return $.trim($(this).val()).length > 0;
                });
                
                if(checked.length + filled.length < 3) {
                    return false;
                }
                
                return true;
            }
             $(function(){
                $('#myForm').on('submit',function(e){
                    e.preventDefault();
                    var twoFilled = checkFields($(this));
                    if(twoFilled) {
                        
                        document.getElementById("myResult").style.display = "block";
                        document.getElementById("table-result").style.display = "block";
                        document.getElementById("list-result").style.display = "none";
                        document.getElementById("alert").style.display = "none";


                    } else {
                        document.getElementById("alert").style.display = "block";
                    }
                });
            });
            


$(function() {
    attachEvent()
})

function attachEvent() {

    $('#publish').click(function() {

        var selectValue = $('#requestValue').val()

        sendRequest(selectValue);
    })

}




  function sendRequest() {
        var someValue = document.getElementById('requestValue').value;
        var url = "https://randomuser.me/api/?results=" + someValue;
        var genderValue = document.getElementById('genderVal').value;
        var nationalValue = document.getElementById('natVal').value;
        var tempArr = [];
        $.ajax({
            url: url,
            dataType: 'json',
            success: function (data) {
                for(let i = 0; i < data.results.length;i++){
                    if(data.results[i].gender == genderValue && data.results[i].nat == nationalValue){
                        console.log('success')
                        tempArr.push(data.results[i])
                        var image = data.results[i].picture.medium;
                        var name = data.results[i].name.first + ' ' + data.results[i].name.last
                        var city = data.results[i].location.city;
                        var phone = data.results[i].phone;
                        addRow(image, name, city, phone);
                        addList(image, name, city, phone)
                    }
                }

                
            }
        })
    }

    function addRow(image, name, city, phone) {
        if (!document.getElementsByTagName) return;
        tabBody = document.getElementsByTagName("tbody").item(0);
        row = document.createElement("tr");
        cell = document.createElement("td");
        cell1 = document.createElement("td");
        cell2 = document.createElement("td");
        cell3 = document.createElement("td");
        textnode = document.createElement("IMG");
        textnode.src = image;
        textnode1 = document.createTextNode(name);
        textnode2 = document.createTextNode(city);
        textnode3 = document.createTextNode(phone);
        cell.appendChild(textnode);
        cell1.appendChild(textnode1);
        cell2.appendChild(textnode2);
        cell3.appendChild(textnode3);
        row.appendChild(cell);
        row.appendChild(cell1);
        row.appendChild(cell2);
        row.appendChild(cell3);
        tabBody.appendChild(row);
    }


    function addList(image, name, city, phone) {
        if (!document.getElementById) return;
        ulBody = document.getElementById("myList");
        row = document.createElement("ul");
        row.setAttribute("class", "col-sm-3 col-xs-6");
        cell = document.createElement("li");
        cell1 = document.createElement("li");
        cell2 = document.createElement("li");
        cell3 = document.createElement("li");
        textnode = document.createElement("IMG");
        textnode.src = image;
        textnode1 = document.createTextNode(name);
        textnode2 = document.createTextNode(city);
        textnode3 = document.createTextNode(phone);
        cell.appendChild(textnode);
        cell1.appendChild(textnode1);
        cell2.appendChild(textnode2);
        cell3.appendChild(textnode3);
        row.appendChild(cell);
        row.appendChild(cell1);
        row.appendChild(cell2);
        row.appendChild(cell3);
        ulBody.appendChild(row);
    }





