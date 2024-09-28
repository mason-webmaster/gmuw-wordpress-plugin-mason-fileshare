//Implement datatables
jQuery(document).ready(function() {

  //regular datatables
  jQuery('table.data_table:not(.simple)').DataTable({
    paging: false,
    dom: 'Bfrtip',
    buttons: [
      'copy', 'excel', 'csv', 'print'
    ]
  });

  //simple datatables
  jQuery('table.data_table.simple').DataTable({
    paging: false,
    dom: 'frtip',
  });

});

//Implement toggle containers
jQuery(document).ready(function(){
  
  //  Summary: JQuery subroutine to support toggle containers
  //  Details: This script will first hide any elements with a 'toggleContiner' class. It will then find any elements with a class of 'toggleContinerTrigger', and attach a function to them which will toggle the following element (should be the toggleContainer) on or off when clicked.

  //Hide any elements with a 'toggleContainer' class
    jQuery(".toggleContainer").hide();
  //Attach a function to any elements with a class of 'toggleContainerTrigger', which will toggle the following element (should be the toggleContainer) on or off when clicked.
    jQuery(".toggleContainerTrigger").click(function(){
      jQuery(this).toggleClass("active").next().slideToggle("fast");
    });
});
