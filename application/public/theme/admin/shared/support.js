/**
 * Custom Support
 *
 */

const modal = {}
function modalShow(config = {}) {

    let settings;
    if (config.static && config.static == true) {
        settings = {backdrop: 'static', keyboard: false}
    }

    let size = 'modal-dialog'
    if (config.size && config.size == 'large') size = size + ` modal-lg`

    let title = config.title ?? 'Dialog'

    let header = `<h4 class="modal-title">${title}</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>`
    if (config.static && config.static == true) {
        header = `<h4 class="modal-title">${title}</h4>`
    }

    let body = config.body ?? `<p>No content</p>`
    let bodyPadding = config.bodyPadding ?? ``

    let footer = config.footer ?? `<button class="btn btn-default" class="close" data-dismiss="modal">Close</button>`

    $('#modal-dialog').html(
        `<div class="${size}">
            <div id="modal-content" class="modal-content">
                <div id="modal-header" class="modal-header">${header}</div>
                <div id="modal-body" class="modal-body ${bodyPadding}">${body}</div>
                <div id="modal-footer" class="modal-footer clearfix" style="clear:fix">${footer}</div>
            </div>
        </div>`
    )

    $('#modal-dialog').modal(settings)
}

function modalHide() {
    $('#modal-dialog').modal('hide')
}