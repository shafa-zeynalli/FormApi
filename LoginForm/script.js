$('#myForm').on('submit', (e) => {
    e.preventDefault();

    let data = $('#myForm').serialize();
    // console.log(data)

    $.ajax({
        url: 'main.php?action=save',
        method: 'GET',
        data: data,
        success: (res) => {
            console.log(res)
            if (res.success) {
                var emailValue = $('#email').val();
                var passwordValue = $('#password').val();
                var combinedValue = 'Email: ' + emailValue + " " + '<br>Password: ' + passwordValue;

                $('div').html(combinedValue);
                $('#myForm').css('display', 'none');
                $('div').css('display', 'block');
                $('#errorPassword').html('');

            } else {
                if (res.email) {
                    $('#email').css('border', '1px solid red')
                    $('#errorEmail').html(res.email);
                } else {
                    $('#email').css('border', '1px solid green')
                    $('#errorEmail').html('');

                }

                if (res.password) {
                    $('#password').css('border', '1px solid red')
                    $('#errorPassword').html(res.password);
                } else {
                    $('#password').css('border', '1px solid green')
                    $('#errorPassword').html('');
                }

                if (!res.password && !res.email && res.erMessage) {
                    $('#errorPassword').html(res.erMessage);
                }
            }

        }
    })

})

$('#myForm2').on('submit', (e) => {
    e.preventDefault();

    let data = $('#myForm2').serialize();
    // console.log(data)

    $.ajax({
        url: 'main.php?action=save',
        method: 'GET',
        data: data,
        success: (res) => {
            console.log(res)
            if (res.name) {
                $('#name').css('border', '1px solid red')
                $('#errorName').html(res.name);
            } else {
                $('#name').css('border', '1px solid green')
                $('#errorName').html('');
            }
            if (res.email1) {
                $('#n1email').css('border', '1px solid red')
                $('#n1errorEmail').html(res.email1);
            } else {
                $('#n1email').css('border', '1px solid green')
                $('#n1errorEmail').html('');
            }

            if (res.password2) {
                $('#n2password').css('border', '1px solid red')
                $('#n2errorPassword').html(res.password2);
            } else {
                $('#n2password').css('border', '1px solid green')
                $('#n2errorPassword').html('');
            }

            if (res.password1) {
                $('#n1password').css('border', '1px solid red')
                $('#n1errorPassword').html(res.password1);
            } else {
                $('#n1password').css('border', '1px solid green')
                $('#n1errorPassword').html('');
            }

            if (!res.password1 && !res.password2 && res.erMessage2) {
                $('#n2errorPassword').html(res.erMessage2);
            }
            if (!res.password1 && !res.password2 && res.erMessage3) {
                $('#n2errorPassword').html(res.erMessage3);
            }

            if (res.success2) {
                $('#myForm2').css('display', 'none');
                $('div').css('display', 'block');
                $('div').html('Təbriklər qeydiyyatdan ugurla kecdiniz')
                $('#n2errorPassword').html('');
            }


        }
    })

})

$('#btnSignUp').on('click', () => {
    $('#myForm').css('display', 'none');
    $('#myForm2').css('display', 'block');
})
$('#btn2').on('click', () => {
    $('#myForm').css('display', 'block');
    $('#myForm2').css('display', 'none');
})

