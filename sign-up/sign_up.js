debugger
$(function () {
    $('.sign_up_btn').on('click', () => {
        let currentUsername = $('[name=username]').val()
        let currentPassword = $('[name=user_password]').val()
        let confirm_password = $('[name=confirm_password]').val()

        if (checkInfo(currentUsername) && checkInfo(currentPassword) && checkInfo(confirm_password)) {
            $.ajax({
                method: 'POST',
                url: './sign_up_handle.php',
                dataType: 'JSON',
                data: {
                    currentUsername: currentUsername,
                    currentPassword: currentPassword,
                    confirm_password: confirm_password,
                },
                success: res => {
                    if (res.success === 'create_account_OK') {
                        showInfo('Sign up success!')
                        document.location.href = '../index.php'
                    } else if (res.success === 'psw_confirm_ERROR') {
                        showInfo("Passwords didn't match. Try again!")
                    } else if (res.success === 'same_username_ERROR') {
                        showInfo('This username has already been taken!')
                    }
                },
            })
        } else if (!checkInfo(currentUsername) || !checkInfo(currentPassword) || !checkInfo(confirm_password)) {
            showInfo('Enter your username or password.')
        }
    })
    $('.psl_info').on('focus', () => {
        $('.sign_up_info').text('')
    })
})

function checkInfo(detail) {
    if (!detail) {
        return false
    } else {
        return true
    }
}

function showInfo(information) {
    $('.sign_up_info').text(information)
}
