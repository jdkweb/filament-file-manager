document.addEventListener('DOMContentLoaded', function () {
    // select buttons in loop
    buttons = [];
    document.querySelectorAll('[data-trix-action=\'file-manager\']').forEach(function (button) {
        if (button === null) return '';

        [prefix, id] = button.parentElement.parentElement.parentElement.getAttribute('id').split("\.")
        buttons.push(button);
    });

    document.addEventListener('livewire:init', () => {
        console.log("FOUT init1");
        console.log(Livewire);
        console.log(Livewire.dispatchTo('select-file','updatedate'));
        Livewire.dispatchTo('select-file','updatedate');
        console.log("init2");

        for (let i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener('click', function (event) {
                let toolbar = event.currentTarget.parentElement.parentElement.parentElement;
                // split id in trix-prefix and fieldname
                [prefix, fieldname] = toolbar.getAttribute('id').split("\.")

                console.log('Custom element clicked:', fieldname);
                Livewire.dispatch('updatedate', (event) => {
                    console.log(event);
                });
            });
        }
    });
});
