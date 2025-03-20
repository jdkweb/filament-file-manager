<div>
    <div>
        <div class="mb-4">
        </div>
        <div class="overflow-hidden">
            <div x-cloak x-on:setrecord.window="function(el) {
                const handler = customTrixEditor();
                if(!handler.setItem(el)){
                    return;
                }
                let form = document.getElementById('media_select_edit_preview');
                let flex = document.getElementById('media_select_flex');
                document.getElementById('media_select_edit_preview').src = handler.item.original_url;
                flex.classList.remove('media_selected');
                form.classList.remove('hidden');
                console.log( handler.item.original_url );
            }"></div>
            <div x-cloak x-on:toContent.window="function(el) {

                if(!handler.setItem(el)){
                    return;
                }

                var activeElement = window.document.activeElement;
                var editor = this.$refs.trix?.editor;
                var html = editor.element.innerHTML;

                console.log(this.$root);
                console.log(editor);

                //editor.setSelectedRange([0,editor.getDocument().getLength()]);
                //editor.insertHTML(content);
                //activeElement && activeElement.focus && activeElement.focus();

                editor.recordUndoEntry(handler.getTitle());
                editor.setSelectedRange([editor.getPosition(),editor.getPosition()]);
                editor.insertHTML(handler.getTitle());
                activeElement && activeElement.focus && activeElement.focus();

                $dispatch('close-modal', { id: 'file-selector' })
            }"></div>
            <div class="media_select_flex"
                 id="media_select_flex">
                <div class="media_select_gallery">
                    aaaa
                    @foreach($records as $record)
                        <x-filament-file-manager::editor.imagecard :record="$record" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


