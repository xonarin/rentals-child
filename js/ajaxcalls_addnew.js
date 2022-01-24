jQuery("#edit_prop_1").hover(function () {
      var descval = jQuery("#property_description").val();
      jQuery("#property_description-tmce").click();
      jQuery("#property_description").val(abra);
  });

jQuery("#edit_prop_1").hover(function () {
  var abra = jQuery('#property_description_ifr').contents().find('body').html();

      jQuery("#property_description").toggleClass( "background-red" );
      jQuery("#property_description").val(abra);
  });