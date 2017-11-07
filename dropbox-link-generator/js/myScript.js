function myFunction() {
    var raw = 0;
    var bbimg = 0;
    var bburl = 0;
    var htmlimg = 0;
    var htmla = 0;
    var allurl = 0;
    var dropbox_url = $("#textarea_url").val();
    if (document.getElementById('raw').checked) {
        var raw = 1;
    }
    if (document.getElementById('bbimg').checked) {
        var bbimg = 1;
    }
    if (document.getElementById('bburl').checked) {
        var bburl = 1;
    }
    if (document.getElementById('htmlimg').checked) {
        var htmlimg = 1;
    }
    if (document.getElementById('htmla').checked) {
        var htmla = 1;
    }
    if (document.getElementById('allurl').checked) {
        var allurl = 1;
    }
    $("#number").html('<center><img src="img/plese-wait-dropbox.gif" width="100px"><br>Plese wait...</center>');
    $.post("logic.php", {
        dropbox_url: dropbox_url,
        raw: raw,
        bbimg: bbimg,
        bburl: bburl,
        htmlimg: htmlimg,
        htmla: htmla,
        allurl: allurl
    })
            .done(function (data) {
                $("#number").html(data);
            }).fail(function () {
        //alert( "error" );
    })
            .always(function () {
                //alert( "complete" );
            });
}
function checkTextArea()
{
    if (document.getElementById('textarea_url').value === '' || !(document.getElementById('raw').checked || document.getElementById('bbimg').checked || document.getElementById('bburl').checked || document.getElementById('htmlimg').checked || document.getElementById('htmla').checked || document.getElementById('allurl').checked))
    {
        alert('Error! Links or checkbox not found!');
        return false;
    } else {
        myFunction();
        return true;
    }
    return false;
}
function checkMail()
{
    if (document.getElementById('usr').value === '' || document.getElementById('email').value === '' || document.getElementById('message').value === '')
    {
        alert('Error! Please complete all fields!');
        return false;
    } else {
        return true;
    }
    return false;
}