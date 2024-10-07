export function maskCPF(inputElement) {
    inputElement.addEventListener('input', (e) => {
        let value = e.target.value;
        value = value.replace(/\D/g, ''); // Remove tudo que não é dígito
        value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca ponto após os 3 primeiros dígitos
        value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca ponto após o segundo grupo de 3 dígitos
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Coloca hífen no final

        // Validação de CPF
        if (value.length === 14) { // CPF tem 14 caracteres com a máscara
            inputElement.style.borderColor = 'green';
        } else {
            inputElement.style.borderColor = 'red';
        }

        e.target.value = value;
    });
}
