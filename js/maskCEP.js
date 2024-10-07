export function maskCEP(inputElement) {
    inputElement.addEventListener('input', (e) => {
        let value = e.target.value;

        // Remove todos os caracteres que não são números
        value = value.replace(/\D/g, '');

        // Aplica a máscara de CEP no formato 00000-000
        if (value.length > 5) {
            value = value.replace(/^(\d{5})(\d)/, '$1-$2');
        }

        // Atualiza o valor no campo de input
        e.target.value = value;
    });
}
