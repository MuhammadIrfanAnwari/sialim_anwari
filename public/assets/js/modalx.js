$('.modal').on('shown.bs.modal', function(){
    $(this).before($('.modal-backdrop'))
    $(this).css('z-index', parseInt($('.modal-backdrop').css('z-index'))+1)
})