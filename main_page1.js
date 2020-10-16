/* ============ SUBMIT MESSAGE ============ */

$(function () {
    $('.wrap').on('click', '.submit', (e) => {
        if ($(e.target).parent().find('textarea').val() === '') {
            const placeHolder = $(e.target).parent().find('textarea')
            placeHolder.attr('placeholder', 'you have to write something.')
            for (let i = 0; i <= 5; i += 1) {
                placeHolder.animate({ 'margin-left': '-5px' }, 40).animate({ 'margin-left': '5px' }, 40)
            }
            placeHolder.animate({ margin: '0 0 10px' }, 40)
            placeHolder.on('focus', () => {
                placeHolder.attr('placeholder', 'say something...')
            })
            return false
        } else {
            let username = $(e.target).parent().find('[name=username]').val()
            let content = $(e.target).parent().find('textarea').val()
            const parent_id = $(e.target).prev().val()

            $.ajax({
                method: 'POST',
                url: './main_page_handle.php',
                data: { username: username, content: content, parent_id: parent_id },
                dataType: 'JSON',
                success: (res) => {
                    if (parent_id == 0) {
                        const content = `
                                        <div class='message_wrap for_delete'>
                                            <div class='container1'>
                                                <div class='name1'>
                                                    <div class='username'>${htmlspecialchars(res.username)}</div>
                                                </div>
                                                <div class='body'>
                                                    <div class='content for_edit'>${htmlspecialchars(res.message)}</div>
                                                    <div class='time'>${res.time}</div>
                                                </div>
                                                <div class='interface'>
                                                    <input name='id' type='hidden' value='${res.id}'>
                                                    <a class='delete'>delete /</a>
                                                    <a class='edit'>edit</a>
                                                </div>
                                                <span class='toggle_message'>[ + ]</span>
                                            </div>
                                            
                                            <div class='sub_container'>
                                                <div class='sub_name'>
                                                    <div class='sub_username'>${htmlspecialchars(res.username)}</div>
                                                </div>
                                                <div class='sub_body'>
                                                    <textarea class='commentArea' name='sub_message' cols='5' rows='5' placeholder='say something...'></textarea>
                                                    <input name='username' type='hidden' value='${htmlspecialchars(
                                                        res.username
                                                    )}'>
                                                    <input name='parent_id' type='hidden' value='${res.id}'>
                                                    <input class='submit btn btn btn-dark btn-sm' type='submit' value='submit'>
                                                </div>
                                            </div>
                                        </div>
                                        `
                        $(e.target.closest('div')).find('textarea').val('')
                        $(e.target.closest('div')).find('textarea').attr('placeholder', 'say something...')
                        $(e.target).closest('.submit_message_wrap').after($(content).hide().fadeIn(500))
                        // 留言完成後，清除主留言區塊的內容。
                    } else {
                        // 若 parent_id 不等於 0，就是子留言 submit。
                        const content = `
                                <div class='sub_container1 for_delete' style='background: hsl(180, 15%, 90%)'>
                                    <div class='sub_name'>
                                        <div class='sub_username'>${htmlspecialchars(res.username)}</div>
                                    </div>
                                    <div class='sub_body'>
                                        <div class='content for_edit'>${htmlspecialchars(res.message)}</div>
                                        <div class='time'>${res.time}</div>
                                    </div>
                                    <div class='interface1'>
                                        <input name='id' type='hidden' value='${res.id}'>
                                        <a class='delete'>delete /</a>
                                        <a class='edit'>edit</a>
                                    </div>
                                </div>
                                    `

                        $(e.target.closest('div')).find('textarea').val('')
                        $(e.target.closest('div')).find('textarea').attr('placeholder', 'say something...')
                        $(e.target).closest('.sub_container').before($(content).hide().fadeIn(500))
                    }
                },
            })
            return false
        }
    })

    /* ============ LOG OUT ============ */

    $('.log_out').on('click', () => {
        document.location.href = '../api/log_out.php'
    })

    /* ============ DELETE MESSAGE============ */

    $('.wrap').on('click', '.delete', (e) => {
        if (!confirm('delete the message ?')) return false
        const id = $(e.target).prev().val()
        $.ajax({
            method: 'POST',
            url: '../api/delete.php',
            data: { id: id },
            dataType: 'JSON',
            success: (res) => {
                if (res.success == 'OK') {
                    $(e.target).closest('.for_delete').fadeOut(500)
                } else {
                    alert(res.error)
                }
            },
        })
        return false
    })

    /* ============ EDIT MESSAGE============ */

    $('.wrap').on('click', '.done', (e) => {
        const id = $(e.target).prev().prev().val()
        const changedMessage = $(e.target).parent().parent().find('textarea').val()
        $.ajax({
            method: 'POST',
            url: '../api/edit.php',
            data: { id: id, changedMessage: changedMessage },
            dataType: 'JSON',
            success: (res) => {
                if (res.success == 'OK') {
                    const newMessage = `
                        <div class='content for_edit'>${htmlspecialchars(changedMessage)}</div>
                    `

                    $(e.target).parent().parent().find('.time').before($(newMessage).hide().fadeIn(500))
                    $(e.target).parent().parent().find('textarea').fadeOut(500).remove()

                    $(e.target).text('edit')
                } else {
                    alert(res.error)
                }
            },
        })
        return false
    })

    $('.wrap').on('click', '.edit', (e) => {
        const editContent = $(e.target).parent().parent().find('.for_edit')
        const editContentText = editContent.text()
        const newArea = document.createElement('textarea')
        $(e.target).text('done')
        $(e.target).addClass('done')
        $(newArea).addClass('commentArea')
        $(newArea).text(editContentText)
        $(editContent).remove()
        $(e.target).parent().parent().find('.time').before(newArea.outerHTML)
    })

    /* =============== TOGGLE COMMENT AREA====================== */

    $('.wrap').on('click', '.toggle_message', (e) => {
        if (e.target.innerText === '[ + ]') {
            e.target.innerText = '[ - ]'
            $(e.target.closest('.container1')).siblings('.sub_container').css('display', 'block')
        } else {
            e.target.innerText = '[ + ]'
            $(e.target.closest('.container1')).siblings('.sub_container').css('display', 'none')
        }
    })
})

var htmlspecialchars = function (string, quote_style) {
    string = string.toString()

    string = string.replace(/&/g, '&amp;')
    string = string.replace(/</g, '&lt;')
    string = string.replace(/>/g, '&gt;')

    if (quote_style == 'ENT_QUOTES') {
        string = string.replace(/"/g, '&quot;')
        string = string.replace(/\'/g, '&#039;')
    } else if (quote_style != 'ENT_NOQUOTES') {
        string = string.replace(/"/g, '&quot;')
    }

    return string
}
