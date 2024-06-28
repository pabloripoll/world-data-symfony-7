/**
 * Authentication
 */

const CSRF_TOKEN = $(`meta[name=csrf-token]`)
const username = $(`[name=username]`)
const password = $(`[name=password]`)
const loginStatus = $(`#login-status`)
const submitButton = $(`#submit-button`)

function resetLoginStatus() {
    loginStatus.html(`
        <div class="alert alert-default alert-dismissible">
            <span>&nbsp;</span>
        </div>
    `)
}

function formEnabled() {
    username.prop('disabled', false)
    password.prop('disabled', false)
    submitButton.prop('disabled', false)
    submitButton.removeClass('btn-default').addClass('btn-primary')
    submitButton.html(`SIGN IN <i class="fas fa-sign-in"></i>`)
}

function formDisabled() {
    username.prop('disabled', true)
    password.prop('disabled', true)
    submitButton.prop('disabled', true)
    submitButton.removeClass('btn-primary').addClass('btn-default')
    submitButton.html(`<i class="fas fa-spinner fa-spin"></i> wait...`)
}

function loginProcess(params = {}) {
    let icon = params.icon ?? ''
    let field = params.field ?? null
    let status = params.status ?? 'default'
    let message = params.message ?? null

    if (field) {
        document.querySelector(`#${field}`).focus()
    }

    if (status == 'default') {
        message = message ?? `&nbsp;`
    }

    if (status == 'warning') {
        icon = icon ?? `fas fa-check`
        message = message ?? `Complete ${field}`
    }

    if (status == 'danger') {
        icon = icon ?? `fas fa-check`
        message = message ?? `Error on field ${field}`
    }

    if (status == 'success') {
        icon = icon ?? `fas fa-check`
        message = message ?? `Complete ${field}`
    }

    loginStatus.html(`
        <div class="alert alert-${status} alert-dismissible">
            <span><i class="icon ${icon}"></i> ${message}</span>
        </div>
    `)
}

function submitForm() {
    formDisabled()

    if (username.val() == '' || password.val() == '') {
        formEnabled()

        return
    }

    let payload = {
        username: username.val(),
        password: password.val(),
        _csrf_token: CSRF_TOKEN.attr('content')
    }

    $.ajaxSetup({
        headers: {
            'Content-Type': 'application/json',
            'X-AUTH-TOKEN': CSRF_TOKEN.attr('content')
        },
        dataType: 'json',
    })
    let request = $.post('/access/admin/authenticate', payload)

    request.done((response) => {
        console.log(response)
        //location.href = '/admin'

    })

    request.fail((error) => {
        formEnabled()
        this.loginProcess({status:'danger', message:'connection error', icon:'fas fa-wifi'})
    })

}

username.on('focus', function() {
    resetLoginStatus()
})

password.on('focus', function() {
    resetLoginStatus()
})

password.on('keyup', e => {
    if (e.keyCode === 13) submitForm()
})

submitButton.on('keyup', e => {
    if (e.keyCode === 13) submitForm()
})

submitButton.on('click', e => {
    submitForm()
})

/* On load
----------------------- */

username.focus()

resetLoginStatus()


/* General
----------------------- */

$('form').on('submit', function (e) {
    e.preventDefault()
})

window.addEventListener('wheel', { passive: false })