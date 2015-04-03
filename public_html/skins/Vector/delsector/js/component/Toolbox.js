ds.Component.Toolbox = $.extend(ds.Component, {}, {
 init : function() {
  // hide the toolbox, we won't use it
  this.hide();
 },
 hide : function() {
  $('#p-tb').hide();
 }
});