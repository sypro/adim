$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide"
  });
});
// Can also be used with $(document).ready()
$(window).load(function() {
  $('.flexslider-gal').flexslider({
    animation: "slide",
    controlNav: "thumbnails"
  });
});
// DOM ready
	 $(function() {

//     wmark.init({
//     /* config goes here */
//         "position": "top-right", // default "bottom-right"
//         "opacity": 50, // default 50
//         "className": "fotorama__img", // default "watermark
//         "path": "/images/logo.png"
//     });


      // Create the dropdown base
      $("<select />").appendTo("nav");
      
      // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Menu"
      }).appendTo("nav select");
      
      // Populate dropdown with menu items
      $("nav a").each(function() {
       var el = $(this);
       $("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo("nav select");
      });
      
	   // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      $("nav select").change(function() {
        window.location = $(this).find("option:selected").val();
      });



	 });

