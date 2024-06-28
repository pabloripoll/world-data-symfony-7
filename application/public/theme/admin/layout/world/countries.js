


function removeRegister(id) {
    let countryName = $(`[data-target=country-name-${id}]`).html()
    modal.static = true
    modal.title  = `<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Attention!</span>`
    modal.body   = `
        <p class="text-center">Are you sure to proceed on removing <b>${countryName}</b> from registers?</p>`
    modal.footer = `
        <button class="btn btn-default float-left" data-dismiss="modal">No, Close</button>
        <button class="btn btn-danger" onclick="deleteRegister(${id})">Yes, Delete <i class="far fa-trash-alt"></i></button>`

    modalShow(modal)
}

function deleteRegister(id) {
    let payload = {
        id: id,
        _csrf_token: CSRF_TOKEN
    }

    $('#modal-footer').html(`
        <button class="btn btn-danger">Deleting ...<i class="fas fa-spinner fa-spin"></i></button>
    `)

    $.ajax({
        url: '/admin/world/countries/delete',
        method: 'POST',
        dataType: 'json',
        data: payload
    })
    .done((response) => {
        console.log(response)
        location.href = `/admin/world/countries`

        toastr.success('Changes saved :)')
        modalHide()
    })
    .fail((error) => {
        //modalHide()
        console.log(error)
    })
}