<div class="row-span-full">
    <div x-on:setimagerecord__.window="function(el) {
        console.log('media-resource.blade');
        var element = el.detail[0]['original_url'];
        var factor = el.detail[0].factor;
        var activeElement = window.document.activeElement;
        //var editor = this.$refs.trix?.editor;
        var editor = document.getElementById(el.detail[0].editor_id);
      //  var html = editor.element.innerHTML;
        var dim = {h: 0, w: 0};


        const img = new Image();
        img.onload = function() {
            // Create image element
            let c = document.createElement('img');
            c.setAttribute('src', element);
            c.setAttribute('width', Math.round(this.width * factor));
            c.setAttribute('height',Math.round(this.height * factor));
            c.setAttribute('alt',el.detail[0]['custom_properties'].description);

            // Place in editor
            //editor.recordUndoEntry(c.outerHTML);
            //editor.setSelectedRange([editor.getPosition(),editor.getPosition()]);
            //editor.insertHTML(c.outerHTML);
            activeElement && activeElement.focus && activeElement.focus();
            $dispatch('close-modal', { id: 'filament-file-manager' })
        }
        img.src = element;
        }"
        x-on:setfilerecord.window="function(el) {
             var element = el.detail[0]['original_url'];
             var type = el.detail[0].linktype;
             var activeElement = window.document.activeElement;
             var editor = this.$refs.trix?.editor;
             var html = editor.element.innerHTML;

             // Place in editor
             editor.setSelectedRange([editor.getPosition(),editor.getPosition()]);
             if(type!='icon') {
                editor.insertHTML(`<a href='${element}' download>${el.detail[0]['custom_properties'].description}</a>`);
             }
             else {
                //console.log(editor);
                //editor.insertFiles(el);
                editor.insertHTML(`<a class='strip_figure' href='${element}' download><img src='${el.detail[0].typeicon}' alt='' /></a>`);
             }
             activeElement && activeElement.focus && activeElement.focus();
             $dispatch('close-modal', { id: 'filament-file-manager' });

        }"
    </div>
    <div id="media_select_flex">
        <section class="media_card_container flex flex-row flex-wrap py-5">
            @foreach($records as $record)
                @if(preg_match("/image\/.*/", $record->mime_type))
                <x-filament-file-manager::imagecard :record="$record"/>
                @else
                <x-filament-file-manager::filecard :record="$record"/>
                @endif
            @endforeach
        </section>
        <x-filament::button
            wire:click="triggerBack"
            icon="heroicon-o-arrow-left">
            Terug
        </x-filament::button>
    </div>
</div>






