ds.Component.Head = $.extend(true, {}, ds.Component, {
  UPLOAD_FILE_URL : '/w/Especial:SubirArchivo',
  init : function() {
    this.addUploadLink();
  },
  addUploadLink : function() {
    var li = $('<li>');
    var a = $('<a>');
    li.append(a);

    a.text('Subir un archivo');
    a.attr('href', this.UPLOAD_FILE_URL);
    
    var $bar = $('#mw-head #p-personal ul');
    $('li:last', $bar).before(li)
  }
});