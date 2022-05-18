import MicroModal from 'micromodal'

export default class FormModal {
    constructor () {
        this.setProperties()
        this.init()
    }

    setProperties () {
        this.modalId = 'wpgdprc-form-modal'
        this.options = {
            openClass: 'is-open',
            disableScroll: true,
            disableFocus: true,
            openTrigger: 'data-form-open',
            closeTrigger: 'data-form-close',
            onShow: () => { document.body.style.overflowY = 'hidden' },
            onClose: () => { document.body.style.overflowY = 'auto' }
        }

        this.showFormModal = wpgdprcAdmin.showFormModal
    }

    init () {
        // return

        /* eslint-disable-next-line */
        if (!document.querySelector(`#${this.modalId}`)) {
            return
        }

        MicroModal.init(this.options)

        if (this.showFormModal) {
            MicroModal.show(this.modalId, this.options)
        }
    }
}
