var pEnum = 0;
var vks = {
	inter: function(){
   
	$.post('index.php?go=robokassa', function(d){
	  
	});
  },
 send_inter: function(){
	$.post('index.php?go=vk', function(d){
   if(d == '1'){
	   location.href = 'http://fungun.net/case/';
	    $(".yes_vks").show()
	    $(".errror_groups").hide()
        } 
    else  if(d == '2'){
          
         $(".errror_groups").show()
        }  
      
			
      });	


  },
  send_yes: function(){
		$.ajax({
			url: '/case/index.php?go=profile&act=yes',
			type: 'POST',
			dataType: 'json',
			data: {
				act: 'yes'
			},
			success: function(data) {
				if (data.status == 'success') {
					 location.href = 'http://fungun.net/case/';
				}
			},
			error: function() {
				alert('Произошла ошибка! Попробуйте еще раз')
			}
		})
  }
}