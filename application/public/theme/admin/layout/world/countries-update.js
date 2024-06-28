/**
 * Config
 */
let properties = JSON.parse($(`[id=database-properties]`).val())[0]

if (properties === undefined) {
    properties = {}
} else {
    properties = properties.content
}

let countryInfo = {
    id: $(`[id=country-id]`).val(),
    name: $(`[id=country-name]`).val(),
    data: JSON.parse($(`[id=database-list]`).val())
}

/**
 * API REQUEST
 */

const countryName = $(`[id=country-name]`)
const countryNameButton = $(`[id=country-name-button]`)
const countryDataResponseWrapper = $(`[id=country-data-response]`)

function formEnabled() {
    countryName.prop('disabled', false)
    countryNameButton.prop('disabled', false)
    countryNameButton.removeClass('btn-default').addClass('btn-primary')
    countryNameButton.html(`Search <i class="fas fa-search"></i>`)
}

function formDisabled() {
    countryName.prop('disabled', true)
    countryNameButton.prop('disabled', true)
    countryNameButton.removeClass('btn-primary').addClass('btn-default')
    countryNameButton.html(`Wait... <i class="fas fa-spinner fa-spin"></i>`)
}

function generateTable() {
    let i = 0
    let rows = ``

    for (const [key, value] of Object.entries(countryInfo.data)) {
        i++;

        let content = value
        if (Object.keys(countryInfo.data).length < 1) content = `+ ${Object.keys(countryInfo.data).length}`;

        rows += `
        <tr id="property-${key}" data-widget="expandable-table" aria-expanded="true">
            <td>${i}</td>
            <td>${key}</td>
            <td>${content}</td>
            <td>
                <button class="btn btn-block btn-xs btn-danger" onclick="removeProperty('${key}')"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr id="property-child-${key}" class="expandable-body d-none">
            <td colspan="4">
                <p>${JSON.stringify(value, null, '\t')}</p>
            </td>
        </tr>`
    }

    countryDataResponseWrapper.html(rows)
}

function removeProperty(key) {
    delete countryInfo.data[key]
    generateTable()
}

function requestCountryData() {
    if (countryName.val().length < 4) {
        return false
    }

    formDisabled()

    let request = $.get('https://restcountries.com/v3.1/name/'+ countryName.val())
    request.done((response) => {
        if (response[0] === undefined) {
            countryDataResponseWrapper.text(`[No response for ${countryName}]`)
        } else {
            countryInfo.name = countryName.val()
            //countryInfo.data = response[0]
            let apiResult = response[0];
            countryInfo.data = Object.assign(countryInfo.data, apiResult)
            generateTable()
            countryName.blur()
        }
        formEnabled()
    })
    request.fail((error) => {
        countryDataResponseWrapper.text(`[No response for ${countryName.val()}]`)
        formEnabled()
    })
}

countryName.on('keyup', e => {
    if (e.keyCode === 13) requestCountryData()
})

countryNameButton.on('keyup', e => {
    if (e.keyCode === 13) requestCountryData()
})

countryNameButton.on('click', e => {
    requestCountryData()
})

countryName.focus()

/**
 * Update Register
 */

const goBackButton = $(`[id=go-back-button]`)
const updateRegisterButton = $(`[id=update-register-button]`)

function registerButtonEnabled() {
    goBackButton.css('display', 'block')
    updateRegisterButton.prop('disabled', false)
    updateRegisterButton.removeClass('btn-default').addClass('btn-primary')
    updateRegisterButton.html(`Save Changes`)
}

function registerButtonDisabled() {
    goBackButton.css('display', 'none')
    updateRegisterButton.prop('disabled', true)
    updateRegisterButton.removeClass('btn-primary').addClass('btn-default')
    updateRegisterButton.html(`Wait... <i class="fas fa-spinner fa-spin"></i>`)
}

function createRegister() {

    if (countryInfo.name == '') { // || Object.keys(countryInfo.data).length < 1
        return false
    }

    formDisabled()
    registerButtonDisabled()

    let payload = {
        id: countryInfo.id,
        name: countryName.val(),
        data: JSON.stringify(countryInfo.data),
        _csrf_token: CSRF_TOKEN
    }

    $.ajax({
        url: '/admin/world/countries/update',
        method: 'POST',
        dataType: 'json',
        data: payload
    })
    .done((response) => {

        if (Object.hasOwn(response, 'id')) {
            location.href = `/admin/world/countries`
        }

        toastr.success('Changes saved :)')
    })
    .fail((error) => {
        formEnabled()
        registerButtonEnabled()
    })
}

updateRegisterButton.on('keyup', e => {
    if (e.keyCode === 13) createRegister()
})

updateRegisterButton.on('click', e => {
    createRegister()
})

/**
 * Properties
 */

const insertPropertyButton = $(`[id=insert-property-button]`)

function addPropertyToCountry(key) {
    if (countryInfo.name == '') { // || Object.keys(countryInfo.data).length < 1
        toastr.error(`The country info has to be loaded first :/`)

        return false
    }

    countryInfo.data = {...countryInfo.data, [key]: properties[key]}

    generateTable()

    modalHide()
    toastr.success(`<b>${key}</b> property has been included successfully :)`)
    //countryDataResponseWrapper.text(JSON.stringify({search: countryInfo.name, response: countryInfo.data}, null, '\t'))
}

function propertiesTableRows() {
    let i = 0
    let rows = ``

    for (const [key, value] of Object.entries(properties)) {
        i++;

        let button = `
            <button class="btn btn-xs btn-default" title="Insert property" onclick="addPropertyToCountry('${key}')">
                <i class="fas fa-download mx-2"></i>
            </button>`

        if (countryInfo.data[key] !== undefined) {
            button = `
            <button class="btn btn-xs btn-success" title="Property is now included">
                <i class="fas fa-check mx-2"></i>
            </button>`
        }

        rows += `
        <tr id="property-${key}">
            <td>${key}</td>
            <td align="right">
                ${button}
            </td>
        </tr>`
    }

    return rows
}

function insertProperty() {
    modal.static = true
    modal.title = `Insert Property`
    modal.body = `
        <div class="card mb-0">
            <div class="card-body p-0">
                <table class="table table-striped">
                    <tbody>
                        ${propertiesTableRows()}
                    </tbody>
                </table>
            </div>
        </div>`
    modal.bodyPadding = 'p-0'

    modalShow(modal)
}

insertPropertyButton.on('keyup', e => {
    if (e.keyCode === 13) insertProperty()
})

insertPropertyButton.on('click', e => {
    insertProperty()
})

/**
 * Onload
 */
generateTable()