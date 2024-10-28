function loading()
{
    $('#loader').show();
    $('.div-loading').addClass('background-load');
}
function matikanLoading()
{
    $('#loader').hide();
    $('.div-loading').removeClass('background-load');
}
function hapusvalidasi(key) {
    let pesan = $('#' + key);
    let text = $('.' + key);
    pesan.removeClass('is-invalid');
    text.text(null);
}
function addValidasi(key,textVal) {
    let pesan = $('#' + key);
    let text = $('.' + key);
    pesan.addClass('is-invalid');
    text.text(textVal);
}

function bacaLink(inputan,image) {
    if (inputan.files && inputan.files[0]) {
        var baca=new FileReader();
        baca.onload=function(e)
        {
            image.attr('src',e.target.result);
            image.hide();
            image.fadeIn(650);
        }
        baca.readAsDataURL(inputan.files[0]);
    }
}

function customNumberSeparator(number, separator = '.') {
    
    if (typeof number !== 'number') {
      throw new Error('Input must be a number');
    }
  
    if (typeof separator !== 'string' || separator.length !== 1) {
      throw new Error('Separator must be a single character string');
    }
    // Convert the number to a string
    const numberString = number.toString();
    // Use a regular expression to add custom separator
    const formattedNumber = numberString.replace(/\B(?=(\d{3})+(?!\d))/g, separator);
  
    return formattedNumber;
  }

  function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};