$( function() {
	$( "#datepicker" ).datepicker();
});
$(document).ready(function() {
    $('.selectpicker').select2();
});
function preview_image(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('imagem');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}