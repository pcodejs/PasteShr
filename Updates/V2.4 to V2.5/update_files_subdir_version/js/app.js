$(document).ready(function () {
    new WOW().init();
    $('.select2').select2();
});

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}

function copyToClip(str, response_field = '') {
    function listener(e) {
        e.clipboardData.setData("text/html", str);
        e.clipboardData.setData("text/plain", str);
        e.preventDefault();
    }

    document.addEventListener("copy", listener);
    document.execCommand("copy");
    document.removeEventListener("copy", listener);
    if (response_field.length > 0) $('#' + response_field).html(txt_copied);
}


$(function(){
    $("#load_file").on('click', function(e){
        e.preventDefault();
        $("#paste_file:hidden").trigger('click');
    });

}); 

function handleFileSelect(input)
{               
    if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
      alert('The File APIs are not fully supported in this browser.');
      return;
    }   

    var input = input;
    if (!input) {
      alert("Um, couldn't find the fileinput element.");
    }
    else if (!input.files) {
      alert("This browser doesn't seem to support the `files` property of file inputs.");
    }
    else if (!input.files[0]) {
      alert("Please select a file before clicking 'Load'");               
    }
    else {
      var file = input.files[0];
      var fr = new FileReader();
      fr.readAsText(file)

      fr.onload =  function() { 
        var file_size = file.size / 1000;
        if (file_size > max_content_size_kb) {
            alert('Please select file less than '+max_content_size_kb+' kb');
        }
        else{
            $('[name="content"]').val(fr.result);
            if(typeof editor !== 'undefined' && editor !== null){  
                editor.setValue(fr.result, -1);
            }
        }
      }
      
    }
}

if(isAdBlockActive){
    $('main > div').html('<div class="row"><div class="card col-md-12 text-center text-danger h1 pt-5 pb-5">'+ad_block_message+'</div></div>');
}