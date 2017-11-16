//  GLOBAL SCRIPTS

//  This manifest imports all of the individual JS modules together ready to
//  compile into a single minified file.
//
//  It is recommended that you customise the loadout of your project by
//  removing any modules that will not be used.


//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


// PROJECT LEVEL JS

$(document).ready(function() {

  $('.nav__toggle').click(function() {
    $('body').toggleClass('nav--open');
  });

  $('.nav__blur').click(function() {
    $('body').removeClass('nav--open');
  });

  $('#ajax-form').submit(function(event){
    event.preventDefault();
    ajaxFunction();
  });

   // FUNCTION TO TRIGGER THE AJAX
  function ajaxFunction(){
    // reset styles
    $('.ajax-message').html('');
    $('.ajax-message').removeClass('error');
    $('input.error').removeClass('error');
    $('input.error').removeClass('success');
    $('textarea.error').removeClass('error');

    // getting the email inputted
    var form = $('#ajax-form');
    var formData = $(form).serialize();
    var email = $('input[name=email]').val();

    $.ajax({
      type: "post",
      url: $(form).attr('action'),
      data: formData,
      dataType: 'json',
      // when complete run this
      success:function(data){
        console.dir(data);

        if ( !data.success) {
          $('.ajax-message').addClass('error');
          if (data.errors.name) {
            $('#ajax-form').find('input[name=name]').addClass('error');
            $('.ajax-message').append('<li>' + data.errors.name + '</li>');
          };
          if (data.errors.email) {
            $('#ajax-form').find('input[name=email]').addClass('error');
            $('.ajax-message').append('<li>' + data.errors.email + '</li>');
          };
          if (data.errors.message) {
            $('#ajax-form').find('textarea[name=message]').addClass('error');
            $('.ajax-message').append('<li>' + data.errors.message + '</li>');
          };
          if (data.errors.address1) {
            $('#ajax-form').find('input[name=address1]').addClass('error');
            $('.ajax-message').append('<li>' + data.errors.address1 + '</li>');
          };
          if (data.errors.address2) {
            $('#ajax-form').find('input[name=address2]').addClass('error');
            $('.ajax-message').append('<li>' + data.errors.address2 + '</li>');
          };
          if (data.errors.town) {
            $('#ajax-form').find('input[name=town]').addClass('error');
            $('.ajax-message').append('<li>' + data.errors.town + '</li>');
          };
          if (data.errors.postcode) {
            $('#ajax-form').find('input[name=postcode]').addClass('error');
            $('.ajax-message').append('<li>' + data.errors.postcode + '</li>');
          };
          if (data.errors.choices) {
            $('.ajax-message').append('<li>' + data.errors.choices + '</li>');
          };
        } else {
          $('.ajax-message').addClass('success');
          $('input[name=submit]').addClass('btn--notify-success');
          $('input[name=submit]').removeClass('btn--accent');
          $('input[name=submit]').val('Sent');
          $('.ajax-message').append('<li>' + data.message + '</li>');
        }; // ON SUCCESS
      }
    });
  }

});


//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //
