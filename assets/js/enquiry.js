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

// OTP Configuration
const RECAPTCHA_SITE_KEY = '6LfvdVcqAAAAABlZbwDh0MKP9LpT10JKxPSqEYqG';
const SEND_OTP_URL = 'includes/send-otp.php';
const VERIFY_OTP_URL = 'includes/verify-otp.php';

// Send OTP Handler for Modal Forms
$(document).on('click', '.send-otp-btn-modal, .send-otp-btn-main', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    var btn = $(this);
    var form = btn.closest('form.enquiryFormModal');
    var isModal = btn.hasClass('send-otp-btn-modal');
    var otpSection = isModal ? form.find('.otp-section-modal') : form.find('.otp-section-main');
    var mainSection = form.find('.row').first();
    var messageArea = form.find('.modalMsg');
    var otpMessageArea = form.find('.otp-message-area');
    
    // Prevent double submission
    if (form.data('submitting')) {
        return false;
    }
    
    // Basic form validation
    if (!form[0].checkValidity()) {
        form[0].reportValidity();
        return false;
    }
    
    // Get form values
    var countryCode = form.find('select[name="countryCode"]').val();
    var phone = form.find('input[name="phone"]').val().trim().replace(/\D/g, '');
    var email = form.find('input[name="email"]').val().trim();
    
    // Validate phone
    if (!phone || phone.length < 7) {
        messageArea.html('<div class="text-danger">Please enter a valid phone number.</div>');
        return false;
    }
    
    // Validate email
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        messageArea.html('<div class="text-danger">Please enter a valid email address.</div>');
        return false;
    }
    
    form.data('submitting', true);
    btn.prop('disabled', true);
    messageArea.html('<div class="text-info">Sending verification code...</div>');
    
    // Send OTP request
    $.ajax({
        url: SEND_OTP_URL,
        type: 'POST',
        data: {
            countryCode: countryCode,
            phone: phone,
            email: email
        },
        dataType: 'json',
        success: function(response) {
            form.data('submitting', false);
            btn.prop('disabled', false);
            
            if (response.success) {
                messageArea.html('<div class="text-success">' + response.msg + '</div>');
                // Hide main form, show OTP section
                mainSection.hide();
                otpSection.show();
                form.find('.otp-input-modal, .otp-input-main').focus();
            } else {
                messageArea.html('<div class="text-danger">' + (response.error || 'Failed to send verification code.') + '</div>');
            }
        },
        error: function(xhr, status, error) {
            form.data('submitting', false);
            btn.prop('disabled', false);
            try {
                var response = JSON.parse(xhr.responseText);
                messageArea.html('<div class="text-danger">' + (response.error || 'Request failed. Please try again.') + '</div>');
            } catch(e) {
                messageArea.html('<div class="text-danger">Request failed. Please try again.</div>');
            }
        }
    });
});

// Resend OTP Handler
$(document).on('click', '.resend-otp-modal, .resend-otp-main', function(e) {
    e.preventDefault();
    var form = $(this).closest('form.enquiryFormModal');
    var isModal = $(this).hasClass('resend-otp-modal');
    var sendBtn = isModal ? form.find('.send-otp-btn-modal') : form.find('.send-otp-btn-main');
    sendBtn.trigger('click');
});

// Back to Form Handler
$(document).on('click', '.back-to-form-modal, .back-to-form-main', function(e) {
    e.preventDefault();
    var form = $(this).closest('form.enquiryFormModal');
    var isModal = $(this).hasClass('back-to-form-modal');
    var otpSection = isModal ? form.find('.otp-section-modal') : form.find('.otp-section-main');
    var mainSection = form.find('.row').first();
    var otpInput = isModal ? form.find('.otp-input-modal') : form.find('.otp-input-main');
    var otpMessageArea = form.find('.otp-message-area');
    
    otpSection.hide();
    mainSection.show();
    otpInput.val('');
    otpMessageArea.html('');
    form.find('.submit-btn-modal, .submit-btn-main').prop('disabled', true);
});

