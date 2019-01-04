$(".colorpicker").each(function(){
  $(this).spectrum({
    color: $(this).val(),
    showInput: true,
    allowEmpty:true
  })
});
