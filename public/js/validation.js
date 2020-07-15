

function validate(){
    console.log('error');
    $('#fcreate-driver').validate({
        rules: {
            nik : {
                required: true,
                minlength: 2
            },
            name : "required",
            username: {
                required : true,
                minlength : 5
            }
        },
        messages: {
            nik:{
                required : "Please enter your NIK",
                minlength : "NIK must be at least 16 characters long"
            }
            
        },
        errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
				}

    });
}
