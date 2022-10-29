const togglesDiv = document.getElementsByClassName('toggle-hide-other-fields');

for (const toggleDiv of togglesDiv) {
   const inputs = toggleDiv.getElementsByTagName('input');

   for (const input of inputs) {
       if (input.type !== 'checkbox') {
           continue;
       }

       const name = getName(input.name);
       const prefix = input.dataset.prefix;
       const hideClass = input.dataset.hide;

       if (! name) {
           console.error('cannot extract name of field ' . input.name);
           continue;
       }

       input.addEventListener('change', function(e) {
            const elementsToToggleHide = document.getElementsByClassName(prefix + name);

            for (const elementToToggleHide of elementsToToggleHide) {
                elementToToggleHide.classList.toggle(hideClass);

                const inputsToToggleHide = elementToToggleHide.getElementsByTagName('input')

                for (const inputToToggleHide of inputsToToggleHide) {
                    if (! inputToToggleHide.hasAttribute('data-required-field')) {
                        continue;
                    }

                    inputToToggleHide.required = ! inputToToggleHide.required;
                    const labelsToToggleHide = elementToToggleHide.getElementsByTagName('label');

                    for (const labelToToggleHide of labelsToToggleHide) {
                        if (labelToToggleHide.getAttribute('for') !== inputToToggleHide.id) {
                            continue;
                        }
                        labelToToggleHide.classList.toggle('required');
                    }
                }
            }
       });
   }
}

function getName(inputName)
{
    const regex = /\[(.*)\]/gm;

    let m = regex.exec(inputName);

    return m !== null ? m[m.length - 1] : null;
}