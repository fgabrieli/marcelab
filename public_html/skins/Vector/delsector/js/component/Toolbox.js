ds.Component.Toolbox = $.extend(true, {}, ds.Component, {
 init : function() {
  // hide the toolbox, we won't use it
  this.hide();
 },
 hide : function() {
  $('#p-tb').hide();
 }
});