//Newsletter Form
$(".form-subscribe").submit( function (){
	obj = $(".form-subscribe");
	$(obj).find('.submitBtn').prop('disabled', true);
	$.post( "includes/newslettermail.php", $(obj).serialize())
	  .done(function( data ) {
		var txt ='';
		if(data.status=='success'){
			window.location.href = "thank-you.php";
			$(obj)[0].reset();
        }else{
			txt ='<span class="text-danger"> Error occured Please try again later.</span>';
			$(obj).find('.submitBtn').prop('disabled', false);
		}
		$(obj).find('.newsletterMsg').html(txt);
	});
	return false;
});

//Modal Enquiry Form
$(".enquiryFormModal").submit( function (){
	obj = $(".enquiryFormModal");
	$(obj).find('.submitBtn').prop('disabled', true);
	$.post( "includes/mail.php", $(obj).serialize())
	  .done(function( data ) {
		var txt ='';
		if(data.status=='success'){
			window.location.href = "thank-you.php";
			$(obj)[0].reset();
        }else{
			txt ='<span class="text-danger"> Error occured Please try again later.</span>';
			$(obj).find('.submitBtn').prop('disabled', false);
		}
		$(obj).find('.modalMsg').html(txt);
	});
	return false;
});

//Enquiry Form
$(".enquiryForm").submit( function (){
	obj = $(".enquiryForm");
	$(obj).find('.submitBtn').prop('disabled', true);
	$.post("includes/mail.php", $(obj).serialize())
	  .done(function( data ) {
		var txt ='';
		if(data.status=='success'){
			window.location.href = "thank-you.php";
			$(obj)[0].reset();
        }else{
			txt ='<span class="text-danger"> Error occured Please try again later.</span>';
			$(obj).find('.submitBtn').prop('disabled', false);
		}
		$(obj).find('.enquiryMsg').html(txt);
	});
	return false;
});

//Modal Download Brochure Form
$(".downloadFormModal").submit( function (){
	obj = $(".downloadFormModal");
	$(obj).find('.submitBtn').prop('disabled', true);
	$.post( "includes/download-brochure.php", $(obj).serialize())
	  .done(function( data ) {
		var txt ='';
		if(data.status=='success'){
			window.location.href = "download.php";
			$(obj)[0].reset();
        }else{
			txt ='<span class="text-danger"> Error occured Please try again later.</span>';
			$(obj).find('.submitBtn').prop('disabled', false);
		}
		$(obj).find('.modalMsg').html(txt);
	});
	return false;
});