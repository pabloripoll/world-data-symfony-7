/**
 * Config
 */
let properties = JSON.parse($(`[id=database-list]`).val())[0]

if (properties === undefined) {
    properties = {}
} else {
    properties = properties.content
}

/**
 * Create Property
 */

const propertyName = $(`[id=property-name]`)
const propertyContent = $(`[id=property-content]`)
const propertyInsertButton = $(`[id=property-insert-button]`)
const propertyTableBody = $(`[id=properties-table]`)

function formEnabled() {
    propertyName.prop('disabled', false)
    propertyContent.prop('disabled', false)
    propertyInsertButton.removeClass('btn-default').addClass('btn-warning')
    propertyInsertButton.html(`Insert <i class="fas fa-plus"></i>`)
}

function formDisabled() {
    propertyName.prop('disabled', true)
    propertyContent.prop('disabled', true)
    propertyInsertButton.removeClass('btn-warning').addClass('btn-default')
    propertyInsertButton.html(`Wait... <i class="fas fa-spinner fa-spin"></i>`)
}

function generateTable() {
    let i = 0
    let rows = ``

    for (const [key, value] of Object.entries(properties)) {
        i++;
        rows += `
        <tr id="property-${key}">
            <td>${i}</td>
            <td>${key}</td>
            <td>${value}</td>
            <td align="center">
                <button class="btn btn-xs btn-primary" title="Edit property" onclick="editProperty('${key}')">
                    <i class="fas fa-edit mx-2"></i>
                </button>
                <button class="btn btn-xs btn-danger" title="Delete property from registers" onclick="removeProperty('${key}')">
                    <i class="fas fa-times mx-2"></i>
                </button>
            </td>
        </tr>`
    }

    propertyTableBody.html(rows)
    formEnabled()
}

function insertProperty() {
    if (propertyName.val().length < 4) {
        return false
    }

    formDisabled()

    if (properties.hasOwnProperty(propertyName.val())) {
        delete properties[propertyName.val()]
    }

    properties = {...properties, [propertyName.val()]: propertyContent.val()}

    formEnabled()
    generateTable()

    propertyName.val('')
    propertyContent.val('')
    propertyName.focus()
}

propertyName.on('keyup', e => {
    if (e.keyCode === 13) insertProperty()
})

propertyContent.on('keyup', e => {
    if (e.keyCode === 13) insertProperty()
})

propertyInsertButton.on('keyup', e => {
    if (e.keyCode === 13) insertProperty()
})

propertyInsertButton.on('click', e => {
    insertProperty()
})

propertyName.focus()

/**
 * Update Property
 */
function editProperty(key) {
    propertyName.val(key)
    propertyContent.val(properties[key])
    propertyName.focus()
}

/**
 * Delete Property
 */
function removeProperty(key) {
    delete properties[key];
    generateTable()
}

/**
 * Save Changes
 */
const saveChangesButton = $(`[id=save-changes-button]`)

function saveButtonEnabled() {
    saveChangesButton.removeClass('btn-default').addClass('btn-primary')
    saveChangesButton.html(`Save Changes`)
}

function saveButtonDisabled() {
    saveChangesButton.removeClass('btn-primary').addClass('btn-default')
    saveChangesButton.html(`Wait... <i class="fas fa-spinner fa-spin"></i>`)
}

function saveChanges() {

    if (Object.keys(properties).length < 1) {
        return false
    }

    saveButtonDisabled()

    let payload = {
        properties: JSON.stringify(properties),
        _csrf_token: CSRF_TOKEN
    }
    $.ajax({
        url: '/admin/world/properties/persist',
        method: 'POST',
        dataType: 'json',
        data: payload
    })
    .done((response) => {
        console.log(response)
        toastr.success('Changes saved :)')
        formEnabled()
        saveButtonEnabled()
    })
    .fail((error) => {
        console.log(error)
        formEnabled()
        saveButtonEnabled()
    })
}

saveChangesButton.on('keyup', e => {
    if (e.keyCode === 13) saveChanges()
})

saveChangesButton.on('click', e => {
    saveChanges()
})

/**
 * On load
 */

generateTable()