// OTP Input Handler - Enable submit button when 6 digits entered
$(document).on('input', '.otp-input-modal, .otp-input-main', function() {
    var otp = $(this).val().replace(/\D/g, '');
    $(this).val(otp);
    var form = $(this).closest('form.enquiryFormModal');
    var isModal = $(this).hasClass('otp-input-modal');
    var submitBtn = isModal ? form.find('.submit-btn-modal') : form.find('.submit-btn-main');
    
    if (otp.length === 6) {
        submitBtn.prop('disabled', false);
    } else {
        submitBtn.prop('disabled', true);
    }
});

//Modal Enquiry Form - Final Submission (after OTP verification)
$(".enquiryFormModal").submit( function (e){
    e.preventDefault();
    e.stopPropagation();
    
    var obj = $(this);
    var isModal = obj.find('.otp-section-modal').is(':visible');
    var otpInput = isModal ? obj.find('.otp-input-modal') : obj.find('.otp-input-main');
    var otpMessageArea = obj.find('.otp-message-area');
    var recaptchaTokenField = isModal ? obj.find('#modalRecaptchaToken') : obj.find('#mainRecaptchaToken');
    
    // Check if OTP section is visible (means we're in OTP verification step)
    if (obj.find('.otp-section-modal, .otp-section-main').is(':visible')) {
        var otp = otpInput.val().trim();
        
        // Validate OTP format
        if (!otp || otp.length !== 6 || !/^\d{6}$/.test(otp)) {
            otpMessageArea.html('<div class="text-danger">Please enter a valid 6-digit verification code.</div>');
            return false;
        }
        
        // Prevent double submission
        if (obj.data('verifying')) {
            return false;
        }
        obj.data('verifying', true);
        obj.find('.submit-btn-modal, .submit-btn-main').prop('disabled', true);
        otpMessageArea.html('<div class="text-info">Verifying code...</div>');
        
        // Verify OTP first
        $.ajax({
            url: VERIFY_OTP_URL,
            type: 'POST',
            data: { otp: otp },
            dataType: 'json',
            success: function(response) {
                obj.data('verifying', false);
                
                if (response.success) {
                    otpMessageArea.html('<div class="text-success">' + response.msg + '</div>');
                    
                    // OTP verified, now get reCAPTCHA token and submit to Netlify
                    if (typeof grecaptcha !== 'undefined') {
                        grecaptcha.ready(function() {
                            grecaptcha.execute(RECAPTCHA_SITE_KEY, {action: 'submit'}).then(function(token) {
                                recaptchaTokenField.val(token);
                                submitToNetlify(obj);
                            });
                        });
                    } else {
                        // If reCAPTCHA not loaded, submit anyway (will be handled server-side)
                        submitToNetlify(obj);
                    }
                } else {
                    otpMessageArea.html('<div class="text-danger">' + (response.error || 'Invalid verification code.') + '</div>');
                    obj.find('.submit-btn-modal, .submit-btn-main').prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                obj.data('verifying', false);
                obj.find('.submit-btn-modal, .submit-btn-main').prop('disabled', false);
                try {
                    var response = JSON.parse(xhr.responseText);
                    otpMessageArea.html('<div class="text-danger">' + (response.error || 'Verification failed. Please try again.') + '</div>');
                } catch(e) {
                    otpMessageArea.html('<div class="text-danger">Verification failed. Please try again.</div>');
                }
            }
        });
        
        return false;
    }
    
    // If OTP section is not visible, this shouldn't happen (form should be blocked)
    return false;
});

// Submit to Netlify after OTP verification
function submitToNetlify(form) {
    var obj = form;
    
    // Prevent double submission
    if (obj.data('submitting')) {
        return false;
    }
    obj.data('submitting', true);
    
    var formData = new FormData(obj[0]);
    
    // Add form-name to the form data
    formData.append('form-name', 'modal-contact');
    
    obj.find('.submit-btn-modal, .submit-btn-main').prop('disabled', true);
    var otpMessageArea = obj.find('.otp-message-area');
    otpMessageArea.html('<div class="text-info">Submitting form...</div>');
    
    // Submit to Netlify
    fetch("https://spinecare-landing-page.netlify.app", {
        method: 'POST',
        body: formData,
        mode: 'no-cors',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(() => {
        // Wait a moment to ensure Netlify processes the submission
        setTimeout(() => {
            window.location.href = "thank-you.php";
            obj[0].reset();
        }, 1000);
    })
    .catch(error => {
        console.error('Form submission error:', error);
        var txt = '<div class="text-danger">Error occurred. Please try again later.</div>';
        otpMessageArea.html(txt);
        obj.find('.submit-btn-modal, .submit-btn-main').prop('disabled', false);
    })
    .finally(() => {
        obj.data('submitting', false);
    });
}

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
$(".downloadFormModal").submit( function (e){
    e.preventDefault();
    e.stopPropagation();
    
    var obj = $(this);
    
    // Prevent double submission
    if (obj.data('submitting')) {
        return false;
    }
    
    // Clear previous error messages
    $(obj).find('.modalMsg').html('');
    $(obj).find('.form-control').removeClass('is-invalid');
    
    // Get form fields
    var name = $(obj).find('#brochureName').val().trim();
    var countryCode = $(obj).find('#brochureCountryCode').val();
    var phone = $(obj).find('#brochurePhone').val().trim();
    var email = $(obj).find('#brochureEmail').val().trim();
    
    var isValid = true;
    var errorMessages = [];
    
    // Validate Name
    if (!name || name.length < 2) {
        isValid = false;
        $(obj).find('#brochureName').addClass('is-invalid');
        errorMessages.push('Name must be at least 2 characters long');
    } else if (!/^[a-zA-Z\s]{2,50}$/.test(name)) {
        isValid = false;
        $(obj).find('#brochureName').addClass('is-invalid');
        errorMessages.push('Name can only contain letters and spaces');
    }
    
    // Validate Country Code
    if (!countryCode) {
        isValid = false;
        $(obj).find('#brochureCountryCode').addClass('is-invalid');
        errorMessages.push('Please select a country code');
    }
    
    // Validate Phone Number
    if (!phone) {
        isValid = false;
        $(obj).find('#brochurePhone').addClass('is-invalid');
        errorMessages.push('Phone number is required');
    } else if (!/^[0-9]{7,15}$/.test(phone)) {
        isValid = false;
        $(obj).find('#brochurePhone').addClass('is-invalid');
        errorMessages.push('Phone number must be 7-15 digits only');
    } else {
        // Validate phone length based on country code
        var phoneLength = phone.length;
        var countryCodeDigits = countryCode.replace('+', '');
        
        // US/Canada: 10 digits
        if ((countryCode === '+1') && phoneLength !== 10) {
            isValid = false;
            $(obj).find('#brochurePhone').addClass('is-invalid');
            errorMessages.push('US/Canada phone numbers must be 10 digits');
        }
        // UK: 10 digits
        else if ((countryCode === '+44') && phoneLength !== 10) {
            isValid = false;
            $(obj).find('#brochurePhone').addClass('is-invalid');
            errorMessages.push('UK phone numbers must be 10 digits');
        }
        // India: 10 digits
        else if ((countryCode === '+91') && phoneLength !== 10) {
            isValid = false;
            $(obj).find('#brochurePhone').addClass('is-invalid');
            errorMessages.push('India phone numbers must be 10 digits');
        }
    }
    
    // Validate Email
    if (!email) {
        isValid = false;
        $(obj).find('#brochureEmail').addClass('is-invalid');
        errorMessages.push('Email is required');
    } else {
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            isValid = false;
            $(obj).find('#brochureEmail').addClass('is-invalid');
            errorMessages.push('Please enter a valid email address (e.g., name@domain.com)');
        }
    }
    
    // If validation fails, show errors and stop submission
    if (!isValid) {
        var errorHtml = '<div class="alert alert-danger" role="alert"><ul class="mb-0">';
        errorMessages.forEach(function(msg) {
            errorHtml += '<li>' + msg + '</li>';
        });
        errorHtml += '</ul></div>';
        $(obj).find('.modalMsg').html(errorHtml);
        obj.data('submitting', false);
        return false;
    }
    
    // All validations passed, proceed with submission
    obj.data('submitting', true);
    
    $(obj).find('.submitBtn').prop('disabled', true);
    $(obj).find('.modalMsg').html('<div class="text-info"><i class="bi bi-shield-check"></i> Verifying with reCAPTCHA...</div>');
    
    // Generate reCAPTCHA v3 token before submission
    grecaptcha.ready(function() {
        grecaptcha.execute('6LfvdVcqAAAAABlZbwDh0MKP9LpT10JKxPSqEYqG', {action: 'brochure_download'})
        .then(function(token) {
            // Set the token in the hidden field
            $('#brochureRecaptchaToken').val(token);
            
            // Now proceed with form submission
            var formData = new FormData(obj[0]);
    
    // Add form-name to the form data
    formData.append('form-name', 'brochure-download');
    
    // Submit to Netlify
    fetch("https://spinecare-landing-page.netlify.app", {
        method: 'POST',
        body: formData,
        mode: 'no-cors',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(() => {
        // Wait a moment to ensure Netlify processes the submission
        setTimeout(() => {
            window.location.href = "download.php";
            obj[0].reset();
        }, 1000);
    })
            .catch(error => {
                console.error('Form submission error:', error);
                var txt = '<span class="text-danger">Error occurred. Please try again later.</span>';
                $(obj).find('.modalMsg').html(txt);
                $(obj).find('.submitBtn').prop('disabled', false);
                obj.data('submitting', false);
            });
        })
        .catch(function(error) {
            console.error('reCAPTCHA error:', error);
            // If reCAPTCHA fails, still allow submission but log the error
            var formData = new FormData(obj[0]);
            formData.append('form-name', 'brochure-download');
            
            fetch("https://spinecare-landing-page.netlify.app", {
                method: 'POST',
                body: formData,
                mode: 'no-cors',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(() => {
                setTimeout(() => {
                    window.location.href = "download.php";
                    obj[0].reset();
                }, 1000);
            })
    .catch(error => {
        console.error('Form submission error:', error);
        var txt = '<span class="text-danger">Error occurred. Please try again later.</span>';
        $(obj).find('.modalMsg').html(txt);
        $(obj).find('.submitBtn').prop('disabled', false);
    })
    .finally(() => {
        obj.data('submitting', false);
            });
        });
    });
});

// Real-time validation for brochure download form
$(document).ready(function() {
    // Name validation
    $('#brochureName').on('input', function() {
        var name = $(this).val().trim();
        if (name.length >= 2 && /^[a-zA-Z\s]{2,50}$/.test(name)) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else if (name.length > 0) {
            $(this).removeClass('is-valid').addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid is-valid');
        }
    });
    
    // Phone validation
    $('#brochurePhone').on('input', function() {
        var phone = $(this).val().trim();
        var countryCode = $('#brochureCountryCode').val();
        
        // Remove any non-digit characters
        phone = phone.replace(/\D/g, '');
        $(this).val(phone);
        
        if (phone.length >= 7 && phone.length <= 15 && /^[0-9]{7,15}$/.test(phone)) {
            // Check country-specific length
            var isValidLength = true;
            if (countryCode === '+1' && phone.length !== 10) isValidLength = false;
            else if (countryCode === '+44' && phone.length !== 10) isValidLength = false;
            else if (countryCode === '+91' && phone.length !== 10) isValidLength = false;
            
            if (isValidLength) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        } else if (phone.length > 0) {
            $(this).removeClass('is-valid').addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid is-valid');
        }
    });
    
    // Country code change - revalidate phone and update help text
    $('#brochureCountryCode').on('change', function() {
        var countryCode = $(this).val();
        var helpText = $('#phoneHelpText');
        
        // Update help text based on country code
        if (countryCode === '+1' || countryCode === '+44' || countryCode === '+91') {
            helpText.text('Enter 10 digits (without spaces or dashes)');
        } else {
            helpText.text('Enter 7-15 digits (without spaces or dashes)');
        }
        
        $('#brochurePhone').trigger('input');
    });
    
    // Email validation
    $('#brochureEmail').on('input', function() {
        var email = $(this).val().trim();
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        if (email.length > 0 && emailPattern.test(email)) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else if (email.length > 0) {
            $(this).removeClass('is-valid').addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid is-valid');
        }
    });
});