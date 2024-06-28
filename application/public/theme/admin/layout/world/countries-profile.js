/**
 * Config
 */
let properties = JSON.parse($(`[id=database-list]`).val())

if (properties === undefined) {
    properties = {}
}

let countryInfo = {
    name: $(`[id=country-name]`).val(),
    data: properties
}

const countryDataResponseWrapper = $(`[id=country-data-response]`)

function generateTable() {
    let i = 0
    let rows = ``

    for (const [key, value] of Object.entries(countryInfo.data)) {
        i++;

        let content = `<a href="javascript:;">${value}</a>`

        rows += `
        <tr id="property-${key}" data-widget="expandable-table" aria-expanded="true">
            <td>${i}</td>
            <td title="Click top see content">${key}</td>
            <td title="Click top see content">${content}</td>
            <td>
                <button class="btn btn-block btn-xs btn-default" disabled><i class="fas fa-times"></i></button>
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

generateTable()