export function validateForm(formElement) {
    formElement.addEventListener('input', (e) => {

        const cep = document.getElementById('CEP').value.replace(/\D/g, ''); // Remove traços e espaços do CEP

        // Você pode adicionar mais validações aqui para outros campos
        if (cep.length !== 8) {
            document.getElementById('messager').innerHTML = 'CEP inválido! Por favor, insira um CEP válido com 8 dígitos.'
        } else {
            document.getElementById('messager').innerHTML = '';
        }
    });
}
