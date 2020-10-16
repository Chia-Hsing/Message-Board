$(function () {
    $('.sign_in_btn').on('click', () => {
        let currentUsername = $('[name=username]').val()
        let currentPassword = $('[name=user_password]').val()

        if (checkInfo(currentUsername) && checkInfo(currentPassword)) {
            $.ajax({
                method: 'POST',
                url: './sign_in_handle.php',
                data: { currentUsername: currentUsername, currentPassword: currentPassword },
                dataType: 'JSON',
                success: (res) => {
                    if (res.success === 'sign_in_OK') {
                        showInfo('Sign in success!')
                        document.location.href = '../main-page/main_page.php'
                    } else if (res.success === 'sign_in_ERROR') {
                        showInfo('Incorrect username or password.')
                    }
                },
            })
        } else if (!checkInfo(currentUsername) || !checkInfo(currentPassword)) {
            showInfo('Enter your username or password.')
        }
    })
    // focus input 時，取消登入的information
    $('.psl_info').on('focus', () => {
        $('.sign_in_info').text('')
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
    $('.sign_in_info').text(information)
}
