function customTrixEditor() {

    return {
        item: null,
        // modal with images to select
        modal: document.getElementById('media_select_flex'),
        // Selected image and form
        template: document.getElementById('media_select_edit_form_template'),
        // Selected image form
        form: document.getElementById('media_select_edit_form'),
        // Form fields
        formFields: {

        },
        // AlpineJs dispatcher
        dispatch: null,
        refs: null,
        clone: null,
        path: "/files/content/",
        selected: {
            'file': '',
            'preview': ''
        },
        mediaRecord: null,
        mediaLib: null,

        setFormFields()
        {
            this.formFields = {
                media_selected_image_height: document.getElementById('media_selected_image_height'),
                media_selected_image_width: document.getElementById('media_selected_image_width'),
                media_selected_image_alt: document.getElementById('media_selected_image_alt'),
                media_selected_image_style: document.getElementById('media_selected_image_style'),
            }
        },

        setItem(e)
        {
            this.closeModalEventListener();

            if(e.detail[0]) {
                this.item = e.detail[0];
                return true;
            }
            return false
        },

        /**
         * Select image with onclick
         * @param mediaRecord       Spatie mediaLib record
         * @param mediaLibRecord    Record media only
         * @param AlpineDispatcher  AlpineJs dispatcher
         * @param AlpineReference   AlpineJs X-ref's
         * @return {boolean}
         */
        setImage(mediaRecord, mediaLibRecord, AlpineDispatcher, AlpineReference)
        {
            this.mediaLib = mediaLibRecord;
            this.mediaRecord = mediaRecord;
            this.dispatch = AlpineDispatcher;
            this.refs = AlpineReference;
            this.setFormFields();

            // this.dispatch.media_selected_image_height = 600;
            // console.log(this.dispatch);
            // this.dispatch('tester')

            // this.clone = this.template.content.cloneNode(true);
            // this.setFormFields();
            // this.modal.classList.add('media_selected');

            this.setSelected();
            this.createPreview();

            return true;

            // document.addEventListener('toContent',() => {
            //     const handler = customTrixEditor();
            //
            //     let img_w = document.getElementById('media_selected_image_width');
            //     let img_h = document.getElementById('media_selected_image_height');
            //     let img_alt = document.getElementById('media_selected_image_alt');
            //     let img_style = document.getElementById('media_selected_image_style');
            //     let image_tag = document.querySelector('#media_selected_image img');
            //
            //     if(img_w.value != '') {
            //         image_tag.setAttribute('width', img_w.value);
            //     }
            //
            //     if(img_h.value == '') {
            //         image_tag.setAttribute('height', img_h.value);
            //     }
            //
            //     if(img_alt.value == '') {
            //         image_tag.setAttribute('alt', img_alt.value);
            //     }
            //
            //     if(img_style.value == '') {
            //         image_tag.setAttribute('style', img_style.value);
            //     }
            //
            //
            //
            //     return image_tag;
            // })


           // this.section.append(this.clone);
        },

        toContent()
        {
            this.setFormFields();
            var activeElement = window.document.activeElement;
            var editor = this.refs.trix?.editor;
            var html = editor.element.innerHTML;

            editor.recordUndoEntry(this.getImageTag());
            editor.setSelectedRange([editor.getPosition(),editor.getPosition()]);
            editor.insertHTML(this.getImageTag());
            activeElement && activeElement.focus && activeElement.focus();

            this.dispatch('close-modal', { id: 'file-selector' })
        },

        setSelected()
        {
            this.selected.file = this.path + this.mediaRecord.id + '/' + this.mediaRecord.file_name;
            if(this.mediaRecord.mime_type.substr(0,6) == 'image/') {
                this.selected.preview = this.path +
                    this.mediaRecord.id +
                    '/conversions/' +
                    this.mediaRecord.name +"-preview" +
                    this.mediaRecord.file_name.substring(this.mediaRecord.name.length, this.mediaRecord.file_name.length);
            }
            else {
                this.mediaRecord = '';
            }
        },

        createPreview()
        {
            const simg = new Image();
            const size = {w: '', h: ''};
            const self = this;
            simg.onload = function() {
                size.w = this.naturalWidth;
                size.h = this.naturalHeight;
            }
            simg.src = this.selected.file;
            document.body.append(simg);
            simg.remove();

            const img = new Image();
            img.classList.add('w-full', 'rounded-lg');
            img.onload = function() {
                self.setForm(size);
            }
            img.src = this.selected.preview;
            document.getElementById('media_selected_image').innerHTML = '';
            document.getElementById('media_selected_image').append(img);
        },


        setForm(size)
        {
            document.getElementById('media_selected_filename').innerText = this.mediaRecord.file_name;
            document.getElementById('media_selected_filesize').innerText = size.w + "x" + size.h + "px | " + Math.round(this.mediaRecord.size/1024) + "kb | " + this.mediaRecord.mime_type;

            this.formFields.media_selected_image_height.value = size.h;
            this.formFields.media_selected_image_width.value = size.w;
            this.setListeners(size);
        },

        /**
         * Set listeners when change size
         * @param size
         */
        setListeners(size)
        {
            this.formFields.media_selected_image_height.addEventListener('change', function(e) {
                 this.changeHeight(e, size);
            }.bind(this));
            this.formFields.media_selected_image_width.addEventListener('change', function(e) {
                 this.changeWidth(e, size);
            }.bind(this));
        },

        changeHeight(e, size)
        {
            let newHeight = parseInt(e.target.value);
            let h = parseInt(size.h);
            let w = parseInt(size.w);
            let newWidth = Math.round(w * newHeight/h);
            this.formFields.media_selected_image_height.value = newHeight;
            this.formFields.media_selected_image_width.value = newWidth;
        },

        changeWidth(e, size)
        {
            let newWidth = parseInt(e.target.value);
            let h = parseInt(size.h);
            let w = parseInt(size.w);
            let newHeight = Math.round(h * newWidth/w);
            this.formFields.media_selected_image_height.value = newHeight;
            this.formFields.media_selected_image_width.value = newWidth;
        },

        isset() {
          return !(this.item === null)
        },

        getImageTag()
        {
            let img = document.createElement('img');
            img.setAttribute('src', this.path + "/" + this.mediaLib.model_id + "/" + this.mediaLib.file_name);
            img.setAttribute('alt', this.formFields.media_selected_image_alt.value);
            if(this.formFields.media_selected_image_height.value != '') {
                img.height = parseInt(this.formFields.media_selected_image_height.value);
            }
            if(this.formFields.media_selected_image_width.value != '') {
                img.width = parseInt(this.formFields.media_selected_image_width.value);
            }
            if(this.getFormFieldValue('style') != '') {
                img.setAttribute('style',this.getFormFieldValue('style'));
            }

            console.log(img.outerHTML);

            return img.outerHTML;
        },

        getFormFieldValue(name)
        {
            return this.formFields['media_selected_image_'+name].value.trim();
        },

        /**
         * In javascript: $dispatch('close-modal', { id: 'file-selector' })
         *
         * Sluiten na selectie
         */
        closeModalEventListener()
        {
            const modal = document.getElementById('file-selector');

            if(modal) {
                window.addEventListener('close-modal', event => {
                    modal.close();
                });
            }
        }
    }
}
const handler = customTrixEditor();
