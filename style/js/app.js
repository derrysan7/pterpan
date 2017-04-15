$(function(){
    var removeLink = '<a class="btn btn-danger remove" href="#" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false">Hapus</a>';
    $('a.copy').relCopy({append: removeLink});
});

